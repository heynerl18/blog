<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class PostsManager extends Component
{
  use WithPagination;
  use AuthorizesRequests;

  public $perPage = 5;
  protected $listeners = ['pageChanged' => 'updatePage'];
  public $search = '';

  public function updatePage($page)
  {
    $this->setPage($page);
  }

  public function mount()
  {
    // $this->perPage = 10;
    $this->authorize('posts.index');
  }

  #[On('refreshPosts')]
  public function reloadPosts()
  {
    $this->resetPage();
  }

  public function render()
  {
    $posts = Post::with(['user', 'category', 'media', 'tags'])
      ->when($this->search, function ($query) {
        $query->where('title', 'like', '%' . $this->search . '%');
      })
      ->paginate($this->perPage);

    return view('livewire.admin.posts.posts-manager', ['posts' => $posts]);
  }

  public function updatingSearch()
  {
    $this->resetPage();
  }
}
