<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Category;
use App\Models\Media;
use App\Models\Post;
use App\Models\Tag;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class AddEditPost extends Component
{
  use WithFileUploads;

  public $postId;
  public $title = '';
  public $category_id;
  public $selectedTags = [];
  public $postStatus;
  public $content = '';
  public $media;
  public $images = [];
  public $video;
  
  public $selectedMediaType;
  public $imagePreviews = [];
  public $videoPreview;

  public $existingVideo;
  public $existingImages = [];

  const POST_DRAFT     = 0;
  const POST_PUBLISHED = 1;

  protected function rules()
  {
    return [
      'title' => ['required', 'string','min:3', 'max:255'],
      'category_id' => ['required', 'integer'],
      'selectedTags' => ['required', 'array', 'min:1', 'max:3'],
      'selectedTags.*' => ['integer', 'exists:tags,id'],
      'content' => 'required',
      'selectedMediaType' => ['nullable', 'in:image,video'],
      'images' => $this->selectedMediaType === 'image'
        ? ['nullable', 'array', 'max:4']
        : ['nullable'],
      'video' => $this->selectedMediaType === 'video'
        ? ['nullable', 'mimes:mp4', 'max:10240']
        : ['nullable'],
    ];
  }

  protected function messages()
  {
    return [
      'title.required' => 'El título es requerido.',
      'title.string' => 'El título debe ser una cadena de texto.',
      'title.min' => 'Este título es demasiado corto.',
      'title.max' => 'El título no debe superar los 255 caracteres.',
      'category_id' => 'Por favor selecciona una categoría.',
      'category_id.integer' => 'El campo categoría debe ser un número válido.',
      'selectedTags.required' => 'Por favor selecciona al menos una etiqueta.',
      'selectedTags.array' => 'Las etiquetas seleccionados deben ser un arreglo.',
      'selectedTags.min' => 'Selecciona al menos una etiqueta.',
      'selectedTags.max' => 'No puedes seleccionar más de 4 etiquetas.',
      'selectedTags.*.integer' => 'Cada etiqueta seleccionado debe ser un número válido.',
      'content.required' => 'Por favor proporcione el contenido de la nota.',
      'selectedMediaType.required' => 'Por favor selecciona una opción.',
      'selectedMediaType.in' => 'La opción seleccionada no es válida. Debe ser "image" o "video".',
      'images.required' => 'Por favor selecciona al menos una imagen.',
      'images.array' => 'Las imágenes deben ser un arreglo de archivos.',
      'images.min' => 'Debes seleccionar al menos una imagen.',
      'images.max' => 'Puedes subir un máximo de 4 imágenes.',
      'video.required' => 'Por favor selecciona un archivo de video.',
      'video.mimes' => 'El archivo debe ser un video en formato MP4.',
      'video.max' => 'El video no debe superar los 10 MB.',
    ];
  }

  public function mount($postId = null)
  {
    $this->resetForm();  
    $this->postId = $postId;

    if($postId){
      $post = Post::with(['user', 'category', 'media', 'tags'])->find($postId);
      $this->title = $post->title;
      $this->category_id = $post->category_id;
      $this->selectedTags = $post->tags()->pluck('tag_id')->toArray();
      $this->postStatus = $post->status === self::POST_PUBLISHED;
      $this->content = $post->content;
      
      // Load previews of existing images and video

      $this->media = $post->media()->get();

      $hasImages = $this->media->whereIn('file_type', ['image/png', 'image/jpeg', 'image/jpg'])->isNotEmpty();
      $hasVideo = $this->media->where('file_type', 'video/mp4')->isNotEmpty();

      if ($hasImages) {
        $this->selectedMediaType = 'image';
        $this->existingImages = $this->media
          ->whereIn('file_type', ['image/png', 'image/jpeg', 'image/jpg'])
          ->map(function ($image) {
            return [
              'id' => $image['id'],
              'url' => $image['url'],
              'file_type' => $image['file_type'],
            ];
          })
          ->toArray();
        $this->imagePreviews = array_column($this->existingImages, 'url');
      } elseif ($hasVideo) {
        $this->selectedMediaType = 'video';
        $video = $this->media->where('file_type', 'video/mp4')->first();
        $this->videoPreview = $video->url;
        $this->existingVideo = $video;
      }
    }
    $this->dispatch('initializeEditor', content: $this->content);
  }

  #[On('updateContent')]
  public function updateContent($content)
  {
    $this->content = $content;
  }

  public function togglePostStatus()
  {
    $this->postStatus = !$this->postStatus;
  }
  
  public function updatedImages()
  {
    $this->imagePreviews = [];
    if (is_array($this->images)) {
      $this->imagePreviews = [];
      foreach ($this->images as $image) {
        $this->imagePreviews[] = $image->temporaryUrl();
      }
    }
  }

  public function updatedVideo()
  {
    $this->videoPreview = $this->video->temporaryUrl();
  }

  public function updatedSelectedMediaType($value)
  {
    if ($value === 'image') {
      // If you change to "image", delete the existing video if there is any
      if ($this->existingVideo) {
        Storage::disk('public')->delete(str_replace('/storage/', '', $this->existingVideo->url));
        Media::where('id', $this->existingVideo->id)->delete();
        $this->existingVideo = null;
        $this->videoPreview = null;
      }
    } elseif ($value === 'video') {
      // If you switch to "video", delete existing images if any
      if ($this->existingImages) {
        foreach ($this->existingImages as $existingImage) {
          Storage::disk('public')->delete(str_replace('/storage/', '', $existingImage['url']));
          Media::where('id', $existingImage['id'])->delete();
        }
        $this->existingImages = [];
        $this->imagePreviews = [];
      }
    }
  }

  public function save()
  {

    $this->validate();

    if ($this->postId) {
      $post = Post::findOrFail($this->postId);
      $post->update([
        'title' => $this->title,
        'category_id' => $this->category_id,
        'content' => $this->content,
        'status' => $this->postStatus,
      ]);
    }else {
      $post = Post::create([
        'title' => $this->title,
        'category_id' => $this->category_id,
        'content' => $this->content,
        'status' => $this->postStatus,
        'user_id' => Auth::id(),
      ]);
    }

    if (!empty($this->selectedTags)) {
      $post->tags()->sync($this->selectedTags);
    }

    if ($this->selectedMediaType === 'image' && $this->images) {
      $this->handleImages($post);
    }

    if ($this->selectedMediaType === 'video' && $this->video) {
      $this->handleVideo($post);
    }

    $this->dispatch('refreshPosts');
    $message = $this->postId ? 'Nota actualizado correctamente.' : 'Nota creado correctamente.';
    session()->flash('alert', $message);
    return redirect()->route('posts.index');
  }

  protected function handleImages($post)
  {
    // Delete existing video if any
    if ($this->existingVideo) {
      Storage::disk('public')->delete(str_replace('/storage/', '', $this->existingVideo->url));
      Media::where('id', $this->existingVideo->id)->delete();
      $this->existingVideo = null;
      $this->videoPreview = null;
    }

    // Delete existing images if any
    if ($this->existingImages) {
      foreach ($this->existingImages as $existingImage) {
        Storage::disk('public')->delete(str_replace('/storage/', '', $existingImage['url']));
        Media::where('id', $existingImage['id'])->delete();
      }
     // $this->existingImages = [];
     // $this->imagePreviews = [];
    }

    // Save new images
    if ($this->images) {
      foreach ($this->images as $image) {
        $uuid = Uuid::uuid4()->toString();
        $extension = $image->getClientOriginalExtension();
        $fileName = $uuid . '.' . $extension;
        $path = $image->storeAs('uploads', $fileName, 'public');

        $post->media()->create([
          'url' => '/storage/' . $path,
          'file_type' => $image->getMimeType(),
        ]);
      }
    }
  }

  protected function handleVideo($post)
  {
    // Delete existing images if any
    if ($this->existingImages) {
      foreach ($this->existingImages as $existingImage) {
        Storage::disk('public')->delete(str_replace('/storage/', '', $existingImage['url']));
        Media::where('id', $existingImage['id'])->delete();
      }
      $this->existingImages = [];
      $this->imagePreviews = [];
    }

    // Delete existing video if any
    if ($this->existingVideo) {
      Storage::disk('public')->delete(str_replace('/storage/', '', $this->existingVideo->url));
      Media::where('id', $this->existingVideo->id)->delete();
      $this->existingVideo = null;
      $this->videoPreview = null;
    }

    // Save new video
    if ($this->video) {
      $uuid = Uuid::uuid4()->toString();
      $extension = $this->video->getClientOriginalExtension();
      $fileName = $uuid . '.' . $extension;
      $path = $this->video->storeAs('uploads', $fileName, 'public');

      $post->media()->create([
        'url' => '/storage/' . $path,
        'file_type' => $this->video->getMimeType(),
      ]);
    }
  }

  public function resetForm()
  {
    $this->reset([
      'postId',
      'title',
      'category_id',
      'selectedTags',
      'content',
      'media',
      'images',
      'video',
      //'imagePreviews',
      //'videoPreview',
      //'existingVideo',
      //'existingImages'
    ]);
  }

  public function render()
  {
    $categories = Category::all();
    $tags = Tag::all();
    return view('livewire.admin.posts.add-edit-post', ['categories' => $categories, 'tags' => $tags]);
  }
}
