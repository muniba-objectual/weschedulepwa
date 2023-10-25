<?php
namespace App\Http\Livewire\Forms\CaseManage;

use Livewire\Component;
use Spatie\MediaLibraryPro\MediaLibraryRequestItem;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;

class FileUploaderCollection extends Component
{
    use WithMedia;

    public $model;

    public $section;

    private $mediaComponentNames = ['images_1'];
//= ['images_','images_1', 'images_2'];

    public $key;
    public $images;
    public $images_1;

    public $familyMemberID;

    public function mount() {
        //dd ($this->key);

        // dd ($this->model);
        $this->mediaComponentNames = ["images_" . $this->key];

        if ($this->familyMemberID) {
            $this->{$this->mediaComponentNames[0]} = $this->model->getMedia($this->section . "_" . $this->familyMemberID);
        } else {
            $this->{$this->mediaComponentNames[0]} = $this->model->getMedia($this->section . "_" . "primary");
        }






        //dd ($this->images);
        //dd($this->mediaComponentNames);
    }


    public function submit2()
    {


        if ($this->familyMemberID) {

            $this->mediaComponentNames = [$this->key];

            //clear out existing files in this collection
            $this->model->clearMediaCollection($this->section . "_" . $this->familyMemberID);

            //dd ($this->mediaComponentNames[0]);
            //dd ($this->mediaComponentNames[0]);

            $this->model
                ->addFromMediaLibraryRequest($this->images_1)
                ->toMediaCollection($this->section . "_" . $this->familyMemberID);

//    $this->model
//        ->addFromMediaLibraryRequest($this->{$this->mediaComponentNames[0]})
//        ->toMediaCollection($this->section . "_" . $this->familyMemberID);

        } else {

            //clear out existing files in this collection
            $this->model->clearMediaCollection($this->section . "_" . "primary");

            $this->model
                ->addFromMediaLibraryRequest($this->images_1)
                ->toMediaCollection($this->section . "_" . $this->familyMemberID);


//        $this->model
//        ->addFromMediaLibraryRequest($this->{$this->mediaComponentNames[0]})
//        ->toMediaCollection($this->section . "_" . "primary");

        }


        //dd ($this->images);

//$this->clearMedia();
    }


    public function render()
    {

        //$this->images = $this->model->getMedia($this->section);

        //  $this->mediaComponentNames = ["images_" . $this->key];


        //dd($this->mediaComponentNames[0]);
        return <<<'blade'

            <div>
            {{-- $this->mediaComponentNames[0] --}}
                <label class="mt-3">{{$this->section}} (Attachment)</label>

                 <form method="POST"   wire:submit.prevent="submit2">
                     @csrf
                        @if ($this->familyMemberID)

                     <x-media-library-collection
                            name="images_1"


                            :model="$model"
                            collection="{{$this->section . '_' . $this->familyMemberID}}"
                            max-items="1"
                            {{--
                            fields-view="livewire.forms.case-manage.FileUploaderCollectionCustomFields" --}}
                        />

                        @else

                          <x-media-library-collection
                            {{--
                            name="{{$this->mediaComponentNames[0]}}"
                            --}}
                            name="images_1"
                            :model="$model"
                            collection="{{$this->section . '_' . 'primary'}}"
                            max-items="1"
                            {{--
                            fields-view="livewire.forms.case-manage.FileUploaderCollectionCustomFields" --}}
                        />
                      @endif

                        <button type="submit">Submit</button>
                </form>

            </div>
        blade;
    }
}
