<?php
namespace App\Http\Livewire\Forms\CaseManage;

use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FileUploader extends Component
{
use WithMedia, WithFileUploads;

public $model;
public $section;
public $key;
public $multiple;
public $familyMemberID;

public $uploadedFiles;
public $media;
public $omitTitle;
public function mount() {

    if ($this->familyMemberID) {
        $this->media = $this->model->getMedia($this->section . "_" . $this->familyMemberID);
    } else {
        $this->media = $this->model->getMedia($this->section . "_" . "primary");
    }
//    dd ($this->media);
}


public function submit()
{


}

public function render()
    {


        return <<<'blade'


            <div>
            @if (!$this->omitTitle)
            <label class="mt-0">{{$this->section}} (Attachment)</label>
            @endif

            <form id="upload_form_{{$this->key}}" action="{{ route('FPAFileUpload') }}" method="post" >
                        <div>
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                {{ session('message') }}
                                    </div>
                                @endif
                            </div>
                        @csrf
                        <input type="file" name="uploadedFiles[]"  id="uploadedFiles_{{$key}}" wire:model="uploadedFiles" required @if ($this->multiple) multiple @endif/>
                        <input type="hidden" name="FPAFormID" id="FPAFormID" value="{{$model->id}}" />
                        <input type="hidden" name="key" id="key" value="{{$key}}" />
                        <input type="hidden" name="section" id="section" value="{{$section}}" />
                        <input type="hidden" name="familyMemberID" id="familyMemberID" value="{{$familyMemberID}}" />

                        <button id="btnSavePhoto_{{$key}}" disabled type="submit" style="display: none;">Save Attachment</button>
                    </form>
                <script>
                    // Set default FilePond options
                    FilePond.setOptions({

                        credits: false,
                        pdfPreviewHeight: 320,
                        // pdfComponentExtraParams: 'toolbar=0&view=fit&page=1',
                        allowPdfPreview: false,
                        allowDownloadByUrl: false,
                        server: {
                            url: "{{ config('filepond.server.url') }}",

                            headers: {
                                'X-CSRF-TOKEN': "{{ @csrf_token() }}",
                            },

                        load: (source, load, error, progress, abort, headers) => {
                                            // now load it using XMLHttpRequest as a blob then load it.
                                            let request = new XMLHttpRequest();
                                            request.open('GET', source);
                                            request.responseType = "blob";
                                            request.onreadystatechange = () => request.readyState === 4 && load(request.response);
                                            request.send();
                                        },
             },
                            labelIdle: '<span class="filepond--label-action"> Browse to upload... </span>'

                    });

                    // Register the plugin
                    // FilePond.registerPlugin(FilePondPluginImagePreview);
                    //  FilePond.registerPlugin(FilePondPluginPdfPreview);
                    FilePond.registerPlugin(FilePondPluginGetFile);
                    FilePond.registerPlugin(FilePondPluginImageOverlay);


                    // Create the FilePond instance
                 var myFilePond =   FilePond.create(document.querySelector('#uploadedFiles_{{$key}}'),
                    {

                        files: [
                             @foreach ($media as $file)
                            {
                                source: '{{str_replace("we-schedule.ca","casemanage.ca",$file->getUrl())}}',
                                options: {
                                    type: 'local'
                                }
                            },
                        @endforeach
                        ]
                    }
                    );

                    $("#upload_form_{{$this->key}}").submit(function (e) {
                        e.preventDefault();
                        var fd = new FormData(this);
                        // append files array into the form data
                        //var pondFiles = $('.filePond').filepond('getFiles');
                        var pondFiles = myFilePond.getFiles();
                        $(pondFiles).each(function (index) {
                            fd.append('file[]', pondFiles[index].file);
                        });

                        //pondFiles = FilePond.getFiles();
                        // for (var i = 0; i < pondFiles.length; i++) {
                        //     fd.append('file[]', pondFiles[i].file);
                        // }

                        $.ajax({
                                url: '{{route('FPAFileUpload')}}',
                                type: 'POST',
                                data: fd,
                                dataType: 'JSON',
                                contentType: false,
                                cache: false,
                                processData: false,
                                success: function (data) {
                                    //    todo the logic
                                    // remove the files from filepond, etc
                                    //alert (data);
                                },
                                error: function (data) {
                                    //    todo the logic
                                     alert ("error", data);
                                }
                            }
                        );
                    });



                $( document ).ready(function() {
                       // get a reference to the root node
                            //const pond = document.querySelector('.filepond--root');
                            const pond = document.querySelector('#uploadedFiles_{{$key}}')
                        // listen for events
                        pond.addEventListener('FilePond:processfiles', (e) => {
                            //alert ('added');
                            console.log('Files have been added/processed', e.detail);
                            $('#upload_form_{{$key}}').submit();
                            $('#btnSavePhoto_{{$key}}').prop("disabled",false);
                             });

                        pond.addEventListener('FilePond:removefile', (e) => {
                            //alert ('added');
                            console.log('File removed', e.detail);

                            if (myFilePond.getFiles().length === 0) {
                                $('#btnSavePhoto_{{$key}}').prop("disabled",true);
                            }


                             });
                        });

                </script>

            </div>
        blade;
}
}
