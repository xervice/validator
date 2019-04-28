<?php
declare(strict_types=1);

namespace Xervice\Validator\Business;


use Xervice\ArrayHandler\Business\ArrayHandlerFacade;
use Xervice\ArrayHandler\Dependency\FieldHandlerPluginInterface;
use Xervice\Core\Business\Model\Factory\AbstractBusinessFactory;
use Xervice\Validator\Business\Model\ValidatorProvider;
use Xervice\Validator\Business\Model\ValidatorProviderInterface;
use Xervice\Validator\Business\Model\ValidatorType\ClosureValidator;
use Xervice\Validator\Business\Model\ValidatorType\IsRequired;
use Xervice\Validator\Business\Model\ValidatorType\IsType;
use Xervice\Validator\Business\Model\ValidatorType\ValidatorInterface;
use Xervice\Validator\Communication\Plugin\FieldHandler\FieldHandlerPlugin;
use Xervice\Validator\ValidatorDependencyProvider;

/**
 * @method \Xervice\Validator\ValidatorConfig getConfig()
 */
class ValidatorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @param array $configurationPlugins
     *
     * @return \Xervice\Validator\Business\Model\ValidatorProviderInterface
     */
    public function createValidatorProvider(array $configurationPlugins): ValidatorProviderInterface
    {
        return new ValidatorProvider(
            $this->getArrayHandlerFacade(),
            $configurationPlugins,
            $this->getArrayFieldHandler()
        );
    }

    /**
     * @return \Xervice\ArrayHandler\Dependency\FieldHandlerPluginInterface
     */
    public function getArrayFieldHandler(): FieldHandlerPluginInterface
    {
        return new FieldHandlerPlugin(
            $this->getValidatorTypePlugins()
        );
    }

    /**
     * @return \Xervice\Validator\Business\Model\ValidatorType\ValidatorInterface
     */
    public function createClosureValidator(): ValidatorInterface
    {
        return new ClosureValidator();
    }

    /**
     * @return \Xervice\Validator\Business\Model\ValidatorType\ValidatorInterface
     */
    public function createIsTypeValidator(): ValidatorInterface
    {
        return new IsType();
    }

    /**
     * @return \Xervice\Validator\Business\Model\ValidatorType\ValidatorInterface
     */
    public function createIsRequiredValidator(): ValidatorInterface
    {
        return new IsRequired();
    }

    /**
     * @return \Xervice\Validator\Business\Dependency\ValidatorTypePluginInterface[]
     */
    public function getValidatorTypePlugins(): array
    {
        return $this->getDependency(ValidatorDependencyProvider::VALIDATOR_TYPE_PLUGINS);
    }

    /**
     * @return \Xervice\ArrayHandler\Business\ArrayHandlerFacade
     */
    public function getArrayHandlerFacade(): ArrayHandlerFacade
    {
        return $this->getDependency(ValidatorDependencyProvider::ARRAY_HANDLER_FACADE);
    }
}