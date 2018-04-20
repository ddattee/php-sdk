<?php
namespace ShoppingFeed\Sdk\Api\Order;

use Jsor\HalClient\HalLink;
use ShoppingFeed\Sdk\Operation\AbstractBulkOperation;
use ShoppingFeed\Sdk\Order\OrderCollection;

class OrderUpdate extends AbstractBulkOperation
{
    /**
     * Order accessible operation
     */
    const ORDER_ACCEPT = 'accept';
    const ORDER_REFUSE = 'refuse';
    const ORDER_CANCEL = 'cancel';
    const ORDER_SHIP   = 'ship';

    /**
     * @var array
     */
    private $operations = [];

    /**
     * @param array $data Array of ['ref' => 'operation']
     *
     * @throws \Exception
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $ref => $operation) {
            $this->add($ref, $operation);
        }
    }

    public function getRelatedResource()
    {
        return 'order';
    }

    public function execute(HalLink $link)
    {
        return $this->chunk(
            function (array $chunk, OrderCollection $collection) use ($link) {
                $response = $link->post([], $this->createHttpBody($chunk));
                $collection->merge(new OrderCollection($this->getRelated($response)));
            },
            new OrderCollection()
        );
    }

    /**
     * Add operation to do on order
     *
     * @param string $reference
     * @param string $operation
     * @param array  $options
     *
     * @throws \Exception
     */
    public function add($reference, $operation, array $options = [])
    {
        if (! is_string($reference)) {
            throw new \Exception('Only string are allowed as order reference');
        }

        if (! is_string($operation)) {
            throw new \Exception('Only string are allowed as order operation');
        }

        $this->operations[$operation] = [$reference => $options];
    }
}
