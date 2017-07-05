<?php

namespace Authentification;

use Authentification\Controller\AuthentificationController;
use Authentification\Controller\Factory\AuthentificationControllerFactory;
use Authentification\Controller\Factory\UserControllerFactory;
use Authentification\Controller\UserController;
use Authentification\Service\AuthentificationAdapter;
use Authentification\Service\Factory\AuthentificationAdapterFactory;
use Authentification\Service\Factory\AuthentificationServiceFactory;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zend\Authentication\AuthenticationService;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'list.users' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/user',
                    'defaults' => [
                        'controller' => UserController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'add.users' => [
                'type' => literal::class,
                'options' => [
                    'route' => '/user/add',
                    'defaults' => [
                        'controller' => UserController::class,
                        'action' => 'add',
                    ],
                ],
            ],
            'view.users' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/user/view[/:id]',
                    'constraints' => [
                        'id' => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller' => UserController::class,
                        'action' => 'view',
                    ],
                ],
            ],
            'connexion' => [
                'type' => literal::class,
                'options' => [
                    'route' => '/connexion',
                    'defaults' => [
                        'controller' => AuthentificationController::class,
                        'action' => 'login',
                    ],
                ],
            ],
            'test_connexion' => [
                'type' => literal::class,
                'options' => [
                    'route' => '/test_connexion',
                    'defaults' => [
                        'controller' => AuthentificationController::class,
                        'action' => 'verifylogin',
                    ],
                ],
            ],
            'deconnexion' => [
                'type' => literal::class,
                'options' => [
                    'route' => '/deconnexion',
                    'defaults' => [
                        'controller' => AuthentificationController::class,
                        'action' => 'logout',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            UserController::class => UserControllerFactory::class,
            AuthentificationController::class => AuthentificationControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            AuthenticationService::class => AuthentificationServiceFactory::class,
            AuthentificationAdapter::class => AuthentificationAdapterFactory::class,
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
