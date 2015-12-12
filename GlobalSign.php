<?php

namespace Certly\GlobalSign;

use \SoapClient;

class GlobalSign
{
    /**
     * The SoapClient instances used to make requests.
     *
     * @var array
     */
    protected $soap;

    /**
     * The WSDL URIs for GlobalSign's API.
     *
     * @var array
     */
    protected $wsdl;

    /**
     * The GlobalSign account username.
     *
     * @var string
     */
    protected $username;

    /**
     * The GlobalSign account password.
     *
     * @var string
     */
    protected $password;

    /**
     * The indicator of whether or not to use GlobalSign's production API.
     *
     * @var string
     */
    protected $production;

    /**
     * Create a new GlobalSign API wrapper.
     *
     * @param  string  $username
     * @param  string  $password
     * @param  bool  $production
     * @return void
     */
    public function __construct($username, $password, $production = true)
    {
        $this->username = $username;
        $this->password = $password;
        $this->production = $production;
        $this->wsdl($this->production);
        $this->soap();
    }
    
    /**
     * Catch all calls to the class and treat them as a SOAP request.
     *
     * @param  string  $method
     * @param  array  $arguments
     * @return array
     */
    public function __call($method, $arguments)
    {
        return $this->soapCall($method, $arguments[0]);
    }
    
    /**
     * Set the WSDL URIs.
     *
     * @param  bool  $production
     * @return array
     */
    protected function wsdl($production = true)
    {
        return $this->wsdl = [
            "ServerSSL" => "https://" . (! $production ? "test" : "") . "system.globalsign.com/kb/ws/v1/ServerSSLService?wsdl",
            "GASService" => "https://" . (! $production ? "test" : "") . "system.globalsign.com/kb/ws/v1/GASService?wsdl",
            "AccountService" => "https://" . (! $production ? "test" : "") . "system.globalsign.com/kb/ws/v1/AccountService?wsdl",
            "GasQuery" => "https://system.globalsign.com/qb/ws/GasQuery?wsdl"
        ];
    }
    
    /**
     * Create the SoapClient instances.
     *
     * @return array
     */
    protected function soap()
    {
        return $this->soap = [
            "ServerSSL" => new SoapClient($this->wsdl["ServerSSL"]),
            "GASService" => new SoapClient($this->wsdl["GASService"]),
            "AccountService" => new SoapClient($this->wsdl["AccountService"]),
            "GasQuery" => new SoapClient($this->wsdl["GasQuery"])
        ];
    }
    
    /**
     * Call SoapClient->__soapCall with the parameters we build.
     *
     * @param  string  $method
     * @param  array  $arguments
     * @return array
     */
    protected function soapCall($method, $arguments)
    {
        return $this->soap->__soapCall($method, $this->build($method, $arguments));
    }
    
    /**
     * Add the function's arguments to the SOAP call.
     *
     * @param  string  $method
     * @param  array  $arguments
     * @param  bool  $query
     * @return array
     */
    protected function build($method, $arguments, $query = false)
    {
        return [
            "Request" => [
                $method => [
                    ($query ? "QueryRequestHeader" : "OrderRequestHeader") => [
                        "AuthToken" => [
                            "UserName" => $this->username,
                            "Password" => $this->password
                        ]
                    ],
                    $arguments
                ]
            ]
        ];
    }
}
