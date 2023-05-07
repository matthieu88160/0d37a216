<?php

declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\Parameter;
use ApiPlatform\OpenApi\Model\PathItem;
use ApiPlatform\OpenApi\Model\RequestBody;
use ApiPlatform\OpenApi\Model\Response;
use ApiPlatform\OpenApi\OpenApi;
use ArrayObject;

class ApiDocFactory implements OpenApiFactoryInterface
{
    public function __construct(private OpenApiFactoryInterface $decorated)
    {
    }

    /**
     * @inheritDoc
     */
    public function __invoke(array $context = []): OpenApi
    {
        $api = $this->decorated->__invoke($context);

        $api->getPaths()->addPath(
            '/api/login',
            (new PathItem())->withPost(
                (new Operation())->addResponse(
                    new Response(
                        'The logged roles',
                        new ArrayObject(
                            [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'roles' => [
                                                'type' => 'array',
                                                'items' => ['type' => 'string']
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        )
                    )
                )->withRequestBody(
                    new RequestBody(
                        '',
                        new ArrayObject(
                            [
                                'application/x-www-form-urlencoded' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'name' => [
                                                'type' => 'string'
                                            ],
                                            'password' => [
                                                'type' => 'string'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        )
                    )
                )
            )
        );

        return $api;
    }
}
