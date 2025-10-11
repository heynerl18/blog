<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On; 
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class CategoriesManager extends Component
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
    $this->authorize('categories.index');
  }

  #[On('refreshCategories')]
  public function reloadCategoriesList()
  {
    $this->resetPage();
  }

  public function render()
  {
    $categories = Category::where('name', 'like', "%{$this->search}%")
      ->orWhere('slug', 'like', "%{$this->search}%")
      ->paginate($this->perPage);
    return view('livewire.admin.categories.categories-manager', ['categories' => $categories]);
  }

  public function updatingSearch()
  {
    $this->resetPage();
  }
}
