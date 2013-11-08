<?php
namespace OAuth2ProviderTests;

use OAuth2Provider\Service\Factory\ConfigurationFactory;

/**
 * ConfigurationFactory test case.
 */
class ConfigurationFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
	 * @var ConfigurationFactory
	 */
    private $ConfigurationFactory;
    /**
	 * Prepares the environment before running a test.
	 */
    protected function setUp()
    {
        parent::setUp();
        // TODO Auto-generated ConfigurationFactoryTestx::setUp()
        $this->ConfigurationFactory = new ConfigurationFactory(/* parameters */);
    }
    /**
	 * Cleans up the environment after running a test.
	 */
    protected function tearDown()
    {
        // TODO Auto-generated ConfigurationFactoryTestx::tearDown()
        $this->ConfigurationFactory = null;
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
	 * Tests ConfigurationFactory->createService()
	 */
    public function testCreateService()
    {
        $config = array(
            'api_oauth_provider' => array(
                'server' => 'OauthServer',
                'controller' => 'OauthController',
                'main_server' => 'client',
            ),
        );

        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $mainSm->setService('Config', $config);

        $configOption = $this->ConfigurationFactory->createService($mainSm);
        $this->assertEquals('OauthServer', $configOption->getServer());
        $this->assertEquals('OauthController', $configOption->getController());
        $this->assertEquals('oauth2provider.server.client', $configOption->getMainServer());
    }

    /**
	 * Tests ConfigurationFactory->createService()
	 */
    public function testCreateServiceWithMainServerEmptyValueShouldUseDefault()
    {
        $config = array(
            'api_oauth_provider' => array(
                'main_server' => '',
            ),
        );

        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $mainSm->setService('Config', $config);

        $configOption = $this->ConfigurationFactory->createService($mainSm);
        $this->assertEquals('oauth2provider.server.default', $configOption->getMainServer());
    }

    /**
	 * Tests ConfigurationFactory->createService()
	 * @expectedException OAuth2Provider\Exception\InvalidConfigException
	 */
    public function testCreateServiceReturnsException()
    {
        $config = array(); //empty array

        $mainSm = Bootstrap::getServiceManager()->setAllowOverride(true);
        $mainSm->setService('Config', $config);

        $configOption = $this->ConfigurationFactory->createService($mainSm);
    }
}

