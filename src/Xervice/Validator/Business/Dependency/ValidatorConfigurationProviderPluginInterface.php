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
     *          'type' => 'string'
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
     *          'type' => int
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
     * - string
     * - int
     * - bool
     * - array
     * - object
     * - float
     *
     * @return array
     */
    public function getValidatorConfiguration(): array;
}