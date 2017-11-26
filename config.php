<?php
return [
    // So far 34 languages including: Afrikaans, Arabic, Bengali, Bulgarian, Catalan, Chinese, Czech, Danish,
    // Dutch, English, French, German, Greek, Hindi, Hungarian, Indonesian, Italian, Japanese, Korean,
    // Lithuanian, Mongolian, Norwegian, Persian, Polish, Portuguese, Brazilian Portuguese, Romanian,
    // Russian, Slovak, Spanish, Thai, Turkish, Ukrainian, Vietnamese
    'default_language'	=> 'Indonesian',

    // This is the assets folder where all the JavaScript, CSS, images and font files are located
    'assets_folder' => 'http://127.0.0.1/sistemakademik/assets/grocery-crud/',

    // The default per page when a user firstly see a list page
    'default_per_page'	=> 10,

    // Having some options at the list paging. This is the default one that all the websites are using.
    // Make sure that the number of grocery_crud_default_per_page variable is included to this array.
    'paging_options' => ['10', '25', '50', '100'],

    // The environment is important so we can have specific configurations for specific environments
    'environment' => 'production',

    // This is basically in order to have a php cache. Be aware that in case you disble the php cache
    // things will get too slow
    'backend_cache' => false,

    'xss_clean' => false,

    // The character limiter at the datagrid columns, zero(0) value if you don't want any character
    // limitation to the column
    'column_character_limiter' => 50,

    // For more read http://framework.zend.com/manual/current/en/modules/zend.cache.storage.adapter.html
    // If you are not sure about how to use it, you can just change the ttl value (time to live) and
    // the file path of the cache
    'cache' => [
        'adapter' => [
            'name'    => 'filesystem',
            'options' => [
                'namespace' => 'gcrud',
                'ttl' => 3600 * 24 * 30 * 6,
                'cache_dir' => realpath(__DIR__ . '/Cache/')
            ],
        ],
        'plugins' => [
            'exception_handler' => ['throw_exceptions' => false],
        ],
    ],
];