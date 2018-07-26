<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultControllerTest
 * @package App\Tests\Controller
 */
class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/');

        $responseArray = \json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('success', $responseArray);
        $this->assertArrayHasKey('message', $responseArray);
        $this->assertEquals(false, $responseArray['success']);
    }
}