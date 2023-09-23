<?php

namespace Classes;

class Customer extends User
{
    private string $name;
    private float $balance = 0;

    public function __construct(string $email, string $password, string $name = "")
    {
        parent::__construct($email, $password);
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function login()
    {
        if (CustomerDataHandler::isValidCredentials($this->email, $this->password)) {
            $customer = CustomerDataHandler::getCustomer($this->email);
            $this->name = $customer["name"];
            $this->balance = $customer["balance"];

            return true;
        } else {
            return false;
        }
    }

    public function register()
    {
        // Check if the customer is already registered
        if (CustomerDataHandler::getCustomer($this->email) != null) {
            echo "Error! Email already exists.\n";
            return;
        }

        // Add customer to database
        CustomerDataHandler::addCustomer($this->name, $this->email, $this->password);

        echo "Customer registered successfully!\n";
    }

    public function deposit(float $amount)
    {
        // Check if amount is valid
        if ($amount <= 0) {
            echo "Error! Amount must be greater than 0.\n";
            return;
        }

        $this->balance += $amount;
        CustomerDataHandler::updateBalance($this->email, $this->balance);
        CustomerDataHandler::addTransaction($this->email, $amount, "deposit");

        echo "Deposited successfully!\n";
    }

    public function withdraw(float $amount)
    {
        // Check if amount is valid
        if ($amount <= 0) {
            echo "Error! Amount must be greater than 0.\n";
            return;
        }

        // Check if the customer has enough balance
        if ($this->balance < $amount) {
            echo "Error! Not enough balance.\n";
            return;
        }

        $this->balance -= $amount;
        CustomerDataHandler::updateBalance($this->email, $this->balance);
        CustomerDataHandler::addTransaction($this->email, $amount, "withdraw");

        echo "Withdrawn successfully!\n";
    }

    public function transfer(float $amount, string $toEmail)
    {
        // Check if amount is valid
        if ($amount <= 0) {
            echo "Error! Amount must be greater than 0.\n";
            return;
        }

        // Check if the customer has enough balance
        if ($this->balance < $amount) {
            echo "Error! Not enough balance.\n";
            return;
        }

        // Check if the customer is transferring to himself
        if ($this->email == $toEmail) {
            echo "Error! Cannot transfer to yourself.\n";
            return;
        }

        // Check if the recipient customer exists
        if (CustomerDataHandler::getCustomer($toEmail) == null) {
            echo "Error! Recipient customer does not exist.\n";
            return;
        }

        // Send
        $this->balance -= $amount;
        CustomerDataHandler::updateBalance($this->email, $this->balance);
        CustomerDataHandler::addTransaction($this->email, $amount, "send", $toEmail);

        // Receive
        $toCustomer = CustomerDataHandler::getCustomer($toEmail);
        $toCustomerBalance = $toCustomer["balance"];
        $toCustomerBalance += $amount;
        CustomerDataHandler::updateBalance($toEmail, $toCustomerBalance);
        CustomerDataHandler::addTransaction($toEmail, $amount, "receive", $this->email);

        echo "Transferred successfully!\n";
    }
}
