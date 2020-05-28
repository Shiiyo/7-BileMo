# Project 7 - BileMo

OpenClassrooms project as part of the PHP / Symfony application developer courses.

## Prerequisite
- Php 7.4.2
- MySQL
- MAMP, WAMP or XAMPP depend of your OS
-  Composer

## Install project
Run the command line: <br/>
<code>git clone https://github.com/Shiiyo/7-BileMo.git</code><br/>
<code>composer install</code><br/>

Config your database on the .env file and run:<br/>
<code>php bin/console doctrine:migrations:migrate</code><br/>
Then run this to generate fake data into the DB:<br/>
<code>php bin/console doctrine:fixtures:load</code><br/>
Lunch the server with:<br/>
<code>symfony server:start -d</code>

## Dependencies