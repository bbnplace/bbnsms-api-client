<?php

namespace Bbnsms;

use Requests;

class APIManager
{
    private static $obj;
    public $endpointData;
    private static $endpointsRegister = "endpoints.json";


    /**
     * Undocumented function
     */
    private function __construct()
    {
        // Load Configuration
        $this->loadAPIConfig();

        // Check when last the registry was updated. 
        // If registry file has not been updated in the last 24 hours update the file
        if (!file_exists(__DIR__."/../".self::$endpointsRegister)) {
            self::updateEndpointsRegistry($this->endpointData);
        } else {
            // Auto Update Register
            $this->runAutoUpdate();
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function getInstance(): APIManager
    {
        if (!isset(self::$obj)) {
            self::$obj = new APIManager();
        } 
        return self::$obj;
    }


    /**
     * Undocumented function
     *
     * @return void
     */
    private function runAutoUpdate()
    {
        $localData = json_decode($this->endpointData);

            // Disable last update check if last check tiem is not registered
            if (empty($localData->lastUpdateCheck) || !is_numeric($localData->lastUpdateCheck)) {
                $localData->lastUpdateCheck = time() - (10 + $localData->updateInterval);
            }

            if ((time() - filemtime(__DIR__."/../".self::$endpointsRegister) > $localData->updateInterval) && (time() - $localData->lastUpdateCheck > $localData->updateInterval)) {
                $remoteDataString = $this->getEndpointsFromRegistry();
                $remoteData = json_decode($remoteDataString);
                if ($localData->version == $remoteData->version) {
                    $localData->lastUpdateCheck = time();
                    self::updateEndpointsRegistry($this->endpointData);
                } else {
                    self::updateEndpointsRegistry($remoteDataString);
                    $this->updateEndpointData($remoteDataString);
                }
            }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    private function loadAPIConfig()
    {
        // Load endpoints from the remote register if the local version is not found.
            $this->endpointData = file_exists(__DIR__."/../".self::$endpointsRegister) ? file_get_contents(__DIR__."/../".self::$endpointsRegister) : $this->getEndpointsFromRegistry();
    }


    /**
     * Undocumented function
     *
     * @return string
     */
    private function getEndpointsFromRegistry(): string
    {
        $endpointData = !is_null($this->endpointData) ? json_decode($this->endpointData) : json_decode("");
        $serviceConfig = Requests::get(isset($endpointData->serviceAPIs) ? $endpointData->serviceAPIs : "https://sms.bbnplace.com/bulksms/endpoints.json");
        return $serviceConfig->body;
    }


    /**
     * Undocumented function
     *
     * @param [type] $newData
     * @return void
     */
    private static function updateEndpointsRegistry($newData)
    {
        file_put_contents(__DIR__."/../".self::$endpointsRegister, $newData);
    }

    /**
     * Undocumented function
     *
     * @param [type] $data
     * @return void
     */
    public function updateEndpointData($data)
    {
        $this->endpointData = $data;
    }


    /**
     * Undocumented function
     *
     * @return void
     */
    public function getEndpointData(){
        return $this->endpointData;
    }
}