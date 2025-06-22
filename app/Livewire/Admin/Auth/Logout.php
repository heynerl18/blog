<?php

namespace App\Livewire\Admin\Auth;

use App\Livewire\Actions\Logout as ActionsLogout;
use Livewire\Component;

class Logout extends Component
{
	public function logout(ActionsLogout $logout)
	{
		$logout();
		return redirect()->to('/login');
	}
	public function render()
	{
		return view('livewire.admin.auth.logout');
	}
}
