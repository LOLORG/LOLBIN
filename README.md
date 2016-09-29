# LOLBIN
THE BEST AND THE FASTEST PASTEBIN EVER! LOL!!!!!!!

-------

Aside from joking, LOLBIN is one of the fastest pastebins ever, it's configured to do every single sort of optimization to maximize the performance of the pastebin, achiving the maximum possible load times a website can ever do.

The performance score is 100 as rated by Google's PageSpeed, all sorts of optimizations are done

# Installation:

LOLBIN is built on the LAMP stack, and it pretty much requires it. Notable things your server should absolutely have is MySQL and PHP support

If you use any other server than Apache, the please use the equivalent rules defined in `.htaccess`, or the performance will siginificantly go down and the website might not even load in the first place.

Installing LOLBIN has never been easier.

## Step 1

Login into your MySQL server and execute the following:

```
CREATE DATABASE lolbin;
USE lolbin;
CREATE TABLE pastes (`id` varchar(8) NOT NULL PRIMARY KEY, `content` TEXT NOT NULL, `user_token` TINYTEXT);
```

This creates a DB called `lolbin` and creates a `pastes` table.


## Step 2

Now to actually install the website, go to your webserver's root folder (Usually `/var/www/html/` or Ubuntu or just `/var/www/` on Debian) and and execute:

```
git clone https://github.com/MicroDroid/LOLBIN
mv ./LOLBIN/* .
```

This will clone the repository to your webserver's root folder.

## Step 3

This is the last step, you just need to configure the website, go through `index.php` and `load.php` files, in the first several lines of them, there are a set of `define` statements, simply configure those according to your MySQL server's location and credentials

> Hooray! you're done!

# Troubleshooting

### 500 Internal server error

You might get some `500 Internal Server Error` pages, this is probably due to some modules not being loaded in Apache, make sure to have the following mods loaded:

```
headers
deflate
rewrite
expires
```

Depending on your operation system, the way of enabling those differs. On Ubuntu/Debian systems, that's how you enable mods:

```
sudo a2enmod <mod_name>
```
 For Windows, find your configuration file and uncomment lines starting with `LoadMod` that are relevant the mods listed above


### The website is slow and/or not working

This is probably `.htaccess` file not taking effect, in your server's configuration file, you should change `AllowOverride` statements to activate `.htaccess`, you can Google that to get to know how you can allow overrides.
