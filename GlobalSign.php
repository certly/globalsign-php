<?php

namespace Certly\GlobalSign;

use SoapClient;

class GlobalSign
{
    /**
     * The SoapClient instance used to make requests.
     *
     * @var SoapClient
     */
    protected $soap;

    /**
     * The WSDL files for GlobalSign's API.
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
        return $this->soapCall($method, $arguments[1]);
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
