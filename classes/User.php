<?php

namespace Classes;

class User
{
    protected string $email;
    protected string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function login()
    {
        $tmp = explode('\\', get_called_class());
        $calledClass = end($tmp);

        if ($calledClass == 'Admin') {
            if (AdminDataHandler::isValidCredentials($this->email, $this->password)) {
                return true;
            }
        } else if ($calledClass == 'Customer') {
            if (CustomerDataHandler::isValidCredentials($this->email, $this->password)) {
                return true;
            }
        }

        return false;
    }

    public function showTransactions(string $email = null)
    {
        $tmp = explode('\\', get_called_class());
        $calledClass = end($tmp);

        if ($calledClass == 'Customer') {
            $email = $this->email;
        }

        $transactions = CustomerDataHandler::getTransactions($email);

        if (count($transactions) == 0) {
            echo "No transactions found!\n";
            return;
        }

        echo "\nTransactions";
        if ($email != null) {
            echo " of $email:";
        } else {
            echo " of all customers:";
        }

        echo "\n------------------\n";

        $listNum = 1;
        foreach ($transactions as $transaction) {
            $email = $transaction["email"];
            $amount = $transaction["amount"];
            $type = $transaction["type"];
            $date = $transaction["date"];

            echo "$listNum. Email: $email, Amount: $amount, Type: $type";

            if ($type == "send") {
                $toEmail = $transaction["toEmail"];
                echo ", Sent to: $toEmail";
            } else if ($type == "receive") {
                $fromEmail = $transaction["fromEmail"];
                echo ", Received from: $fromEmail";
            }

            echo ", Date: $date\n";

            $listNum++;
        }
    }
}
