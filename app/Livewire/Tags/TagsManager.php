<?php

namespace App\Livewire\Tags;

use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On; 

class TagsManager extends Component
{
  use WithPagination;

  public $perPage = 10;
  protected $listeners = ['pageChanged' => 'updatePage'];
  public $search = '';

  public function updatePage($page)
  {
    $this->setPage($page);
  }

  public function mount()
  {
    //$this->perPage = 10;
  }

  #[On('refreshTags')]
  public function reloadTags()
  {
    $this->resetPage();
  }

  public function render()
  {
    $tags = Tag::where('name', 'like', "%{$this->search}%")
      ->paginate($this->perPage);

    return view('livewire.tags.tags-manager', [
      'tags' => $tags,
    ]);
  }

  public function updatingSearch()
  {
    $this->resetPage();
  }
}
