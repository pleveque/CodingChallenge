<?php

namespace Suggestions;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Suggestions\Model\City;
use Suggestions\Model\CityTable;


class Module 
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() //Retourne un tableau
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php'
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }
    
     public function getServiceConfig()
    {
        return array(
            'factories' => array(
                        
                        'Suggestions\Model\CityTable' =>  function($sm) 
                        {
                            $tableGateway = $sm->get('CityTableGateway');
                            $table = new CityTable($tableGateway);
                            return $table;
                        },
                        'CityTableGateway' => function ($sm)
                        {
                            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                            $resultSetPrototype = new ResultSet();
                            $resultSetPrototype->setArrayObjectPrototype(new City());
                            return new TableGateway('cities', $dbAdapter, null, $resultSetPrototype);
                        },
              )
        );
    }
}
