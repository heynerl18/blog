<?php

namespace App\Livewire\Admin\Roles;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DeleteRole extends Component
{
	use AuthorizesRequests;

	public $roleId;
	public $isModalOpen = false;

	#[On('openModalDelete')]
	public function openModalDelete($roleId)
	{
		$this->authorize('roles.destroy');
		$role = Role::findOrFail($roleId);

		if($role->name === 'Admin'){
			$this->dispatch('showAlert',
				message: 'El rol Admin no se puede eliminar por seguridad.',
				type: 'error'
			);
			return;
		}

		$this->roleId = $role->id;
		$this->isModalOpen = true;
	}

	#[On('closeDeleteModal')]
	public function closeDeleteModal()
	{
		$this->isModalOpen = false;
		$this->reset('roleId');
	}

	public function deleteRole()
	{
		$this->authorize('roles.destroy');
		try {

			$role = Role::findOrFail($this->roleId);

			if(!$role) {
				$this->dispatch('showAlert',
					message: 'El rol no existe o ya fue eliminado.',
					type: 'error'
				);
				$this->closeDeleteModal();
				return;
			}
      // Do not allow deleting Admin role
			if($role->name === 'Admin'){
				$this->dispatch('showAlert',
					message: 'El rol Admin no se puede eliminar por seguridad.',
					type: 'error'
				);
				$this->closeDeleteModal();
				return;
			}
      
			// Check if role has users assigned
			if($role->users()->count() > 0){
				$usersCount = $role->users()->count();
				$this->dispatch('showAlert',
					message: "No se puede eliminar el rol porque tiene {$usersCount} " . 
						($usersCount === 1 ? 'usuario asignado' : 'usuarios asignados') . '.',
					type: 'warning'
        );
				$this->closeDeleteModal();
				return;
			}

			$role->delete();

			// Clear permission cache
			app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

			$this->dispatch('refreshRoles');
			$this->closeDeleteModal();

			$this->dispatch('showAlert', message: 'Rol eliminado correctamente.', type: 'success');

		} catch (\Exception $e) {

			$this->closeDeleteModal();

			$this->dispatch('showAlert',
        message: 'Ocurrió un error al eliminar el rol. Por favor, inténtalo de nuevo.',
        type: 'error'
      );
            
      Log::error('Error al eliminar el rol: ' . $e->getMessage());
		}
	}

	public function render()
	{
		return view('livewire.admin.roles.delete-role');
	}
}
