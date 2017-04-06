# Installation

## Upload files

The preferred way of installing is with Git, because this makes it easy to update. This may change when a built-in updater is implemented.

With your CLI, go to the webroot of your hosting account and type:

``` bash
$ git clone https://github.com/madewithpepper/Pulse-Proximity-Platform.git .
```
If you don't want to use Git, you can simply upload all files to the webroot. The webroot can be the root of a domain or subdomain.

## Folder permissions

Make sure these folders are writable:

 - `attachments/`
 - `uploads/`
 - `core/bootstrap/cache/`
 - `core/storage/` and all underlying folders

## Configuration file

Copy `core/.env.example` to `.env` and open the file with a text editor.

> In Windows, you have to enter a space and a dot after `.env` to rename the file. Like this: `.env .` and press enter.

Open the file and modify the configuration, there're explanations for most settings included. After you've updated the file and saved it, open the URL where you've installed the script and the database will be migrated and seeded automatically.

> You have to create the MySQL database yourself.

This is what the default configuration file looks like:

``` bash
# Name and icon for app

APP_NAME="Proximity Platform"
APP_ICON="assets/images/logos/icon.svg"

# Set APP_DEBUG to true if you get the message "Whoops, looks like something went wrong.".
# After installation you can set it to false.

APP_DEBUG=true

# MySQL database

DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

# Supported: "smtp", "mail", "sendmail", "mailgun", "mandrill", "ses", "sparkpost", "log"

MAIL_DRIVER=mail

# Only use MAIL_HOST and MAIL_PORT if you use SMTP
# Common SMTP ports:
#  - SMTP - port 25 or 2525 or 587
#  - Secure SMTP (SSL / TLS) - port 465 or 25 or 587

MAIL_HOST=mail.example.com
MAIL_PORT=587

# Only when you use Mailgun

MAILGUN_DOMAIN=
MAILGUN_SECRET=

# "tls" or "ssl"

MAIL_ENCRYPTION=tls

MAIL_USERNAME=null
MAIL_PASSWORD=null

# Default from address

MAIL_FROM_ADDRESS=support@example.com
MAIL_FROM_NAME="My Application"

# Google Maps Key: https://developers.google.com/maps/documentation/javascript/get-api-key

GMAPS_KEY=""
GMAPS_DEFAULT_LAT=37.528038
GMAPS_DEFAULT_LNG=-122.262775
GMAPS_DEFAULT_ZOOM=12
GMAPS_DEFAULT_RADIUS=2000

# Leave this key, a new one will be generated on install

APP_KEY=base64:GZft2mqFBPuCC9FWTmB6vYo06Ezfnqed4J3tUHdjlPo=
```

## First login

After you've installed the platform, you can login with the following credentials:

**E-mail:** info@example.com

**Password:** welcome