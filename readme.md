<p align="center"><img src="https://www.ingic.com/assets-web/images/logo.png"></p>

## InfyOm Generator Builder with ACL

Create Laravel Applications with Admin Panel and ACL in minutes with InfyOm and our Generator Builder. 

## Whats used?

- **PHP 7.1** 
- **Laravel 5.6**
- InfyOm Laravel Generator
- AdminLTE Theme
- Swagger Generator from InfyOm
- DataTables
- Entrust (ACL)
- Repository Pattern

## Installation
- git clone "http://gitlab.axact.com/app-backends/infyom-boilerplate.git"
- Update Composer "composer update"
- Edit .env file according to your DB credentials.
- Rum Migration and Seeder "php artisan migrate:refresh --seed"

## How To?
**Step 1**
- Make Schema Architecture in Mysql.
- Select Module Right there in side menu
- Select Table.
- Enter Module Name
- Next

**Step 2**
- Enter fields for listing tables.
- Width -> Col Width in %.
 
**Step 3**
- Enter fields for forms. {Add / Edit}
- Type -> HTML input type.
- Validation -> laravel validations.
- Width -> Bootstrap Columns.


**Check Generated Files:**
- Check Controller, Model, View, Request, Repositories

## Admin Credentials are here:
- Super admin (development admin)

    - 'email'    => "superadmin@ingic.com"
    - 'password' => 'superadmin123'
- Admin
    - 'email'    => "admin@ingic.com"
    - 'password' => 'admin123'
     
## update vendor file for swagger
- update root -> vendor/jlapp/swaggervel/src/Jlapp/Swaggervel/routes.php line# 51,52 comment both lines

## Want to use Searchable Dropdown?
- Add class "select2" to your dropdown.

## Ask SW confirmation before delete?
- Call function "confirmDelete()" on Onclick event.

## Want toggle switch instead of checkbox?
- Add attribute " 'data-toggle'=>'toggle' " on html checkbox.

## Want to add add fields from another related table in datatables?
- please see DataTables/Admin/UserDataTable.php

## Want to add Translatable module?
- please see Page Module For Reference.

**_Build Something Amazing_**
