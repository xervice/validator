<?php
declare(strict_types=1);

namespace Xervice\Validator\Communication\Plugin\ValidatorType;


use Xervice\Core\Plugin\AbstractBusinessPlugin;
use Xervice\Validator\Business\Dependency\ValidatorTypePluginInterface;

/**
 * @method \Xervice\Validator\Business\ValidatorFacade getFacade()
 */
class IsTypePlugin extends AbstractBusinessPlugin implements ValidatorTypePluginInterface
{
    protected const NAME = 'IsTypePlugin';

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
        return (
            is_array($config)
            && isset($config['type'])
        );
    }

    /**
     * @param array $data
     * @param string $key
     * @param mixed $config
     */
    public function validate(array $data, string $key, $config): void
    {
        $this->getFacade()->validateIsType($data, $key, $config);
    }
}