<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Controller\IndexController;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'list.themes' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/theme',
                    'defaults' => [
                        'controller' => Controller\ThemeController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'add.themes' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/theme/add',
                    'defaults' => [
                        'controller' => Controller\ThemeController::class,
                        'action'     => 'add',
                    ],
                ],
            ],
            'view.themes' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/theme/view[/:id]',
                    'constraints' => [
                        'id' => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\ThemeController::class,
                        'action'     => 'view',
                    ],
                ],
            ],
            'delete.themes' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/theme/delete[/:id]',
                    'constraints' => [
                        'id' => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\ThemeController::class,
                        'action'     => 'delete',
                    ],
                ],
            ],
            'edit.themes' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/theme/edit[/:id]',
                    'constraints' => [
                        'id' => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\ThemeController::class,
                        'action'     => 'edit',
                    ],
                ],
            ],
            'view.articles' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/article/view[/:id]',
                    'defaults' => [
                        'controller' => Controller\ArticleController::class,
                        'action'     => 'view',
                    ],
                ],
            ],
            'add.articles' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/article/add',
                    'defaults' => [
                        'controller' => Controller\ArticleController::class,
                        'action' => 'add',
                    ],
                ],
            ],
            'index.articles' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/article',
                    'defaults' => [
                        'controller' => Controller\ArticleController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'listJson.articles' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/article/autocomplete',
                    'defaults' => [
                        'controller' => Controller\ArticleController::class,
                        'action' => 'listJson',
                    ],
                ],
            ],
            'redirectlist.articles' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/article/redirect_autocomplete',
                    'defaults' => [
                        'controller' => Controller\ArticleController::class,
                        'action' => 'redirectAutocomplete',
                    ],
                ],
            ],
            'edit.articles' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/article/edit[/:id]',
                    'defaults' => [
                        'controller' => Controller\ArticleController::class,
                        'action' => 'edit',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\Factory\IndexControllerFactory::class,
            Controller\ArticleController::class => Controller\Factory\ArticleControllerFactory::class,
            Controller\ThemeController::class => Controller\Factory\ThemeControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
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
