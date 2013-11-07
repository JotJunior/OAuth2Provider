<?php
namespace ApiOAuthProviderTests;

use ApiOAuthProvider\Service\Factory\ControllerFactory;

/**
 * ControllerFactory test case.
 */
class ControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
	 * @var ControllerFactory
	 */
    private $ControllerFactory;
    /**
	 * Prepares the environment before running a test.
	 */
    protected function setUp()
    {
        parent::setUp();
        // TODO Auto-generated ControllerFactoryTest::setUp()
        $this->ControllerFactory = new ControllerFactory(/* parameters */);
    }
    /**
	 * Cleans up the environment after running a test.
	 */
    protected function tearDown()
    {
        // TODO Auto-generated ControllerFactoryTest::tearDown()
        $this->ControllerFactory = null;
        parent::tearDown();
    }
    /**
	 * Constructs the test case.
	 */
    public function __construct()
    {
        // TODO Auto-generated constructor
    }

    /**
	 * Tests ControllerFactory->createService()
	 */
    public function testCreateServiceWithValidController()
    {
        $controllerStub = $this->getMock('stdClass', array('getController'));
        $controllerStub->expects($this->once())
            ->method('getController')
            ->will($this->returnValue('ApiOAuthProvider\Controller\UserCredentialsController'));

        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $mainSm->setService('ApiOAuthProvider\Options\Configuration', $controllerStub);

        $pluginSM = $this->getMockBuilder('Zend\ServiceManager\ServiceManager')
            ->setMethods(array('getServiceLocator'))
            ->getMock();
        $pluginSM->expects($this->once())
            ->method('getServiceLocator')
            ->will($this->returnValue($mainSm));

        $r = $this->ControllerFactory->createService($pluginSM);
        $this->assertNotNull($r);
    }

    /**
	 * Tests ControllerFactory->createService()
	 * @expectedException ApiOAuthProvider\Exception\InvalidConfigException
	 */
    public function testCreateServiceReturnsException()
    {
        $controllerStub = $this->getMock('stdClass', array('getController'));
        $controllerStub->expects($this->once())
            ->method('getController')
            ->will($this->returnValue('I\do\not\exist'));

        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $mainSm->setService('ApiOAuthProvider\Options\Configuration', $controllerStub);

        $pluginSM = $this->getMockBuilder('Zend\ServiceManager\ServiceManager')
            ->setMethods(array('getServiceLocator'))
            ->getMock();
        $pluginSM->expects($this->once())
            ->method('getServiceLocator')
            ->will($this->returnValue($mainSm));

        $r = $this->ControllerFactory->createService($pluginSM);
        $this->assertNotNull($r);
    }
}

