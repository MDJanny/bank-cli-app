<?php
require_once "vendor/autoload.php";

use Classes\Customer;
use Classes\UserDataHandler;

// Initialize the database
UserDataHandler::init();

while (true) {
    echo "\nSelect an option:\n";
    echo "1. Login\n";
    echo "2. Register\n";
    echo "3. Exit\n";

    $option = readline("Option: ");

    switch ($option) {
        case '1':
            $email = readline("Email: ");
            $password = readline("Password: ");

            $customer = new Customer($email, $password);

            if ($customer->login()) {
                // Clear the screen
                echo "\033[2J\033[;H";

                echo "Welcome, " . $customer->getName() . "!\n";

                while (true) {
                    echo "\nSelect an option:\n";
                    echo "1. Deposit Money\n";
                    echo "2. Withdraw Money\n";
                    echo "3. Transfer Money\n";
                    echo "4. Check Balance\n";
                    echo "5. View Transactions\n";
                    echo "6. Logout\n";

                    $option = readline("Option: ");

                    switch ($option) {
                        case '1':
                            $amount = intval(readline("Amount: "));
                            $customer->deposit($amount);
                            break;

                        case '2':
                            $amount = intval(readline("Amount: "));
                            $customer->withdraw($amount);
                            break;

                        case '3':
                            $amount = intval(readline("Amount: "));
                            $toEmail = readline("To (Email): ");
                            $customer->transfer($amount, $toEmail);
                            break;

                        case '4':
                            echo "Balance: " . $customer->getBalance() . "\n";
                            break;

                        case '5':
                            $customer->showTransactions();
                            break;

                        case '6':
                            echo "Goodbye, " . $customer->getName() . "!\n";
                            break 2;

                        default:
                            echo "Error! Invalid option.\n";
                            break;
                    }
                }
            } else {
                echo "Error! Wrong email or password.\n";
            }

            break;

        case '2':
            $name = trim(readline("Name: "));
            $email = trim(readline("Email: "));

            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Error! Invalid email.\n";
                break;
            }

            $password = readline("Password: ");

            $customer = new Customer($email, $password, $name);
            $customer->register();
            break;

        case '3':
            exit(0);

        default:
            echo "Error! Invalid option.\n";
            break;
    }
}
