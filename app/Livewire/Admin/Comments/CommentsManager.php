<?php

namespace App\Livewire\Admin\Comments;

use App\Models\Comment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\Attributes\On; 

#[Layout('layouts.app')]
class CommentsManager extends Component
{
  use WithPagination;
  use AuthorizesRequests;

  public $perPage = 5;
  public $search = '';

  #[On('pageChanged')]
  public function updatePage($page)
  {
    $this->setPage($page);
  }

  public function mount()
  {
    // $this->perPage = 10;
    $this->authorize('comments.index');
  }

  #[On('refreshComments')]
  public function reloadCommentsList()
  {
    $this->resetPage();
  }

  public function render()
  {
    $comments = Comment::with(['user', 'post', 'parent'])
      ->when($this->search, function ($query) {
        $query->where('comment', 'like', '%' . $this->search . '%')
          ->orWhereHas('user', function ($q) {
            $q->where('name', 'like', '%' . $this->search . '%');
          })
          ->orWhereHas('post', function ($q) {
            $q->where('title', 'like', '%' . $this->search . '%');
          });
      })
      ->paginate($this->perPage);
    //dd($comments);
    return view('livewire.admin.comments.comments-manager', ['comments' => $comments]);
  }

  public function updatingSearch()
  {
    $this->resetPage();
  }
}
  