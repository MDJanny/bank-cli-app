# Bank CLI App

This is a simple CLI app for a bank. It has two types of users: Admin and Customer.
Admin can view all customers, all transactions and transactions of a specific customer.
Customer can deposit money to his/her account, withdraw money from his/her account, transfer money to another customer, view his/her transactions and view his/her account balance.

## Requirements

- PHP >= 7.4
- Composer

## Project Setup

### Clone the repository

```bash
git clone https://github.com/MDJanny/bank-cli-app.git
```

### Generate autoload file

Go to the project directory and run the following command:

```bash
composer dump-autoload
```

## Run the App

```bash
php bank.php
```

## Admin Panel

```bash
php admin.php
```

## Add New Admin

```bash
php add-admin.php
```
