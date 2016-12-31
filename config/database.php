<?php

return [
    'dsn' => 'sqlite:' . __DIR__ . '/../data/blog.sq3',
    'tables' => [
        'posts' => [
            'id'        => 'integer not null primary key',
            'title'     => 'text not null',
            'slug'      => 'text not null',
            'filename'  => 'text not null',
            'body'      => 'text not null',
            'created'   => 'integer not null',
            'published' => 'integer null default null'
        ],
        'users' => [
            'id'       => 'integer not null primary key',
            'username' => 'text not null',
            'email'    => 'text not null',
            'password' => 'text not null'
        ]
    ]
];
