<?php

namespace App\Livewire\Admin\Roles;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class RolesManager extends Component
{
  use WithPagination;
  use AuthorizesRequests;

  public $perPage = 5;
  public $search = '';
  
  #[On('pageChanged')]
  public function updatePage($page)
  {
    $this->setPage($page);
  }

  public function mount()
  {
    // $this->perPage = 10;
    $this->authorize('roles.index');
  }

  #[On('refreshRoles')]
  public function reloadRoles()
  {
    $this->resetPage();
  }

  public function render()
  {
    $roles = Role::withCount('permissions', 'users')
      ->where('name', 'like', "%{$this->search}%")
      ->paginate($this->perPage);

    return view('livewire.admin.roles.roles-manager', ['roles' => $roles]);
  }

  public function updatingSearch()
  {
    $this->resetPage();
  }
}
