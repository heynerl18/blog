<?php

namespace App\Livewire\Public;

use App\Models\Tag;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class PublicTagPosts extends Component
{
  public Tag $tag;
  public $posts;

  public function mount(Tag $tag) {
    $this->tag = $tag;
    $this->posts = $this->tag->posts()->with(['category', 'user', 'media', 'tags'])->get();
    // Add the status of post
  }

  public function render()
  {
    return view('livewire.public.public-tag-posts', ['posts' => $this->posts]);
  }
}
