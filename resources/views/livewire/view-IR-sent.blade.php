<div class="container-fluid">

    <p>This IR has been sent.</p>

{{--    @dd ($LW_incident_entryCurrentRevision->getFirstMedia("Sent_IRs"))--}}

    <div>
{{--    <embed width="100%" height="60%" src="{{'/storage/IRs/' . $LW_incident_entryCurrentRevision->getFirstMedia("Sent_IRs")->id . '/Sent_IRs/IR_Report.pdf'}}" />--}}
{{--    <p>{{$LW_incident_entryCurrentRevision->getFirstMedia("Sent_IRs")->toInlineResponse($this)}}</p>--}}
    </div>



    <div align="center">
        <iframe id="pdf-js-viewer" src="/pdfJS/web/viewer.html?file={{'/storage/IRs/' . $LW_incident_entryCurrentRevision->getFirstMedia("Sent_IRs")->id . '/Sent_IRs/IR_Report.pdf'}}" title="webviewer" frameborder="0" width="75%" height="75%"></iframe>
    </div>

    <p>Details will go here:</p>
</div>
