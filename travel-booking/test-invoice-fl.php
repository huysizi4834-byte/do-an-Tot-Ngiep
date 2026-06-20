<?php
session_start();
$_SESSION['user_id'] = 7;
$_GET['code'] = 'FLC64C58';
require 'invoice.php';
