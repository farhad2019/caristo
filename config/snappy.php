<?php

return array(
    'pdf'   => array(
        'enabled' => true,
//        'binary' => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe"',
        'binary'  => base_path('storage/app/wkhtmltopdf.exe'),
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
//        'binary' => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe"',
//        'binary'  => base_path('storage/app/wkhtmltopdf.exe'),
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
);
