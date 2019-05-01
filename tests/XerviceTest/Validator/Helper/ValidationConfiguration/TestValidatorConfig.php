<?php
declare(strict_types=1);

namespace XerviceTest\Validator\Helper\ValidationConfiguration;


use Xervice\Validator\Business\Dependency\ValidatorConfigurationProviderPluginInterface;
use Xervice\Validator\Business\Model\ValidatorType\IsType;

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
                    'type' => IsType::TYPE_INTEGER
                ],
                'floatTest' => [
                    'type' => IsType::TYPE_FLOAT
                ]
            ],
            [
                'isTest' => [
                    'required' => true,
                    'type' => IsType::TYPE_BOOLEAN
                ]
            ],
            [
                'floatTest' => function ($value) {
                    return $value === 1.23;
                },
                'child' => [
                    'subchild1',
                    'subchild2' => [
                        'type' => IsType::TYPE_OBJECT
                    ],
                    'subchild3' => [
                        'type' => IsType::TYPE_BOOLEAN
                    ]
                ]
            ],
            [
                'child.*' => function ($value) {
                    return (is_string($value) || is_object($value));
                }
            ]
        ];
    }
}