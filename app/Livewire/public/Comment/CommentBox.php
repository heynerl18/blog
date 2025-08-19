<?php

namespace App\Livewire\Public\Comment;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class CommentBox extends Component
{
	public Post $post;
	public $comment;

	public function mount(Post $post)
	{
		$this->post = $post;
		$this->comment = '';
	}


	public function sendComment()
	{

		if(!Auth::check()) {
			session()->flash('status', 'Debes iniciar sesión para publicar un comentario.');
			return redirect()->guest(route('login'));
		}

		try {			
			// Validation rule.
			$this->validate(
				[
				'comment' => 'required|string|min:2|max:500',
				],
				[
					'comment.required' => 'El comentario es requerido.',
					'comment.string' => 'El comentario debe ser un texto.',
					'comment.min' => 'El comentario debe tener al menos 2 caracteres.',
					'comment.max' => 'El comentario no puede tener más de 500 caracteres.',
				]
		  );

			// Create a new comment.
			$newComment =Comment::create([
				'comment' => $this->comment,
				'user_id' => Auth::id(), // Assuming the user is authenticated
				'post_id' => $this->post->id,
				'parent_id' => null, // This is a top-level comment
				'likes_count' => 0,
				'dislikes_count' => 0,
			]);

		  $this->reset('comment');
			$this->dispatch('commentAdded', $newComment->id)->to('public.comment.comment-list');

		} catch (ValidationException $e) {
			throw $e;
		}
	}

	public function render()
	{
		return view('livewire.public.comment.comment-box');
	}
}
