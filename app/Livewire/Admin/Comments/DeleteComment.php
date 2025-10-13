<?php

namespace App\Livewire\Admin\Comments;

use App\Models\Comment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\Attributes\On;

class DeleteComment extends Component
{
  use AuthorizesRequests;

  public $commentId;
  public $isModalOpen = false;
  public $isReply = false;
  public $hasReplies = false;
  public $repliesCount = 0;

  #[On('openModalDelete')]
  public function openModalDelete($commentId)
  {
    $this->authorize('comments.destroy');

    $comment = Comment::findOrFail($commentId);

    if(!$this->canDeleteComment($comment, true)){
      return;
    }

    $this->commentId = $comment->id;
    $this->isReply = !is_null($comment->parent_id);
    $this->repliesCount = $comment->replies()->count();
    $this->hasReplies = $this->repliesCount > 0;

    $this->isModalOpen = true;
  }

  #[On('closeModalDelete')]
  public function closeModalDelete()
  {
    $this->isModalOpen = false;
    $this->reset(['commentId', 'isReply', 'hasReplies', 'repliesCount']);
  }

  public function deleteComment()
  {

    try {

      $comment = Comment::findOrFail($this->commentId);
      
      if(!$this->canDeleteComment($comment)){
        return;
      }
  
      if($this->hasReplies){
        $comment->replies()->delete();
      }

      $comment->delete();

      if ($this->isReply) {
        $message = 'Respuesta eliminada correctamente.';
      } else {
        $message = $this->hasReplies 
          ? "Comentario y sus {$this->repliesCount} respuesta(s) eliminados correctamente." 
          : 'Comentario eliminado correctamente.';
      }

      $this->closeModalDelete();
      $this->dispatch('refreshComments');
      $this->dispatch('showAlert', message: $message, type: 'success');

    } catch (\Exception $e) {
      $this->dispatch('showAlert', message: 'Error al eliminar el comentario.', type: 'error');
      $this->closeModalDelete();
    }
  }

  private function canDeleteComment(Comment $comment, bool $beforeOpen = false): bool
  {
    $user = auth()->user();

    if($user->hasRole('Admin')){
      return true;
    }

    if($user->hasRole('Blogger') && $comment->post->user_id === $user->id){
      return true;
    }

    $message = $user->hasRole('Blogger')
      ? 'Solo puedes eliminar comentarios de tus propios posts.'
      : 'No tienes permiso para eliminar este comentario.';

    $this->dispatch('showAlert', message: $message, type: 'error');
    $this->closeModalDelete();

    if (!$beforeOpen ) {
      $this->closeModalDelete();
    }

    return false;
  }

  public function render()
  {
    return view('livewire.admin.comments.delete-comment');
  }
}
