<?php

namespace App\Livewire\Public\Comment;

use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;

class CommentList extends Component
{
	public Post $post;
	public $comments = null;
	public $replyingTo = null;
	public $replyComment = null;
	public $collapsedReplies = [];

	public $editingComment = null;
	public $editCommentContent = '';


	public function mount(Post $post)
	{
		$this->post = $post;
		$this->loadComments();
		$this->collapseAllReplies();
	}

  #[On('commentAdded')]
	public function reloadComments($commentId)
	{
		$newComment = Comment::with('user')->find($commentId);
		if($newComment){
			$this->comments->prepend($newComment);
		}
	}

	private function loadComments()
	{
		// Load comments from the database
		$this->comments = $this->post->comments()
			->with([
				'user',
				'replies.user',
				// Load likes for the current user
				'likes' => function($query) {
					if(Auth::check()) {
						$query->where('user_id', Auth::id());
					}else {
						$query->whereRaw('1=0'); // No likes for unauthenticated users
					}
				},
				// Load replies with user and likes for the current user
				'replies.likes' => function($query) {
					if(Auth::check()) {
						$query->where('user_id', Auth::id());
					}else {
						$query->whereRaw('1=0'); // No likes for unauthenticated users
					}
				},
			])
			->whereNull('parent_id')
			->orderBy('created_at', 'desc')
			->get();
	}

	public function setReply($commentId)
	{
		$this->replyingTo = $commentId;
		$this->replyComment = null;
	}

	public function cancelReply()
	{
		$this->replyingTo = null;
		$this->replyComment = null;
	}

	public function likeComment($commentId)
	{
		if(!Auth::check()) {
			session()->flash('status', 'Debes iniciar sesión para dar "Me gusta".');
			return redirect()->guest(route('login'));
		}
		
		$userId = Auth::id();
		$comment = Comment::find($commentId);

		if(!$comment){
			//session()->flash('status', 'Comentario no encontrado.');
			return;
		}

		// Check if the user has already liked this comment
		$existingInteraction = CommentLike::where('comment_id', $commentId)
			->where('user_id', $userId)
			->first();

		if($existingInteraction) {
			// User has already interacted with this comment
			if($existingInteraction->is_like) {
				// If the existing interaction was a LIKE, and they click LIKE again, we remove it (UNLIKE)
				$existingInteraction->delete();
			}else {
				// If the existing interaction was a DISLIKE, and they click LIKE, we change it to LIKE
				$existingInteraction->update(['is_like' => true]);
			}
		} else {
			// User has not interacted with this comment yet, so we add a like
			CommentLike::create([
				'user_id' => $userId,
				'comment_id' => $commentId,
				'is_like' => true,
			]);
		}

		$this->loadComments();
	}

	public function dislikeComment($commentId)
	{
		if(!Auth::check()) {
			session()->flash('status', 'Debes iniciar sesión para dar "No me gusta".');
			return redirect()->guest(route('login'));
		}

		$userId = Auth::id();
		$comment = Comment::find($commentId);
		
		if (!$comment) {
			//session()->flash('status', 'El comentario no existe.');
			return;
    }

		$existingInteraction = CommentLike::where('user_id', $userId)
			->where('comment_id', $commentId)
			->first();
			
		if ($existingInteraction) {
			if(!$existingInteraction->is_like) {
				// If the existing interaction was a DISLIKE, and they click DISLIKE again, we remove it (UNDISLIKE)
				$existingInteraction->delete();
			}else {
				// If the existing interaction was a LIKE, and they click DISLIKE, we change it to DISLIKE
				$existingInteraction->update(['is_like' => false]);
			}
		}else {
			CommentLike::create([
				'user_id' => $userId,
				'comment_id' => $commentId,
				'is_like' => false,
			]);
		}

		$this->loadComments();

	}

	public function toggleReplies($commentId)
	{
		if(in_array($commentId, $this->collapsedReplies)) {
			$this->collapsedReplies = array_diff($this->collapsedReplies, [$commentId]);
		}else {
			$this->collapsedReplies[] = $commentId;
		}
	}

	private function collapseAllReplies(){
		$this->collapsedReplies = $this->comments->pluck('id')->toArray();
	}

	public function submitReply($parentId)
	{
		if(!Auth::check()) {
			session()->flash('status', 'Debes iniciar sesión para responder un comentario.');
			return redirect()->guest(route('login'));
		}

		try {
			
			$this->validate(
				[
				'replyComment' => 'required|string|min:2|max:500',
				],
				[
					'replyComment.required' => 'El comentario es requerido.',
					'replyComment.string' => 'El comentario debe ser un texto.',
					'replyComment.min' => 'El comentario debe tener al menos 2 caracteres.',
					'replyComment.max' => 'El comentario no puede tener más de 500 caracteres.',
				]
		  );

			// Create a new reply comment
			Comment::create([
				'comment'   => $this->replyComment,
				'user_id'   => Auth::id(),
				'post_id'   => $this->post->id,
				'parent_id' => $parentId,
				'likes_count' => 0,
				'dislikes_count' => 0,
			]);

			$this->replyComment = null;
		  $this->replyingTo = null;

			$this->loadComments();

		} catch (ValidationException $e) {
			throw $e;
		}
	}

	public function editComment($commentId){
		$comment = Comment::find($commentId);
		// Verify if the user can edit the comment
		if(Auth::id() !== $comment->user_id) {
			return;
		}

		$this->editingComment = $commentId;
		$this->editCommentContent = $comment->comment;
	}

	public function updateComment($commentId){
		$comment = Comment::find($commentId);
		// Verify permission to edit
    if (Auth::id() !== $comment->user_id) {
      return;
    }

		$comment->update([
			'comment' => $this->editCommentContent,
		]);

		$this->cancelEditComment();
		$this->loadComments();
	}

	public function cancelEditComment(){
		$this->editingComment = null;
		$this->editCommentContent = '';
	}

	#[On('commentDeleted')]
	public function reloadCommentsList() // This method is called when a comment is deleted
	{
		$this->loadComments();
		$this->collapseAllReplies();
	}

	public function render()
	{
		return view('livewire.public.comment.comment-list');
	}
}
