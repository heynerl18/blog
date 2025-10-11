<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\Attributes\On;

class AddEditCategory extends Component
{
  use AuthorizesRequests;

  public $categoryId;
  public $isModalOpen = false;
  public $name;

  protected $rules = [
    'name' => 'required|min:3|max:255',
  ];

  protected $messages = [
    'name.required' => 'El nombre de la categoría es requerido.',
    'name.min' => 'El nombre debe tener al menos 3 caracteres.',
    'name.max' => 'El nombre no puede tener más de 255 caracteres.',
  ];

  #[On('openModal')]
  public function openModal($categoryId = null)
  {
    if($categoryId){
      $this->authorize('categories.edit');
    } else {
      $this->authorize('categories.create');
    }
    
    $this->resetForm();
    $this->categoryId = $categoryId;

    if ($categoryId) {
      $category = Category::findOrFail($categoryId);
      $this->name = $category->name;
    }

    $this->isModalOpen = true;
  }

  #[On('closeModal')]
  public function closeModal()
  {
    $this->isModalOpen = false;
    $this->resetForm();
    $this->resetValidation();
  }

  public function save()
  {
    $this->validate();

    if ($this->categoryId) {

      $this->authorize('categories.edit');

      $category = Category::findOrFail($this->categoryId);
      $category->update([
        'name' => $this->name,
      ]);
      $message = 'Categoría actualizada correctamente.';
    } else {

      $this->authorize('categories.create');

      Category::create([
        'name' => $this->name,
      ]);
      $message = 'Categoría creada correctamente.';
    }

    $this->closeModal();
    $this->dispatch('refreshCategories');
    $this->dispatch('showAlert', message: $message, type: 'success');
  }

  public function resetForm()
  {
    $this->reset(['categoryId', 'name']);
    $this->resetValidation();
  }

  public function render()
  {
    return view('livewire.admin.categories.add-edit-category');
  }
}
