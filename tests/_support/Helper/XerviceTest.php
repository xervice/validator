<?php
namespace XerviceTest\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Xervice\Core\Business\Model\Locator\Locator;
use Xervice\Validator\Business\ValidatorFacade;

class XerviceTest extends \Codeception\Module
{
    /**
     * @return \Xervice\Validator\Business\ValidatorFacade
     */
    public function getFacade(): ValidatorFacade
    {
        return Locator::getInstance()->validator()->facade();
    }
}
