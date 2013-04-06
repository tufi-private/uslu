<?php
return array(
    'live' => array(
        'httpd'    => array(
            'protocol' => 'http',
            'host'     => 'uslu.com',
            'path'     => 'neu'
        ),
        'database' => array(
            'host'            => 'localhost',
            'username'        => 'www',
            'password'        => 'www.www',
            'dbname'          => 'www',
            'characterset'    => 'utf8',
        ),
        'locale'   => array(
            'default' => array(
                'lc_all'       => 'C',
                'timezone'     => 'Europe/Berlin',
            )
        ),
    ),
    'dev' => array(
        'httpd'    => array(
            'protocol' => 'http',
            'host'     => 'uslu.com',
            'path'     => 'ws_tufi/uslu.com/frontend'
        ),
        'database' => array(
            'host'            => 'localhost',
            'username'        => 'root',
            'password'        => 'tufan',
            'dbname'          => 'uslu',
            'characterset'    => 'utf8',
        ),
        'locale'   => array(
            'default' => array(
                'lc_all'       => 'C',
                'timezone'     => 'Europe/Berlin',
            )
        ),
    ),
);
