<?php

namespace App\Livewire\Admin\Posts;

use Livewire\Component;

class RichTextEditor extends Component
{
  public $content = '';

  public function render()
  {
    return view('livewire.admin.posts.rich-text-editor');
  }
}
