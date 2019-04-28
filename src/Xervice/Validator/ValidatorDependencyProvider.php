<?php
declare(strict_types=1);

namespace Xervice\Validator;


use Xervice\Core\Business\Model\Dependency\Provider\AbstractDependencyProvider;
use Xervice\Core\Business\Model\Dependency\DependencyContainerInterface;
use Xervice\Validator\Communication\Plugin\ValidatorType\ClosureValidatorPlugin;
use Xervice\Validator\Communication\Plugin\ValidatorType\IsRequiredPlugin;
use Xervice\Validator\Communication\Plugin\ValidatorType\IsTypePlugin;

/**
 * @method \Xervice\Core\Locator\Locator getLocator()
 */
class ValidatorDependencyProvider extends AbstractDependencyProvider
{
    public const VALIDATOR_TYPE_PLUGINS = 'validator.type.plugins';
    public const ARRAY_HANDLER_FACADE = 'validator.array.handler.facade';

    /**
     * @param \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface $container
     *
     * @return \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface
     */
    public function handleDependencies(DependencyContainerInterface $container): DependencyContainerInterface
    {
        $container = $this->addValidatorTypePlugins($container);
        $container = $this->addArrayHandlerFacade($container);

        return $container;
    }

    /**
     * @param \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface $container
     *
     * @return \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface
     */
    protected function addValidatorTypePlugins(DependencyContainerInterface $container): DependencyContainerInterface
    {
        $container[static::VALIDATOR_TYPE_PLUGINS] = function (DependencyContainerInterface $container) {
            return [
                new IsRequiredPlugin(),
                new IsTypePlugin(),
                new ClosureValidatorPlugin()
            ];
        };

        return $container;
    }

    /**
     * @param \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface $container
     *
     * @return \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface
     */
    protected function addArrayHandlerFacade(DependencyContainerInterface $container): DependencyContainerInterface
    {
        $container[static::ARRAY_HANDLER_FACADE] = function (DependencyContainerInterface $container) {
            return $container->getLocator()->arrayHandler()->facade();
        };
        return $container;
}
}
