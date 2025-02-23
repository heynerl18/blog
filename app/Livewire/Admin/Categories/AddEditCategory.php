<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\On;

class AddEditCategory extends Component
{
  public $categoryId;
  public $isModalOpen = false;
  public $name;

  protected $rules = [
    'name' => 'required|min:3|max:255|unique:categories,name',
  ];

  protected $messages = [
    'name.required' => 'El nombre de la categoría es obligatorio.',
    'name.min' => 'El nombre debe tener al menos 3 caracteres.',
    'name.max' => 'El nombre no puede tener más de 255 caracteres.',
    'name.unique' => 'Esta categoría ya existe.',
  ];

  #[On('openModal')]
  public function openModal($categoryId = null)
  {
    $this->resetForm();
    $this->categoryId = $categoryId;

    if ($categoryId) {
      $category = Category::find($categoryId);
      $this->name = $category->name;
    }

    $this->isModalOpen = true;
  }

  #[On('closeModal')]
  public function closeModal()
  {
    $this->isModalOpen = false;
    $this->resetForm();
  }

  public function save()
  {
    $this->validate();

    if ($this->categoryId) {
      $category = Category::find($this->categoryId);
      $category->update([
        'name' => $this->name,
      ]);
      $message = 'Categoría actualizada correctamente.';
    } else {
      Category::create([
        'name' => $this->name,
      ]);
      $message = 'Categoría creada correctamente.';
    }

    $this->closeModal();
    $this->dispatch('refreshCategories');
    $this->dispatch('showAlert', message: $message);
  }

  public function resetForm()
  {
    $this->reset(['categoryId', 'name']);
  }

  public function render()
  {
    return view('livewire.admin.categories.add-edit-category');
  }
}
