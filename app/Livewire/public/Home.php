<?php

namespace App\Livewire\Public;

use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')] 
class Home extends Component
{
  public function render()
  {
    $posts = Post::with(['user', 'category', 'media', 'tags'])
      ->latest()
/*       ->take(4) */
      ->get();
      
    return view('livewire.public.home', ['posts' => $posts]);
  }
}
