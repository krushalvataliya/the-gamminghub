<?php
require_once 'Model/Core/Adapter.php';
require_once 'Model/Core/Request.php';
require_once 'Model/Core/Url.php';
require_once 'Model/Core/Api.php';
require_once 'Model/Core/Message.php';
require_once 'Model/Core/Response.php';
require_once 'Model/Core/Api.php';

class Controller_Core_Action
{
	public $request = null;
	public $adapter = null;
	public $modelUrl = null;
	public $session = null;
	public $message = null;
	protected $_response = null;
	protected $_api = null;

	public function getRequest()
	{
		if($this->request)
		{
			return $this->request;
		}
		$request = new Model_Core_Request();
		$this->setRequest($request);
		return $request;
	}

    protected function setRequest(Model_Core_Request $request)
	{
		$this->request = $request;
		return $this;
	}

	public function getAdapter()
	{
		if($this->adapter)
		{
			return $this->adapter;
		}
		$adapter = new Model_Core_Adapter();
		$this->setAdapter($adapter);
		return $adapter;
	}
	
    protected function setAdapter(Model_Core_Adapter  $adapter)
	{
		$this->adapter = $adapter;
		return $this;
	}

	public function errorAction($action)
	{
		throw new Exception("method:{$action} does not exists.", 1);
		
	}

	public function redirect($a=null,$c=null, array $perameters=null,$reset = false,$url=null)
	{
		if($url == null){
			$url = $this->getModelUrl()->getUrl($a,$c,$parameters,$reset);
		}
		header("location: {$url}");
		exit();
	}

	public function getTemplete($templetePath)
	{
		require_once "View".DS.$templetePath;
	}

    public function getModelUrl()
    {
        if($this->modelUrl)
		{
			return $this->modelUrl;
		}
		$url = new Model_Core_url();
		$this->setModelUrl($url);
		return $url;
    }

    public function getUrl($a=null,$c=null, array $perameters=null,$reset = false)
    {
    	return $this->getModelUrl()->getUrl($a, $c, $perameters, $reset);
    }

    protected function setModelUrl(Model_Core_Url $url)
    {
        $this->modelUrl = $url;

        return $this;
    }

    public function getSession()
    {
    	 if($this->session)
		{
			return $this->session;
		}
		$session = new Model_Core_Session();
		$this->setSession($session);
		return $this->session;
    }

    protected function setSession($session)
    {
        $this->session = $session;

        return $this;
    }

    public function getMessage()
    {
        if($this->modelUrl)
		{
			return $this->modelUrl;
		}
		$message = new Model_Core_Message();
		$this->setMessage($message);
		return $message;
    }

    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    public function getResponse()
    {
        if($this->_response)
		{
			return $this->_response;
		}
		$response = new Model_Core_Response();
		$this->setMessage($response);
		return $response;
    }

    public function setResponse($_response)
    {
        $this->_response = $_response;

        return $this;
    }

    public function getApi()
    {
    	 if($this->_api)
		{
			return $this->_api;
		}
		$_api = new Model_Core_Api();
		$this->setApi($_api);
		return $this->_api;
    }

    protected function setApi($_api)
    {
        $this->_api = $_api;

        return $this;
    }
}
?>