<?php

require_once __DIR__ . "/../vendor/autoload.php";

$user = User::getInstance()->logout();
Util::redirect('/');
