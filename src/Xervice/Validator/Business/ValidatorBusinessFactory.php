<?php
declare(strict_types=1);

namespace Xervice\Validator\Business;


use Xervice\Core\Business\Model\Factory\AbstractBusinessFactory;
use Xervice\Validator\Business\Model\ValidatorProvider;
use Xervice\Validator\Business\Model\ValidatorProviderInterface;
use Xervice\Validator\Business\Model\ValidatorType\IsRequired;
use Xervice\Validator\Business\Model\ValidatorType\ValidatorInterface;
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
            $configurationPlugins,
            $this->getValidatorTypePlugins()
        );
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
}