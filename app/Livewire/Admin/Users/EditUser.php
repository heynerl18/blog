<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Spatie\Permission\PermissionRegistrar;

class EditUser extends Component
{
  public $userId;
  public $isModalOpen = false;
  #[Validate]
  #[Validate('required', message: 'El nombre es requerido.')]
  public $name = '';
  public $selectedRoles = [];

  private function checkEditPermission()
  {
    if (!auth()->user()->can('users.edit')) {
      session()->flash('error', 'No tienes permiso para editar usuarios.');
      $this->closeModal();
      return false;
    }
    return true;
  }

  #[On('openModal')]
  public function openModal($userId)
  {
    if (!$this->checkEditPermission()) {
      return;
    }

    $this->resetForm();
    $this->userId = $userId;

    if ($userId) {
      // edit mode
      $user = User::with('roles')->find($userId);
      $this->name = $user->name;
      // load roles
      $this->selectedRoles = $user->roles->pluck('id')->toArray();
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
    if (!$this->checkEditPermission()) {
      return;
    }
    
    if ($this->userId) {
      $user = User::find($this->userId);
      $user->roles()->sync($this->selectedRoles);
      $message = 'Se asignó los roles correctamente.';
    }

    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

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
