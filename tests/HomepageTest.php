<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 8/8/18
 * Time: 3:53 PM
 */
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use PHPHtmlParser\Dom;

class HomepageTest extends TestCase
{
    /**
     * @var Client
     */
    private $http;

    /**
     * @var Dom
     */
    private $domParser;

    public function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        $this->http = new Client(
            [
                'base_uri' => env('SITE_URL')
            ]
        );
        $this->domParser = new Dom;
    }

    /**
     * 测试网站首页是否可以正确渲染
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetHomepage(){
        $response = $this->http->request('GET', '/');
        // Make sure website is on
        $this->assertEquals(200, $response->getStatusCode());
        // Check response header type
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals($contentType, \App\core\IHttpTestCase::CONTENT_TYPE_HTML);

        $content = $response->getBody();
        $this->domParser->loadStr($content,[]);
        $elements = $this->domParser->find('#login-form');
        $this->assertGreaterThanOrEqual(1, count($elements));

        // Output result
//        console_log('Homepage is OK!');
    }

    public function testAdminLoginUrlExist(){
        $response = $this->http->post(
            url('/user/login'),
            ['email'=>env('ADMIN_USER'),'password'=>env('ADMIN_PASSWORD')]
        );
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testAdminCheck(){
        $request = new \Klein\Request(
            ['email'=>env('ADMIN_USER'),'password'=>env('ADMIN_PASSWORD')]
        );
        $response = new \Klein\Response();

        $controller = new \App\controller\UsersController($request, $response);

        $controller->verify_user();

        dump(session_get('admin_data_array'));
    }

    public function tearDown() {
        $this->http = null;
        $this->domParser = null;
    }

}