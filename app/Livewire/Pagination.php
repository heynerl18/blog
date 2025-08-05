<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Pagination extends Component
{
  use WithPagination;

  public $totalItems; // Total de elementos
  public $itemsPerPage; // Elementos por página
  public $currentPage = 1; // Página actual

  #[On('pageChanged')] 
  public function updatePage($page)
  {
    $this->currentPage = $page;
  }

  public function previousPage()
  {
    if ($this->currentPage > 1) {
      $this->currentPage--;
      $this->dispatch('pageChanged', $this->currentPage);
    }
  }

  public function nextPage()
  {
    if ($this->currentPage < ceil($this->totalItems / $this->itemsPerPage)) {
      $this->currentPage++;
      $this->dispatch('pageChanged', $this->currentPage);
    }
  }

  public function render()
  {
    // Calcular el rango de elementos mostrados
    $startItem = ($this->currentPage - 1) * $this->itemsPerPage + 1;
    $endItem = min($this->currentPage * $this->itemsPerPage, $this->totalItems);

    return view('livewire.pagination', [
      'startItem' => $startItem,
      'endItem' => $endItem,
      'totalPages' => ceil($this->totalItems / $this->itemsPerPage),
    ]);
  }
}
