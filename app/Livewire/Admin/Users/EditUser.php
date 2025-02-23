<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

class EditUser extends Component
{
  public $userId;
  public $isModalOpen = false;
  #[Validate]
  #[Validate('required', message: 'El nombre es obligatorio.')]
  public $name = '';
  public $selectedRoles = [];

  private function checkEditPermission()
  {
    if (!auth()->user()->can('users.edit')) {
      abort(403, 'No tienes permiso para editar.');
    }
  }

  #[On('openModal')]
  public function openModal($userId)
  {
    $this->checkEditPermission();

    $this->resetForm();
    $this->userId = $userId;

    if ($userId) {
      // edit mode
      $user = User::find($userId);
      $this->name = $user->name;
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
    $this->checkEditPermission();
    
    if ($this->userId) {
      $user = User::find($this->userId);
      $user->roles()->sync($this->selectedRoles);
      $message = 'Se asignó los roles correctamente.';
    }

    $this->closeModal();
    $this->dispatch('refreshUsers');
    $this->dispatch('showAlert', message: $message);
  }

  public function resetForm()
  {
    $this->reset(['userId', 'name', 'selectedRoles']);
  }

  public function render()
  {
    $roles = Role::all();
    return view('livewire.admin.users.edit-user', ['roles' => $roles]);
  }
}
