<?php

namespace App\traits;

trait LayoutTrait
{
    public function section(String $title= 'title')
    {
        echo '
        <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>' . $title . '</title>
                <script src="https://cdn.tailwindcss.com"></script>
                <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
                <link href="./css/styles.css" rel="stylesheet">
            </head> 
            <body class="bg-gray-100">
        ';
    }

    public function endSection()
    {
        echo '
        </body>
        </html>';
    }

    public function scripts(String $src)
    {
        echo '
            <script src=' . $src . 'type="module" defer></script>
        ';
    }
}
