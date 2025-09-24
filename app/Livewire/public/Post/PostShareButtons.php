<?php

namespace App\Livewire\Public\Post;

use Livewire\Component;
use App\Models\Post;

class PostShareButtons extends Component
{
  public Post $post;
  public $currentUrl;

  public function mount(Post $post)
  {
    $this->post = $post;
    $this->currentUrl = url()->current();
  }

  public function getFacebookUrlProperty()
  {
    return 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($this->currentUrl);
  }

  public function getTwitterUrlProperty()
  {
    return 'https://twitter.com/intent/tweet?url=' . urlencode($this->currentUrl) . '&text=' . urlencode($this->post->title);
  }

  public function getWhatsappUrlProperty()
  {
    return 'https://wa.me/?text=' . urlencode($this->post->title . ' - ' . $this->currentUrl);
  }

  public function render()
  {
    return view('livewire.public.post.post-share-buttons');
  }
}
