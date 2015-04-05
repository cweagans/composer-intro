<?php

include_once "../classes/user.php";
include_once "../classes/util.php";

$user = User::getInstance()->logout();
Util::redirect('/');
