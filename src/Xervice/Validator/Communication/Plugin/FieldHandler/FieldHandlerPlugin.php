<?php
declare(strict_types=1);

namespace Xervice\Validator\Communication\Plugin\FieldHandler;


use Xervice\ArrayHandler\Dependency\FieldHandlerPluginInterface;
use Xervice\Core\Plugin\AbstractBusinessPlugin;

class FieldHandlerPlugin extends AbstractBusinessPlugin implements FieldHandlerPluginInterface
{
    /**
     * @var \Xervice\Validator\Business\Dependency\ValidatorTypePluginInterface[]
     */
    protected $validatorTypes;

    /**
     * FieldHandlerPlugin constructor.
     *
     * @param \Xervice\Validator\Business\Dependency\ValidatorTypePluginInterface[] $validatorTypes
     */
    public function __construct(array $validatorTypes)
    {
        $this->validatorTypes = $validatorTypes;
    }

    /**
     * @param array $data
     * @param string $fieldName
     * @param string $config
     *
     * @return array
     */
    public function handleSimpleConfig(array $data, string $fieldName, string $config): array
    {
        foreach ($this->validatorTypes as $validatorType) {
            if ($validatorType->isResponsible($config)) {
                $validatorType->validate($data, $fieldName, $config);
            }
        }

        return $data;
    }

    /**
     * @param array $data
     * @param string $fieldName
     * @param array $config
     *
     * @return array
     */
    public function handleNestedConfig(array $data, string $fieldName, array $config): array
    {
        foreach ($this->validatorTypes as $validatorType) {
            if ($validatorType->isResponsible($config)) {
                $validatorType->validate($data, $fieldName, $config);
            }
        }

        return $data;
    }

    /**
     * @param array $data
     * @param string $fieldName
     * @param callable $config
     *
     * @return array
     */
    public function handleCallableConfig(array $data, string $fieldName, callable $config): array
    {
        foreach ($this->validatorTypes as $validatorType) {
            if ($validatorType->isResponsible($config)) {
                $validatorType->validate($data, $fieldName, $config);
            }
        }

        return $data;
    }
}