# Ubuntu installation

Special thanks to [mangopudding](https://github.com/madewithpepper/Pulse-Proximity-Platform/issues/6).

## Server

### Install Ubuntu Tasksel Utility
`$ sudo apt-get install tasksel`

### Install LAMP Stack via Ubuntu Tasksel
Remember your root password for MySQL
`$ sudo tasksel`

### Verify the version of Apache installed
`$ sudo apache2 -v`

### Verify the version of MySQL installed
`$ sudo mysql --version`

### Verify the version of PHP installed
`$ sudo php -v`

#### Install Additional PHP Libaries Required For This Project
`$ sudo apt-get install php-mcrypt php-curl php-mbstring php-xml php-gd php-intl php-zip php-bcmath php-amqplib`

#### Verify the required PHP libraries are installed
`$ php -m`

## MySQL

### Disable Strict Mode In MySQL 5.7
This is a requirement on MySQL 5.7 at this time. Use the following tech note: [https://serverpilot.io/community/articles/how-to-disable-strict-mode-in-mysql-5-7.html](https://serverpilot.io/community/articles/how-to-disable-strict-mode-in-mysql-5-7.html).

### Create Database for Pulse
Hope you remember the MySQL root password when you installed LAMP Stack via Tasksel.
Steps below to log into mysql commandline, create a database called `pulse`, verify that it exists after creation and exit out of mysql commandline.

`$ mysql -u root -p`

`$ CREATE DATABASE pulse;`

`S SHOW DATABASES;`

`$ exit`

## Files

Create a folder called `pulse` and go into that directory.

`$ sudo mkdir /var/www/html/pulse`

`$ cd /var/www/html/pulse`

Download the Pulse Proximity Platform from GitHub.

`$ sudo git clone https://github.com/madewithpepper/Pulse-Proximity-Platform.git .`

### Folder Permissions
Make sure these folders are writable:

`sudo chmod 777 -R /var/www/html/pulse/assets/`
`sudo chmod 777 -R /var/www/html/pulse/uploads/`
`sudo chmod 777 -R /var/www/html/pulse/core/bootstrap/cache/`
`sudo chmod 777 -R /var/www/html/pulse/core/storage/ `

### Configuration File
Copy the configuration file and update it with the database, mail and Google Maps key info.

`$ sudo cp /var/www/html/pulse/core/.env.example /var/www/html/pulse/core/.env`

`$ sudo vi /var/www/html/pulse/core/.env`

### Create an Apache Virtual Host called `pulse.conf`
`$ sudo vi /etc/apache2/sites-available/pulse.conf`

The contents of **pulse.conf** is:
Make note of the directory **/var/www/html/pulse**

```
<VirtualHost *:80>
    ServerName pulse.mydomain.com

    ServerAdmin no-reply@mydomain.com

    DocumentRoot /var/www/html/pulse/

    <Directory /var/www/html/pulse>
        AllowOverride All
	Options FollowSymLinks
	Order allow,deny
	allow from all
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```
## Enable mod_re-write on Apache 
`$ sudo a2enmod rewrite`

## Restart Apache Services
`$ sudo service apache2 restart`

## Disable Default Apache Virtual Host Profile
`$ sudo a2dissite 000-default.conf`

## Enable Virtual Host Profile on Apache

`$ sudo a2ensite pulse.conf `

## Reload Apache Services
`$ sudo service apache2 reload`

Now, you should able able to launch your browser and complete the installation!
