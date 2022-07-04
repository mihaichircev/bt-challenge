# bt-challenge

# Instalation

Create docker containers using `docker-compose`:

```docker-compose up -d```

Create the database using Adminer:
Go to http://localhost:8080, login with
`server: db`
`username: root`
`password: 123qwe`

Create a database called `bt-challenge-dev` with the following query:

```CREATE DATABASE `bt-challenge-dev` COLLATE 'utf8_general_ci';```

Create the `/app/config/autoload/local.php` from `/app/config/autoload/local.php.dist`

Open the bash console in the `php` container using `docker-compose exec php bash` and run the following commands:

`composer install`

`./vendor/bin/doctrine-module migration:migrate`

In order to populate the db with users run the following command:

`./vendor/bin/laminas create-user <username> <password> <email>`

Open the app (http://localhost), go to the login page and supply these credentials

The tokens (OTP) are sent using a queue. In order to start the consumer that will process the emails please run `vendor/bin/laminas queue`. Currently the tokens are sent via email. This might be extended to other ways by creating new senders that implement `SenderInterface` from `User\Authentication\OtpSender`. The `OtpSenderEmail` might send the email using SMTP or by sending the message in a file. The later is the default setting and it can be changed by adapting the `local.php` file with the desired settings. The config for emails is found in `app/module/Common/config/email.config.php`.

Run tests:

`./vendor/bin/phpunit`

Run code style check

`composer cs-check`

Run static analysis

`composer static-analysis`
