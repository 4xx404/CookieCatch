# CookieCatch
CookieCatch will attempt to steal a target's cookies & store them for access. CookieCatch will also grab the IP address, device information such as Operating System & browser & will also attempt to gather location details via IPInfo. Outputs are written in both textfile & SQLite3 database to allow for easy use of collected data in other tools.

# IPInfo
You can get an API key by signing up for a free account at [IPInfo](https://ipinfo.io/) which allows 50,000 free requests per month. To set your API key in CookieCatch, edit **Core/init.php** & set the key in **API/IPInfo**.  

# Dashboard  
In the latest upgrade, I have added a simple web interface for ease of viewing the results. More features will be added to the web interface in updates to come. To use the web interface, start the PHP server & navigate to the dashboard [here](http://127.0.0.1/dashboard.php)  

# Usage
```
git clone https://github.com/4xx404/CookieCatch
mv ~/CookieCatch /var/www/html/ && cd /var/www/html/CookieCatch/
sudo chown -R $(whoami) /var/www/html/CookieCatch/
php -S localhost:80
```

# Include Ngrok
```
ngrok http 80
```

Send the link to your target.  

Example link using ngrok: http://af9cea23de3.ngrok.io/CookieCatch/
