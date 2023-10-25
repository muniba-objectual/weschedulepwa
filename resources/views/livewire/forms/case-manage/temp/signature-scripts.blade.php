<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    document.addEventListener('livewire:load', function () {
        sigBoot();
    });

    document.addEventListener('livewire-model-updated', function () {
        sigBoot();
    });

    function sigBoot(){
        $('.signature-clear').click(function (){
            Livewire.emit('signatureUpdated', $(this).closest('.signature-container').find('input').attr('wire:model'), ''); // Emit an event to update the Livewire component property
        });

        $('.signature-pad').each(function () {
            var canvas = $(this)[0];
            var signaturePad = new SignaturePad(canvas, {penColor: "blue"});

            //load the current signature if exists
            var current = $(canvas).closest('.signature-container').find('input').val();
            if( current ){
                signaturePad.fromDataURL(current, {width: $(canvas).attr('width'), height: $(canvas).attr('height')});
            }

            @if($printMode??false)
                signaturePad.off();
            @endif

            signaturePad.addEventListener("endStroke", () => {
                var dataURL = signaturePad.toDataURL(); // Get the signature as a data URL
                var input = $(canvas).closest('.signature-container').find('input');
                input.val(dataURL);
                Livewire.emit('signatureUpdated', input.attr('wire:model'), dataURL); // Emit an event to update the Livewire component property
            }, { once: false })
        });
    }
</script>
