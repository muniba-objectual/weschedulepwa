<?php

namespace App\Http\Livewire\MentorHomeVisit;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;

class CommentComponent extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;

    /** @var \Spatie\Comments\Models\Comment */
    public $comment;

    use WithFileUploads;
    public $photo;

    public bool $showAvatar;

    public $newestFirst;

    public bool $writable;

    public $replyText = '';
    public $isEditing = false;

    public $editText = '';

    public bool $showReplies;


    public function updatedPhoto()
    {
        if (isset($this->photo)) {

            $filename = $this->photo->store('public/NEW_AW_PHOTOS');
            if ($filename) {




                $this->dispatchBrowserEvent('new_image_filename', ['filename' => $filename]);
                // $this->editText=$this->editText . "<img src='http://localhost:8000/storage/" . substr($filename,7) . "' width='400px' />" ;
            }
        }
    }

    public function getListeners()
    {
        return [
            'delete' => '$refresh',
        ];
    }

    public function startEditing()
    {
        $this->isEditing = true;
        $this->editText = $this->comment->original_text;
    }

    public function stopEditing()
    {

        $this->isEditing = false;
    }

    public function edit()
    {
        $this->authorize('update', $this->comment);

        $this->validate(['editText' => 'required']);

        $this->comment->update([
            'original_text' => $this->editText,
            'text' => $this->editText,
        ]);

        $this->isEditing = false;
    }

    public function cancel()
    {
        $this->isEditing = false;
    }

    public function reply()
    {
        $this->validate(['replyText' => 'required']);

        $this->comment->comment($this->replyText);
        $this->comment->load('nestedComments');

        $this->replyText = '';
        $this->emit('reply-' . $this->comment->id);
        $this->emitUp('reply-created');
    }

    public function deleteComment()
    {
        $this->authorize('delete', $this->comment);

        $this->comment->delete();

        $this->emitUp('delete');
    }

    public function approve()
    {
        $this->authorize('approve', $this->comment);

        $this->comment->approve();
    }

    public function reject()
    {
        $this->authorize('reject', $this->comment);

        $this->comment->reject();

        $this->emitUp('delete');
    }

    public function toggleReaction(string $reaction)
    {
        $reactionModel = $this->comment->findReaction($reaction);

        $reactionModel
            ? $reactionModel->delete()
            : $this->comment->react($reaction);

        $this->comment->load('reactions');
    }

    public function render()
    {
        return view('comments::livewire.comment');
    }
}
