<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Category;
use App\Models\Media;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class AddEditPost extends Component
{
  use WithFileUploads;
  use AuthorizesRequests;

  public $postId;
  public $title = '';
  public $category_id;
  public $selectedTags = [];
  public $postStatus = false;
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
    $rules = [
      'title' => ['required', 'string','min:3', 'max:255'],
      'category_id' => ['required', 'integer'],
      'selectedTags' => ['required', 'array', 'min:1', 'max:3'],
      'selectedTags.*' => ['integer', 'exists:tags,id'],
      'content' => 'required',
    ];

    if (!empty($this->selectedMediaType)) {
      $rules['selectedMediaType'] = ['required', 'in:image,video'];

      if ($this->selectedMediaType === 'image') {

        $needsImages = !$this->postId || empty($this->existingImages);
        
        if ($needsImages) {
          // Modo creación o edición sin imágenes existentes
          $rules['images'] = ['required', 'array', 'min:1', 'max:4'];
          $rules['images.*'] = ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'];
        } else {
          // Modo edición con imágenes existentes - las nuevas son opcionales
          $rules['images'] = ['nullable', 'array', 'max:4'];
          $rules['images.*'] = ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'];
        }
      }

      if ($this->selectedMediaType === 'video') {

        $needsVideo = !$this->postId || !$this->existingVideo;
        
        if ($needsVideo) {
          // Modo creación o edición sin video existente
          $rules['video'] = ['required', 'file', 'mimes:mp4', 'max:10240'];
        } else {
          // Modo edición con video existente - el nuevo es opcional
          $rules['video'] = ['nullable', 'file', 'mimes:mp4', 'max:10240'];
        }
      }
    } else {
      // Sin tipo de medio seleccionado - todo es opcional
      $rules['selectedMediaType'] = ['nullable', 'in:image,video'];
      $rules['images'] = ['nullable', 'array', 'max:4'];
      $rules['images.*'] = ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'];
      $rules['video'] = ['nullable', 'file', 'mimes:mp4', 'max:10240'];
    }

    return $rules;
  }

  protected function messages()
  {
    return [
      'title.required' => 'El título es requerido.',
      'title.string' => 'El título debe ser una cadena de texto.',
      'title.min' => 'Este título es demasiado corto.',
      'title.max' => 'El título no debe superar los 255 caracteres.',
      'category_id.required' => 'Por favor selecciona una categoría.',
      'category_id.integer' => 'El campo categoría debe ser un número válido.',
      'selectedTags.required' => 'Por favor selecciona al menos una etiqueta.',
      'selectedTags.array' => 'Las etiquetas seleccionados deben ser un arreglo.',
      'selectedTags.min' => 'Selecciona al menos una etiqueta.',
      'selectedTags.max' => 'No puedes seleccionar más de 3 etiquetas.',
      'selectedTags.*.integer' => 'Cada etiqueta seleccionado debe ser un número válido.',
      'content.required' => 'Por favor proporcione el contenido de la nota.',
      'selectedMediaType.required' => 'Por favor selecciona una opción de tipo de archivo.',
      'selectedMediaType.in' => 'La opción seleccionada no es válida. Debe ser "image" o "video".',
      'images.required' => 'Por favor selecciona al menos una imagen.',
      'images.array' => 'Las imágenes deben ser un arreglo de archivos.',
      'images.min' => 'Debes seleccionar al menos una imagen.',
      'images.max' => 'Puedes subir un máximo de 4 imágenes.',
      'images.*.required' => 'Cada archivo de imagen es requerido.',
      'images.*.image' => 'Cada archivo debe ser una imagen válida.',
      'images.*.mimes' => 'Las imágenes deben ser archivos JPG, JPEG, PNG o WEBP.',
      'images.*.max' => 'Cada imagen no debe superar los 2 MB.',
      'video.required' => 'Por favor selecciona un archivo de video.',
      'video.file' => 'El video debe ser un archivo válido.',
      'video.mimes' => 'El archivo debe ser un video en formato MP4.',
      'video.max' => 'El video no debe superar los 10 MB.',
    ];
  }

  public function mount($postId = null)
  {
    $this->resetForm();  
    $this->postId = $postId;

    if($postId){

      $this->authorize('posts.edit');

      $post = Post::with(['user', 'category', 'media', 'tags'])->findOrFail($postId);

      if(!auth()->user()->hasRole('Admin') && $post->user_id !== auth()->id()){
        abort(403, 'No tienes permiso para editar este post.');
      }

      $this->title = $post->title;
      $this->category_id = $post->category_id;
      $this->selectedTags = $post->tags()->pluck('tag_id')->toArray();
      $this->postStatus = $post->status === self::POST_PUBLISHED;
      $this->content = $post->content;
      
      $this->media = $post->media()->get();

      // Verificar imágenes con más flexibilidad en MIME types
      $imageTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];
      $hasImages = $this->media->whereIn('file_type', $imageTypes)->isNotEmpty();
      
      // Verificar videos con más flexibilidad
      $videoTypes = ['video/mp4'];
      $hasVideo = $this->media->whereIn('file_type', $videoTypes)->isNotEmpty();

      if ($hasImages) {
        $this->selectedMediaType = 'image';
        $this->existingImages = $this->media
          ->whereIn('file_type', $imageTypes)
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
        $video = $this->media->whereIn('file_type', $videoTypes)->first();
        $this->videoPreview = $video->url;
        $this->existingVideo = $video;
      }
    } else {
      $this->authorize('posts.create');
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
  
  public function updatedSelectedMediaType($value)
  {
    // Limpiar archivos y vistas previas del otro tipo
    if ($value === 'image') {
      $this->video = null;
      $this->videoPreview = null;
    } elseif ($value === 'video') {
      $this->images = [];
      $this->imagePreviews = [];
    }
  }

  public function save()
  {

    $this->validate();

    if ($this->postId) {

      $this->authorize('posts.edit');

      $post = Post::findOrFail($this->postId);

      if (!auth()->user()->hasRole('Admin') && $post->user_id !== auth()->id()) {
        session()->flash('alert', 'No tienes permiso para editar este post.');
        return redirect()->route('admin.posts.index');
      }

      $post->update([
        'title' => $this->title,
        'category_id' => $this->category_id,
        'content' => $this->content,
        'status' => $this->postStatus,
      ]);

      $message = 'Nota actualizada correctamente.';

    }else {

      $this->authorize('posts.create');

      $post = Post::create([
        'title' => $this->title,
        'category_id' => $this->category_id,
        'content' => $this->content,
        'status' => $this->postStatus,
        'user_id' => Auth::id(),
      ]);

      $message = 'Nota creada correctamente.';
    }

    if (!empty($this->selectedTags)) {
      $post->tags()->sync($this->selectedTags);
    }

    if ($this->selectedMediaType === 'image') {
      $this->handleImages($post);
    } elseif ($this->selectedMediaType === 'video') {
      $this->handleVideo($post);
    }

    $this->dispatch('refreshPosts');
    session()->flash('alert', $message);
    return redirect()->route('admin.posts.index');
  }

  protected function handleImages($post)
  {

    if (empty($this->images)) {
      return;
    }

    if ($this->existingVideo) {
      $this->deleteMedia($this->existingVideo);
      $this->existingVideo = null;
    }

    if (!empty($this->existingImages)) {
      foreach ($this->existingImages as $existingImage) {
        $mediaModel = Media::find($existingImage['id']);
        if ($mediaModel) {
          $this->deleteMedia($mediaModel);
        }
      }
      $this->existingImages = [];
    }

    foreach ($this->images as $image) {
      try {
        $uuid = Uuid::uuid4()->toString();
        $extension = $image->getClientOriginalExtension();
        $fileName = $uuid . '.' . $extension;
        $path = $image->storeAs('uploads', $fileName, 'public');

        $post->media()->create([
          'url' => '/storage/' . $path,
          'file_type' => $image->getMimeType(),
        ]);
      } catch (\Exception $e) {
        \Log::error('Error al subir imagen: ' . $e->getMessage());
        session()->flash('error', 'Error al subir una o más imágenes.');
      }
    }
  }

  protected function handleVideo($post)
  {

    if (empty($this->video)) {
      return;
    }

    if (!empty($this->existingImages)) {
      foreach ($this->existingImages as $existingImage) {
        $mediaModel = Media::find($existingImage['id']);
        if ($mediaModel) {
          $this->deleteMedia($mediaModel);
        }
      }
      $this->existingImages = [];
    }

    if ($this->existingVideo) {
      $this->deleteMedia($this->existingVideo);
      $this->existingVideo = null;
    }

    try {
      $uuid = Uuid::uuid4()->toString();
      $extension = $this->video->getClientOriginalExtension();
      $fileName = $uuid . '.' . $extension;
      $path = $this->video->storeAs('uploads', $fileName, 'public');

      $post->media()->create([
        'url' => '/storage/' . $path,
        'file_type' => $this->video->getMimeType(),
      ]);
    } catch (\Exception $e) {
      \Log::error('Error al subir video: ' . $e->getMessage());
      session()->flash('error', 'Error al subir el video.');
    }
  }

  protected function deleteMedia($media)
  {
    try {
      $path = str_replace('/storage/', '', $media->url);
      if (Storage::disk('public')->exists($path)) {
        Storage::disk('public')->delete($path);
      }
      Media::where('id', $media->id)->delete();
    } catch (\Exception $e) {
      \Log::error('Error al eliminar archivo: ' . $e->getMessage());
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
      'selectedMediaType',
      'imagePreviews',
      'videoPreview',
      'existingVideo',
      'existingImages'
    ]);
    $this->resetValidation();
  }

  public function render()
  {
    $categories = Category::all();
    $tags = Tag::all();
    return view('livewire.admin.posts.add-edit-post', ['categories' => $categories, 'tags' => $tags]);
  }
}