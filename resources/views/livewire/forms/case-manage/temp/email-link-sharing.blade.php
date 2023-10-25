<div>
    @php
        $config = [
            "singleDatePicker" => true,
            "showDropdowns" => true,
            "minYear" => 2000,
            "maxYear" => 2030,
            "timePicker" => false,
            "timePicker24Hour" => false,
            "timePickerSeconds" => false,
            "cancelButtonClasses" => "btn-danger",
            "locale" => ["format" => "YYYY-MM-DD"],
        ];
    @endphp

    <!-- /.modal compose message -->
    <div wire:ignore.self class="modal show" id="modalCompose">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-envelope-square"></i> {{$emailSubject}} </h5>
                    <button type="button" onclick="$('#modalCompose').hide()" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">

                    <form role="form" class="form-horizontal"  wire:ignore>
                        <div class="form-group">
                            <label class="col-sm-2" for="inputTo"><i class="fas fa-user"></i>To</label>
                            <div class="col-sm-10"><input wire:model="emailTo" type="email" class="form-control" id="inputTo" placeholder="Enter e-mail address, comma separated list of recipients"></div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2" for="inputSubject"><span class="glyphicon glyphicon-list-alt"></span>Subject</label>
                            <div class="col-sm-10"><input wire:model="emailSubject" type="text" class="form-control" id="inputSubject" placeholder="Enter Subject"></div>
                        </div>

                        <div class="form-group">
                            <label class="col-4" for="inputDocumentPassword">
                                <span class="glyphicon glyphicon-list-alt"></span>Document Password
                            </label>
                            <div class="col-sm-10">
                                <input wire:model="password" type="text" class="form-control" id="inputDocumentPassword" placeholder="Enter Document Password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2" for="inputDocumentExpireDate">
                                <span class="glyphicon glyphicon-list-alt"></span>Expiry Date
                            </label>
                            <div class="col-sm-10">
{{--                                <div class="form-group">--}}
{{--                                    <div class="input-group input-group-sm">--}}
{{--                                        <input id="inputDocumentExpireDate" name="formattedExpireDate" class="form-control" placeholder="Enter Expire Date" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formattedExpireDate">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <x-adminlte-date-range id="inputDocumentExpireDate" placeholder="Enter Expire Date" class="form-control" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formattedExpireDate" name="formattedExpireDate" igroup-size="sm" :config="$config"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12" for="inputBody">
                                <span class="glyphicon glyphicon-list"></span>Message
                            </label>

                            <div class="col-sm-12">
                                <trix-editor class="ignoreResize" wire:model="emailMessage" class="form-control" id="inputBody" rows="8" cols="50" placeholder="Enter Message"></trix-editor>
                            </div>
                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <div wire:ignore.self id="pleaseWaitSpinner" class="spinner-border text-primary float-left" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <button onclick="$('#modalCompose').hide()" type="button" class="btn btn-default pull-left"
                            data-dismiss="modal">Cancel</button>
                    <button type="button" wire:click="sendEmail()" onclick="pleaseWait()"
                            class="btn btn-primary ">Send <i class="fa fa-arrow-circle-right fa-lg"></i></button>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal compose message -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trix/dist/trix.min.css">
    <script src="https://cdn.jsdelivr.net/npm/trix/dist/trix.min.js" defer></script>

    <script>
        function pleaseWait() {
            $("#pleaseWaitSpinner").css({
                visibility: 'visible'
            })
        }

        window.addEventListener('hideSpinner', event => {
            $("#pleaseWaitSpinner").css({
                visibility: 'hidden'
            })
            $("#modalCompose").hide();
        });

        $(document).ready(function() {
            $("#pleaseWaitSpinner").css({
                visibility: 'hidden'
            });
        });

        window.addEventListener('open-email-prompt', event => {
            $("#modalCompose").show();
        });

    </script>

</div>
