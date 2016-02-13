<?php

namespace Suggestions;

return array(
     'router'=>array(
       'routes' =>array(
         'suggestions-json' => array(
                'type' => 'segment',
                'options' => array(
                   'route'    => '/suggestions[?q=:q][&lat=:lat][&long=:long]', //On spécifie la route avec les paramètres sont optionnels
                   'constraints' => array(
                                'q' => '[a-zA-Z0-9]+', 
                                'lat'=> '-?[a-zA-Z0-9]+', 
                                 'long'=> '-?[a-zA-Z0-9]+',

                    ),
                    'defaults'=> array(
                        'controller' => 'Suggestions\Controller\City',
                        'action' => 'JSonVilles',
                  ),
                           
                ),
            ),
            'suggestions' => array(
                'type' => 'segment',
                'options' => array(
                   'route'    => '/Suggestions',
                    'defaults'=> array(
                        'controller' => 'Suggestions\Controller\City',
                        'action' => 'villes',
                  ),
                           
                ),
            ),
         ),
      ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Suggestions\Controller\City' => 'Suggestions\Controller\CityController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
          'suggestions' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);