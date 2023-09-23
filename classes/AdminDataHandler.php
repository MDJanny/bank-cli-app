<?php

namespace Classes;

class AdminDataHandler extends UserDataHandler
{
    public static function addAdmin(string $email, string $password)
    {
        $admins = file_get_contents(self::ADMINS_FILE);
        $admins = json_decode($admins, true);

        $customer = [
            "email" => $email,
            "password" => $password
        ];

        $admins[] = $customer;

        file_put_contents(self::ADMINS_FILE, json_encode($admins));
    }

    public static function getAdmin(string $email)
    {
        $admins = file_get_contents(self::ADMINS_FILE);
        $admins = json_decode($admins, true);

        foreach ($admins as $admin) {
            if ($admin["email"] == $email) {
                return $admin;
            }
        }

        return null;
    }
}
