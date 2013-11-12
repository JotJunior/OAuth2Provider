<?php
namespace OAuth2Provider\Service\Factory\GrantTypeStrategy;

use OAuth2Provider\Exception;

use Zend\ServiceManager;

class UserCredentialsFactory implements ServiceManager\FactoryInterface
{
    const IDENTIFIER = 'user_credentials';

    /**
     * Initialize an OAuth storage object
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        return function ($grantTypeClassName, $params, $serverKey) use ($serviceLocator) {
            // look for a storage param
            if (empty($params['storage'])) {
                throw new Exception\InvalidConfigException(sprintf(
                    "Class '%s' error: 'storage' configuration key is missing from 'params'",
                    __METHOD__
                ));
            }

            $storageName = $params['storage'];
            $storageContainer = $serviceLocator->get('OAuth2Provider/Containers/StorageContainer');

            // check if there is a direct defined storage key
            if ($storageContainer->isExistingServerContentInKey($serverKey, $storageName))  {
                $storage = $storageContainer->getServerContentsFromKey($serverKey, $storageName);
            } elseif ($storageContainer->isExistingServerContentInKey($serverKey, UserCredentialsFactory::IDENTIFIER)) {
                $storage = $storageContainer->getServerContentsFromKey($serverKey, UserCredentialsFactory::IDENTIFIER);
            } elseif (is_string($storageName) && $serviceLocator->has($storageName)) {
                $storage = $serviceLocator->get($storageName);
            } elseif (is_object($storageName)) {
                $storage = $storageName;
            }

            if (!isset($storage)) {
                throw new Exception\InvalidServerException(sprintf(
                    "Class '%s' error: storage of type '%s' is required for grant type '%s'",
                    __METHOD__,
                    UserCredentialsFactory::IDENTIFIER,
                    $grantTypeClassName
                ));
            }

            return new $grantTypeClassName($storage);
        };
    }
}
