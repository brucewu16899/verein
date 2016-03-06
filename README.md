[![Build Status](https://travis-ci.org/thelfensdrfer/verein.svg?branch=master)](https://travis-ci.org/thelfensdrfer/verein) [![Coverage Status](https://coveralls.io/repos/thelfensdrfer/verein/badge.svg)](https://coveralls.io/r/thelfensdrfer/verein) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/thelfensdrfer/verein/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/thelfensdrfer/verein/?branch=master) [![Code Quality](https://insight.sensiolabs.com/projects/e513b883-5c76-43ec-b3ad-f2b79e14a4fd/small.png)](https://insight.sensiolabs.com/projects/e513b883-5c76-43ec-b3ad-f2b79e14a4fd)

## Install

Install the project with following commands:

* Clone repository `git clone https://github.com/thelfensdrfer/verein.git` (and change into directory `cd connect/`)
* Copy `.env.example` to `.env` and replace the default with your prefered settings
* Install PHP dependencies `composer install`
* Install frontent build dependencies `npm install`
* Install frontent dependencies `bower install`
* Migrate database `php artisan migrate`
* Build javascript and stylesheets `gulp`

### Requirements

* PHP >= 5.4
* MySQL >= 5.5 / MariaDB >= 10.0
* Node.js >= 0.8 / npm
* Composer - `curl -sS https://getcomposer.org/installer | php -- --install-dir=bin`
* gulp - `npm install gulp --global`

Maxminds [GeoLite2 Database](https://dev.maxmind.com/geoip/geoip2/geolite2/). Copy the file (`GeoLite2-Country.mmdb`) into the `storage/geoip` directory.

## Browser support

* Firefox
* Google Chrome
* Safari
* Internet Explorer >= IE 9 (IE 6-8 partially supported)
* Mobile Safari
* Mobile Chrome

## Naming conventions

* **Name**: A model has a name if it exists in real life, e.g. a company or a human person.
* **Title**: A model has a title if the name is constructed, e.g. a project or a task.
