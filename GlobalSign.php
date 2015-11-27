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
     * @param string $username
     * @param string $password
     * @param bool   $production
     *
     * @return void
     */
    public function __construct($username, $password, $production = true)
    {
        $this->username = $username;
        $this->password = $password;
        $this->production = $production;
    }
}
