<?php

require_once 'Session.php';

$session = new Session();


$_SESSION['username'] = 'admin';
$_SESSION['email'] = 'admin@admin.com';


echo 'Session variables are set.';
echo '<br>';
echo 'Username: ' . $_SESSION['username'];
echo '<br>';
echo 'Email: ' . $_SESSION['email'];

