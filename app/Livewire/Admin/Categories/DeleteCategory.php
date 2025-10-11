<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;

class DeleteCategory extends Component
{
	use AuthorizesRequests;

	public $categoryId;
	public $isModalOpen = false;

	#[On('openModalDelete')]
	public function openModalDelete($categoryId)
	{
		$this->authorize('categories.destroy');

		$category = Category::findOrFail($categoryId);
		$this->categoryId = $category->id;
		$this->isModalOpen = true;
	}

	#[On('closeModalDelete')]
	public function closeModalDelete()
	{
		$this->isModalOpen = false;
		$this->reset('categoryId');
	}

	public function deleteCategory()
	{
		$this->authorize('categories.destroy');
		
		try {
			$category = Category::findOrFail($this->categoryId);

			if($category->posts()->count() > 0){
				$this->dispatch('showAlert',
					message: 'No se puede eliminar la categoría porque tiene posts asociados.',
					type: 'error'
				);
				$this->closeModalDelete();
				return;
			}

			$category->delete();

			$message = 'Categoría eliminada correctamente.';

			$this->closeModalDelete();
			$this->dispatch('refreshCategories');
			$this->dispatch('showAlert', message: $message, type: 'success');

		} catch (\Exception $e) {

			$this->closeModalDelete();
			$message = 'Ocurrió un error al eliminar la categoría. Por favor, inténtalo de nuevo.';
			$this->dispatch('showAlert', message: $message, type: 'error');
			Log::error('Error al eliminar la etiqueta: ' . $e->getMessage());
		}
	}

	public function render()
	{
		return view('livewire.admin.categories.delete-category');
	}
}
