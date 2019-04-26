# Validator


## Installation
```
composer require xervice/validator
```


## Using
To use the configurator you have to define validator-configuration plugins.

```php
use Xervice\Validator\Business\Dependency\ValidatorConfigurationProviderPluginInterface;
use Xervice\Validator\Business\Model\ValidatorType\IsType;

class TestValidatorConfig implements ValidatorConfigurationProviderPluginInterface
{
    /**
     * @return array
     */
    public function getValidatorConfiguration(): array
    {
        return [
            'unit',
            'floatTest',
            'child',
            [
                'unit' => [
                    'type' => IsType::TYPE_INTEGER
                ],
                'floatTest' => [
                    'type' => IsType::TYPE_FLOAT
                ]
            ],
            [
                'isTest' => [
                    'required' => true,
                    'type' => IsType::TYPE_BOOLEAN
                ]
            ],
            [
                'floatTest' => function ($value) {
                    return $value === 1.23;
                },
                'child.subchild1',
                'child.subchild2' => [
                    'type' => IsType::TYPE_OBJECT
                ],
                'child.subchild3' => [
                    'type' => IsType::TYPE_BOOLEAN
                ]
            ],
            [
                'child.*' => [
                    'subchild1',
                    'subchild2' => function ($value) {
                        return is_object($value);
                    }
                ]
            ]
        ];
    }
}
```

The configuration is defined as an array. If one entry is a value "keyname" without key, you define this key as required. Also you can define the keyname as an array with the parameter "required" and "type" to define a specific value for the given key.
For nested arrays you can direct address to a child value with level1.level2.level3 or you can define values for all elements like level1.level2.* => [ level3 => [ type => 'integer'] ]. For custom validations you can define a closure for one keyname. You get the value as an parameter in your closure.

## Extending

You can write own Validator-Plugins and configure them in the validator dependency provider. Your plugin must implement the interface \Xervice\Validator\Business\Dependency\ValidatorTypePluginInterface.


```php
class ExamplePlugin extends AbstractBusinessPlugin implements ValidatorTypePluginInterface
{
    protected const NAME = 'ExamplePlugin';

    /**
     * @return string
     */
    public function getTypeName(): string
    {
        return static::NAME;
    }

    /**
     * @param mixed $config
     *
     * @return bool
     */
    public function isResponsible($config): bool
    {
        return true;
    }

    /**
     * @param array $data
     * @param string $key
     * @param mixed $config
     */
    public function validate(array $data, string $key, $config): void
    {
        if (<is-not-valid>) {
            throw new ValidatorException('Foo is not valid because!');
        }
    }
}
```