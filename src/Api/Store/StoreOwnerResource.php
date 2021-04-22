<?php
namespace ShoppingFeed\Sdk\Api\Store;

use ShoppingFeed\Sdk\Resource\AbstractResource;

class StoreOwnerResource extends AbstractResource
{
    /**
     * @return int
     */
    public function getId()
    {
        return $this->getProperty('id');
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->getProperty('login');
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->getProperty('token');
    }
}
