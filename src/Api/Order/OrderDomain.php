<?php
namespace ShoppingFeed\Sdk\Api\Order;

use ShoppingFeed\Sdk\Resource\AbstractDomainResource;
use ShoppingFeed\Sdk\Order;

class OrderDomain extends AbstractDomainResource
{
    /**
     * @var string
     */
    protected $resourceClass = Order\OrderResource::class;

    /**
     * Get an order by its reference
     *
     * @param $reference
     *
     * @return null|Order\OrderResource
     */
    public function getByReference($reference)
    {
        $resource = $this->link->get([], ['query' => ['reference' => $reference]]);
        if ($resource->getProperty('count') > 0) {
            return new Order\OrderResource(
                $resource->getFirstResource('order'),
                false
            );
        }
    }
}
