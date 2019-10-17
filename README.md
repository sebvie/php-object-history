# php-object-history
The package records changes of a PHP object and persists it to a storage. This can be useful if you have a stream of data and you only want the get the changeset of it and throw away the other data.

Example Usage:

Inititate Storage and Comparer:
```
use PhpObjectHistory\Comparer\ObjectComparer;
use PhpObjectHistory\Storage\CsvFileStorage;
use PhpObjectHistory\ObjectHistory;

$storage = new CsvFileStorage();
$storage->setCsvFilePath($filePath);

$objectComparer = new ObjectComparer();

$objectHistory = new ObjectHistory(
    $storage,
    $objectComparer
);
```

Add objects:
```

$object = new \stdClass();
$object->testProperty = 1;
$object->testPropertyUnchanged = true;

$objectHistory->addObject($object);

$object = new \stdClass();
$object->testProperty = 2;
$object->testPropertyUnchanged = true;

$objectHistory->addObject($object);
```

Result is csv file containing:
```
testProperty,testPropertyUnchanged
1;true
2
```
##Custom Formatters

You can add custom Formatters to flatten your object:
```
use PhpObjectHistory\Formatter\ObjectFormatterInterface

class ToStringFormatter implements ObjectFormatterInterface
{

    /**
     * @param object $object
     * @return string
     */
    public function format(object $object): string
    {
        return $object->__toString();
    }

    /**
     * @param object $object
     * @return bool
     */
    public function supports(object $object): bool
    {
        return method_exists($object, '__toString');
    }
}
```
add the formatter:
```
$formatter = new CustomFormatter();

$storage = new CsvFileStorage();
$storage->setCsvFilePath($filePath);
$storage->getObjectFormatterHandler()->addFormatter($formatter);

$objectComparer = new ObjectComparer();
$objectComparer->getObjectFormatterHandler()->addFormatter($formatter);

```


## Implement custom Storages:

```
use PhpObjectHistory\Entity\ObjectChange;

class InMemoryStorage implements StorageInterface
{
    
    /**
     * @var array
     */
    protected $result = [];
    
    /**
     * @param object $object
     */
    public function setInitialObject(object $object): void
    {
        $this->result[] = $object;
    }

    /**
     * @param ObjectChange[] $objectChanges
     */
    public function addObjectChanges(array $objectChanges): void
    {
        if (empty($objectChanges)) {
            return;
        }

        $this->result[] = $objectChanges;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }

}
```

Available Storage:
- CsvFileStorage
- InMemoryStorage

Available Formatters:
- DatetimeFormatter
- ToStringFormatter


