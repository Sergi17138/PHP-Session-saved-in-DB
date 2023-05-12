<?php
require_once 'Session.php';

$session = new Session();

$_SESSION['username'] = 'alex';
$_SESSION['age'] = '22';

echo 'Session variables are set.';
echo '<br>';
echo 'Username:' . $_SESSION['username'];
echo '<br>';
echo 'Age:' . $_SESSION['age'];

