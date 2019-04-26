<?php
declare(strict_types=1);

namespace Xervice\Validator\Business\Dependency;


interface ValidatorConfigurationProviderPluginInterface
{
    /**
     *
     * Structure:
     * [
     *  [
     *      'fieldOneAsArray' => [
     *          'required' => true
     *          'type' => \Xervice\Validator\Business\Model\ValidatorType\IsType::TYPE_STRING
     *      ],
     *  ]
     *  [
     *      'fieldTwoAsClosure' => function($value) {
     *          return true;
     *      },
     *  ]
     *  'fieldThreeSimpleRequired',
     *  [
     *      'fieldFourIsArray.SubfieldOne' => [
     *          'required' => true
     *          'type' => \Xervice\Validator\Business\Model\ValidatorType\IsType::TYPE_INTEGER
     *      ],
     *      'fieldFileIsArray'
     *  ]
     *  [
     *      'fieldFiveIsArray.*' => [
     *          'SubfieldOne' => function($value) {
     *              return true;
     *          },
     *          'SubfieldTwo'
     *      ]
     *  ]
     * ]
     *
     * Possible types:
     * - \Xervice\Validator\Business\Model\ValidatorType\IsType::TYPE_INTEGER
     * - \Xervice\Validator\Business\Model\ValidatorType\IsType::TYPE_STRING
     * - \Xervice\Validator\Business\Model\ValidatorType\IsType::TYPE_INTEGER
     * - \Xervice\Validator\Business\Model\ValidatorType\IsType::TYPE_DOUBLE
     * - \Xervice\Validator\Business\Model\ValidatorType\IsType::TYPE_FLOAT
     * - \Xervice\Validator\Business\Model\ValidatorType\IsType::TYPE_BOOLEAN
     * - \Xervice\Validator\Business\Model\ValidatorType\IsType::TYPE_ARRAY
     * - \Xervice\Validator\Business\Model\ValidatorType\IsType::TYPE_OBJECT
     * - \Xervice\Validator\Business\Model\ValidatorType\IsType::TYPE_RESOURCE
     *
     * @return array
     */
    public function getValidatorConfiguration(): array;
}