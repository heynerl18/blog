<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Spatie\Permission\Models\Role;

class RolesManager extends Component
{
  use WithPagination;

  public $perPage = 5;
  protected $listeners = ['pageChanged' => 'updatePage'];
  public $search = '';

  public function updatePage($page)
  {
    $this->setPage($page);
  }

  public function mount()
  {
    // $this->perPage = 10;
  }

  #[On('refreshRoles')]
  public function reloadTags()
  {
    $this->resetPage();
  }

  public function render()
  {
    $roles = Role::where('name', 'like', "%{$this->search}%")
     ->paginate($this->perPage);

    return view('livewire.admin.roles.roles-manager', ['roles' => $roles]);
  }

  public function updatingSearch()
  {
    $this->resetPage();
  }
}
