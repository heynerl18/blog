<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class PostsManager extends Component
{
  use WithPagination;

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
