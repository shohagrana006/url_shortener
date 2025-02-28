# Task Management System

## Overview

This is a Mini URL Shortener with Analytics project. The system uses Laravel Framework, mysql db, `SB Admin 2` template & bootstrap 5. 



# Project Setup Instructions


### System require
- PHP version 8.2 or above

### Clone the Repository

- Open your terminal and run
    - `git clone https://github.com/shohagrana006/url_shortener.git`
    - `cd url_shortener`
    - `composer install && npm install`
    - `cp .env.example .env`

### DB setup:
    - go to mysql(ui phpmyadmin) and create database name 'url_shortener'

    - Now go to your .env file and change with your db credential
        - DB_DATABASE=your_db_name
        - DB_USERNAME=your_db_username
        - DB_PASSWORD=your_db_password

- Now run this command your terminal
    - run `php artisan key:generate`
    - run `php artisan migrate`


### Run the Application

- Start the Laravel development server by running the following command:
    - `php artisan serve`
- Open your browser and visit:
    - `http://127.0.0.1:8000`
