# inventories operations

### Read inventories

Accessing to the inventory manager can be done from store resource

```php
<?php
$manager = $session->getMainStore()->getInventoryManager();
```

Find a inventory item by product's reference (sku):

```php
<?php
/** @var \ShoppingFeed\Sdk\Api\Catalog\InventoryDomain $inventoryManager */
$item = $inventoryManager->getByReference('AZUR103-XL');
// Access the quantity as integer
$item->getQuantity();
// Access the reference
$item->getReference();
// Get last modification date time
$item->getUpdatedAt()->format('c');
```

Get a particular page of inventories

```php
<?php
/** @var \ShoppingFeed\Sdk\Api\Catalog\InventoryDomain $inventoryManager */
$page  = 1;
$limit = 20;
foreach ($inventoryManager->getPage($page, $limit) as $inventory) {
	echo $inventory->getQuantity() . PHP_EOL;
}
```

Or Iterates over all inventories of your catalog

```php
<?php
/** @var \ShoppingFeed\Sdk\Api\Catalog\InventoryDomain $inventoryManager */
$page = 1;
foreach ($inventoryManager->getAll($page) as $inventory) {
	echo $inventory->getQuantity() . PHP_EOL;
}
```

### Update inventories


```php
<?php
/** @var \ShoppingFeed\Sdk\Api\Catalog\InventoryDomain $inventoryManager */
$operation = new \ShoppingFeed\Sdk\Api\Catalog\InventoryUpdate();
$operation->add('ref1', 7);
$operation->add('ref2', 1);

// Then run the operation
$inventoryManager->execute($operation);
```

The result object hold updated resources, and eventual errors

```php
<?php
// Check if one of the batch fails
$result->hasError(); // true

// Check if all batch failed
$result->isError(); // false

// Retrieve the content of resources
foreach ($result->getResource() as $inventory) {
	echo $inventory->getId() . PHP_EOL;
	echo $inventory->getUpdatedAt()->format('c') . PHP_EOL;
)
```
