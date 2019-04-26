<?php
declare(strict_types=1);

namespace Xervice\Validator\Business\Dependency;


interface ValidatorTypePluginInterface
{
    /**
     * @return string
     */
    public function getTypeName(): string;

    /**
     * @param mixed $config
     *
     * @return bool
     */
    public function isResponsible($config): bool;

    /**
     * @param array $data
     * @param string $key
     * @param mixed $config
     */
    public function validate(array $data, string $key, $config): void;
}