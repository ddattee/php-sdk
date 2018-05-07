<?php
namespace ShoppingFeed\Sdk\Api\Order;

use ShoppingFeed\Sdk\Resource\AbstractResource;

class OrderResource extends AbstractResource
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
    public function getReference()
    {
        return $this->getProperty('reference');
    }
}
