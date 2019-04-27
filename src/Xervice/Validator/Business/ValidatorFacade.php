<?php
declare(strict_types=1);

namespace Xervice\Validator\Business;


use Xervice\Core\Business\Model\Facade\AbstractFacade;

/**
 * @method \Xervice\Validator\Business\ValidatorBusinessFactory getFactory()
 * @method \Xervice\Validator\ValidatorConfig getConfig()
 */
class ValidatorFacade extends AbstractFacade
{
    /**
     * @param array $data
     * @param string $key
     * @param mixed $config
     */
    public function validateClosure(array $data, string $key, $config): void
    {
        $this->getFactory()
            ->createClosureValidator()
            ->validate($data, $key, $config);
    }

    /**
     * @param array $data
     * @param string $key
     * @param mixed $config
     */
    public function validateIsRequired(array $data, string $key, $config): void
    {
        $this->getFactory()
            ->createIsRequiredValidator()
            ->validate($data, $key, $config);
    }

    /**
     * @param array $data
     * @param string $key
     * @param mixed $config
     */
    public function validateIsType(array $data, string $key, $config): void
    {
        $this->getFactory()
            ->createIsTypeValidator()
            ->validate($data, $key, $config);
    }

    /**
     * @param array $data
     * @param array $configurationPlugins
     * @throws \Xervice\Validator\Business\Exception\ValidationException
     */
    public function validate(array $data, array $configurationPlugins): void
    {
        $this->getFactory()
            ->createValidatorProvider($configurationPlugins)
            ->validate($data);
    }
}