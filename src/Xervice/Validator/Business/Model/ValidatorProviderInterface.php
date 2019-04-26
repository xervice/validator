<?php
declare(strict_types=1);

namespace Xervice\Validator\Business\Model;

interface ValidatorProviderInterface
{
    /**
     * @param array $data
     *
     * @throws \Xervice\Validator\Business\Exception\ValidationException
     */
    public function validate(array $data): void;
}