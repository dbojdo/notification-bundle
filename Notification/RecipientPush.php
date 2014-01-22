<?php
namespace Webit\Bundle\NotificationBundle\Notification;

class RecipientPush extends Recipient implements RecipientPushInterface
{

    /**
     *
     * @var string
     */
    protected $method = self::METHOD_GET;

    /**
     *
     * @var string
     */
    protected $url;

    /**
     *
     * @var array
     */
    protected $queryParams = array();

    /**
     *
     * @var array
     */
    protected $params = array();

    /**
     * @return null
     */
    public function getName()
    {
        return null;
    }

    /**
     * @return null
     */
    public function getEmail()
    {
        return null;
    }

    /**
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     *
     * @param string $method            
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     *
     * @param string $url            
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     *
     * @return array
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     *
     * @param array $queryParams            
     */
    public function setQueryParams(array $queryParams)
    {
        $this->queryParams = $queryParams;
    }

    /**
     *
     * @param string $queryParam            
     */
    public function getQueryParam($queryParam)
    {
        return isset($this->queryParams[$queryParam]) ? $this->queryParams[$queryParam] : null;
    }

    /**
     *
     * @param string $queryParam            
     * @param string $value            
     */
    public function setQueryParam($queryParam, $value)
    {
        $this->queryParams[$queryParam] = $value;
    }

    /**
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     *
     * @param array $params            
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     *
     * @param string $param            
     */
    public function getParam($param)
    {
        return isset($this->params[$param]) ? $this->params[$param] : null;
    }

    /**
     *
     * @param string $param            
     * @param string $value            
     */
    public function setParam($param, $value)
    {
        $this->params[$param] = $value;
    }
}