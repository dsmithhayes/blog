<?php

return [
    'dsn' => 'sqlite:' . __DIR__ . '/../data/blog.sq3',
    'tables' => [
        'posts' => [
            'title'          => 'text',
            'slug'           => 'text',
            'body'           => 'text',
            'date_published' => 'integer',
            'published'      => 'integer'
        ],
        'users' => [
            'username' => 'text',
            'email'    => 'text',
            'password' => 'text'
        ]
    ]
];
