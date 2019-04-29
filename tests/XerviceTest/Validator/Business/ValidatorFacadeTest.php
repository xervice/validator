<?php namespace XerviceTest\Validator\Business;

use Xervice\Validator\Business\Exception\ValidationException;
use XerviceTest\Validator\Helper\ValidationConfiguration\AddTestValidatorConfig;
use XerviceTest\Validator\Helper\ValidationConfiguration\TestValidatorConfig;

class ValidatorFacadeTest extends \Codeception\Test\Unit
{
    /**
     * @var \XerviceTest\XerviceTestTester
     */
    protected $tester;

    /**
     * @group Xervice
     * @group Validator
     * @group Business
     * @group ValidatorFacade
     * @group IsRequired
     * @group Integration
     */
    public function testIsRequiredSuccess()
    {
        $sample = [
            'field1' => 'hello',
            'field2' => 'world'
        ];

        $configListe = [
            'field1',
            'field2' => [
                'required' => true
            ],
            'field3' => [
                'required' => false
            ]
        ];

        foreach ($configListe as $key => $config) {
            if (is_string($config)) {
                $key = $config;
            }
            $this->tester->getFacade()->validateIsRequired($sample, $key, $config);
        }
    }

    /**
     * @group Xervice
     * @group Validator
     * @group Business
     * @group ValidatorFacade
     * @group IsRequired
     * @group Integration
     */
    public function testIsRequiredFail()
    {
        $sample = [
            'field3' => 'Foo'
        ];

        $configListe = [
            'field1',
            'field2' => [
                'required' => true
            ]
        ];

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Property is missing "field1"');

        foreach ($configListe as $key => $config) {
            if (is_string($config)) {
                $key = $config;
            }
            $this->tester->getFacade()->validateIsRequired($sample, $key, $config);
        }
    }

    /**
     * @group Xervice
     * @group Validator
     * @group Business
     * @group ValidatorFacade
     * @group Validate
     * @group Integration
     */
    public function testValidationSuccess()
    {
        $sample = $this->getSuccessSampleData();
        $validatorPlugins = $this->getValidatorPlugins();

        $this->tester->getFacade()->validate($sample, $validatorPlugins);
    }

    /**
     * @group Xervice
     * @group Validator
     * @group Business
     * @group ValidatorFacade
     * @group Validate
     * @group Integration
     */
    public function testValidationFailMissingField()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Data not valid. Property is missing "floatTest"');

        $sample = $this->getSuccessSampleData();
        $validatorPlugins = $this->getValidatorPlugins();
        unset($sample['floatTest']);

        $this->tester->getFacade()->validate($sample, $validatorPlugins);
    }

    /**
     * @group Xervice
     * @group Validator
     * @group Business
     * @group ValidatorFacade
     * @group Validate
     * @group Integration
     */
    public function testValidationFailSecondPlugin()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Data not valid. Property is missing "secondField"');

        $sample = $this->getSuccessSampleData();
        $validatorPlugins = $this->getValidatorPlugins();
        unset($sample['secondField']);

        $this->tester->getFacade()->validate($sample, $validatorPlugins);
    }

    /**
     * @group Xervice
     * @group Validator
     * @group Business
     * @group ValidatorFacade
     * @group Validate
     * @group Integration
     */
    public function testValidationFailWrongType()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Data not valid. Property "isTest" have the type string but boolean expected');

        $sample = $this->getSuccessSampleData();
        $validatorPlugins = $this->getValidatorPlugins();
        $sample['isTest'] = 'wrong';

        $this->tester->getFacade()->validate($sample, $validatorPlugins);
    }

    /**
     * @group Xervice
     * @group Validator
     * @group Business
     * @group ValidatorFacade
     * @group Validate
     * @group Integration
     */
    public function testValidationFailClosure()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Data not valid. "floatTest" is invalid');

        $sample = $this->getSuccessSampleData();
        $validatorPlugins = $this->getValidatorPlugins();
        $sample['floatTest'] = 3.21;

        $this->tester->getFacade()->validate($sample, $validatorPlugins);
    }

    /**
     * @return array
     */
    protected function getSuccessSampleData(): array
    {
        $sample = [
            'unit' => 123,
            'floatTest' => 1.23,
            'isTest' => true,
            'child' => [
                'subchild1' => 'Text 1',
                'subchild2' => new \stdClass()
            ],
            'fields' => [
                [
                    'data' => 'test'
                ],
                [
                    'data' => 'test'
                ],
                [
                    'data' => 'test'
                ],
                [
                    'data' => 'test'
                ],
                [
                    'data' => 'test'
                ]
            ],
            'secondField' => 'foo'
        ];
        return $sample;
    }

    /**
     * @return array
     */
    protected function getValidatorPlugins(): array
    {
        $validatorPlugins = [
            new TestValidatorConfig(),
            new AddTestValidatorConfig()
        ];
        return $validatorPlugins;
    }
}