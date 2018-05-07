<?php
namespace ShoppingFeed\Sdk\Api\Order;

use ShoppingFeed\Sdk\Api\Order as ApiOrder;
use ShoppingFeed\Sdk\Resource\AbstractDomainResource;

/**
 * @method ApiOrder\OrderResource[] getIterator()
 * @method ApiOrder\OrderResource[] getAll($page = 1, $limit = 100)
 */
class OrderDomain extends AbstractDomainResource
{
    /**
     * @var string
     */
    protected $resourceClass = ApiOrder\OrderResource::class;

    /**
     * @param string $reference the resource reference
     *
     * @return null|ApiOrder\OrderResource
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getByReference($reference)
    {
        $resource = $this->link->get([], ['query' => ['reference' => $reference]]);
        if ($resource->getProperty('count') > 0) {
            return new $this->resourceClass(
                $resource->getFirstResource('order'),
                false
            );
        }

        return null;
    }
}
