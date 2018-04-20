<?php
namespace ShoppingFeed\Sdk\Api\Order;

use ShoppingFeed\Sdk\Resource\AbstractDomainResource;

class OrderUpdater extends AbstractDomainResource
{
    /**
     * Update orders status
     *
     * @param array|OrderUpdate $orderUpdate
     *
     * @param $orderUpdate
     *
     * @throws \Exception
     */
    public function updateStatus($orderUpdate)
    {
        if (! is_array($orderUpdate) && ! $orderUpdate instanceof OrderUpdate) {
            throw new \Exception('Only array or OrderUpdate are accepted to update orders.');
        }

        if (! $orderUpdate instanceof OrderUpdate) {
            $orderUpdate = new OrderUpdate($orderUpdate);
        }

        $orderUpdate->execute($this->link);
    }

}
