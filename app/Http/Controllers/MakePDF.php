<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MakePDF extends Controller
{
    public function MakeFromHTML(Request $request)
    {

        if ($request->ajax()) {

            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($request->html);
            //return $pdf->stream();
            $pdf->render();

            $output = $pdf->output();
            file_put_contents("file.pdf", $output);
            return $pdf->stream();
            //$pdf->download('test.pdf');

        }
    }
}
