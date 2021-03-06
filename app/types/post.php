<?php

use CandleLight\App;
use CandleLight\Model;

class Post extends Model{

    protected $casts = [
        'meta' => 'array'
    ];

    /**
     * Returns the associated type-settings array
     * @return array Type settings array
     */
    public static function getTypeSettings(): array{
        return [
            "title" => "Blog posts",
            "description" => "Main blog post type.",
            "connection" => "default",
            "table" => "posts",
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
                            "authenticate"
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
                    "validation" => [
                        "not-missing"
                    ]
                ],
                [
                    "name" => "meta",
                ]
            ]
        ];
    }
}

/** @var App $app */
$app->addType('post', Post::class);