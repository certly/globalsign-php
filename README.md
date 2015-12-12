# globalsign-php
![Travis Build Status](https://travis-ci.org/certly/globalsign-php.svg)

A GlobalSign API wrapper for PHP.

## Getting Started
```php
require "vendor/autoload.php";

$api = new Certly\GlobalSign\GlobalSign("PAR123456", "VerySecurePassw0rd!", true);
echo var_dump($api->GetDVApproverList([
    "FQDN" => "ian.sh"
]));
```
