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

### Output
```json
{
    "status": "success",
    "webinars": [
        {
            "webinar_id": 1,
            "webinar_hash": "gfdsg765g",
            "name": "First Webinar",
            "description": "First Webinar From API",
            "type": "Series of presentations",
            "schedules": [
                "Every day, 9:00 AM"
            ],
            "timezone": "Europe\/Dublin"
        },
        {
            "webinar_id": 2,
            "webinar_hash": "gfdsg765g",
            "name": "Second Webinar",
            "description": "Second Webinar From API",
            "type": "Series of presentations",
            "schedules": [
                "Every day, 9:00 AM"
            ],
            "timezone": "Europe\/Dublin"
        }
    ]
}
```

## Details About An Individual Webinar
To get details about one individual webinar (including it's schedules). This returns an array with the response from the API.
```php
/**
 * @param int $webinar_id
 */
$webinar->webinarDetails($webinar_id);
```

### Output
```json
{
    "status": "success",
    "webinar": {
        "webinar_id": 1,
        "webinar_hash": "gfdsg765g",
        "name": "First Webinar",
        "description": "First Webinar From API",
        "type": "Series of presentations",
        "schedules": [
            {
                "date": "2021-03-25 09:00",
                "schedule": 99,
                "comment": "Every day, 9:00 AM"
            }
        ],
        "timezone": "Europe\/Dublin",
        "presenters": [
            {
                "name": "Ciaran Flanagan",
                "email": "test@test.com",
                "picture": ""
            }
        ],
        "registration_url": "",
        "registration_type": "free",
        "registration_fee": 0,
        "registration_currency": "",
        "registration_checkout_url": "",
        "registration_post_payment_url": "",
        "direct_live_room_url": "",
        "direct_replay_room_url": ""
    }
}
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

### Output
```json
{
    "status": "success",
    "user": {
        "webinar_id": 1,
        "webinar_hash": "gfdsg765g",
        "user_id": 1234,
        "first_name": "Ciaran",
        "last_name": "Flanagan",
        "phone_country_code": "+353",
        "phone": "123456789",
        "email": "test@test.com",
        "password": null,
        "schedule": "99",
        "date": "2021-03-25 9:00",
        "timezone": "Europe\/Dublin",
        "live_room_url": "",
        "replay_room_url": "",
        "thank_you_url": ""
    }
}
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

### Output
```php
[
    [
        "date" => "2021-03-25 09:00",
        "schedule" => 99,
        "comment" => "Every day, 9:00 AM",
    ],
    [
        "date" => "2021-03-52 09:00",
        "schedule" => 99,
        "comment" => "Every day, 9:00 AM",
    ],
]
```

