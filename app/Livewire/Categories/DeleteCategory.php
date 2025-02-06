<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;

class DeleteCategory extends Component
{
	public $categoryId;
	public $isModalOpen = false;

	#[On('openModalDelete')]
	public function openModalDelete($categoryId)
	{
		$this->categoryId = $categoryId;
		$this->isModalOpen = true;
	}

	#[On('closeDeleteCategoryModal')]
	public function closeDeleteCategoryModal()
	{
		$this->isModalOpen = false;
	}

	public function deleteCategory()
	{
		try {
			$category = Category::find($this->categoryId);

			if ($category) {
				$category->delete();
				$this->dispatch('refreshCategories');
				$message = 'Categoría eliminada correctamente.';
			} else {
				$message = 'La categoría no existe o ya fue eliminada.';
			}

			$this->closeDeleteCategoryModal();
			$this->dispatch('showAlert', message: $message);
		} catch (\Exception $e) {

			$this->closeDeleteCategoryModal();
			$message = 'Ocurrió un error al eliminar la categoría. Por favor, inténtalo de nuevo.';
			$this->dispatch('showAlert', message: $message);
			Log::error('Error al eliminar la etiqueta: ' . $e->getMessage());
		}
	}

	public function render()
	{
		return view('livewire.categories.delete-category');
	}
}
