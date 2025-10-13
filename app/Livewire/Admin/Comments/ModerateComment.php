<?php

namespace App\Livewire\Admin\Comments;

use App\Models\Comment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\Attributes\On;

class ModerateComment extends Component
{
  use AuthorizesRequests;

  public $commentId;
  public $isModalOpen = false;
  public $action = '';
  public $reason = '';
  public $commentPreview = '';

  #[On('openModalModerate')]
  public function openModalModerate($commentId, $action)
  {
    $this->authorize('comments.moderate');

    $comment = Comment::findOrFail($commentId);

    if (!$this->canModerateComment($comment, true)) {
      return;
    }

    $this->commentId = $comment->id;
    $this->action = $action;
    $this->commentPreview = \Str::limit($comment->comment, 100);
    $this->reason = '';

    $this->isModalOpen = true;
  }  

  #[On('closeModalModerate')]
  public function closeModalModerate()
  {
    $this->isModalOpen = false;
    $this->reset(['commentId', 'action', 'reason', 'commentPreview']);
    $this->resetValidation();
  }

  public function moderateComment()
  {

    if($this->action === 'reject'){
      $this->validate([
        'reason' => 'required|string|min:10|max:200',
      ], [
        'reason.required' => 'Debe proporcionar una razón para rechazar el comentario.',
        'reason.min' => 'La razón debe tener al menos 10 caracteres.',
        'reason.max' => 'La razón no puede exceder los 200 caracteres.',
      ]);
    }

    try {

      $comment = Comment::findOrFail($this->commentId);

      if (!$this->canModerateComment($comment)) {
        return;
      }

      $status = $this->action === 'approve' ? 'approved' : 'rejected';

      $comment->update([
        'status' => $status,
        'moderation_reason' => $this->action === 'reject' ? $this->reason : null,
        'moderated_by' => auth()->id(),
        'moderated_at' => now(),
      ]);

      $message = $this->action === 'approve'
        ? 'Comentario aprobado correctamente.'
        : 'Comentario rechazado correctamente.';
      
      $this->closeModalModerate();
      $this->dispatch('refreshComments');
      $this->dispatch('showAlert', message: $message, type: 'success');

    } catch (\Exception $e) {
      $this->dispatch('showAlert', message: 'Error al moderar el comentario.', type: 'error');
      $this->closeModalModerate();
    }

  }

  private function canModerateComment(Comment $comment, bool $beforeOpen = false): bool
  {
    $user = auth()->user();

    if ($user->hasRole('Admin')) {
      return true;
    }

    if ($user->hasRole('Blogger') && $comment->post->user_id === $user->id) {
      return true;
    }

    $message = $user->hasRole('Blogger')
      ? 'Solo puedes moderar comentarios de tus propios posts.'
      : 'No tienes permiso para moderar este comentario.';

    $this->dispatch('showAlert', message: $message, type: 'error');
    
    if (!$beforeOpen ) {
      $this->closeModalModerate();
    }
    
    return false;
  }

  public function render()
  {
    return view('livewire.admin.comments.moderate-comment');
  }
}
