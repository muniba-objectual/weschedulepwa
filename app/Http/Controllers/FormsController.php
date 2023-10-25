<?php

namespace App\Http\Controllers;

use App\Models\DocumentFile;
use App\Models\DocumentShare;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Barryvdh\Snappy\Facades\SnappyPdf ;

//Michello
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;
use Spiritix\Html2Pdf\Converter;
use Spiritix\Html2Pdf\Input\StringInput;
use Spiritix\Html2Pdf\Input\UrlInput;
use Spiritix\Html2Pdf\Output\DownloadOutput;
use Spiritix\Html2Pdf\Output\EmbedOutput;

class FormsController extends Controller
{
    public function GeneralFormBuilder(Request $request, int $formType, $formId = null)
    {
        $formTypes = \App\Models\TempFormData::formTypes;

        $linkBackUrl = $request->query('back-url', url()->previous());
        $linkBackText = $request->query('back-text');

        $makePDF = false;
        if (is_null($formId)) {
            $formId = \App\Models\TempFormData::create(['form' => $formTypes[$formType]])->id;
            return redirect("TestFormBuilder/{$formType}/{$formId}?back-url={$linkBackUrl}&back-text={$linkBackText}");
        }


        if ($request->query('PDF')) {
            //Michello - using Browsershot from Spatie

//            $linkBackText = "";
            $linkBackUrl = "";
            $makePDF = true;


//        $content = view('DocumentView.DynamicForms.layout', compact('formId', 'formTypes', 'formType', 'linkBackUrl', 'linkBackText'))->render();

            if (App::environment('local'))
            {
                // The environment is local
                $localContentUrl = "http://casemanage.local";
                $pdf = Browsershot::html(view('DocumentView.DynamicForms.layout', compact('formId', 'formTypes', 'formType', 'linkBackUrl', 'linkBackText', 'makePDF'))->render())
                    ->noSandbox()
                    ->showBackground()
                    ->margins(10, 2, 10, 2)

                    //                ->setNodeBinary('/usr/local/bin/node')
//                ->setNpmBinary('/usr/local/bin/npm')
                    ->setContentUrl($localContentUrl)
                    ->setOption('args', ['--disable-web-security'])
                    ->waitUntilNetworkIdle()
//            ->setOption('addScriptTag', json_encode(['content' => 'alert("Hello World")']))
//            ->waitForFunction('window.innerWidth < 100', 1000, 5000)

//            ->dismissDialogs();

//            ->consoleMessages();
                    ->base64pdf();

//                return response($pdf)->header('Content-Type', 'application/pdf');

                $embedded = $pdf;
                return view('DocumentView.document-viewer-layout', compact('formId', 'formTypes', 'formType', 'linkBackUrl', 'linkBackText', 'embedded', 'makePDF'));

                //Michello -- end block
            }

            if (App::environment('staging'))
            {
                // The environment is staging
                $localContentUrl = "https://staging.casemanage.ca";
                $pdf = Browsershot::html(view('DocumentView.DynamicForms.layout', compact('formId', 'formTypes', 'formType', 'linkBackUrl', 'linkBackText', 'makePDF'))->render())
                    ->noSandbox()
                    ->showBackground()
                    ->margins(10, 2, 10, 2)

                    //                ->setNodeBinary('/usr/local/bin/node')
//                ->setNpmBinary('/usr/local/bin/npm')
                    ->setContentUrl($localContentUrl)
                    ->setOption('args', ['--disable-web-security'])
                    ->waitUntilNetworkIdle()
//            ->setOption('addScriptTag', json_encode(['content' => 'alert("Hello World")']))
//            ->waitForFunction('window.innerWidth < 100', 1000, 5000)

//            ->dismissDialogs();

//            ->consoleMessages();
                    ->base64pdf();

                $embedded = $pdf;
                return view('DocumentView.document-viewer-layout', compact('formId', 'formTypes', 'formType', 'linkBackUrl', 'linkBackText', 'embedded', 'makePDF'));

                //Michello -- end block
            }

            if (App::environment('production'))
            {
                // The environment is production
                $localContentUrl = "https://casemanage.ca";

                $pdf = Browsershot::html(view('DocumentView.DynamicForms.layout', compact('formId', 'formTypes', 'formType', 'linkBackUrl', 'linkBackText', 'makePDF'))->render())
                    ->noSandbox()
                    ->showBackground()
                    ->margins(10, 2, 10, 2)
                    ->setNodeBinary('/usr/local/bin/node')
                ->setNpmBinary('/usr/local/bin/npm')
                    ->setContentUrl($localContentUrl)
                    ->setOption('args', ['--disable-web-security'])
                    ->waitUntilNetworkIdle()
//            ->setOption('addScriptTag', json_encode(['content' => 'alert("Hello World")']))
//            ->waitForFunction('window.innerWidth < 100', 1000, 5000)

//            ->dismissDialogs();

//            ->consoleMessages();
                    ->base64pdf();

                $embedded = $pdf;
                return view('DocumentView.document-viewer-layout', compact('formId', 'formTypes', 'formType', 'linkBackUrl', 'linkBackText', 'embedded', 'makePDF'));

                //Michello -- end block
            }



        }


        return view('DocumentView.DynamicForms.layout', compact('formId', 'formTypes', 'formType', 'linkBackUrl', 'linkBackText', 'makePDF'));
    }

    public function renderAsPdf(Request $request, int $formType, $formId){
        $formTypes = \App\Models\TempFormData::formTypes;
        switch($formType) {
            case 1:
                $viewPath = 'forms.case-manage.temp.foster-parent-learning';
                $title = 'Foster Parent Learning';
                break;
            case 2:
                $viewPath = 'forms.case-manage.temp.safety-plan';
                $title = 'Safety Plan';
                break;
            case 3:
                $viewPath = 'forms.case-manage.temp.pre-admissions';
                $title = 'Pre-Admissions';
                break;
            case 4:
                $viewPath = 'forms.case-manage.temp.carpe-diem.preliminary-assessment';
                $title = 'Preliminary Assessment';
                break;
            case 5:
                $viewPath = 'forms.case-manage.temp.carpe-diem.agreement-and-authorization-to-provide-services-to-a-child-in-a-children-residence';
                $title = 'Agreement and Authorization to Provide Services to a Child in a Children Residence';
                break;
            case 6:
                $viewPath = 'forms.case-manage.temp.carpe-diem.authorization-for-supervised-activities';
                $title = 'Authorization for Supervised Activities';
                break;
            case 7:
                $viewPath = 'forms.case-manage.temp.carpe-diem.approval-to-administer-all-medication';
                $title = 'Approval to Administer All Medication';
                break;
        }

//
//        $input = new StringInput();
//        $myViewData = View::make('DocumentView.DynamicForms.pdf-layout', compact('formId', 'viewPath', 'title'))->render();
//
//        $input->setHtml($myViewData);
//
//        $converter = new Converter($input, new EmbedOutput());
//
//        $converter->setOption('landscape', false);
//
//        $converter->setOptions([
//            'printBackground' => true,
//            'displayHeaderFooter' => false,
//            'mediaType' => 'print',
//            'scale' => 1.0
////            'headerTemplate' => '<p>I am a header</p>',
//        ]);
//
//        $output = $converter->convert();
//        $output->embed('google.pdf');
//
//        return "downloaded";

        //Michello - using Browsershot from Spatie
//        $content = view('DocumentView.DynamicForms.pdf-layout', compact('formId', 'viewPath', 'title'));
//        $pdf = Browsershot::html($content)
//            ->waitUntilNetworkIdle()
//            ->pdf();
//        return response($pdf)->header('Content-Type', 'application/pdf');
        //Michello -- end block

        return view('DocumentView.DynamicForms.pdf-layout', compact('formId', 'viewPath', 'title'));



//        PDF OUTPUT WORKING with SNAPPY-PDF, UN-COMMENT BELOW TO RENDER

//        //START OF SNAPPY-PDF
        $pdf = SnappyPdf::setOption('enable-local-file-access', true);
//        $pdf->setOption('enable-smart-shrinking', true);
        $pdf->setOption('no-stop-slow-scripts', true)
        ->loadView('DocumentView.DynamicForms.pdf-layout', compact('formId', 'viewPath', 'title'));

        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="test.pdf"');
        return $pdf->download();
//        //END OF SNAPPY-PDF



//        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('DocumentView.DynamicForms.pdf-layout', compact('formId', 'viewPath', 'title'));
//    //        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML('<b>test</b>');
//                $pdf->setPaper('A4', 'portrait');
//
//        $pdf->render();
//        header('Content-type: application/pdf');
//        header('Content-Disposition: attachment; filename="test.pdf"');
////
//      return $pdf->download();

    }

    public function documentViewer($token)
    {
        //check for expiry

        /**
         * @var DocumentShare $documentShare
         * @var DocumentFile $document
         */
        $documentShare = DocumentShare::where('token', $token)->first();
        $document = DocumentFile::findOrFail($documentShare->document_id);
        $props = $document->file_meta_info;
        $title = $document->file_name;

        $formId =  $props['form_id'];
        $formType =  $props['form_type'];
        $formTypes = \App\Models\TempFormData::formTypes;

        if ($document->file_category === DocumentFile::CATEGORY_DYNAMIC_FORM) {
//            $embedded = $this->renderAsPdf( request(), $props['form_type'], $props['form_id'] );
//            return view('DocumentView.document-viewer-layout', compact('embedded', 'title'));

            $linkBackUrl = "";
            $linkBackText = "";
            $makePDF = true;

            $localContentUrl = "http://casemanage.local";
            $pdf = Browsershot::html(view('DocumentView.DynamicForms.layout', compact('formId', 'formTypes', 'formType', 'linkBackUrl', 'linkBackText', 'makePDF'))->render())
                ->noSandbox()
                ->showBackground()
                ->margins(10, 2, 10, 2)

                //                ->setNodeBinary('/usr/local/bin/node')
//                ->setNpmBinary('/usr/local/bin/npm')
                ->setContentUrl($localContentUrl)
                ->setOption('args', ['--disable-web-security'])
                ->waitUntilNetworkIdle()
//            ->setOption('addScriptTag', json_encode(['content' => 'alert("Hello World")']))
//            ->waitForFunction('window.innerWidth < 100', 1000, 5000)

//            ->dismissDialogs();

//            ->consoleMessages();
                ->base64pdf();

//                return response($pdf)->header('Content-Type', 'application/pdf');

            $embedded = $pdf;
            return view('DocumentView.document-viewer-external-layout', compact( 'embedded', 'makePDF'));


        } elseif ($document->file_category === DocumentFile::CATEGORY_HTML) {
            $view = '';


        } elseif ($document->file_category === DocumentFile::CATEGORY_PDF) {
            $view = '';


        } elseif ($document->file_category === DocumentFile::CATEGORY_IMAGE) {
            $view = '';
        }
    }

    public function showLoginForm(Request $request, string $token = null): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('DocumentView.Auth.document-login', compact('token'));
    }

    public function login(Request $request)
    {
        $token = $request->input('token');
        $password = $request->input('password');

        $documentShare = DocumentShare::where('token', $token)->first();

        if (!$documentShare) {
            return redirect()->route('document.login')->with('error', 'Invalid token');
        }

        if ($documentShare->password !== $password) {
            return redirect()->route('document.login', ['token' => $token])->with('error', 'Invalid password');
        }

        // Authentication successful
        // Create a session for the token
        \Session::put("document_token_{$token}", $token);

        // Set session expiration time to 15 minutes
        $expirationTime = now()->addMinutes(15);
        \Session::put("document_token_expires_at_{$token}", $expirationTime);

        return redirect("/documentViewer/{$token}");
    }

    public function testPDF() {
//        Browsershot::html('<h1>Hello world!!</h1>')->save('example.pdf');
       $pdf =  Browsershot::url('http://casemanage.local/TestFormBuilder/2/626?back-text=Child%20Aaron%20Cruz%20Asessment%20View&back-url=%2Fchildren%2F163%23safety_forms')
           ->waitUntilNetworkIdle()
           ->pdf();
      return response($pdf)->header('Content-Type', 'application/pdf');
    }
}
