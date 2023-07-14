<?php

return [
    'meta'      => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => 'Online Examination For Engineering Students - '.env('APP_NAME'),
            'description'  => env('APP_NAME').' - Prepare for the entrance examination through us. There are different questions available in our application. Practise more and get entry in the campus.',
            'separator'    => ' - ',
            'keywords'     => [],
            'canonical'    => env('APP_URL'), // Set null for using Url::current(), set false to total remove
        ],

        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
        ],
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'        => 'Online Examination For Engineering Students - '.env('APP_NAME'),
            'description' =>env('APP_NAME').' - Prepare for the entrance examination through us. There are different questions available in our application. Practise more and get entry in the campus.',
            'url'         => env('APP_URL'), // Set null for using Url::current(), set false to total remove
            'type'        => 'online-examination',
            'site_name'   => env('APP_NAME'),
            'images'      => [],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
          //'card'        => 'summary',
          //'site'        => '@LuizVinicius73',
        ],
    ],
];
