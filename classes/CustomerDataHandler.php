<?php

namespace Classes;

class CustomerDataHandler extends UserDataHandler
{
    public static function getCustomer(string $email)
    {
        $customers = file_get_contents(self::CUSTOMERS_FILE);
        $customers = json_decode($customers, true);

        foreach ($customers as $customer) {
            if ($customer["email"] == $email) {
                return $customer;
            }
        }

        return null;
    }

    public static function addCustomer(string $name, string $email, string $password)
    {
        $customers = file_get_contents(self::CUSTOMERS_FILE);
        $customers = json_decode($customers, true);

        $customer = [
            "name" => $name,
            "email" => $email,
            "password" => $password,
            "balance" => 0
        ];

        $customers[] = $customer;

        file_put_contents(self::CUSTOMERS_FILE, json_encode($customers));
    }

    public static function updateBalance(string $email, float $balance)
    {
        $customers = file_get_contents(self::CUSTOMERS_FILE);
        $customers = json_decode($customers, true);

        foreach ($customers as &$customer) {
            if ($customer["email"] == $email) {
                $customer["balance"] = $balance;
                break;
            }
        }

        file_put_contents(self::CUSTOMERS_FILE, json_encode($customers));
    }

    public static function addTransaction(string $email, float $amount, string $type, string $toOrFromEmail = null)
    {
        $transactions = file_get_contents(self::TRANSACTIONS_FILE);
        $transactions = json_decode($transactions, true);

        $transaction = [
            "email" => $email,
            "amount" => $amount,
            "type" => $type
        ];

        if ($type == "send")
            $transaction["toEmail"] = $toOrFromEmail;
        else if ($type == "receive")
            $transaction["fromEmail"] = $toOrFromEmail;

        $transaction["date"] = date("Y-m-d H:i:s");

        $transactions[] = $transaction;

        file_put_contents(self::TRANSACTIONS_FILE, json_encode($transactions));
    }

    public static function getCustomers()
    {
        $customers = file_get_contents(self::CUSTOMERS_FILE);
        $customers = json_decode($customers, true);

        return $customers;
    }

    public static function getTransactions(string $email = null)
    {
        $transactions = file_get_contents(self::TRANSACTIONS_FILE);
        $transactions = json_decode($transactions, true);

        if ($email != null) {
            $filteredTransactions = [];

            foreach ($transactions as $transaction) {
                if ($transaction["email"] == $email) {
                    $filteredTransactions[] = $transaction;
                }
            }

            return $filteredTransactions;
        }

        return $transactions;
    }
}
