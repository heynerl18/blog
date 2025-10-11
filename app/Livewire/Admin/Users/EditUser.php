<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Spatie\Permission\PermissionRegistrar;

class EditUser extends Component
{
  use AuthorizesRequests;

  public $userId;
  public $isModalOpen = false;

  #[Validate('required', message: 'El nombre es requerido.')]
  public $name = '';

  public $selectedRoles = [];

  #[On('openModal')]
  public function openModal($userId)
  {
    $this->authorize('users.edit'); 
    
    $this->resetForm();
    $this->userId = $userId;

    if ($userId) {
      // edit mode
      $user = User::with('roles')->find($userId);
      // prevent editing own role
      if($user->id === auth()->id()){
        $this->dispatch('showAlert', message: 'No puedes modificar tu propio rol', type: 'error');
        return;
      }

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
    $this->authorize('users.edit');
    $this->validate();
    
    if ($this->userId) {
      // update mode
      $user = User::findOrFail($this->userId);
      // prevent editing own role
      if($user->id === auth()->id()){
        $this->dispatch('showAlert', message: 'No puedes modificar tu propio rol.', type: 'error');
        $this->closeModal();
        return;
      }
      $user->roles()->sync($this->selectedRoles);

      $message = empty($this->selectedRoles) 
      ? "Se quitaron todos los roles de {$user->name}."
      : 'Se asignó los roles correctamente.';
    }

    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

    $this->closeModal();
    $this->dispatch('refreshUsers');
    $this->dispatch('showAlert', message: $message, type: 'success');
  }

  public function resetForm()
  {
    $this->reset(['userId', 'name', 'selectedRoles']);
    $this->resetValidation();
  }

  public function render()
  {
    $roles = Role::all();
    return view('livewire.admin.users.edit-user', ['roles' => $roles]);
  }
}
