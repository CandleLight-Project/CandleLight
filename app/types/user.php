<?php

use CandleLight\App;
use CandleLight\Model;

class User extends Model{

    /**
     * Returns the associated type-settings array
     * @return array Type settings array
     */
    public static function getTypeSettings(): array{
        return [
            "title" => "User Data",
            "description" => "Access to the logged in user.",
            "connection" => "default",
            "table" => "users",
            "routing" => [
                "get" => [
                    [
                        "url" => "/me",
                        "action" => "me",
                        "middleware" => [
                            "authenticate"
                        ]
                    ],
                    [
                        "url" => "/user",
                        "action" => "default",
                        "attributes" => [],
                        "middleware" => [
                            "authenticate",
                            "pagination"
                        ]
                    ],
                    [
                        "url" => "/user/{id}",
                        "action" => "default",
                        "attributes" => [
                            "operator" => "=",
                            "firstOrFail" => true,
                        ],
                        "middleware" => [
                            "authenticate"
                        ]
                    ]
                ],
                "post" => [
                    [
                        "url" => "/me",
                        "action" => "me",
                        "middleware" => []
                    ],
                    [
                        "url" => "/user",
                        "action" => "default",
                        "middleware" => []
                    ]
                ],
                "delete" => [
                    [
                        "url" => "/user/{id}",
                        "action" => "default",
                        "attributes" => [
                            "operator" => "=",
                            "firstOrFail" => true,
                        ],
                        "middleware" => [
                            "authenticate"
                        ]
                    ]
                ],
                "put" => [
                    [
                        "url" => "/user/{id}",
                        "action" => "default",
                        "attributes" => [
                            "operator" => "=",
                            "firstOrFail" => true,
                        ],
                        "middleware" => [
                            "authenticate"
                        ]
                    ]
                ]
            ],
            "fields" => [
                [
                    "name" => "email",
                    "validation" => [
                        "not-empty",
                        "is-email",
                        "is-unique"
                    ]
                ],
                [
                    "name" => "password",
                    "calculations" => [
                        "hash-password" => [
                            "field" => "password",
                            "salt" => "salt"
                        ]
                    ]
                ]
            ]
        ];
    }
}

/** @var App $app */
$app->addType('user', User::class);