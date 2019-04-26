<?php
declare(strict_types=1);

namespace Xervice\Validator\Business\Model\ValidatorType;


use Xervice\Validator\Business\Exception\ValidationException;

class IsType implements ValidatorInterface
{
    public const TYPE_STRING = 'string';
    public const TYPE_INTEGER = 'integer';
    public const TYPE_DOUBLE = 'double';
    public const TYPE_FLOAT = 'double';
    public const TYPE_BOOLEAN = 'boolean';
    public const TYPE_ARRAY = 'array';
    public const TYPE_OBJECT = 'object';
    public const TYPE_RESOURCE = 'resource';

    /**
     * @param array $data
     * @param string $key
     * @param $config
     *
     * @return void
     * @throws \Xervice\Validator\Business\Exception\ValidationException
     */
    public function validate(array $data, string $key, $config): void
    {
        if (isset($data[$key]) && $config['type'] !== gettype($data[$key])) {
            throw new ValidationException(
                $this->getErrorMessage(
                    $key,
                    gettype($data[$key]),
                    $config['type']
                )
            );
        }
    }

    /**
     * @param string $key
     * @param string $currentType
     * @param string $expectedType
     *
     * @return string
     */
    protected function getErrorMessage(string $key, string $currentType, string $expectedType): string
    {
        return sprintf(
            'Property "%s" have the type %s but %s expected',
            $key,
            $currentType,
            $expectedType
        );
    }
}