<?php

/**
 * Created by PhpStorm.
 * User: jamesskywalker
 * Date: 02/06/2019
 * Time: 20:36
 *
 * this is basically a redirect to easily maintain the routing system and send
 * the call to the correct format (json,xml etc)  - the controller for each one
 * is located in it's correct folder.  This class has no real knowledge of what
 * it is being asked to do
 *
 */
class api {
    private $apiFormat;
    private $apiCallFilepath = "endpoints_private";
    private $apiCall;
    private $apiEndpoint;
    private $apiResponse;
    public $return;


    function __construct()
    {
        $this->setApiFormat();
        $this->setApiCallFilepath();
        $this->setApiCall();
        if($this->initApiClass()) $this->return = $this->apiResponse;
        else $this->return = $this->apiCallUnknown();

    }

    //for the api test page so that we have an object we can read
    public function sendResponse() {
        return json_encode($this->return);
    }

    private function setApiFormat(){
        $this->apiFormat = (isset($_GET["api"]) && in_array($_GET["api"],["json"])) ? $_GET['api'] : "json";//default to json
        require_once "private/api_$this->apiFormat/" . $this->apiFormat . "ApiController.php";
    }

    private function setApiCallFilepath(){
        if(!isset($_GET["npc"]))$this->apiCallFilepath = "endpoints_public";//default to json
    }

    private function setApiCall() {
        $this->apiEndpoint = isset($_GET["endpoint"]) ? $_GET["endpoint"] : "";
        $this->apiCall = isset($_GET["call"]) ? $_GET["call"] . ucfirst($this->apiFormat) : "";
    }

    private function initApiClass(){
        $filepath = "private/api_$this->apiFormat/$this->apiCallFilepath/$this->apiCall.php";
        if(file_exists($filepath)) {
            include_once $filepath;
            $call = new $this->apiCall($this->apiEndpoint);
            $this->apiResponse = $call->callEndpoint();
            return true;
        } else return false;
    }

    private function apiCallUnknown(){
        return (object)['success' => false,'message' => API_MISC_ERROR,'responseData' => []];
    }
}