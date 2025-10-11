<?php

namespace App\Livewire\Admin\Tags;

use App\Models\Tag;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

class AddEditTag extends Component
{
  use AuthorizesRequests;

  public $isOpen = false;
  public $tagId = null;
  #[Validate]
  public $name = '';

  protected $rules = [
    'name' => 'required|min:3|max:255',
  ];

  protected $messages = [
    'name.required' => 'El nombre de la etiqueta es requerido.',
    'name.min' => 'El nombre debe tener al menos 3 caracteres.',
    'name.max' => 'El nombre no puede tener más de 255 caracteres.',
  ];

  #[On('openModal')]
  public function openModal($tagId = null)
  {
    if($tagId){
      $this->authorize('tags.edit');
    } else {
      $this->authorize('tags.create');
    }

    $this->resetForm();
    $this->tagId = $tagId;

    if ($tagId) {
      $tag = Tag::findOrFail($tagId);
      $this->name = $tag->name;
    }

    $this->isOpen = true;
  }

  #[On('closeModal')]
  public function closeModal()
  {
    $this->isOpen = false;
    $this->resetForm();
    $this->resetValidation();
  }

  public function save()
  {
    $this->validate();

    if ($this->tagId) {

      $this->authorize('tags.edit');

      $tag = Tag::findOrFail($this->tagId);
      $tag->update([
        'name' => $this->name
      ]);
      $message = 'Etiqueta actualizada correctamente.';
    } else {

      $this->authorize('tags.create');

      Tag::create([
        'name' => $this->name
      ]);
      $message = 'Etiqueta creada correctamente.';
    }

    $this->closeModal();
    $this->dispatch('refreshTags');
    $this->dispatch('showAlert', message: $message, type: 'success');
  }

  public function resetForm()
  {
    $this->reset(['tagId', 'name']);
    $this->resetValidation();
  }

  public function render()
  {
    return view('livewire.admin.tags.add-edit-tag');
  }
}
