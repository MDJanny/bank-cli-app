<?php

namespace Classes;

class Admin extends User
{
    public function add()
    {
        // Check if the admin is already added
        if (AdminDataHandler::getAdmin($this->email) != null) {
            echo "Error! Admin already exists.\n";
            return;
        }

        AdminDataHandler::addAdmin($this->email, $this->password);

        echo "Admin added successfully!\n";
    }

    public function showCustomers()
    {
        $customers = CustomerDataHandler::getCustomers();

        if (count($customers) == 0) {
            echo "No customers found!\n";
            return;
        }

        echo "\nCustomers:\n------------------\n";
        $listNum = 1;
        foreach ($customers as $customer) {
            $name = $customer["name"];
            $email = $customer["email"];
            $balance = $customer["balance"];

            echo "$listNum. Name: $name, Email: $email, Balance: $balance\n";

            $listNum++;
        }
    }
}
