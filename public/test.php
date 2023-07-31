<?php

$city = 'San Francisco';
$state = 'CA';
$event = 'SIGGRAPH';

$location_vars = ['city', 'state'];

$result = compact('event', $location_vars);
print_r($result);
