<?php
namespace ShoppingFeed\Sdk\Order;

use ShoppingFeed\Sdk\Api;
use ShoppingFeed\Sdk\Hal;
use ShoppingFeed\Sdk\Operation;

class OrderOperation extends Operation\AbstractBulkOperation
{
    /**
     * Operation types
     */
    const TYPE_ACCEPT        = 'accept';
    const TYPE_CANCEL        = 'cancel';
    const TYPE_REFUSE        = 'refuse';
    const TYPE_SHIP          = 'ship';
    const TYPE_ACKNOWLEDGE   = 'acknowledge';
    const TYPE_UNACKNOWLEDGE = 'unacknowledge';

    /**
     * @var array
     */
    private $allowedOperationTypes = [
        self::TYPE_ACCEPT,
        self::TYPE_CANCEL,
        self::TYPE_REFUSE,
        self::TYPE_SHIP,
        self::TYPE_ACKNOWLEDGE,
        self::TYPE_UNACKNOWLEDGE,
    ];

    /**
     * @var array
     */
    protected $operations = [];


    /**
     * Notify market place of order acceptance
     *
     * @param string $reference   Order reference
     * @param string $channelName Channel to notify
     * @param string $reason      Optional reason of acceptance
     *
     * @return OrderOperation
     *
     * @throws UnexpectedTypeException
     */
    public function accept($reference, $channelName, $reason = '')
    {
        $this->addOperation(
            $reference,
            $channelName,
            OrderOperation::TYPE_ACCEPT,
            compact('reason')
        );

        return $this;
    }

    /**
     * Notify market place of order cancellation
     *
     * @param string $reference   Order reference
     * @param string $channelName Channel to notify
     * @param string $reason      Optional reason of cancellation
     *
     * @return OrderOperation
     *
     * @throws UnexpectedTypeException
     */
    public function cancel($reference, $channelName, $reason = '')
    {
        $this->addOperation(
            $reference,
            $channelName,
            OrderOperation::TYPE_CANCEL,
            compact('reason')
        );

        return $this;
    }

    /**
     * Notify market place of order shipment sent
     *
     * @param string $reference      Order reference
     * @param string $channelName    Channel to notify
     * @param string $carrier        Optional carrier name
     * @param string $trackingNumber Optional tracking number
     * @param string $trackingLink   Optional tracking link
     *
     * @return OrderOperation
     *
     * @throws UnexpectedTypeException
     */
    public function ship($reference, $channelName, $carrier = '', $trackingNumber = '', $trackingLink = '')
    {
        $this->addOperation(
            $reference,
            $channelName,
            OrderOperation::TYPE_SHIP,
            compact('carrier', 'trackingNumber', 'trackingLink')
        );

        return $this;
    }

    /**
     * Notify market place of order refusal
     *
     * @param string $reference Order reference
     * @param string $channelName    Channel to notify
     * @param array  $refund    Order item reference that will be refunded
     *
     * @return OrderOperation
     *
     * @throws UnexpectedTypeException
     */
    public function refuse($reference, $channelName, $refund = [])
    {
        $this->addOperation(
            $reference,
            $channelName,
            OrderOperation::TYPE_REFUSE,
            compact('refund')
        );

        return $this;
    }

    /**
     * Acknowledge order reception
     *
     * @param string $reference
     * @param string $channelName
     * @param string $status
     * @param string $storeReference
     * @param string $message
     *
     * @return OrderOperation
     *
     * @throws \Exception
     */
    public function acknowledge($reference, $channelName, $status, $storeReference, $message = '')
    {
        $acknowledgedAt = new \DateTimeImmutable('now');
        $this->addOperation(
            $reference,
            $channelName,
            OrderOperation::TYPE_ACKNOWLEDGE,
            compact('status', 'storeReference', 'acknowledgedAt', 'message')
        );

        return $this;
    }

    /**
     * Unacknowledge order reception
     *
     * @param string $reference
     * @param string $channelName
     * @param string $status
     * @param string $storeReference
     * @param string $message
     *
     * @return OrderOperation
     *
     * @throws \Exception
     */
    public function unacknowledge($reference, $channelName, $status, $storeReference, $message = '')
    {
        $acknowledgedAt = new \DateTimeImmutable('now');
        $this->addOperation(
            $reference,
            $channelName,
            OrderOperation::TYPE_UNACKNOWLEDGE,
            compact('status', 'storeReference', 'acknowledgedAt', 'message')
        );

        return $this;
    }

    /**
     * Execute all declared operations
     *
     * @param Hal\HalLink $link
     *
     * @return mixed|Api\Task\TicketCollection
     */
    public function execute(Hal\HalLink $link)
    {
        // Create requests per batch
        $requests = [];
        foreach ($this->allowedOperationTypes as $type) {
            $this->eachBatch(
                function (array $chunk) use ($type, $link, &$requests) {
                    $requests[] = $link->createRequest(
                        'POST',
                        ['operation' => $type],
                        ['order' => $chunk]
                    );
                },
                $type
            );
        }

        // Send requests
        $resources = [];
        $link->batchSend(
            $requests,
            function (Hal\HalResource $resource) use (&$resources) {
                array_push($resources, ...$resource->getResources('order'));
            },
            null,
            [],
            $this->getPoolSize()
        );

        return new Api\Task\TicketCollection($resources);
    }

    /**
     * Add operation to queue
     *
     * @param string $reference   Order reference
     * @param string $channelName Channel to notify
     * @param string $type        Type of operation
     * @param array  $data        Extra data to pass to operation call
     *
     * @throws UnexpectedTypeException
     */
    public function addOperation($reference, $channelName, $type, $data = [])
    {
        if (! in_array($type, $this->allowedOperationTypes)) {
            throw new UnexpectedTypeException(sprintf(
                'Only %s operations are accepted',
                implode(', ', $this->allowedOperationTypes)
            ));
        }

        if (! isset($this->operations[$type])) {
            $this->operations[$type] = [];
        }

        $this->operations[$type][] = array_merge(compact('reference', 'channelName'), $data);
    }
}