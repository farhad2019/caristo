<?php

return [
    'gcm' => [
        'priority' => 'normal',
        'dry_run'  => false,
        'apiKey'   => 'My_ApiKey',
    ],
    'fcm' => [
        'priority' => 'high',
        'dry_run'  => false,
        'apiKey'   => 'AAAAppkIUEI:APA91bFShRTtyouPs45nIgj9Wv2pdePtT1eB9QT1EBNh1BJXsbt67Sj32cIckCGKoQlbFSAjTlnDGzfRTA4BYndzNy2Gw156C1wJYokgiEGx2yIDy0qTn8Wn5lEsxs2Aa6hIrM8viTG6EsSxl6FKK0bFUb-Pa27ZsA',
    ],
    'apn' => [
        'certificate' => __DIR__ . '/iosCertificates/apns-dev-cert.pem',
        'passPhrase'  => '1234', //Optional
        'passFile'    => __DIR__ . '/iosCertificates/yourKey.pem', //Optional
        'dry_run'     => true
    ]
];