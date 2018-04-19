Order Managment
===============

The SDK allow you to manage your orders.

## Number of new orders

From the store you can retrieve the number of new order :
```php
<?php
/** @var \ShoppingFeed\Sdk\Api\Store\StoreResource $store */
$store->getNewOrderCount();
```

## Order by reference

You can retrieve an order of your store by it's reference

```php
<?php
/** @var \ShoppingFeed\Sdk\Api\Store\StoreResource $store */
$orderDomain = $store->getOrder();
$order       = $orderDomain->getByReference('[REFERENCE]');
````
