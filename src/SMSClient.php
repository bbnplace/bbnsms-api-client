<?php
namespace Bbnsms;

use Requests;
use Bbnsms\APIManager;
use Exception;

/**
 * Undocumented class
 */
class SMSClient
{
    private static $credentialSource = ".bbnsms.json";
    private $credentials;
    public $endpointData;

    public function __construct()
    {
        # code...
        // Read login credentials from .bbnsms.json config file into class
        $this->endpointData = json_decode((APIManager::getInstance())->getEndpointData());

        $this->credentials = json_decode($this->getCredentials());

    }

    /**
     * Undocumented function
     *
     * @param string $message
     * @param string $originator
     * @param array $recipients
     * @param integer $flash
     * @return string
     */
    public function send(string $message, string $originator, array $recipients, int $flash=0): string
    {
        $fullEndpoint = sprintf("%s/%s", $this->endpointData->base, $this->endpointData->endpoints->sending->endpoint);
        $params = json_decode(json_encode($this->endpointData->endpoints->sending->params), true);
        $params['username'] = $this->credentials->access->credentials->username;
        $params['password'] = $this->credentials->access->credentials->password;
        $params['sender'] = $originator;
        $params['message'] = $message;
        $params['mobile'] = implode(",", $recipients);
        $params['flash'] = $flash;
        $response = Requests::post($fullEndpoint, [], $params);
        return $response->body;
    }

    /**
     * Undocumented function
     *
     * @param integer $broadcastTime
     * @param string $scheduleName
     * @param string $message
     * @param string $originator
     * @param array $recipients
     * @param integer $flash
     * @return string
     */
    public function schedule(int $broadcastTime, string $scheduleName, string $message, string $originator, array $recipients, int $flash=0): string
    {
        $fullEndpoint = sprintf("%s/%s", $this->endpointData->base, $this->endpointData->endpoints->schedule->endpoint);
        $params = json_decode(json_encode($this->endpointData->endpoints->schedule->params), true);
        $params['username'] = $this->credentials->access->credentials->username;
        $params['password'] = $this->credentials->access->credentials->password;
        $params['sender'] = $originator;
        $params['message'] = $message;
        $params['mobile'] = implode(",", $recipients);
        $params['flash'] = $flash;
        $params['schedule'] = $originator;
        $params['broadcast_time'] = $broadcastTime;
        $params['schedule_name'] = $scheduleName;
        $params['schedule_notification'] = 1;
        $response = Requests::post($fullEndpoint, [], $params);
        return $response->body;
    }

    /**
     * Undocumented function
     *
     * @return float
     */
    public function getBalance(): float
    {
        $response = Requests::get(sprintf("%s/%s?".$this->endpointData->endpoints->balance->params, 
            $this->endpointData->base, 
            $this->endpointData->endpoints->balance->endpoint, 
            $this->credentials->access->credentials->username,
            $this->credentials->access->credentials->password
        ));
        return $response->body;
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    public function testCredentials():string
    {
        $response = Requests::get(sprintf("%s/%s?".$this->endpointData->endpoints->testCredential->params, 
            $this->endpointData->base, 
            $this->endpointData->endpoints->testCredential->endpoint, 
            $this->credentials->access->credentials->username,
            $this->credentials->access->credentials->password
        ));
        return $response->body;
    }

    private function getCredentials()
    {
        if (!file_exists(__DIR__."/../".self::$credentialSource)) {
            throw new Exception("Credential File not found. Please create file .bbnsms.json at your application root folder. Kindly refer to readme file for guide.", "BSE10055");
        } else {
            return file_get_contents(__DIR__."/../".self::$credentialSource);
        }
    }
}