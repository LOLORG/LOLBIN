# LOLBIN [![Snippets Count](https://codebottle.io/api/v1/embed/searchbadge.php?keywords=%22LOLBIN%22&language=null)](https://codebottle.io/?q=%22LOLBIN%22)

THE BEST AND THE FASTEST PASTEBIN EVER! LOL!!!!!!!

-------

Aside from joking, LOLBIN is one of the fastest pastebins ever, it's configured to do every single sort of optimization to maximize the performance of the pastebin, achiving the maximum possible load times a website can ever do. It's also completely encrypted client-side, meaning pastes can't be read by LOLBIN hosts

The performance score is 100 as rated by Google's PageSpeed, all sorts of optimizations are done. A typical server response time should be around **125ms**

Pingdom test for one of our servers:

[![Pingdom Test for Sigint](https://i.imgur.com/Zd774oM.png)](https://tools.pingdom.com/)

# Installation:

Notable things your server should absolutely have is PHP support, with PDO's SQLite driver installed.

Make sure to have `.htaccess` (Apache) or `nginx.conf` (Nginx) active, or the performance will degrade and the LOLBIN won't work.

Installing LOLBIN has never been easier.


## Step 1

Clone the repository and configure your webserver's root folder to the generated `./LOLBIN` folder

```
git clone https://github.com/MicroDroid/LOLBIN
```

## Step 2

Make sure `nginx.conf` or `.htaccess` are active.

> Hooray! you're done!

# API

You can also use LOLBIN through any HTTP library, here's a python example:

```
response = requests.post("http://lolbin.sigint.pw/", {"raw": 0, "input": "LOLAPI"});
url = "http://lolbin.sigint.pw/" + response.text;
```

Basically:

 - You must set the `raw` parameter to 0 for this to work, so that the pastebin doesn't really try to decrypt the pasted text
 - The index file, when pasting, returns the paste ID in the body, and then we just use it to construct the url
 - `url` in that example contains the URL to view the paste
 - You can also pass the `?raw=1` parameter to `url` so the pastebin only returns a raw response

# Troubleshooting

### 500 Internal server error

You might get some `500 Internal Server Error` pages, this is probably due to some modules not being loaded if you use Apache, make sure to have the following mods loaded:

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


I haven't used nginx, so experiment with that on your own

### The website is slow and/or not working

Make sure `.htaccess` (Apache) or `nginx.conf` (Nginx) is active.

### PDO not finding SQLite driver

If you're on debian-based systems:

```
sudo apt-get install php5-sqlite
# or
sudo apt-get install php7.0-sqlite
```

Uncomment this line in your `php.ini`:

```
...
extension=php_pdo_sqlite.dll
...
```

# List of trusted LOLBINs (All of them are over HTTPS)

 - [Sigint](https://lolbin.sigint.pw/)