<?php

return [

    'characters' => '1234567890ABCDEFGHJMNPQRTUXYZ',
    'default' => [
        'length' => 5,
        'width' => 120,
        'height' => 36,
        'quality' => 100,
        'bgColor' => '#000',
        'fontColors' => ['#000000', '#FF0000', '#ff5f08', '#ff08b6', '#330124', '#08b6ff'],
        'lines' => 5,
        
    ],
    'flat' => [
        'length' => 6,
        'width' => 160,
        'height' => 46,
        'quality' => 100,
        'lines' => 6,
        'bgImage' => false,
        'bgColor' => '#000',
        'fontColors' => ['#000000'],
        'contrast' => -5,
    ],
    'mini' => [
        'length' => 3,
        'width' => 60,
        'height' => 32,
    ],
    'inverse' => [
        'length' => 5,
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'sensitive' => true,
        'angle' => 12,
        'sharpen' => 10,
        'blur' => 2,
        'invert' => true,
        'contrast' => -5,
    ]
];
