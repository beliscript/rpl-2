<?php

if(!session_id() ) session_start();

require_once 'app/init.php';
require 'vendor/autoload.php';
$app = new App;