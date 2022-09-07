# Collabmed Platform

This file will provide essential info related to the development of the system to developers.

# Events

## Vue Events

The `Storegenerator` emits a global **`STORE_SET_ACTION_LOADING`** which passes the current loading state to the emitted event.
It would be a good idea to listen to the loading state via the **`created()`** method and then bind the state to a local variable. Very helpful when one wants
to show the loading state of a table after saving an entity.

```js
created() {
    window.events.$on('STORE_SET_ACTION_LOADING', (val) => { this.loading = val });
}
```

### Paginator
```vue 
<collabmed-paginator v-if="meta" :meta="meta" @change="navigate" />

// methods
 methods: {
        navigate(page) {
            this.get(page)
        },
}
```

# Server Config
## Browsershot errors
In case you encounter errors when using browsershot to export pdf,

```bash
sudo apt-get install gconf-service libasound2 libatk1.0-0 libc6 libcairo2 libcups2 libdbus-1-3 libexpat1 libfontconfig1 libgcc1 libgconf-2-4 libgdk-pixbuf2.0-0 libglib2.0-0 libgtk-3-0 libnspr4 libpango-1.0-0 libpangocairo-1.0-0 libstdc++6 libx11-6 libx11-xcb1 libxcb1 libxcomposite1 libxcursor1 libxdamage1 libxext6 libxfixes3 libxi6 libxrandr2 libxrender1 libxss1 libxtst6 ca-certificates fonts-liberation libappindicator1 libnss3 lsb-release xdg-utils wget
```

Followed by installing puppeteer
```bash
npm install puppeteer

npm install -g puppeteer

sudo npm install -g puppeteer --unsafe-perm=true --allow-root //whitelist incase of perm issues

```

It is installed globally just in case. 
> REMEMBER, never `npm install` on a live server. For this case, only the headless chrome is required, hence particularly specified for installation

## Scheduler
Scheduler should technically not be allowed in cloud backups. The only cloud backup allowed is DB which has been 
defined in the `ScheduleServiceProvider` in the `Sync` Module.
Afterwards, enable this in `.env` file
```dotenv
APP_ALLOW_SCHEDULER=false
```

# Some Nitty-Little Things
### Display errors in vue after backend validation
The `Error.js` class has a helpful method called `display()` that takes care of this.
```html
<v-alert :value="true" type="error" outline v-if="errors.any()">
    <div v-html="errors.display()"></div>
</v-alert>
```


### Enable Server GZIP
Install NPM package
`npm i compression-webpack-plugin`

Open `/etc/nginx/nginx.conf` provide below configuration .

```bash
http {
    gzip on;

    gzip_static on;
    gzip_vary on;
    gzip_proxied any;
    gzip_comp_level 6;
    gzip_buffers 16 8k;

    gzip_http_version 1.1;
    gzip_types text/plain text/css application/json application/javascript text/xml application/xml application/xml+rss text/javascript;
    
    ...
}
```

### NGINX allow cors
All cors are to be allowed in the respective NGINX files. 
> NB: you must install `nginx extras` package first for this to work.
`sudo apt-get install nginx-extras`

Sample `/etc/nginx/sites-available/lexx.collabmed.org`

```bash

server {

       server_name lexx.collabmed.org www.lexx.collabmed.org;

       access_log /var/log/nginx/access.log;
       error_log /var/log/nginx/error.log;

        root /systems/lexx.collabmed.org/html/public;
        index index.php index.html;

        more_set_headers 'Access-Control-Allow-Origin: $http_origin';
        more_set_headers 'Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE, HEAD';
        more_set_headers 'Access-Control-Allow-Credentials: true';
        more_set_headers 'Access-Control-Allow-Headers: Origin,Content-Type,Accept,Authorization';


        location / {

                # Preflighted requests
                if ($request_method = 'OPTIONS') {
                    more_set_headers 'Access-Control-Allow-Origin: $http_origin';
                    more_set_headers 'Access-Control-Allow-Methods: GET, POST, OPTIONS, HEAD';
                    more_set_headers 'Access-Control-Max-Age: 1728000';
                    more_set_headers 'Access-Control-Allow-Credentials: true';
                    more_set_headers 'Access-Control-Allow-Headers: Origin,Content-Type,Accept,Authorization,X-Requested-With,X-CSRF-TOKEN,X-Socket-Id';
                    more_set_headers 'Content-Type: text/plain; charset=UTF-8';
                    more_set_headers 'Content-Length: 0';
                    return 204;
                }

                 try_files $uri $uri/ /index.php$is_args$args;
        }

        location ~ \.php$ {
                include snippets/fastcgi-php.conf;
        #
        #       # With php-fpm (or other unix sockets):
                fastcgi_pass unix:/var/run/php/php7.2-fpm.sock;
        #       # With php-cgi (or other tcp sockets):
        #       fastcgi_pass 127.0.0.1:9000;
        }

        location ~ /\.ht {
                deny all;
        }
}
```

### Backups
First of just include this in your crontab file:
``* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1``

### Supervisor
All supervisor config files are stored in `etc/supervisor/conf.d` directory.

Sample `/etc/supervisor/conf.d/platform-worker.conf`

```bash
[program:platform-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /systems/platform.collabmed.net/html/artisan queue:work redis --queue=platform-supervisor --sleep=3 --tries=3
autostart=true
autorestart=true
user=collabmed
numprocs=2
redirect_stderr=true
stdout_logfile=/systems/platform.collabmed.net/html/storage/logs/platform-worker.log

```

### Migrations order: 07/23/2019
Due to references, follow the following order when migrating on a new platform
* platform
* settings
* finance
* users
* 


##### Migrations failure:
It is now clear that you cannot setup a new instance of the system with the existing migrations. You therefore instead have to 
device new ways to accomplish this simple task: Done this twice now and it now seems like a more frequent operation and therefore
in the meantime as we device a much better approach to the migrations problem here is what I have done to successfully
setup a new database for the new client:
* export a copy of the existing and already established database structure
* import that to the new client's database
* Since we just imported the structure, there are a few operations we need to carry out at this point
to ensure we are able to access the system: 
    * Create a clinic
    * Associate the clinic with its practice/info details
    * import the settings_options table data
    * Re-install sudo
    * Login into the system and assign sudo a clinic
    * Seed settings
    

##### Stock take:
 * can use either of the queue:drivers ( sync, database, redis)
 * preferring redis though due to the power of horizon (tracking and all that)
 * Queue management on ubuntu use supervisor else (ensure to run queue:work as a demon in the background
  and make sure it auto starts)

# PDF Troubleshooting
[Requirements](https://github.com/dompdf/dompdf/wiki/Requirements)

- GD
For 7.1 PHP
```bash
sudo apt-get install php7.1-gd
```

- MBString
```bash
sudo apt-get install php7.0-mbstring
```
To complement [sparkmood's answer](https://askubuntu.com/questions/491629/how-to-install-php-mbstring-extension-in-ubuntu), this now works for PHP 7 if you already imported ondrej's PPA for it.
```bash
sudo apt-get install libapache2-mod-php7.0
```

And even crazier:
```bash
sudo apt-get install dba dom ereg exif fileinfo filter ftp gettext hash iconv json libxml
 mbstring mhash openssl pcre Phar posix Reflection session shmop SimpleXML
 soap sockets SPL standard sysvmsg sysvsem sysvshm tokenizer wddx xml
 xmlreader xmlwriter zip zlib

```

Puppeteer
[answer](https://techoverflow.net/2018/06/05/how-to-fix-puppetteer-error-while-loading-shared-libraries-libx11-xcb-so-1-cannot-open-shared-object-file-no-such-file-or-directory/)
```bash
sudo apt install -y gconf-service libasound2 libatk1.0-0 libc6 libcairo2 libcups2 libdbus-1-3 libexpat1 libfontconfig1 libgcc1 libgconf-2-4 libgdk-pixbuf2.0-0 libglib2.0-0 libgtk-3-0 libnspr4 libpango-1.0-0 libpangocairo-1.0-0 libstdc++6 libx11-6 libx11-xcb1 libxcb1 libxcomposite1 libxcursor1 libxdamage1 libxext6 libxfixes3 libxi6 libxrandr2 libxrender1 libxss1 libxtst6 ca-certificates fonts-liberation libappindicator1 libnss3 lsb-release xdg-utils wget
```

- DOM

## Support
Please contact support via [Support](mailto:info@collabmed.com)
Technical Support : [Kisiara Francis](mailto:fkisiara@collabmed.com)
Technical Support : [Alex Maina](mailto:amaina@collabmed.com)
Technical Support : [John Irungu](mailto:jirungu@collabmed.com)

