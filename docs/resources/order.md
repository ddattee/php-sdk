Order Managment
===============

The SDK allow you to manage your orders.

## Number of new orders

From the store you can retrieve the number of new order :
```php
<?php
/** @var \ShoppingFeed\Sdk\Api\Store\StoreResource $store */
$store->getNewOrderCount(); // 4
```

## Order by reference

You can retrieve an order of your store by it's reference

```php
<?php
/** @var \ShoppingFeed\Sdk\Api\Store\StoreResource $store */
$orderManager = $store->getOrderManager();
$order        = $orderManager->getByReference('[REFERENCE]');

// Then acces order properties
$order->getId(); // 10
$order->getItems(); // []
$order->getCreatedAt()->format('c'); // '2004-02-12T15:19:21+00:00'
````

## Order Update

You can update an order status.

```php
<?php
/** @var \ShoppingFeed\Sdk\Api\Store\StoreResource $store */
$orderUpdater = $store->getOrderUpdater();
$orderUpdate  = new \ShoppingFeed\Sdk\Api\Order\OrderUpdate();

$orderUpdate->add('ref1', \ShoppingFeed\Sdk\Api\Order\OrderUpdate::ORDER_ACCEPT);
$orderUpdate->add('ref2', \ShoppingFeed\Sdk\Api\Order\OrderUpdate::ORDER_REFUSE);
$orderUpdate->add('ref3', \ShoppingFeed\Sdk\Api\Order\OrderUpdate::ORDER_CANCEL);
$orderUpdate->add('ref4', \ShoppingFeed\Sdk\Api\Order\OrderUpdate::ORDER_SHIP);

$orderUpdater->updateStatus($orderUpdate);
````