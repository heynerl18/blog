<?php

namespace App\Livewire\Public;

use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class PublicCategoryPosts extends Component
{
  public Category $category;
  public $posts;

  public function mount(Category $category)
  {
    $this->category = $category;
    $this->posts = $this->category->posts()->with(['category', 'user', 'media', 'tags'])->get();
    // Add the status of post
  }

  public function render()
  {
    return view('livewire.public.public-category-posts', ['posts' => $this->posts]);
  }
}
