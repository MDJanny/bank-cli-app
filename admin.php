<?php
require_once "vendor/autoload.php";

use Classes\Admin;
use Classes\UserDataHandler;

// Initialize the database
UserDataHandler::init();

echo "* Admin Login *\n\n";

$email = readline("Email: ");
$password = readline("Password: ");

$admin = new Admin($email, $password);

if ($admin->login()) {
    // Clear the screen
    echo "\033[2J\033[;H";

    echo "Welcome, Admin ($email)!\n";

    while (true) {
        echo "\nSelect an option:\n";
        echo "1. View All Customers\n";
        echo "2. View All Transactions\n";
        echo "3. View Transactions of a Customer\n";
        echo "4. Logout\n";

        $option = readline("Option: ");

        switch ($option) {
            case '1':
                $admin->showCustomers();
                break;

            case '2':
                $admin->showTransactions();
                break;

            case '3':
                $email = readline("Email: ");
                $admin->showTransactions($email);
                break;

            case '4':
                echo "Goodbye!\n";
                exit;

            default:
                echo "Error! Invalid option.\n";
                break;
        }
    }
} else {
    echo "Error! Invalid credentials.\n";
}
