<?php
declare(strict_types=1);

namespace Xervice\Validator\Business\Model\ValidatorType;

interface ValidatorInterface
{
    /**
     * @param array $data
     * @param string $key
     * @param mixed $config
     */
    public function validate(array $data, string $key, $config): void;
}