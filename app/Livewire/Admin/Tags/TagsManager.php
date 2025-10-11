<?php

namespace App\Livewire\Admin\Tags;

use App\Models\Tag;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On; 
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class TagsManager extends Component
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
    //$this->perPage = 10;
    $this->authorize('tags.index');
  }

  #[On('refreshTags')]
  public function reloadTagsList()
  {
    $this->resetPage();
  }

  public function render()
  {
    $tags = Tag::where('name', 'like', "%{$this->search}%")
      ->orWhere('slug', 'like', "%{$this->search}%")
      ->paginate($this->perPage);

    return view('livewire.admin.tags.tags-manager', [
      'tags' => $tags,
    ]);
  }

  public function updatingSearch()
  {
    $this->resetPage();
  }
}
