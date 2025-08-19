<div class="space-y-6">
  @foreach ($comments as $comment)
    <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-5 shadow-sm hover:shadow-md transition-all duration-300">
      <div class="flex items-start gap-4">
        {{-- Avatar with user image or fallback to initial --}}
        <div class="flex-shrink-0 w-10 h-10 rounded-full overflow-hidden">
          @if($comment->user->avatar)
            <img src="{{ $comment->user->avatar }}" 
              alt="{{ $comment->user->name }}" 
              class="w-full h-full object-cover"
              onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div class="w-full h-full bg-blue-600 text-white items-center justify-center font-semibold text-sm uppercase hidden">
              {{ Str::substr($comment->user->name, 0, 1) }}
            </div>
          @else
            <div class="w-full h-full bg-blue-600 text-white flex items-center justify-center font-semibold text-sm uppercase">
              {{ Str::substr($comment->user->name, 0, 1) }}
            </div>
          @endif
        </div>

        <div class="flex-1">
          {{-- Header: name and date --}}
          <div class="flex justify-between items-center">
            <span class="font-semibold text-sm text-gray-900 dark:text-white">{{ $comment->user->name }}</span>
            <div class="flex items-center gap-2">
              <span class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
              
              {{-- Options menu (only for comment owner) --}}
              @if(Auth::check() && Auth::id() === $comment->user_id)
                <div class="relative" x-data="{ open: false }">
                  <button @click="open = !open" class="p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                    </svg>
                  </button>
                  
                  <div x-show="open" @click.away="open = false" x-transition
                       class="absolute right-0 top-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg border dark:border-gray-700 py-1 min-w-24 z-10">
                    <button wire:click="editComment({{ $comment->id }})" 
                      class="w-full px-3 py-2 text-xs text-left hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                      Editar
                    </button>
                    <button wire:click="$dispatch('openModal', { commentId: {{ $comment->id }} })"
                      @click="open = false"
                      class="w-full px-3 py-2 text-xs text-left hover:bg-gray-100 dark:hover:bg-gray-700 text-red-600 dark:text-red-400">
                      Eliminar
                    </button>
                  </div>
                </div>
              @endif
            </div>
          </div>

          {{-- Content of comment --}}
          @if($editingComment === $comment->id)
            <div class="mt-2">
              <textarea wire:model.defer="editCommentContent"
                class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm p-2 text-gray-900 dark:text-white"
                rows="3">{{ $comment->comment }}</textarea>
              <div class="mt-2 flex justify-end space-x-2">
                <button wire:click="cancelEditComment" class="text-sm text-gray-500 hover:underline">Cancelar</button>
                <button wire:click="updateComment({{ $comment->id }})" class="text-sm text-blue-600 hover:underline">Guardar</button>
              </div>
            </div>
          @else
            <p class="mt-2 text-sm text-gray-800 dark:text-gray-200 leading-relaxed">
              {{ $comment->comment }}
              @if($comment->updated_at > $comment->created_at)
                <span class="text-xs text-gray-400 italic ml-2">(editado)</span>
              @endif
            </p>
          @endif

          {{-- Actions: like, dislike, replay --}}
          <div class="mt-3 flex items-center gap-6 text-sm text-gray-600 dark:text-gray-400">
            <button wire:click="likeComment({{ $comment->id }})"
              class="flex items-center transition
              @if(Auth::check() && $comment->isLikedByUser(Auth::user())) text-blue-600 @else hover:text-blue-500 @endif"
            >
              <svg class="w-6 h-6 
                @if(Auth::check() && $comment->isLikedByUser(Auth::user())) text-blue-600 @else text-gray-800 dark:text-white @endif" 
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M15.03 9.684h3.965c.322 0 .64.08.925.232.286.153.532.374.717.645a2.109 2.109 0 0 1 .242 1.883l-2.36 7.201c-.288.814-.48 1.355-1.884 1.355-2.072 0-4.276-.677-6.157-1.256-.472-.145-.924-.284-1.348-.404h-.115V9.478a25.485 25.485 0 0 0 4.238-5.514 1.8 1.8 0 0 1 .901-.83 1.74 1.74 0 0 1 1.21-.048c.396.13.736.397.96.757.225.36.32.788.269 1.211l-1.562 4.63ZM4.177 10H7v8a2 2 0 1 1-4 0v-6.823C3 10.527 3.527 10 4.176 10Z" clip-rule="evenodd"/>
             </svg>
              <span class="ml-1">{{ $comment->likes_count }}</span>
            </button>
            <button wire:click="dislikeComment({{ $comment->id }})" class="flex items-center transition
              @if(Auth::check() && $comment->isDislikedByUser(Auth::user())) text-red-600 @else hover:text-red-500 @endif"
            >
              <svg class="w-6 h-6
                @if(Auth::check() && $comment->isDislikedByUser(Auth::user())) text-red-600 @else text-gray-800 dark:text-white @endif"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M8.97 14.316H5.004c-.322 0-.64-.08-.925-.232a2.022 2.022 0 0 1-.717-.645 2.108 2.108 0 0 1-.242-1.883l2.36-7.201C5.769 3.54 5.96 3 7.365 3c2.072 0 4.276.678 6.156 1.256.473.145.925.284 1.35.404h.114v9.862a25.485 25.485 0 0 0-4.238 5.514c-.197.376-.516.67-.901.83a1.74 1.74 0 0 1-1.21.048 1.79 1.79 0 0 1-.96-.757 1.867 1.867 0 0 1-.269-1.211l1.562-4.63ZM19.822 14H17V6a2 2 0 1 1 4 0v6.823c0 .65-.527 1.177-1.177 1.177Z" clip-rule="evenodd"/>
              </svg>
              <span class="ml-1">{{ $comment->dislikes_count }}</span>
            </button>
            <button wire:click="setReply({{ $comment->id }})" class="hover:underline text-blue-500">
              Responder
            </button>
          </div>

          {{-- Answer box--}}
          @if ($replyingTo === $comment->id)
            <div class="mt-4">
              <textarea wire:model.defer="replyComment"
                class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm p-2 text-gray-900 dark:text-white"
                rows="2" placeholder="Escribe tu respuesta..."></textarea>
              <div class="mt-2 flex justify-end space-x-2">
                <button wire:click="cancelReply" class="text-sm text-gray-500 hover:underline">Cancelar</button>
                <button wire:click="submitReply({{ $comment->id }})" class="text-sm text-blue-600 hover:underline">Enviar</button>
              </div>
            </div>
          @endif

          @if($comment->replies->isNotEmpty())
            <div class="mt-4">
                <button wire:click="toggleReplies({{ $comment->id }})"
                  class="text-blue-500 hover:underline text-sm font-semibold mb-2 inline-flex items-center">
                  @if (in_array($comment->id, $collapsedReplies))
                    {{-- Show "See X answers" if they are collapsed --}}
                    <svg class="w-4 h-4 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                    Ver {{ $comment->replies->count() }} respuestas
                  @else
                    {{-- Shows "Hide replies" if they are expanded --}}
                    <svg class="w-4 h-4 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                    </svg>
                    Ocultar respuestas
                  @endif
                </button>

                @unless (in_array($comment->id, $collapsedReplies))
                  {{-- Replies --}}
                  @foreach ($comment->replies ?? [] as $reply)
                    <div class="mt-6 ml-10 border-l-2 border-blue-500 pl-4">
                      <div class="flex items-start gap-4">
                        {{-- Reply Avatar --}}
                        <div class="flex-shrink-0 w-8 h-8 rounded-full overflow-hidden">
                          @if($reply->user->avatar)
                            <img src="{{ $reply->user->avatar }}" 
                                 alt="{{ $reply->user->name }}" 
                                 class="w-full h-full object-cover"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="w-full h-full bg-blue-500 text-white items-center justify-center text-xs font-bold uppercase hidden">
                              {{ Str::substr($reply->user->name, 0, 1) }}
                            </div>
                          @else
                            <div class="w-full h-full bg-blue-500 text-white flex items-center justify-center text-xs font-bold uppercase">
                              {{ Str::substr($reply->user->name, 0, 1) }}
                            </div>
                          @endif
                        </div>
                        
                        <div class="flex-1">
                          <div class="flex justify-between items-center">
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $reply->user->name }}</span>
                            <div class="flex items-center gap-2">
                              <span class="text-xs text-gray-500 dark:text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>
                              
                              {{-- Options menu for replies (only for reply owner) --}}
                              @if(Auth::check() && Auth::id() === $reply->user_id)
                                <div class="relative" x-data="{ open: false }">
                                  <button @click="open = !open" class="p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                    <svg class="w-3 h-3 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                    </svg>
                                  </button>
                                  
                                  <div x-show="open" @click.away="open = false" x-transition
                                      class="absolute right-0 top-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg border dark:border-gray-700 py-1 min-w-24 z-10">
                                    <button wire:click="editComment({{ $reply->id }})" 
                                      class="w-full px-3 py-2 text-xs text-left hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                                      Editar
                                    </button>
                                    <button wire:click="$dispatch('openModal', { commentId: {{ $reply->id }} })"
                                      @click="open = false"
                                      class="w-full px-3 py-2 text-xs text-left hover:bg-gray-100 dark:hover:bg-gray-700 text-red-600 dark:text-red-400">
                                      Eliminar
                                    </button>
                                  </div>
                                </div>
                              @endif
                            </div>
                          </div>

                          @if($editingComment === $reply->id)
                            <div class="mt-1">
                              <textarea wire:model.defer="editCommentContent"
                                class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm p-2 text-gray-900 dark:text-white"
                                rows="2">{{ $reply->comment }}</textarea>
                              <div class="mt-2 flex justify-end space-x-2">
                                <button wire:click="cancelEditComment" class="text-sm text-gray-500 hover:underline">Cancelar</button>
                                <button wire:click="updateComment({{ $reply->id }})" class="text-sm text-blue-600 hover:underline">Guardar</button>
                              </div>
                            </div>
                          @else
                            <p class="text-sm mt-1 text-gray-700 dark:text-gray-300">
                              {{ $reply->comment }}
                              @if($reply->updated_at > $reply->created_at)
                                <span class="text-xs text-gray-400 italic ml-2">(editado)</span>
                              @endif
                            </p>
                          @endif

                          <div class="mt-2 flex items-center gap-6 text-sm text-gray-600 dark:text-gray-400">
                            <button wire:click="likeComment({{ $reply->id }})" 
                              class="flex items-center transition
                              @if(Auth::check() && $reply->isLikedByUser(Auth::user())) text-blue-600 @else hover:text-blue-500 @endif"
                            >
                              <svg class="w-6 h-6 
                                @if(Auth::check() && $reply->isLikedByUser(Auth::user())) text-blue-600 @else text-gray-800 dark:text-white @endif" 
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M15.03 9.684h3.965c.322 0 .64.08.925.232.286.153.532.374.717.645a2.109 2.109 0 0 1 .242 1.883l-2.36 7.201c-.288.814-.48 1.355-1.884 1.355-2.072 0-4.276-.677-6.157-1.256-.472-.145-.924-.284-1.348-.404h-.115V9.478a25.485 25.485 0 0 0 4.238-5.514 1.8 1.8 0 0 1 .901-.83 1.74 1.74 0 0 1 1.21-.048c.396.13.736.397.96.757.225.36.32.788.269 1.211l-1.562 4.63ZM4.177 10H7v8a2 2 0 1 1-4 0v-6.823C3 10.527 3.527 10 4.176 10Z" clip-rule="evenodd"/>
                              </svg>
                              <span class="ml-1">{{ $reply->likes_count }}</span>
                            </button>
                            <button wire:click="dislikeComment({{ $reply->id }})" 
                              class="flex items-center transition
                              @if(Auth::check() && $reply->isDislikedByUser(Auth::user())) text-red-600 @else hover:text-red-500 @endif"
                            >
                              <svg class="w-6 h-6
                                @if(Auth::check() && $reply->isDislikedByUser(Auth::user())) text-red-600 @else text-gray-800 dark:text-white @endif"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M8.97 14.316H5.004c-.322 0-.64-.80-.925-.232a2.022 2.022 0 0 1-.717-.645 2.108 2.108 0 0 1-.242-1.883l2.36-7.201C5.769 3.54 5.96 3 7.365 3c2.072 0 4.276.678 6.156 1.256.473.145.925.284 1.35.404h.114v9.862a25.485 25.485 0 0 0-4.238 5.514c-.197.376-.516.67-.901.83a1.74 1.74 0 0 1-1.21.048 1.79 1.79 0 0 1-.96-.757 1.867 1.867 0 0 1-.269-1.211l1.562-4.63ZM19.822 14H17V6a2 2 0 1 1 4 0v6.823c0 .65-.527 1.177-1.177 1.177Z" clip-rule="evenodd"/>
                              </svg>
                              <span class="ml-1">{{ $reply->dislikes_count }}</span>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                @endunless
            </div>
          @endif
        </div>
      </div>
    </div>
  @endforeach

  {{-- Include modal component --}}
  @livewire('public.comment.delete-comment')

  {{-- Pagination --}}
</div>