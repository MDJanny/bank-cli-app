<?php

namespace Classes;

class UserDataHandler
{
    protected const DATA_DIR = "data";
    protected const CUSTOMERS_FILE = self::DATA_DIR . "/customers.json";
    protected const ADMINS_FILE = self::DATA_DIR . "/admins.json";
    protected const TRANSACTIONS_FILE = self::DATA_DIR . "/transactions.json";

    public static function init()
    {
        if (!file_exists(self::DATA_DIR)) {
            mkdir(self::DATA_DIR);
        }

        if (!file_exists(self::CUSTOMERS_FILE)) {
            file_put_contents(self::CUSTOMERS_FILE, "[]");
        }

        if (!file_exists(self::ADMINS_FILE)) {
            file_put_contents(self::ADMINS_FILE, "[]");
        }

        if (!file_exists(self::TRANSACTIONS_FILE)) {
            file_put_contents(self::TRANSACTIONS_FILE, "[]");
        }
    }

    public static function isValidCredentials(string $email, string $password)
    {
        $tmp = explode('\\', get_called_class());
        $calledClass = end($tmp);

        if ($calledClass == 'AdminDataHandler') {
            $users = file_get_contents(self::ADMINS_FILE);
        } else if ($calledClass == 'CustomerDataHandler') {
            $users = file_get_contents(self::CUSTOMERS_FILE);
        }

        $users = json_decode($users, true);

        foreach ($users as $user) {
            if ($user["email"] == $email && $user["password"] == $password) {
                return true;
            }
        }

        return false;
    }
}
