<?php

namespace App\Livewire\Admin\Tags;

use App\Models\Tag;
use Livewire\Component;
use Livewire\Attributes\On;

class DeleteTag extends Component
{
	public $tagId;
	public $isModalOpen = false;

	#[On('openModalDelete')]
	public function openModalDelete($tagId)
	{
		$this->tagId = $tagId;
		$this->isModalOpen = true;
	}

	#[On('closeDeleteTagModal')]
	public function closeDeleteTagModal()
	{
		$this->isModalOpen = false;
	}

	public function deleteTag()
	{
		try {
			$tag = Tag::find($this->tagId);

			if ($tag) {
				$tag->delete();
				$this->dispatch('refreshTags');
				$message = 'Etiqueta eliminada correctamente.';
			} else {
				$message = 'La etiqueta no existe o ya fue eliminada.';
			}

			$this->closeDeleteTagModal();
			$this->dispatch('showAlert', message: $message);

		} catch (\Exception $e) {

			$this->closeDeleteTagModal();
			$message = 'Ocurrió un error al eliminar la etiqueta. Por favor, inténtalo de nuevo.';
			$this->dispatch('showAlert', message: $message);
		}
	}

	public function render()
	{
		return view('livewire.admin.tags.delete-tag');
	}
}
