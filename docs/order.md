# Order

## Access

Accessing order operation can be done from the store.

```php
<?php
$orderApi = $session->getMainStore()->getOrder();
```

## Operations

From order API you can then access all available operation :
```php
<?php
/** @var \ShoppingFeed\Sdk\Api\Order\OrderDomain $orderApi */
$orderApi
    ->newOperations()
    ->accept('ref3', 'amazon')
    ->refuse('ref4', 'amazon')
    ->ship('ref5', 'amazon')
    ->cancel('ref1', 'amazon')
    ->execute();
```

### Accept

The accept operation accept 3 parameters :
1. [mandatory] `$reference` : Order reference (eg: 'reference1') 
2. [mandatory] `$channelName` : The channel where the order is from (eg: 'amazon') 
3. [optional] `$reason` : The reason of the acceptance (eq: 'Why we accept the order') 

Example :
```php
<?php
/** @var \ShoppingFeed\Sdk\Api\Order\OrderDomain $orderApi */
$orderApi
    ->newOperations()
    ->accept('ref1', 'amazon')
    ->accept('ref2', 'amazon', 'Why we accept it')
    ->execute();
```

### Cancel

The cancel operation accept 3 parameters :
1. [mandatory] `$reference` : Order reference (eg: 'reference1') 
2. [mandatory] `$channelName` : The channel where the order is from (eg: 'amazon') 
3. [optional] `$reason` : The reason of the cancelling (eq: 'Why we cancel the order') 

Example :
```php
<?php
/** @var \ShoppingFeed\Sdk\Api\Order\OrderDomain $orderApi */
$orderApi
    ->newOperations()
    ->cancel('ref1', 'amazon')
    ->cancel('ref2', 'amazon', 'Why we accept it')
    ->execute();
```

### Refuse

The refuse operation accept 3 parameters :
1. [mandatory] `$reference` : Order reference (eg: 'reference1') 
2. [mandatory] `$channelName` : The channel where the order is from (eg: 'amazon') 
3. [optional] `$refund` : Item references to refund (eq: `['itemref1', 'itemref2']`) 

Example :
```php
<?php
/** @var \ShoppingFeed\Sdk\Api\Order\OrderDomain $orderApi */
$orderApi
    ->newOperations()
    ->refuse('ref1', 'amazon')
    ->refuse('ref2', 'amazon', ['itemref1', 'itemref2'])
    ->execute();
```

### Ship

The ship operation accept 3 parameters :
1. [mandatory] `$reference` : Order reference (eg: 'reference1') 
2. [mandatory] `$channelName` : The channel where the order is from (eg: 'amazon') 
3. [optional] `$carrier` : The carrier name used for the shipment (eq: 'ups') 
4. [optional] `$trackingNumber` : Tracking number (eq: '01234598abcdef') 
5. [optional] `$trackingLink` : Tracking link (eq: 'http://tracking.url/') 

Example :
```php
<?php
/** @var \ShoppingFeed\Sdk\Api\Order\OrderDomain $orderApi */
$orderApi
    ->newOperations()
    ->ship('ref1', 'amazon')
    ->ship('ref2', 'amazon', 'ups', '123456789abcdefg', 'http://tracking.url/')
    ->execute();
```

### Acknowledge

To acknowledge the good reception of order :
1. [mandatory] `$reference` : Order reference (eg: 'reference1') 
2. [mandatory] `$channelName` : The channel where the order is from (eg: 'amazon') 
3. [mandatory] `$status` : Status of acknowledgment (eq: 'success') 
4. [mandatory] `$storeReference` : Store reference (eq: 'store-reference') 
5. [optional] `$message` : Acknowledge message  (eq: 'Order well acknowledge') 

Example :
```php
<?php
/** @var \ShoppingFeed\Sdk\Api\Order\OrderDomain $orderApi */
$orderApi
    ->newOperations()
    ->acknowledge('reference1', 'amazon', 'success', 'sotre-reference')
    ->acknowledge('reference1', 'amazon', 'error', 'sotre-reference')
    ->acknowledge('reference1', 'amazon', 'error', 'sotre-reference', 'Order well acknowledged')
    ->execute();
```

### Unacknowledge

To unacknowledge the good reception of order :
1. [mandatory] `$reference` : Order reference (eg: 'reference1') 
2. [mandatory] `$channelName` : The channel where the order is from (eg: 'amazon') 
3. [mandatory] `$status` : Status of unacknowledgment (eq: 'success') 
4. [mandatory] `$storeReference` : Store reference (eq: 'store-reference') 
5. [optional] `$message` : Unacknowledge message  (eq: 'Order well unacknowledge') 

Example :
```php
<?php
/** @var \ShoppingFeed\Sdk\Api\Order\OrderDomain $orderApi */
$orderApi
    ->newOperations()
    ->unacknowledge('reference1', 'amazon', 'success', 'sotre-reference')
    ->unacknowledge('reference1', 'amazon', 'error', 'sotre-reference')
    ->unacknowledge('reference1', 'amazon', 'error', 'sotre-reference', 'Order well unacknowledged')
    ->execute();
```