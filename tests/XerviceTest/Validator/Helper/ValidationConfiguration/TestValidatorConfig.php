<?php
declare(strict_types=1);

namespace XerviceTest\Validator\Helper\ValidationConfiguration;


use Xervice\Validator\Business\Dependency\ValidatorConfigurationProviderPluginInterface;

class TestValidatorConfig implements ValidatorConfigurationProviderPluginInterface
{
    /**
     * @return array
     */
    public function getValidatorConfiguration(): array
    {
        return [
            'unit',
            'floatTest',
            'child',
            [
                'unit' => [
                    'type' => 'int'
                ],
                'floatTest' => [
                    'type' => 'float'
                ]
            ],
            [
                'isTest' => [
                    'required' => true,
                    'type' => 'bool'
                ]
            ],
            [
                'floatTest' => function ($value) {
                    return $value === 1.23;
                },
                'child.subchild1',
                'child.subchild2' => [
                    'type' => 'object'
                ],
                'child.subchild3' => [
                    'type' => 'bool'
                ]
            ],
            [
                'child.*' => [
                    'subchild1',
                    'subchild2' => function ($value) {
                        return is_object($value);
                    }
                ]
            ]
        ];
    }
}