<?php
namespace Authentification;

use Authentification\Business\Factory\UserBusinessFactory;
use Authentification\Business\UserBusiness;
use Authentification\Controller\Factory\UserControllerFactory;
use Authentification\Controller\UserController;
use Zend\Router\Http\Literal;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'router' => [
        'routes' => [
            'list.users' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/user',
                    'defaults' => [
                        'controller' => UserController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'add.users' => [
                'type'    => literal::class,
                'options' => [
                    'route'    => '/user/add',
                    'defaults' => [
                        'controller' => UserController::class,
                        'action'     => 'add',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            UserController::class => UserControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            UserBusiness::class => UserBusinessFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
];
