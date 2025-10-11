<?php

namespace App\Livewire\Admin\Tags;

use App\Models\Tag;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\Attributes\On;

class DeleteTag extends Component
{
	use AuthorizesRequests;

	public $tagId;
	public $isModalOpen = false;

	#[On('openModalDelete')]
	public function openModalDelete($tagId)
	{
		$this->authorize('tags.destroy');

		$tag = Tag::findOrFail($tagId);
		$this->tagId = $tag->id;
		$this->isModalOpen = true;
	}

	#[On('closeModalDelete')]
	public function closeModalDelete()
	{
		$this->isModalOpen = false;
		$this->reset('tagId');
	}

	public function deleteTag()
	{
		$this->authorize('tags.destroy');

		try {
			$tag = Tag::findOrFail($this->tagId);

			if($tag->posts()->count() > 0){
				$this->dispatch('showAlert',
					message: 'No se puede eliminar la etiqueta porque tiene posts asociados.',
					type: 'error'
				);
				$this->closeModalDelete();
				return;
			}

			if ($tag) {
				$tag->delete();
				$this->dispatch('refreshTags');
				$message = 'Etiqueta eliminada correctamente.';
			} else {
				$message = 'La etiqueta no existe o ya fue eliminada.';
			}

			$this->closeModalDelete();
			$this->dispatch('showAlert', message: $message);

		} catch (\Exception $e) {

			$this->closeModalDelete();
			$message = 'Ocurrió un error al eliminar la etiqueta. Por favor, inténtalo de nuevo.';
			$this->dispatch('showAlert', message: $message);
		}
	}

	public function render()
	{
		return view('livewire.admin.tags.delete-tag');
	}
}
