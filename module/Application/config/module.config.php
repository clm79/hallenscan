<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'log' => [
        'Logger' => [
            'writers' => [
                [
                    'name' => 'db',
                    'options' => [
                        'db' => 'Zend\Db\Adapter\Adapter',
                        'table' => 'zend_log',
                    ],
                ],
            ],
            'processors' => [
                'requestId' => [
                    'name' => \Zend\Log\Processor\RequestId::class,
                ],
                'requestURI' => [
                    'name' => \Application\Util\Log\LogProcessor::class,
                ],
            ],            
        ],
    ],
    'navigation' => [
        'default' => [
            [
                'label' => 'Home',
                'route' => 'home',
            ],
            [
                'label' => 'Bordero',
                'route' => 'bordero-file',
                'pages' => [
                    [
                        'label' => 'Import',
                        'route' => 'bordero-file',
                        'action' => 'import',
                    ],
                ],
            ],
            [
                'label' => 'Log-Protokoll',
                'route' => 'log',
                'pages' => [
                    [
                        'label' => 'Liste',
                        'route' => 'log',
                        'action' => 'list',
                    ],
                ],
            ],
        ],
    ],
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'application' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/application[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],                    
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'bordero-file' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/bordero-file[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],                    
                    'defaults' => [
                        'controller' => Controller\BorderoFileController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'log' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/log[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],                    
                    'defaults' => [
                        'controller' => Controller\LogController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\BorderoFileController::class => Controller\Factory\BorderoFileControllerFactory::class,
            Controller\LogController::class => Controller\Factory\LogControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\BorderoFileManager::class => Service\Factory\BorderoFileManagerFactory::class,
        ],
        'abstract_factories' => [
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
    ],
    'session_containers' => [
        'session'
    ],    
    'view_manager' => [
        'display_not_found_reason' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
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
    ]
];
