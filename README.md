# Project 7 - BileMo

OpenClassrooms project as part of the PHP / Symfony application developer courses.

[![Maintainability](https://api.codeclimate.com/v1/badges/a87a84353a720a496c96/maintainability)](https://codeclimate.com/github/Shiiyo/7-BileMo/maintainability)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/4a70928a83ff40a4a7aea6231c5dc760)](https://www.codacy.com/manual/Shiiyo/7-BileMo?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Shiiyo/7-BileMo&amp;utm_campaign=Badge_Grade)

## Prerequisite
-   Php 7.4.2
-   MySQL
-   MAMP, WAMP or XAMPP depend of your OS
-   Composer

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
