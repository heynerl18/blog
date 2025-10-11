<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Storage;

class DeletePost extends Component
{
  use AuthorizesRequests;

  public $postId;
  public $isModalOpen = false;

  #[On('openModalDelete')]
  public function openModalDelete($postId)
  {
    $this->authorize('posts.destroy');

    $this->postId = $postId;
    $this->isModalOpen = true;
  }

  #[On('closeModal')]
	public function closeModal()
	{
		$this->isModalOpen = false;
    $this->reset(['postId']);
	}

  public function delete()
  {
    $this->authorize('posts.destroy');

    $post = Post::findOrFail($this->postId);

    if (!auth()->user()->hasRole('Admin') && $post->user_id !== auth()->id()) {
      $this->dispatch('showAlert', [
        'message' => 'No tienes permiso para eliminar este post.',
        'type' => 'error'
      ]);
      $this->closeModal();
      return;
    }

    $this->deletePostMedia($post);
    $post->delete();

    $this->closeModal();
    $this->dispatch('refreshPosts');
    $this->dispatch('showAlert', [
      'message' => 'Nota eliminada correctamente.',
      'type' => 'success'
    ]);
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
