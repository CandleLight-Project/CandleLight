<?php

/**
 * Register a content type named "post"
 * in the system
 */
$app->addType('post', [
    "title" => "Blog posts",
    "description" => "Main blog post type.",
    "connection" => "default",
    "table" => "post",
    "routing" => [
        "get" => [
            [
                "url" => "/post",
                "action" => "default",
                "attributes" => [],
                "middleware" => [
                    "pagination"
                ]
            ],
            [
                "url" => "/post/{id}",
                "action" => "default",
                "attributes" => [
                    "operator" => "=",
                    "firstOrFail" => true,
                ],
                "middleware" => []
            ]
        ],
        "post" => [
            [
                "url" => "/post",
                "action" => "default",
                "middleware" => [
                    'authenticate'
                ]
            ]
        ],
        "delete" => [
            [
                "url" => "/post/{id}",
                "action" => "default",
                "attributes" => [
                    "operator" => "=",
                    "firstOrFail" => true,
                ],
                "middleware" => [
                    'authenticate'
                ]
            ]
        ],
        "put" => [
            [
                "url" => "/post/{id}",
                "action" => "default",
                "attributes" => [
                    "operator" => "=",
                    "firstOrFail" => true,
                ],
                "middleware" => [
                    'authenticate'
                ]
            ]
        ]
    ],
    "fields" => [
        [
            "name" => "title",
            "validation" => [
                "not-empty",
                "range" => [
                    "min" => 4,
                    "max" => 10
                ]
            ]
        ],
        [
            "name" => "slug",
            "calculations" => [
                "serialize-field" => [
                    "field" => "title"
                ]
            ],
            "filters" => [
                "unique-increment"
            ]
        ],
        [
            "name" => "content",
        ],
        [
            "name" => "meta",
        ]
    ]
]);