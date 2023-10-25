<?php
namespace App\Http\Livewire\Forms\CaseManage;

use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FileUploaderExpenses extends Component
{
use WithMedia, WithFileUploads;

public $model;

public $uploadedFiles;
public $media;
public $omitTitle;
public function mount() {

//        $this->media = $this->model->getMedia();

//    dd ($this->media);
}


public function submit()
{


}

public function render()
    {


        return <<<'blade'


            <div>


            <form id="upload_form" action="{{ route('ExpensesFileUpload') }}" method="post" >
                        <div>
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                {{ session('message') }}
                                    </div>
                                @endif
                            </div>
                        @csrf
                        <input type="file" name="uploadedFiles[]"  id="uploadedFiles" wire:model="uploadedFiles" required  @endif/>
                        <input type="hidden" name="ExpenseID" id="ExpenseID" value="{{$model->id}}" />

                        <button id="btnSavePhoto" disabled type="submit" style="display: none;">Save Attachment</button>
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
                 var myFilePond =   FilePond.create(document.querySelector('#uploadedFiles'),
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

                    $("#upload_form").submit(function (e) {
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
                                url: '{{route('ExpensesFileUpload')}}',
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
                            const pond = document.querySelector('#uploadedFiles')
                        // listen for events
                        pond.addEventListener('FilePond:processfiles', (e) => {
                            //alert ('added');
                            console.log('Files have been added/processed', e.detail);
                            $('#upload_form').submit();
                            $('#btnSavePhoto').prop("disabled",false);
                             });

                        pond.addEventListener('FilePond:removefile', (e) => {
                            //alert ('added');
                            console.log('File removed', e.detail);

                            if (myFilePond.getFiles().length === 0) {
                                $('#btnSavePhoto').prop("disabled",true);
                            }


                             });
                        });

                </script>

            </div>
        blade;
}
}
