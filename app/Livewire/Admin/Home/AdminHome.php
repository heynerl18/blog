<?php

namespace App\Livewire\Admin\Home;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class AdminHome extends Component
{
  public function render()
  {
    return view('livewire.admin.home.admin-home');
  }
}
