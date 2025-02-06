<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class DeleteRole extends Component
{
	public $roleId;
	public $isModalOpen = false;

	#[On('openModalDelete')]
	public function openModalDelete($roleId)
	{
		$this->roleId = $roleId;
		$this->isModalOpen = true;
	}

	#[On('closeDeleteModal')]
	public function closeDeleteModal()
	{
		$this->isModalOpen = false;
	}

	public function deleteRole()
	{
		try {

			$role = Role::find($this->roleId);
			if ($role) {
				$role->delete();
				$this->dispatch('refreshRoles');
				$message = 'Rol eliminado correctamente.';
			} else {
				$message = 'El rol no existe o ya fue eliminada.';
			}

			$this->closeDeleteModal();
			$this->dispatch('showAlert', message: $message);
		} catch (\Exception $e) {

			$this->closeDeleteModal();
			$message = 'Ocurrió un error al eliminar el rol. Por favor, inténtalo de nuevo.';
			$this->dispatch('showAlert', message: $message);
			Log::error('Error al eliminar el rol: ' . $e->getMessage());
		}
	}

	public function render()
	{
		return view('livewire.admin.roles.delete-role');
	}
}
