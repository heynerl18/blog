<?php

namespace App\Livewire\Admin\Tags;

use App\Models\Tag;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

class AddEditTag extends Component
{
  public $isOpen = false;
  public $tagId = null;
  #[Validate]
  public $name = '';

  protected $rules = [
    'name' => 'required|min:3|max:255|unique:tags,name',
  ];

  protected $messages = [
    'name.required' => 'El nombre de la etiqueta es obligatorio.',
    'name.min' => 'El nombre debe tener al menos 3 caracteres.',
    'name.max' => 'El nombre no puede tener más de 255 caracteres.',
    'name.unique' => 'Esta etiqueta ya existe.',
  ];

  #[On('openModal')]
  public function openModal($tagId = null)
  {
    $this->resetForm();
    $this->tagId = $tagId;

    if ($tagId) {
      $tag = Tag::find($tagId);
      $this->name = $tag->name;
    }

    $this->isOpen = true;
  }

  #[On('closeModal')]
  public function closeModal()
  {
    $this->resetForm();
    $this->resetValidation();
    $this->isOpen = false;
  }

  public function save()
  {
    $this->validate();

    if ($this->tagId) {
      $tag = Tag::find($this->tagId);
      $tag->update([
        'name' => $this->name
      ]);
      $message = 'Etiqueta actualizada correctamente.';
    } else {
      Tag::create([
        'name' => $this->name
      ]);
      $message = 'Etiqueta creada correctamente.';
    }

    $this->closeModal();
    $this->dispatch('refreshTags');
    $this->dispatch('showAlert', message: $message);
  }

  public function resetForm()
  {
    $this->reset(['tagId', 'name']);
  }

  public function render()
  {
    return view('livewire.admin.tags.add-edit-tag');
  }
}
