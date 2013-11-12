<?php
namespace OAuth2Provider\Containers;

use Zend\Stdlib\ArrayStack;

class GrantTypeContainer extends ArrayStack implements ContainerInterface
{
    public function getServerContents($server)
    {
        $grantTypeData = $this->getArrayCopy();
        if (isset($grantTypeData[$server])) {
            return $grantTypeData[$server];
        }
    }

    public function getServerContentsFromKey($server, $key)
    {
        $grantTypeData = $this->getArrayCopy();
        if (isset($grantTypeData[$server][$key])) {
            return $grantTypeData[$server][$key];
        }
    }

    public function isExistingServerContentInKey($server, $key)
    {
        if (is_string($server)
            && is_string($key)
            && null !== $this->getServerContentsFromKey($server, $key)
        ) {
            return true;
        }
        return false;
    }
}
