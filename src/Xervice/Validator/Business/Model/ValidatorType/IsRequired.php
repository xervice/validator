<?php
declare(strict_types=1);

namespace Xervice\Validator\Business\Model\ValidatorType;


use Xervice\Validator\Business\Exception\ValidationException;

class IsRequired implements ValidatorInterface
{
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
        if (is_array($config)) {
            $this->validateNestedType($data, $key, $config);
        } elseif (is_string($config)) {
            $this->validateStringType($data, $key);
        }
    }

    /**
     * @param string $key
     *
     * @return string
     */
    protected function getErrorMessage(string $key): string
    {
        return sprintf(
            'Property is missing "%s"',
            $key
        );
    }

    /**
     * @param array $data
     * @param string $fieldName
     *
     * @return bool
     */
    protected function checkRequiredField(array $data, string $fieldName): bool
    {
        return isset($data[$fieldName]);
    }

    /**
     * @param array $data
     * @param string $key
     * @param $config
     *
     * @return bool
     */
    protected function validateArrayConfig(array $data, string $key, $config): bool
    {
        $valid = true;

        if (isset($config['required']) && $config['required'] === true) {
            $valid = $this->checkRequiredField($data, $key);
        }

        return $valid;
    }

    /**
     * @param array $data
     * @param $config
     *
     * @throws \Xervice\Validator\Business\Exception\ValidationException
     */
    protected function validateStringType(array $data, $config): void
    {
        if (!$this->checkRequiredField($data, $config)) {
            throw new ValidationException($this->getErrorMessage($config));
        }
    }

    /**
     * @param array $data
     * @param string $key
     * @param $config
     *
     * @throws \Xervice\Validator\Business\Exception\ValidationException
     */
    protected function validateNestedType(array $data, string $key, $config): void
    {
        if (!$this->validateArrayConfig($data, $key, $config)) {
            throw new ValidationException($this->getErrorMessage($key));
        }
    }
}