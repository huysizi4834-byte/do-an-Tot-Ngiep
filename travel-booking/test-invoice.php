<?php
session_start();
$_SESSION['user_id'] = 7;
$_GET['code'] = 'TR0C67ED';
require 'invoice.php';
