<?php

namespace App\Tests\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function test_postUser_routeExists() {
        $client = static::createClient();
        $client->request(
            'POST',
            '/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'username' => 'test',
                'password'=> 'test'
            ]));
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }
}