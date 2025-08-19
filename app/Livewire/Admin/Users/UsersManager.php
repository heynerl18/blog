<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On; 
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class UsersManager extends Component
{
  use WithPagination;

  public $perPage = 10;
  public $search = '';

  #[On('pageChanged')]
  public function updatePage($page)
  {
    $this->setPage($page);
  }

  public function mount()
  {
    // 
  }

  #[On('refreshUsers')]
  public function reloadUsers()
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
