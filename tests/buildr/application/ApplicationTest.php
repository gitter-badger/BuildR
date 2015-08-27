<?php namespace buildr\tests\application;

use buildr\Application\Application;
use buildr\Http\Request\Request;
use buildr\Loader\PSR4ClassLoader;
use buildr\Router\Router;
use buildr\Startup\BuildrStartup;
use buildr\Utils\StringUtils;
use buildr\tests\Buildr_TestCase as BuildRTestCase;

/**
 * Application tests
 *
 * BuildR PHP Framework
 *
 * @author Zoltán Borsos <zolli07@gmail.com>
 * @package buildr
 * @subpackage Tests\ApplicationTes
 *
 * @copyright    Copyright 2015, Zoltán Borsos.
 * @license      https://github.com/Zolli/BuildR/blob/master/LICENSE.md
 * @link         https://github.com/Zolli/BuildR
 */
class ApplicationTest extends BuildRTestCase {

    /**
     * @type \buildr\Application\Application
     */
    protected $application;

    public function setUp() {
        $container = Application::getContainer();

        if(!$container->has('request')) {
            //Create a dummy request
            $dummyData = $this->getDummyRequestData();

            $request = new Request();

            $request->createFromGlobals(
                $dummyData['server'],
                $dummyData['cookie'],
                $dummyData['query'],
                $dummyData['post']);

            $container->add('request', $request);
        }

        $this->application = new Application();

        parent::setUp();
    }

    /**
     * @return \buildr\Router\Router
     */
    private function getDummyRouter() {
        return new Router();
    }

    private function getDummyRequestData() {
        return [
            'server' => [
                'HTTP_HOST' => 'http://test.tld',
                'HTTP_HTTPS' => 1,
                'HTTP_COOKIE' => 'dummyCookie',
                'SERVER_PORT' => 80,
                'REQUEST_SCHEME' => 'https',
            ],
            'cookie' => [
                'testCookie' => serialize(new \stdClass()),
            ],
            'query' => [
                'a' => 'b',
            ],
            'post' => [
                'param' => 'value',
                'anotherParam' => 'anotherValue',
            ],
        ];
    }

    private function getDummyAppConfig() {
        return [
            'location'          => '/tests/dummyApplication',
            'namespaceName'     => 'dummyApplication\\'
        ];
    }

    public function testInitializationWorksCorrectly() {
        $this->application->initialize($this->getDummyAppConfig());

        $loader = BuildrStartup::getAutoloader()->getLoaderByName(PSR4ClassLoader::NAME)[0];
        $registeredNamespaces = $this->getPrivatePropertyFromClass(PSR4ClassLoader::class,
            'registeredNamespaces',
            $loader);

        $lastLoader = end($registeredNamespaces);

        //Test that the loader is properly registered
        $this->assertTrue(StringUtils::contains($lastLoader[0], 'dummyApplication\\'));
        $this->assertTrue(StringUtils::contains($lastLoader[1], 'dummyApplication'));

        //Test that the global app namespace is registered
        $this->assertEquals('dummyApplication\\', APP_NS);
    }

    public function basePathDetectionProvider() {
        return [
            ['/index.php', ''],
            ['/hello/index.php', '/hello'],
            ['/hello/world/root_path/index.php', '/hello/world/root_path'],
        ];
    }

    /**
     * @dataProvider basePathDetectionProvider
     */
    public function testBasePathDetection($basePath, $expected = '') {
        $expected = (string) $expected;

        $result = $this->invokePrivateMethod(Application::class, 'getBasePath', [$basePath]);

        $this->assertEquals($expected, $result);
    }

    public function noErrorHandlerRouterProvider() {
        $routerNonSet = $this->getDummyRouter();

        $routerSetNonexist = $this->getDummyRouter();
        $routerSetNonexist->setFailedHandlerName('nonExistRoute');

        return [
            [$routerNonSet],
            [$routerSetNonexist],
        ];
    }

    /**
     * @dataProvider noErrorHandlerRouterProvider
     */
    public function testFailedRouteReturning($router) {
        $givenRoute = $this->invokePrivateMethod(Application::class, 'getFailedHandler', [$router]);

        $this->assertEquals(Application::FAIL_HANDLER_NAME, $givenRoute->name);
        $this->assertEquals('/' . Application::FAIL_HANDLER_NAME, $givenRoute->path);
        $this->assertTrue(($givenRoute->handler instanceof \Closure));
    }

    public function testFailedRouteReturningWhenFailHandlerIsSet() {
        $router = $this->getDummyRouter();
        $router->getMap()->get('errorHandler', '/errorHandler', function() {});
        $router->setFailedHandlerName('errorHandler');

        $givenRoute = $this->invokePrivateMethod(Application::class, 'getFailedHandler', [$router]);

        $this->assertEquals('errorHandler', $givenRoute->name);
        $this->assertEquals('/errorHandler', $givenRoute->path);
    }

    public function routeHandlerTestDataProvider() {
        $router = $this->getDummyRouter();

        $router->getMap()->get('testClosure', '/testClosure', function() {});
        $router->getMap()->get('tesClassName', '/testClassName', '::');

        return [
            []
        ];
    }

    /**
     * @dataProvider routeHandlerTestDataProvider
     */
    public function testRouteHandlerCalling() {

    }

}
