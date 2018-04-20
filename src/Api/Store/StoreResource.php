<?php
namespace ShoppingFeed\Sdk\Api\Store;

use Jsor\HalClient\HalResource;
use ShoppingFeed\Sdk\Api\Catalog\InventoryDomain;
use ShoppingFeed\Sdk\Api\Order\OrderDomain;
use ShoppingFeed\Sdk\Api\Order\OrderUpdater;
use ShoppingFeed\Sdk\Resource\AbstractResource;

class StoreResource extends AbstractResource
{
    /**
     * @return string
     */
    public function getName()
    {
        return $this->getProperty('name');
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->getProperty('id');
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->getProperty('status') === 'active';
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->getProperty('country');
    }

    /**
     * @return InventoryDomain
     */
    public function getInventoryManager()
    {
        return new InventoryDomain(
            $this->resource->getFirstLink('inventory')
        );
    }

    /**
     * @return OrderDomain
     */
    public function getOrderManager()
    {
        return new OrderDomain(
            $this->resource->getFirstLink('order')
        );
    }

    /**
     * @return OrderUpdater
     */
    public function getOrderUpdater()
    {
        return new OrderUpdater(
            $this->resource->getFirstLink('order:operation')
        );
    }

    /**
     * Get number of new order for the current store
     *
     * @return int
     */
    public function getNewOrderCount()
    {
        /** @var HalResource $orderCount */
        $orderCount = array_shift($this->resource->getResource('order'));
        return (int) $orderCount->getProperty('newCount');
    }
}
