<?php
namespace App\Api\Client;

use App\Api\Client\ClientApi;

class ClientRestFulApi extends ClientApi
{
    protected $_token;
    protected $_action;
    protected $_urlEndpoint;
    protected $_type;
    protected $_headerAuthorization;
    protected $_userPassword;
    protected $_path;

    public function doAction()
    {
        $ch = curl_init();
        $curlOptions = [
            CURLOPT_URL => $this->getUrlEndpoint(),
            CURLOPT_MAXREDIRS => 30,
            CURLOPT_CUSTOMREQUEST => $this->getType(),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true
        ];
        if ($this->getHeaderAuthorization() !="" && !is_null($this->getHeaderAuthorization())) {
            $curlOptions[CURLOPT_HTTPHEADER] = [$this->getHeaderAuthorization()];
        }
        if (!is_null($this->getUserPassword()) && $this->getUserPassword()!="") {
            $curlOptions[CURLOPT_USERPWD] = $this->getUserPassword();
        }
        switch ($this->getType()) {
            case "POST":
                $curlOptions[CURLOPT_POST] =  1;
                $curlOptions[CURLOPT_POSTFIELDS] = $this->getRequest();
                break;
            
            default:
                # code...
                break;
        }
        curl_setopt_array($ch, $curlOptions);

        $response = curl_exec($ch);
        if( $response === false) {
            $obj = new \stdClass;
            $obj->curl_error = curl_error($ch);
            $this->setResponse(json_encode($obj));
        } else {
            $this->setResponse($response);
        }
        $this->setStatus(curl_getinfo($ch, CURLINFO_HTTP_CODE));
        curl_close($ch);
    }
    public function generateUserPassword()
    {
        $this->setUserPassword($this->getUser()."@".$this->getInstance().":".$this->getPassword());
    }
    public function getToken()
    {
        return $this->_token;
    }
    public function setToken($token = null)
    {
        $this->_token = $token;
    }
    public function getAction()
    {
        return $this->_action;
    }
    public function setAction($action = "")
    {
        $this->_action = $action;
    }
    public function getType()
    {
        return $this->_type;
    }
    public function setType($type = "GET")
    {
        $this->_type = $type;
    }
    public function getHeaderAuthorization()
    {
        return $this->_headerAuthorization;
    }
    public function setHeaderAuthorization($headerAuthorization = "")
    {
        $this->_headerAuthorization = $headerAuthorization;
    }
    public function getUserPassword()
    {
        return $this->_userPassword;
    }
    public function setUserPassword($userPassword = "")
    {
        $this->_userPassword = $userPassword;
    }
    public function getUrlEndpoint()
    {
        return $this->_urlEndpoint;
    }
    public function setUrlEndpoint($urlEndpoint = "")
    {
        $this->_urlEndpoint = $urlEndpoint;
    }
    public function getPath()
    {
        return $this->_path;
    }
    public function setPath($path = "")
    {
        $this->_path = $path;
    }
}
