<?php

namespace Application\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Service\BorderoFileManager;
use Application\Controller\BorderoFileController;

class BorderoFileControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container,
            $requestedName, array $options = null) {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $borderoFileManager = $container->get(BorderoFileManager::class);

        // Instantiate the controller and inject dependencies
        return new BorderoFileController($entityManager, $borderoFileManager);
    }

}
