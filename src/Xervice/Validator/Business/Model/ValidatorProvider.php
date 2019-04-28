<?php
declare(strict_types=1);

namespace Xervice\Validator\Business\Model;


use Xervice\ArrayHandler\Business\ArrayHandlerFacade;
use Xervice\ArrayHandler\Dependency\FieldHandlerPluginInterface;
use Xervice\Validator\Business\Dependency\ValidatorConfigurationProviderPluginInterface;
use Xervice\Validator\Business\Exception\ValidationException;

class ValidatorProvider implements ValidatorProviderInterface
{
    /**
     * @var \Xervice\ArrayHandler\Business\ArrayHandlerFacade
     */
    private $arrayHandlerFacade;

    /**
     * @var \Xervice\Validator\Business\Dependency\ValidatorConfigurationProviderPluginInterface[]
     */
    private $configurationPlugins;

    /**
     * @var \Xervice\ArrayHandler\Dependency\FieldHandlerPluginInterface
     */
    private $arrayFieldHandlerPlugin;

    /**
     * Validator constructor.
     *
     * @param \Xervice\ArrayHandler\Business\ArrayHandlerFacade $arrayHandlerFacade
     * @param \Xervice\Validator\Business\Dependency\ValidatorConfigurationProviderPluginInterface[] $configurationPlugins
     * @param \Xervice\ArrayHandler\Dependency\FieldHandlerPluginInterface $arrayFieldHandlerPlugin
     */
    public function __construct(
        ArrayHandlerFacade $arrayHandlerFacade,
        array $configurationPlugins,
        FieldHandlerPluginInterface $arrayFieldHandlerPlugin
    ) {
        $this->arrayHandlerFacade = $arrayHandlerFacade;
        $this->configurationPlugins = $configurationPlugins;
        $this->arrayFieldHandlerPlugin = $arrayFieldHandlerPlugin;
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
                $this->arrayHandlerFacade->handleArray(
                    $this->arrayFieldHandlerPlugin,
                    $data,
                    $configurationPlugin->getValidatorConfiguration()
                );
            }
        } catch (ValidationException $exception) {
            throw new ValidationException(
                sprintf(
                    'Data not valid. %s',
                    $exception->getMessage()
                )
            );
        }
    }
}