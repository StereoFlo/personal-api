<?php

namespace Tests\Controller;

use Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AuthControllerTest
 * @package App\Tests\Controller
 */
class AuthControllerTest extends WebTestCase
{
    const USER_EMAIL = 'functest@functest.ru';
    const USER_PASSWORD = 'test';
    const USER_USERNAME = 'func_test';

    const URL_REGISTER = '/auth/register';
    const URL_LOGIN    = '/auth/login';
    const URL_LOGOUT   = '/auth/logout';
    const URL_USER     = '/user';

    private static $token = '';

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function testRegister(): void
    {
        $client = static::createClient();
        $client->xmlHttpRequest(Request::METHOD_POST, self::URL_REGISTER, [
            'email'    => self::USER_EMAIL,
            'password' => self::USER_PASSWORD,
            'username' => self::USER_USERNAME
        ]);

        $this->assertEquals(202, $client->getResponse()->getStatusCode());
        $responseArray = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('success', $responseArray);
    }

    /**
     * @depends testRegister
     */
    public function testLogin(): void
    {
        $client = static::createClient();
        $client->xmlHttpRequest(Request::METHOD_POST, self::URL_LOGIN, [
            'email'    => self::USER_EMAIL,
            'password' => self::USER_PASSWORD,
        ]);

        $this->assertEquals(202, $client->getResponse()->getStatusCode());
        $responseArray = json_decode($client->getResponse()->getContent(), true);
        static::$token = $responseArray['data']['apiToken']['key'];
        $this->assertArrayHasKey('success', $responseArray);
        $this->assertArrayHasKey('data', $responseArray);
        $this->assertArrayHasKey('key', $responseArray['data']['apiToken']);

    }

    /**
     * @depends testLogin
     */
    public function testUser()
    {
        $client = static::createClient();
        $client->xmlHttpRequest(Request::METHOD_GET, self::URL_USER, [], [], [
            'HTTP_x-api-token' => self::$token
        ]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $responseArray = json_decode($client->getResponse()->getContent(), true);
        $this->assertTrue($responseArray['success']);
        $this->assertTrue($responseArray['data']['username'] === self::USER_USERNAME);
        $this->assertTrue($responseArray['data']['email']    === self::USER_EMAIL);
        $this->assertTrue($responseArray['data']['apiToken']['key'] === self::$token);
    }

    /**
     * @depends testUser
     */
    public function testLogout()
    {
        $client = static::createClient();
        $client->xmlHttpRequest(Request::METHOD_POST, self::URL_LOGOUT, [
            'token' => static::$token,
        ]);
        $this->assertEquals(202, $client->getResponse()->getStatusCode());
    }

    /**
     * just setup the test
     */
    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public static function tearDownAfterClass(): void
    {
        $obj = new self();
        $obj->setUp();
        $user = $obj->entityManager->getRepository(User::class)->findOneBy(['email' => self::USER_EMAIL]);
        $obj->entityManager->remove($user);
        $obj->entityManager->flush();
    }
}