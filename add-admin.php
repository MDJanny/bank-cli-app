<?php
require_once "vendor/autoload.php";

use Classes\Admin;
use Classes\UserDataHandler;

// Initialize the database
UserDataHandler::init();

echo "* Add an Admin *\n\n";
$email = trim(readline("Email: "));

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Error! Invalid email.\n";
    exit;
}

$password = readline("Password: ");

$admin = new Admin($email, $password);
$admin->add();
