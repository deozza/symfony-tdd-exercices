<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CalculatorControllerTest extends WebTestCase
{
    public function test_calculate_responseInJson(): void
    {
        $client = static::createClient();
        $client->request('GET', '/calculate');
        $this->assertEquals('application/json', $client->getResponse()->headers->get('Content-Type'));
    }

    /**
     * @dataProvider dataprovider_calculate_methodIsValid
     */
    public function test_calculate_methodIsValid(string $method): void
    {
        $client = static::createClient();
        $client->request($method, '/calculate');
        $this->assertEquals(405, $client->getResponse()->getStatusCode());
    }

    private static function dataprovider_calculate_methodIsValid(): array
    {
        return [
            ['POST'],
            ['PUT'],
            ['DELETE'],
            ['PATCH']
        ];
    }

    public function test_calculate_verifyErrorNoParams()
    {
        $client = static::createClient();
        $client->request('GET', '/calculate');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function test_calculate_additionIsValid()
    {
        $client = static::createClient();
        $client->request('GET', '/calculate?operation=add&leftOperand=10&rightOperand=5');

        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());

        $responseContent = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('result', $responseContent);
        $this->assertEquals(15, $responseContent['result']);
    }

    public function test_calculate_invalidOperation()
    {
        $client = static::createClient();
        $client->request('GET', '/calculate?operation=notexists&leftOperand=10&rightOperand=5');

        $response = $client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());

        $responseContent = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('errors', $responseContent);
        $this->assertEquals(1, count($responseContent['errors']));
        $this->assertEquals('The operation is invalid', $responseContent['errors'][0]);
    }

    public function test_calculate_invalidOperand()
    {
        $client = static::createClient();
        $client->request('GET', '/calculate?operation=add&leftOperand=string&rightOperand=5');

        $response = $client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());
        $responseContent = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('errors', $responseContent);
        $this->assertEquals(1, count($responseContent['errors']));
        $this->assertEquals('The operands must be numeric', $responseContent['errors'][0]);

    }

    public function test_calculate_checkWithMissingParam()
    {
        $client = static::createClient();
        $client->request('GET', '/calculate?operation=add&leftOperand=10');

        $response = $client->getResponse();

        $this->assertEquals(400, $response->getStatusCode());
        $responseContent = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('errors', $responseContent);
        $this->assertEquals(1, count($responseContent['errors']));
        $this->assertEquals('The right operand is missing', $responseContent['errors'][0]);
    }

    /**
     * @dataProvider dataprovider_calculate_checkResultAccordingToOperation
     */
    public function test_calculate_checkResultAccordingToOperation(string $operation, int $leftOperand, int $rightOperand, float $expectedResult)
    {
        $client = static::createClient();
        $client->request('GET', '/calculate?operation='. $operation .'&leftOperand='. $leftOperand .'&rightOperand='.$rightOperand);

        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());

        $responseContent = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('result', $responseContent);
        $this->assertEquals($expectedResult, $responseContent['result']);   
    }

    private static function dataprovider_calculate_checkResultAccordingToOperation(): array
    {
        return [
            ['add', 10, 5, 15],
            ['substract', 10, 5, 5],
            ['multiply', 10, 5, 50],
            ['divide', 10, 5, 2]
        ];
    }


}