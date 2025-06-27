<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.public')]
class AboutPage extends Component
{
	public function render()
	{
		return view('livewire.public.about-page');
	}
}
