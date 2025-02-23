<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On; 

class UsersManager extends Component
{
  use WithPagination;

  public $perPage = 10;
  protected $listeners = ['pageChanged' => 'updatePage'];
  public $search = '';

  public function updatePage($page)
  {
    $this->setPage($page);
  }

  public function mount()
  {
    // 
  }

  #[On('refreshUsers')]
  public function reloadTags()
  {
    $this->resetPage();
  }

  public function render()
  {
    $users = User::where('name', 'like', "%{$this->search}%")
      ->paginate($this->perPage);
    return view('livewire.admin.users.users-manager', ['users' => $users]);
  }

  public function updatingSearch()
  {
    $this->resetPage();
  }
}
