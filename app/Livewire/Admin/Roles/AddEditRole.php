<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Component;
use Livewire\Attributes\On;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\Validate;

class AddEditRole extends Component
{
    public $roleId;
    public $isModalOpen = false;
    #[Validate]
    public $name = '';
    public $selectedPermissions = [];
    
    protected $rules = [
      'name' => 'required|min:3|max:255|unique:Roles,name',
    ];

    protected $messages = [
      'name.required' => 'El nombre del rol es obligatorio.',
      'name.min' => 'El nombre debe tener al menos 3 caracteres.',
      'name.unique' => 'Este rol ya existe.',
    ];

    #[On('openModal')]
    public function openModal($roleId = null)
    {
      $this->resetForm();
      $this->roleId = $roleId;
  
      if ($roleId) {
        $role = Role::find($roleId);
        $this->name = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
      }
      
      $this->isModalOpen = true;
    }

    #[On('closeModal')]
    public function closeModal()
    {
      $this->resetForm();
      $this->resetValidation();
      $this->isModalOpen = false;
    }

    public function save()
    {
      $this->validate();
  
      if ($this->roleId) {
        $role = Role::find($this->roleId);
        $role->update([
          'name' => $this->name,
        ]);
        $role->permissions()->sync($this->selectedPermissions);
        $message = 'Rol actualizado correctamente.';
      } else {
        $role = Role::create([
          'name' => $this->name,
        ]);
        $role->permissions()->sync($this->selectedPermissions);
        $message = 'Rol creado correctamente.';
      }
  
      $this->closeModal();
      $this->dispatch('refreshRoles');
      $this->dispatch('showAlert', message: $message);
    }

    public function resetForm()
    {
      $this->reset(['roleId', 'name', 'selectedPermissions']);
    }

    public function render()
    {
      $permissions = Permission::all();
      return view('livewire.admin.roles.add-edit-role', ['permissions' => $permissions]);
    }
}
