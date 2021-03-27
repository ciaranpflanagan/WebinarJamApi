# WebinarJam Composer Package

A composer package that makes it easier to communicate with the WebinarJam API.

# Installation
```shell
composer require ciaranpflanagan/webinarjam-api
```
Add the service provider to your `config/app.php` providers array
```php
ciaranpflanagan\WebinarJamApi\WebinarJamServiceProvider::class
```

# Usage
Include the package so it can be used
```php
use ciaranpflanagan\WebinarJamApi\WebinarJam;
```
Create a new instance of the WebinarJam class, passing in your WebinarJam API key. More can be found on obtaining your API key in the [WebinarJam API Documentation](https://documentation.webinarjam.com/connecting-to-our-api/).
```php
$webinar = new WebinarJam('WEBINARJAM_API_KEY');
```

## List All Webinars
To get a full list of webinars. This returns an array with the response from the API.
```php
$webinar->webinars();
```

## Details About An Individual Webinar
To get details about one individual webinar (including it's schedules). This returns an array with the response from the API.
```php
/**
 * @param int $webinar_id
 */
$webinar->webinarDetails($webinar_id);
```

## Register A Person To A Webinar
To register a person to a webinar. This returns an array with the response from the API.    
**Note:** `$webinar_id` and `$schedule` are of type `int`.
```php
/**
 * @param int $webinar_id
 * @param array $details
 */
$details = array(
    "first_name" => "",
    "last_name" => "", // Optional
    "email" => "",
    "schedule" => 0,
    "ip_address" => "", // Optional
    "phone_country_code" => "", // Optional
    "phone" => "", // Optional
);

$webinar->register($webinar_id, $details);
```

## Get A Webinar's Schedule
To get a webinars schedule. This returns an array with the response from the API.  
```php
/**
 * @param int $webinar_id
 */
$webinar->webinarSchedule($webinar_id);

// or
$webinar->webinarDetails($webinar_id);
$webinar->webinarSchedule();
```
**NOTE:** If `->webinarDetails($webinar_id)` is has already been called, `->webinarSchedule()` can be called with no parameters and it will get the schedule using the same webinar ID used in `->webinarDetails($webinar_id)`.