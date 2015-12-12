# globalsign-php
![Travis Build Status](https://travis-ci.org/certly/globalsign-php.svg) [![StyleCI](https://styleci.io/repos/43564129/shield)](https://styleci.io/repos/43564129) [![Code Climate](https://codeclimate.com/github/certly/globalsign-php/badges/gpa.svg)](https://codeclimate.com/github/certly/globalsign-php)

A GlobalSign API wrapper for PHP.

## Getting Started
```php
require "vendor/autoload.php";

$api = new Certly\GlobalSign\GlobalSign("PAR123456", "VerySecurePassw0rd!", true);
echo var_dump($api->GetDVApproverList([
    "FQDN" => "ian.sh"
], true));
```
