<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function test_postUser_routeExists() {
        $client = static::createClient();
        $client->request(
            'POST',
            '/user',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'username' => 'test',
                'email'=> 'test@gmail.com',
                'password'=> 'test'
            ]));
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }

    /**
     * @dataProvider dataprovider_postUser_onlyAcceptsPostMethod
     */
    public function test_postUser_onlyAcceptsPostMethod(string $method) {
        $client = static::createClient();
        $client->request($method, '/user');
        $this->assertEquals(405, $client->getResponse()->getStatusCode());
    }

    private static function dataprovider_postUser_onlyAcceptsPostMethod(): array {
        return [
            ['GET'],
            ['PUT'],
            ['PATCH'],
            ['DELETE'],
            ['OPTIONS'],
            ['HEAD'],
            ['TRACE'],
            ['CONNECT'],
        ];
    }

    public function test_postUser_contentTypeIsJson() {
        $client = static::createClient();
        $client->request('POST', '/user');
        $this->assertEquals('application/json', $client->getResponse()->headers->get('Content-Type'));
    }

    /**
     * @dataProvider dataprovider_postUser_invalidPayloadElementsReturnsBadRequest
     */
    public function test_postUser_invalidPayloadElementsReturnsBadRequest(array $payload) {
        $client = static::createClient();
        $client->request(
            'POST',
            '/user',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($payload));
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    private static function dataprovider_postUser_invalidPayloadElementsReturnsBadRequest(): array {
        return [
            [[]], //tout est manquant
            [['email' => 1]], //que l'email
            [['username' => 1]], //que le username
            [['password' => 1]], //que le password
            [['username' => 1, 'email' => 1]], //password manquant
            [['email' => 1, 'password' => 1]], //username manquant
            [['password' => 1, 'username' => 1]], //email manquant
            [['email' => 1, 'invalid' => 1, 'password' => 1, 'username' => 1]], //valeur en trop
        ];
    }

    /**
     * @dataProvider dataprovider_postUser_invalidPayloadContentsReturnsBadRequest
     */
    public function test_postUser_invalidPayloadContentsReturnsBadRequest(array $payload) {
        $client = static::createClient();
        $client->request(
            'POST',
            '/user',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($payload));
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    private static function dataprovider_postUser_invalidPayloadContentsReturnsBadRequest(): array {
        return [
            [['email' => null, 'password' => 'test', 'username' => 'test']], //email vide
            [['email' => 'test@gmail.com', 'password' => null, 'username' => 'test']], //password vide
            [['email' => 'test@gmail.com', 'password' => 'test', 'username' => null]], //username vide
            [['email' => 'test@gmail.com', 'password' => 'tes', 'username' => 'test']], //password pas assez de caractères
            [['email' => 'test@gmail.com', 'password' => 'test', 'username' => 'tes']], //username pas assez de caractères
            [['email' => 'testgmail.com', 'password' => 'test', 'username' => 'test']], //username pas assez de caractères
            [['email' => 'test@gmailcom', 'password' => 'test', 'username' => 'test']], //username pas assez de caractères
            [['email' => 'testgmailcom', 'password' => 'test', 'username' => 'test']], //username pas assez de caractères
            [['email' => 'test@gmail.com', 'password' => 'test', 'username' => 'testestestestestestestestestestestestestestestestestestestestestestestestestestestestestestestestestestestestestestestestestestestestestestestes']], //username pas assez de caractères
            [['email' => 'test@gmail.com', 'password' => 1234, 'username' => 'test']], //email vide

        ];
    }

    public function test_postUser_responseContains5ElementsOnSuccess() {
        $client = static::createClient();
        $client->request(
            'POST',
            '/user',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'test@gmail.com',
                'username'=> 'test',
                'password'=> 'test'
            ]));
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $responseBody = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(5, count($responseBody));
    }

    public function test_postUser_responseHasPropertiesOnSuccess() {
        $client = static::createClient();
        $client->request(
            'POST',
            '/user',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'test@gmail.com',
                'username'=> 'test',
                'password'=> 'test'
            ]));
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $responseBody = json_decode($client->getResponse()->getContent(), true);

        $this->assertTrue(array_key_exists('id', $responseBody));
        $this->assertTrue(array_key_exists('dateCreation', $responseBody));
        $this->assertTrue(array_key_exists('dateUpdate', $responseBody));
        $this->assertTrue(array_key_exists('username', $responseBody));
        $this->assertTrue(array_key_exists('email', $responseBody));
    }

    public function test_postUser_payloadIsValid() {
        $client = static::createClient();
        $client->request(
            'POST',
            '/user',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'test@gmail.com',
                'username'=> 'test',
                'password'=> 'test'
            ]));
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }
}