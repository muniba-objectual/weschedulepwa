<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        {{-- Base Meta Tags --}}
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">


        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style type="text/css">
            /* Set page width to 800px */
            body {
                border: solid 1px;
                width: 1300px;
                margin: 0 auto; /* Center the content horizontally */
            }

            .page-break {
                page-break-after: always;
            }

            /*@media (max-width: 400px) {*/
            /*    body {*/
            /*        font-size: 14px;*/
            /*        color: red;*/
            /*    }*/
            /*}*/
        </style>
    </head>
    <body>
        <script type="text/php">

            if (isset($pdf)) {
                $x = 540;
                $y = 10;
                $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
                $font = null;
                $size = 8;
                $color = array(0,0,0);
                $word_space = 0.0;  //  default
                $char_space = 0.0;  //  default
                $angle = 0.0;   //  default
                $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
            }

             if (isset($pdf)) {
                $x = 100;
                $y = 810;
                $text = "9355 Dixie Road, Brampton, ON L6S 1J7 Tel: 905.799.2947 Fax: 905.790.8262 Email: info@carpediem.ca";
                $font = null;
                $size = 8;
                $color = array(0,0,0);
                $word_space = 0.0;  //  default
                $char_space = 0.0;  //  default
                $angle = 0.0;   //  default
                $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
            }
        </script>
        <div id="print_node">
            @livewire($viewPath, [$formId])
        </div>
    </body>
</html>



