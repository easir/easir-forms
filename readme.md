# EASI’R Forms

The goal of this project is to create a lead form builder for the CRM application EASI'R. It will allow users to design and create custom forms that submit leads into EASI'R, a long with a HTML code generator to embed the form on any website.

## Design Goals

* OAuth compatibility
* Drag and drop form creation with input fields, help texts, buttons, images
* Form themes
* Generate a HTML code to include on other sites

Requires PHP 5.6 or higher, PHP 7 recommended.

## Setup

1. Copy `.env.example` to `.env`
2. Create an OAuth application using the EASI'R API. See https://easir.io. Set the EASIR_ env variables in `.env`.
3. Run `php artisan serve` in your terminal

© Simon Fredsted (@fredsted)