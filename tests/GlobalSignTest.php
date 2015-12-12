<?php

class GlobalSignTest extends PHPUnit_Framework_TestCase
{
    public function testSuccessfulConstruction()
    {
        new \Certly\GlobalSign\GlobalSign('PAR123', '456');
    }
}
