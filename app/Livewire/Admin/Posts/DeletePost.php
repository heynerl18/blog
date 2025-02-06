<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Storage;

class DeletePost extends Component
{
  public $postId;
  public $isModalOpen = false;

  #[On('openModalDelete')]
  public function openModalDelete($postId)
  {
    $this->postId = $postId;
    $this->isModalOpen = true;
  }

  #[On('closeModal')]
	public function closeModal()
	{
		$this->isModalOpen = false;
	}

  public function delete()
  {
    $post = Post::find($this->postId);
    if ($post) {
      // Delete multimedia files associated with the post
      $this->deletePostMedia($post);
      $post->delete();
      $this->dispatch('refreshPosts');
      $message = 'Nota eliminado correctamente.';
    } else {
      $message = 'La nota no existe o ya fue eliminado.';
    }

    $this->closeModal();
    $this->dispatch('showAlert', message : $message);
  }

  protected function deletePostMedia($post)
  {
    $media = $post->media()->get();

    foreach ($media as $file) {
      try {
        // Delete the physical file
        Storage::disk('public')->delete(str_replace('/storage/', '', $file->url));
        // Delete database record
        $file->delete();
      } catch (\Exception $e) {
        logger()->error('Error al eliminar archivo multimedia: ' . $e->getMessage());
      }
    }
  }

  public function render()
  {
    return view('livewire.admin.posts.delete-post');
  }
}
