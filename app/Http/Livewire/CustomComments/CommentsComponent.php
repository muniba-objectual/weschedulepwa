<?php

namespace App\Http\Livewire\CustomComments;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\Comments\Enums\NotificationSubscriptionType;
use Spatie\LivewireComments\Support\Config;
use Intervention\Image\Facades\Image;
use Spatie\MediaLibrary\Conversions\ImageGenerators\Video;

class CommentsComponent extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $photo;
    public $photo_img_tag;

    /** @var \Spatie\Comments\Models\Concerns\HasComments */
    public $model;

    public string $text = '';

    public bool $writable;
    public bool $showAvatars;
    public bool $showNotificationOptions;
    public bool $newestFirst;
    public string $selectedNotificationSubscriptionType = '';
    public ?string $noCommentsText = null;
    public bool $showReplies;


    public function UpdateText($value)
    {
        if ($value) {
            $this->text = $value;

        }
    }

    public function updatedPhoto()
    {
        if (isset($this->photo)) {

            $filename = $this->photo->store('public/NEW_AW_PHOTOS');
            if ($filename) {


                $mimeType = mime_content_type(getcwd() . "/storage/" . substr($filename,7));
                if (str_contains($mimeType, "image")) {
                    //resize image to a width of 400 and constrain aspect ratio (auto height)

                    //ray (storage_path('app/'));
                    $img = Image::make(storage_path('app/') . $filename)->orientate()->resize(400, 400, function ($constraint) {
                        $constraint->aspectRatio();

                    });
                    $resizeFilename = substr($filename, 0, -4) . "_resized.jpg";
                    $img->save(storage_path('app/') . $resizeFilename);
                    $this->dispatchBrowserEvent('new_image_filename', ['filename' => $resizeFilename]);
                    // $this->text=$this->text . "<img src='http://localhost:8000/storage/" . substr($filename,7) . "' width='400px' />" ;
                    $this->photo_img_tag = "<img src='/storage/" . substr($resizeFilename, 7) . "'  />";
                }
                if (str_contains($mimeType,"video")) {
                    $this->dispatchBrowserEvent('new_video_filename', ['filename' => $filename]);
}
            }
            }
        }



    public function mount(
        bool  $readOnly = false,
        ?bool $hideAvatars = null,
        bool  $hideNotificationOptions = true,
        bool $newestFirst = false,
        bool $noReplies = false,
    ) {
        $this->writable = ! $readOnly;

        $this->showReplies = ! $noReplies;

        $showAvatars = is_null($hideAvatars)
            ? null
            : ! $hideAvatars;

        $this->showAvatars = $showAvatars ?? Config::showAvatars();

        $this->showNotificationOptions = ! $hideNotificationOptions;

        $this->newestFirst = $newestFirst;

        $this->selectedNotificationSubscriptionType = auth()->user()
                ?->notificationSubscriptionType($this->model)?->value ?? NotificationSubscriptionType::Participating->value;
    }

    public function getListeners()
    {
        return [
            'delete' => '$refresh',
            'reply-created' => 'saveNotificationSubscription',
            'UpdateText' => 'UpdateText'

        ];
    }

    public function comment()
    {
        $this->validate(['text' => 'required']);

       if ($this->photo) {
//            $this->model->comment($this->photo_img_tag . "<br /><br />" . $this->text);
           $this->model->comment($this->text);
        } else {

            $this->model->comment($this->text);
        }

        //$this->model->comment($this->text);

        $this->text = '';
        // @todo This is weird behaviour when your comment appears on a later page.
        // To revisit when we decide how to handle comment sorting.
        $this->goToPage(1);

        $this->saveNotificationSubscription();

        $this->dispatchBrowserEvent('empty_comment');

        $this->emit('comment');
    }

    public function updateSelectedNotificationSubscriptionType($type)
    {
        $this->selectedNotificationSubscriptionType = $type;

        $this->saveNotificationSubscription();
    }

    public function saveNotificationSubscription()
    {
        if (! $this->showNotificationOptions) {
            return;
        }

        /** @var \Spatie\Comments\Models\Concerns\Interfaces\CanComment $currentUser */
        $currentUser = auth()->user();

        if (! $currentUser) {
            return;
        }

        $type = NotificationSubscriptionType::from($this->selectedNotificationSubscriptionType);

        if ($type === NotificationSubscriptionType::None) {
            $currentUser->unsubscribeFromCommentNotifications($this->model);

            return;
        }

        $currentUser->subscribeToCommentNotifications(
            $this->model,
            NotificationSubscriptionType::from($this->selectedNotificationSubscriptionType)
        );
    }

    public function render()
    {
        $comments = $this->model
            ->comments()
            ->with([
                'commentator',
                'nestedComments' => function (HasMany $builder) {
                    if ($this->newestFirst) {
                        $builder->latest();
                    }
                },
                'nestedComments.commentator',
                'reactions',
                'reactions.commentator',
                'nestedComments.reactions',
                'nestedComments.reactions.commentator',
            ])
            ->when($this->newestFirst, fn (Builder $builder) => $builder->latest())
            ->paginate(config('comments.pagination.results', 10000), ['*'], config('comments.pagination.page_name', 'page'));

        return view('comments::livewire.comments', [
            'comments' => $comments,
        ]);
    }

    public function paginationView()
    {
        if (view()->exists(config('comments.pagination.theme'))) {
            return config('comments.pagination.theme');
        }

        if (view()->exists('livewire::' . config('comments.pagination.theme'))) {
            return 'livewire::' . config('comments.pagination.theme');
        }

        return 'livewire::tailwind';
    }
}
