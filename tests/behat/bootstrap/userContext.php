<?php

use Behat\Behat\Context\Context;
use GuzzleHttp\Client;
use Dotenv\Dotenv;

/**
 * Class userContext
 */
class userContext implements Context
{
    /**
     * @var Client
     */
    private GuzzleHttp\Client $Client;

    /**
     * @var string
     */
    private string $uri;

    /**
     * @var Dotenv
     */
    private Dotenv $DotEnv;

    /**
     * userContext constructor.
     */
    public function __construct()
    {
        $this->Client = new GuzzleHttp\Client();
        $this->DotEnv = Dotenv::createImmutable(__DIR__ . '/../../../');
        $this->DotEnv->load();
        $this->uri = getenv('WEBSERVER_HOST_NAME');
    }

    /**
     * @Given I sign up as an user
     * @throws Exception
     */
    public function testUserSignUp(): void
    {
        $res = $this->Client->request(
            'POST',
            $this->uri.'/api/user/signup',
            [
                'form_params' => [
                    'name' => 'behatuser',
                    'password' => 'behatuserpw',
                    'email' => 'behatuser@test.com'
                ]
            ]
        );

        if ($res->getStatusCode() == 400) {
            throw new Exception('sign up failed');
        }

        $data = json_decode($res->getBody()->getContents(), true);
        if (!isset($data['success']) || !$data['success'] == 'successfully signed up') {
            throw new Exception(
                'Expected Message: {"success" => "successfully signed up",
                         Actual Message: "'.print_r($res->getBody()->getContents(), true).'"'
            );
        }
    }

    /**
     * @Given I sign in as an user
     * @throws Exception
     */
    public function testUserSignIn()
    {
        $res = $this->Client->request(
            'POST',
            $this->uri.'/api/user/signin',
            [
                'form_params' => [
                    'name' => 'behatuser',
                    'password' => 'behatuserpw'
                ]
            ]
        );

        if ($res->getStatusCode() == 400) {
            throw new Exception('sign in failed');
        }

        $data = json_decode($res->getBody()->getContents(), true);
        if (!isset($data['success']) || !$data['success'] == 'successfully signed in') {
            throw new Exception(
                'Expected Message: {"success" => "successfully signed in",
                         Actual Message: "'.print_r($res->getBody()->getContents(), true).'"'
            );
        }
        if(!isset($data['access_token'])) {
            throw new Exception(
                'Expected: access_token, Actual: "'.print_r($res->getBody()->getContents(), true).'"'
            );
        }
    }
}
