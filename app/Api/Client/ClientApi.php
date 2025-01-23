<?php
namespace App\Api\Client;

abstract class ClientApi
{
    protected $_service;
    protected $_client;
    protected $_request;
    protected $_response;
    protected $_status;
    protected $_user;
    protected $_password;
    protected $_instance;

    public function getService()
    {
        return $this->_service;
    }
    public function getClient()
    {
        return $this->_client;
    }
    public function getResponse()
    {
        return $this->_response;
    }
    public function getRequest()
    {
        return $this->_request;
    }
    public function setService($service = null)
    {
        $this->_service = $service;
    }
    public function setClient($client = null)
    {
        $this->_client = $client;
    }
    public function setRequest($request = null)
    {
        $this->_request = $request;
    }
    public function setResponse($response = null)
    {
        $this->_response = $response;
    }
    public function setStatus($status = 200)
    {
        $this->_status = $status;
    }
    public function getStatus()
    {
        return $this->_status;
    }
    public function getUser()
    {
        return $this->_user;
    }
    public function getPassword()
    {
        return $this->_password;
    }
    public function getInstance()
    {
        return $this->_instance;
    }
    public function setUser($user = "")
    {
        $this->_user = $user;
    }
    public function setPassword($password = "")
    {
        $this->_password = $password;
    }
    public function setInstance($instance = "")
    {
        $this->_instance = $instance;
    }
}
