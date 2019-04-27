<?php
declare(strict_types=1);

namespace Xervice\Validator\Business\Model;


use Xervice\Validator\Business\Dependency\ValidatorConfigurationProviderPluginInterface;
use Xervice\Validator\Business\Exception\ValidationException;

class ValidatorProvider implements ValidatorProviderInterface
{
    /**
     * @var \Xervice\Validator\Business\Dependency\ValidatorConfigurationProviderPluginInterface[]
     */
    private $configurationPlugins;

    /**
     * @var \Xervice\Validator\Business\Dependency\ValidatorTypePluginInterface[]
     */
    protected $validatorTypes;

    /**
     * Validator constructor.
     *
     * @param \Xervice\Validator\Business\Dependency\ValidatorConfigurationProviderPluginInterface[] $configurationPlugins
     * @param \Xervice\Validator\Business\Dependency\ValidatorTypePluginInterface[] $validatorTypes
     */
    public function __construct(array $configurationPlugins, array $validatorTypes)
    {
        $this->configurationPlugins = $configurationPlugins;
        $this->validatorTypes = $validatorTypes;
    }


    /**
     * @param array $data
     *
     * @throws \Xervice\Validator\Business\Exception\ValidationException
     */
    public function validate(array $data): void
    {
        try {
            foreach ($this->configurationPlugins as $configurationPlugin) {
                $this->validateByPlugin($data, $configurationPlugin);
            }
        }
        catch (ValidationException $exception) {
            throw new ValidationException(
                sprintf(
                    'Data not valid. %s',
                    $exception->getMessage()
                )
            );
        }
    }

    /**
     * @param array $data
     * @param \Xervice\Validator\Business\Dependency\ValidatorConfigurationProviderPluginInterface $configurationProviderPlugin
     */
    protected function validateByPlugin(array $data, ValidatorConfigurationProviderPluginInterface $configurationProviderPlugin): void
    {
        foreach ($configurationProviderPlugin->getValidatorConfiguration() as $fieldConfig) {
            if (is_string($fieldConfig)) {
                $this->validateField($data, $fieldConfig, $fieldConfig);
            }
            else {
                $this->validateNested($data, $fieldConfig);
            }
        }
    }

    /**
     * @param array $data
     * @param array $configs
     */
    protected function validateNested(array $data, array $configs): void
    {
        foreach ($configs as $key => $fieldConfig) {
            $this->validateByType($data, $key, $fieldConfig);
        }
    }

    /**
     * @param array $data
     * @param string $fieldName
     * @param mixed $config
     */
    protected function validateField(array $data, string $fieldName, $config): void
    {
        foreach ($this->validatorTypes as $validatorType) {
            if ($validatorType->isResponsible($config)) {
                $validatorType->validate($data, $fieldName, $config);
            }
        }
    }

    /**
     * @param array $data
     * @param string $key
     * @param mixed $fieldConfig
     */
    protected function validateArrayKey(array $data, string $key, $fieldConfig): void
    {
        $context = explode('.', $key);
        $subdata = $data;
        $lastKey = $this->array_key_last($context);
        $lastChain = $context[$lastKey];
        foreach ($context as $subkey => $chain) {
            if ($subkey !== $lastKey) {
                $subdata = $subdata[$chain];
            }
        }
        $this->validateField($subdata, $lastChain, $fieldConfig);
    }

    /**
     * @param array $data
     * @param mixed $key
     * @param mixed $fieldConfig
     */
    protected function validateByType(array $data, $key, $fieldConfig): void
    {
        if (is_string($fieldConfig)) {
            $key = $fieldConfig;
        }

        if (strpos($key, '.*') !== false) {
            $this->validateAllArrayFields($data, $key, $fieldConfig);
        }
        elseif (strpos($key, '.') !== false) {
            $this->validateArrayKey($data, $key, $fieldConfig);
        }
        else {
            $this->validateField($data, $key, $fieldConfig);
        }
    }

    /**
     * @param array $data
     * @param string $key
     * @param mixed $fieldConfig
     */
    protected function validateAllArrayFields(array $data, string $key, $fieldConfig): void
    {
        $context = explode('.', $key);
        $subdata = $data;
        $lastKey = $this->array_key_last($context);
        foreach ($context as $subkey => $chain) {
            if ($subkey !== $lastKey) {
                $subdata = $subdata[$chain];
            }
        }

        foreach ($subdata as $childkey => $childdata) {
            $this->validateField($subdata, $childkey, $fieldConfig);
        }
    }

    /**
     * @param array $array
     *
     * @return mixed
     */
    private function array_key_last(array $array)
    {
        if (!function_exists("array_key_last")) {
            return array_keys($array)[count($array) - 1];
        }

        return array_key_last($array);
    }
}