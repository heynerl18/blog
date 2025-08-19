<?php

namespace App\Livewire\Public\Comment;
use App\Models\Comment;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class DeleteComment extends Component
{
  public $showModal = false;
  public $commentId = null;

  #[On('openModal')]
  public function openModal($commentId)
  {
    $this->commentId = $commentId;
    $this->showModal = true;
  }

  #[On('closeModal')]
  public function closeModal()
  {
    $this->showModal = false;
    $this->commentId = null;
  }

  public function deleteComment(){
    
    if(!$this->commentId){
      return;
    }

    $comment = Comment::find($this->commentId);

    if(!$comment){
      $this->closeModal();
      return;
    }

    if(Auth::id() !== $comment->user_id){
      $this->closeModal();
      return;
    }
    
    $comment->delete();

    $this->closeModal();
    // Dispatch an event to refresh the comment list
    $this->dispatch('commentDeleted');

    $this->dispatch('showAlert', message: 'Comentario eliminado correctamente.');
  }

  public function render()
  {
    return view('livewire.public.comment.delete-comment');
  }
}
