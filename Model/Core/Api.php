<?php

class Model_Core_Api
{
    protected $_url;
    protected $_headers = array();
    protected $_timeout = 30;

    public function __construct($url = null)
    {
        if ($url) {
            $this->setUrl($url);
        }
    }

    public function setUrl($url)
    {
        $this->_url = $url;
        return $this;
    }

    public function addHeader($name, $value)
    {
        $this->_headers[] = "$name: $value";
        return $this;
    }

    public function setTimeout($seconds)
    {
        $this->_timeout = $seconds;
        return $this;
    }

    public function sendRequest($method = 'GET', $data = array())
    {
        if (!$this->_url) {
            throw new Exception("URL is not set.");
        }

        $ch = curl_init($this->_url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->_timeout);

        if (!empty($this->_headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->_headers);
        }

        if (strtoupper($method) == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        } elseif (strtoupper($method) == 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        } elseif (strtoupper($method) == 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        }

        $response = curl_exec($ch);
        if ($response === false) {
            throw new Exception('cURL Error: ' . curl_error($ch));
        }

        curl_close($ch);

        return json_decode($response, true);
    }

    public function get($url = null)
    {
        if ($url) {
            $this->setUrl($url);
        }
        return $this->sendRequest('GET');
    }

    public function post($url = null, $data = array())
    {
        if ($url) {
            $this->setUrl($url);
        }
        return $this->sendRequest('POST', $data);
    }

    public function put($url = null, $data = array())
    {
        if ($url) {
            $this->setUrl($url);
        }
        return $this->sendRequest('PUT', $data);
    }

    public function delete($url = null)
    {
        if ($url) {
            $this->setUrl($url);
        }
        return $this->sendRequest('DELETE');
    }
}
