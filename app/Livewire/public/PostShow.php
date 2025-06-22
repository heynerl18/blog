<?php

namespace App\Livewire\Public;

use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class PostShow extends Component
{
  public Post $post;

  public function mount(Post $post)
  {
    $this->post = $post;
    // Add the status of post
  }
  public function render()
  {
    return view('livewire.public.post-show');
  }
}
