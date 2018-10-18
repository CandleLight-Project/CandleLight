<?php

/**
 * Register a content type named "user"
 * in the system
 */
$app->addType('user', [
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
//            [
//                "url" => "/user/{id}",
//                "action" => "default",
//                "attributes" => [
//                    "operator" => "=",
//                    "firstOrFail" => true,
//                ],
//                "middleware" => []
//            ]
        ],
        "put" => [
//            [
//                "url" => "/user/{id}",
//                "action" => "default",
//                "attributes" => [
//                    "operator" => "=",
//                    "firstOrFail" => true,
//                ],
//            ]
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
]);