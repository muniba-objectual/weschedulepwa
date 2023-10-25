<div wire:ignore>
    <script>
        var activeTab = window.localStorage.getItem('activeTab');

    </script>
<div wire:ignore style="visibility:hidden;" id="tmpReport"></div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
<script>

    window.addEventListener('reportLoaded', event => {
        $('#myTab a[href="#SRA"]').tab('show');

        tinymce.activeEditor.setContent(event.detail.report);

        alert('Report has been loaded');
        var scrollPos =  $("#mceu_43").offset().top;
        $(window).scrollTop(scrollPos);
    });

    window.addEventListener('reportDeleted', event => {

        alert('Report has been deleted');

    });

    function confirmDelete(reportID) {
        confirmDel = confirm('Are you sure you want to delete this report?');
        if (confirmDel) {
            Livewire.emitTo('s-r-a-reports', 'deleteReport', reportID);
        }
        }
    function exportPDF() {
        //var doc = new jsPDF();  //create jsPDF object


        var doc = // Document of 8.5 inch width and 11 inch high
            new jsPDF({
                orientation: 'p',
                unit: 'in',
                format: [612, 792]
            });
        doc.fromHTML(document.getElementById("tmpReport"), // page element which you want to print as PDF
            1,
            1,
            {
                'width': 300  //set width
            },
            function(a)
            {
                doc.save("HTML2PDF.pdf"); // save file name as HTML2PDF.pdf
            });
    }
</script>
    <div wire:poll.visible>
    @if (count($entries) > 0)

        @foreach ($entries as $entry)
            @php
                if (is_array($entry)) {
                    $month = \Carbon\Carbon::parse($entry['start'])->format('M Y');
                } else {
                $month = \Carbon\Carbon::parse($entry->start)->format('M Y');

                }
                // echo $month;
                 $groupedArray[$month][] = $entry;

            @endphp
        @endforeach
        @foreach ($groupedArray as $tmpkey=>$entry)
                <div class="text-center">{{$tmpkey}}</div>

                @foreach ($entry as $entrytmp)

      @php
      $username = \App\Models\User::where('id','=',$entrytmp->fk_UserID)->get()->first();
      @endphp
        <div class="text-center">
                    <a href="javascript:Livewire.emitTo('s-r-a-reports','loadReport','{{$entrytmp->id}}');">{{$entrytmp->report_title}} by {{$username->name}} [{{\Carbon\Carbon::parse($entrytmp->updated_at)->format('M d')}}]
        </a>    <a href="javascript:confirmDelete('{{$entrytmp->id}}');"><sup>X</sup></a><!--| <a href="javascript:document.getElementById('tmpReport').innerHTML = '{{$entrytmp->report_html}}'; exportPDF();">Export</a>--><br />
        </div>
            @endforeach
@endforeach

        @else
            <div class="text-center">No SRA Reports</div>
    @endif
    </div>
</div>
