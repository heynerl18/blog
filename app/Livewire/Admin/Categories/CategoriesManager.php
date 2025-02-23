<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On; 

class CategoriesManager extends Component
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
    // $this->perPage = 10;
  }

  #[On('refreshCategories')]
  public function reloadTags()
  {
    $this->resetPage();
  }

  public function render()
  {
    $categories = Category::where('name', 'like', "%{$this->search}%")
    ->paginate($this->perPage);
    return view('livewire.admin.categories.categories-manager', ['categories' => $categories]);
  }

  public function updatingSearch()
  {
    $this->resetPage();
  }
}
