<?php
declare(strict_types=1);

namespace Xervice\Validator\Business\Model\ValidatorType;


use Xervice\Validator\Business\Exception\ValidationException;

class ClosureValidator implements ValidatorInterface
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
        if (isset($data[$key]) && !$config($data[$key])) {
            throw new ValidationException($this->getErrorMessage($key));
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
            '"%s" is invalid',
            $key
        );
    }
}