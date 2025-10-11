<?php

namespace App\Livewire\Admin\Roles;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\Attributes\On;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\Validate;
use Spatie\Permission\PermissionRegistrar;

class AddEditRole extends Component
{
  use AuthorizesRequests;

  public $roleId;
  public $isModalOpen = false;

  #[Validate('required|min:3|max:10', message: 'El nombre del rol es requerido y debe tener entre 3 y 10 caracteres.')]
  public $name = '';
  public $selectedPermissions = [];
    
  protected $messages = [
    'name.required' => 'El nombre del rol es requerido.',
    'name.min' => 'El nombre debe tener al menos 3 caracteres.',
    'name.max' => 'El nombre no puede tener más de 10 caracteres.',
  ];

  #[On('openModal')]
  public function openModal($roleId = null)
  {
    if($roleId){
      $this->authorize('roles.edit');
    } else {
      $this->authorize('roles.create');
    }

    $this->resetForm();
    $this->roleId = $roleId;

    if ($roleId) {
      $role = Role::findOrFail($roleId);

      if($role->name === 'Admin'){
        $this->dispatch('showAlert',
          message: 'El rol Admin no se puede editar por seguridad.',
          type: 'error'
        );
        return;
      }

      $this->name = $role->name;
      $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
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

    if ($this->roleId) {
      $this->authorize('roles.edit');

      $role = Role::findOrFail($this->roleId);
      
      // Prevent editing Admin role
      if($role->name === 'Admin'){
        $this->dispatch('showAlert',
          message: 'El rol Admin no se puede editar por seguridad.',
          type: 'error'
        );
        $this->closeModal();
        return;
      }

      if(strtolower($this->name) === 'admin' && $role->name !== 'Admin'){
        $this->addError('name', 'No puedes usar el nombre "Admin".');
        $this->reset('name');
        return;
      }

      $role->update([
        'name' => $this->name,
      ]);

      $role->permissions()->sync($this->selectedPermissions);
      $message = 'Rol actualizado correctamente.';
      
    } else {

      $this->authorize('roles.create');

      if (strtolower($this->name) === 'admin') {
        $this->addError('name', 'No puedes crear un rol con el nombre "Admin".');
        return;
      }

      if(Role::where('name', $this->name)->exists()){
        $this->addError('name', 'Ya existe un rol con ese nombre.');
        $this->reset('name');
        return;
      }
      // Create new role
      $role = Role::create([
        'name' => $this->name,
      ]);

      $role->permissions()->sync($this->selectedPermissions);
      $message = 'Rol creado correctamente.';
    }
    // Clear permission cache
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

    $this->closeModal();
    $this->dispatch('refreshRoles');
    $this->dispatch('showAlert', message: $message, type: 'success');
  }

  public function resetForm()
  {
    $this->reset(['roleId', 'name', 'selectedPermissions']);
    $this->resetValidation();
  }

  public function render()
  {
    $permissions = Permission::all()->groupBy(function ($permission){
      return explode('.', $permission->name)[0]; // Group by: users, posts, categories, etc.
    });
    return view('livewire.admin.roles.add-edit-role', ['permissions' => $permissions]);
  }
}
