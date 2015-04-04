<?php

include_once "../includes/user.inc";
include_once "../includes/misc.inc";

user_destroy_session();
redirect('/');
