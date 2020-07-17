# Project 7 - BileMo

OpenClassrooms project as part of the PHP / Symfony application developer courses. It's an exercice, not a real API.

[![Maintainability](https://api.codeclimate.com/v1/badges/a87a84353a720a496c96/maintainability)](https://codeclimate.com/github/Shiiyo/7-BileMo/maintainability)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/4a70928a83ff40a4a7aea6231c5dc760)](https://www.codacy.com/manual/Shiiyo/7-BileMo?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Shiiyo/7-BileMo&amp;utm_campaign=Badge_Grade)

# Prerequisite
-   Php 7.4.2
-   MySQL
-   MAMP, WAMP or XAMPP depend of your OS
-   Composer

# Install project
Run the command line: <br/>
<code>git clone https://github.com/Shiiyo/7-BileMo.git</code><br/>
<code>cd 7-BileMo</code><br/>
<code>composer install</code><br/>

## JWT's configuration
### Generate the SSH keys:
<code>mkdir -p config/jwt</code><br/>
<code>openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096</code><br/>
<code>openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout</code>

### Config your database on the .env file and run:
<code>php bin/console doctrine:database:create</code><br/>
<code>php bin/console doctrine:migrations:migrate</code><br/><br/>
Then run this to generate fake data into the DB:<br/>
<code>php bin/console doctrine:fixtures:load</code><br/><br/>
Lunch the server with:<br/>
<code>symfony server:start -d</code>

# Login
If you want to use the API you will need a token. To generate it you will have to send a request to the /login_check route:</br>
<code>curl --request POST \
  --url http://127.0.0.1:8000/api/login_check \
  --header 'content-type: application/json' \
  --data '{"username":"Orange","password":"yourPassword"}'</code></br>
  </br>
  For each request you just have to add on the headers the token like this:
  <code>authorization: Bearer token</code>
# Tests
For lunch test you just have to run this command:</br>
<code>./vendor/bin/simple-phpunit</code>

# UML diagrams
All the UML diagrams are saved in the <code>/public/diagrams </code> folder.