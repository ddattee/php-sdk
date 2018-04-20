<?php
namespace ShoppingFeed\Sdk\Order;

use ShoppingFeed\Sdk\Api\Store\StoreResource;
use ShoppingFeed\Sdk\Resource\AbstractResource;

class OrderResource extends AbstractResource
{
    /**
     * @return int
     */
    public function getId()
    {
        return (int) $this->getProperty('id');
    }

    /**
     * @return int
     */
    public function getStoreId()
    {
        return (int) $this->getProperty('storeId');
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return (string) $this->getProperty('reference');
    }

    /**
     * @return null|string
     */
    public function getStoreReference()
    {
        return $this->getProperty('storeReference');
    }

    /**
     * @return null|\DateTimeImmutable
     */
    public function getAcknowledgedAt()
    {
        return date_create_immutable($this->getProperty('acknowledgedAt'));
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt()
    {
        return date_create_immutable($this->getProperty('createdAt'));
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getUpdatedAt()
    {
        return date_create_immutable($this->getProperty('updatedAt'));
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return (string) $this->getProperty('status');
    }

    /**
     * @return array
     */
    public function getShippingAddress()
    {
        return $this->getProperty('shippingAddress');
    }

    /**
     * @return array
     */
    public function getBillingAddress()
    {
        return $this->getProperty('billingAddress');
    }

    /**
     * @return array
     */
    public function getPaymentInformation()
    {
        return $this->getProperty('payment');
    }

    /**
     * @return array
     */
    public function getShipment()
    {
        return $this->getProperty('shipment');
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->getProperty('items');
    }

    /**
     * @return StoreResource
     */
    public function getStore()
    {
        return new StoreResource(
            $this->getLink('store')->get()
        );
    }
}
