<?php
declare(strict_types=1);

namespace XerviceTest\Validator\Helper\ValidationConfiguration;


use Xervice\Validator\Business\Dependency\ValidatorConfigurationProviderPluginInterface;

class AddTestValidatorConfig implements ValidatorConfigurationProviderPluginInterface
{
    /**
     * @return array
     */
    public function getValidatorConfiguration(): array
    {
        return [
            'secondField',
            [
                'fields.*' => [
                    'data'
                ]
            ]
        ];
    }
}