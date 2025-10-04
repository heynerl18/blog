<?php

namespace App\Livewire\Admin\Comments;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class CommentsManager extends Component
{
  public function render()
  {
    return view('livewire.admin.comments.comments-manager');
  }
}
