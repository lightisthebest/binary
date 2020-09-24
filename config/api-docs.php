<?php

use Illuminate\Http\Response;
use Illuminate\Support\Str;

/**
 * @return array
 */
function getApiErrorResponse()
{
    return [
        "description" => "Internal server error.",
        "content" => [
            "application/json" => [
                'schema' => [
                    "type" => 'object',
                    'required' => [
                        "status", "message"
                    ],
                    "properties" => [
                        "status" => [
                            "example" => 500,
                            "type" => "integer"
                        ],
                        "message" => [
                            "example" => "Something went wrong.",
                            "type" => "string"
                        ],
                        "file" => [
                            "example" => "/Users/admin/Projects/current/app/Http/Controllers/FileName.php",
                            "type" => "string"
                        ],
                        "line" => [
                            "example" => 53,
                            "type" => "integer"
                        ],
                    ]
                ]
            ]
        ]
    ];
}

/**
 * @return array
 */
function getItemRequired()
{
    return [
        "id", "parent_id", "position", "path", "level"
    ];
}

/**
 * @param int $id
 * @param null $parent_id
 * @param null $position
 * @param string $path
 * @param int $level
 * @return array
 */
function getItemAttributes($id = 1, $parent_id = null, $position = null, $path = "1", $level = 1)
{
    return [
        "id" => [
            "example" => $id,
            "type" => 'integer'
        ],
        "parent_id" => [
            "example" => $parent_id,
            "type" => 'integer',
            "nullable" => true
        ],
        "position" => [
            "example" => $position,
            "type" => 'integer',
            "nullable" => true,
            "allowEmptyValue" => true,
            "enum" => [1, 2],

        ],
        "path" => [
            "example" => $path,
            "type" => 'string'
        ],
        "level" => [
            "example" => $level,
            "type" => 'integer'
        ]
    ];
}

return [
    'main' => [
        "openapi" => "3.0.0",
        "info" => [
            "title" => "Documentation",
            "contact" => [
                "phone" => "380638508007"
            ],
            "version" => "1.0.0"
        ],
        "servers" => [
            [
                "url" => Str::finish(env('APP_URL'), '/') . 'api/binar',
                "description" => "Local server"
            ]
        ],
        "components" => [
            "securitySchemes" => [
                "" => [
                    "type" => "openIdConnect"
                ]
            ]
        ],
        "tags" => [
            [
                "name" => "GET routes"
            ],
            [
                "name" => "POST routes"
            ]
        ],
    ],

    "paths" => [
        "/create" => [
            "post" => [
                "summary" => "Create new binar.",
                "tags" => ["POST routes"],
                "parameters" => [],
                "requestBody" => [
                    "required" => true,
                    'description' => 'New binar options.',
                    "content" => [
                        "application/json" => [
                            "schema" => [
                                "type" => "object",
                                "required" => [
                                    "parent_id",
                                    "position"
                                ],
                                "properties" => [
                                    "parent_id" => [
                                        "type" => "integer",
                                        "description" => "ID of the parent binar.",
                                        "example" => 1
                                    ],
                                    "position" => [
                                        "type" => "integer",
                                        "description" => "Position of new binar: 1 - for left, 2 - for right.",
                                        "example" => 1,
                                        "enum" => [1, 2]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                "responses" => [
                    Response::HTTP_OK => [
                        "description" => "New binar was created successfully.",
                        "content" => [
                            "application/json" => [
                                'schema' => [
                                    "type" => 'object',
                                    'required' => [
                                        "status", "message", "item"
                                    ],
                                    "properties" => [
                                        "status" => [
                                            "example" => Response::HTTP_OK,
                                            "type" => "integer"
                                        ],
                                        "message" => [
                                            "example" => "OK",
                                            "type" => "string"
                                        ],
                                        "item" => [
                                            "type" => "object",
                                            "required" => getItemRequired(),
                                            "properties" => getItemAttributes(2, 1, 1, "1.2", 2)
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY => [
                        "description" => "Validation exception.",
                        "content" => [
                            "application/json" => [
                                'schema' => [
                                    "type" => 'object',
                                    'required' => [
                                        "status", "message", "errors"
                                    ],
                                    "properties" => [
                                        "status" => [
                                            "example" => Response::HTTP_UNPROCESSABLE_ENTITY,
                                            "type" => "integer"
                                        ],
                                        "message" => [
                                            "example" => "The given data was invalid.",
                                            "type" => "string"
                                        ],
                                        "errors" => [
                                            "type" => "object",
                                            "example" => [
                                                "parent_id" => [
                                                    "The selected parent id is invalid.",
                                                    "The parent id must be an integer."
                                                ],
                                                "position" => [
                                                    "The position field is required."
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    Response::HTTP_INTERNAL_SERVER_ERROR => getApiErrorResponse()
                ]
            ]
        ],
        "/fill" => [
            "get" => [
                "summary" => "Fill binars table up to 5 level automatically.",
                "tags" => ["GET routes"],
                "parameters" => [],
                "responses" => [
                    Response::HTTP_OK => [
                        "description" => "Successfully filled table.",
                        "content" => [
                            "application/json" => [
                                'schema' => [
                                    "type" => 'object',
                                    'required' => [
                                        "status", "message"
                                    ],
                                    "properties" => [
                                        "status" => [
                                            "example" => Response::HTTP_OK,
                                            "type" => "integer"
                                        ],
                                        "message" => [
                                            "example" => "OK",
                                            "type" => "string"
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    Response::HTTP_INTERNAL_SERVER_ERROR => getApiErrorResponse()
                ]
            ]
        ],
        "/{binar}/related" => [
            "get" => [
                "summary" => "Get binar by id with all parents and children in tree view.",
                "tags" => ["GET routes"],
                "parameters" => [
                    [
                        "name" => "binar",
                        "required" => true,
                        "in" => "path",
                        "example" => 1,
                        "description" => "Binar ID."
                    ]
                ],
                "responses" => [
                    Response::HTTP_OK => [
                        "description" => "Operation finished successfully.",
                        "content" => [
                            "application/json" => [
                                'schema' => [
                                    "type" => 'object',
                                    'required' => [
                                        "status", "message", "data"
                                    ],
                                    "properties" => [
                                        "status" => [
                                            "example" => Response::HTTP_OK,
                                            "type" => "integer"
                                        ],
                                        "message" => [
                                            "example" => "OK",
                                            "type" => "string"
                                        ],
                                        "data" => [
                                            "type" => "object",
                                            "required" => getItemRequired(),
                                            "properties" => array_merge(getItemAttributes(), [
                                                "children" => [
                                                    "type" => "array",
                                                    "items" => [
                                                        "type" => "object",
                                                        "required" => getItemRequired(),
                                                        "properties" => getItemAttributes(3, 1, 1, "1.3", 2)
                                                    ]
                                                ]
                                            ])
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    Response::HTTP_NOT_FOUND => [
                        "description" => "Not found exception.",
                        "content" => [
                            "application/json" => [
                                'schema' => [
                                    "type" => 'object',
                                    'required' => [
                                        "message", "status"
                                    ],
                                    "properties" => [
                                        "status" => [
                                            "type" => "integer",
                                            "example" => Response::HTTP_NOT_FOUND
                                        ],
                                        "message" => [
                                            "example" => "Data is not found.",
                                            "type" => "string"
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                ]
            ]
        ]
    ]
];
