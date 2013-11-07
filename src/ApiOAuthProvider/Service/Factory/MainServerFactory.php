<?php
namespace ApiOAuthProvider\Service\Factory;

use ApiOAuthProvider\Exception;

use Zend\ServiceManager;

class MainServerFactory implements ServiceManager\FactoryInterface
{
    /**
     * Initialized the Main Server used by the controllers
     *
     * The main server call is: apioauthprovider.server.main
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $configuration = $serviceLocator->get('ApiOAuthProvider\Options\Configuration');

        // initialize the main server via the abstract server factory;
        return $serviceLocator->get($configuration->getMainServer());
    }
}
