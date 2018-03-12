# toolboxphp [![Build Status](https://travis-ci.org/RaymondByczko/toolboxphp.svg?branch=master)](https://travis-ci.org/RaymondByczko/toolboxphp)

## Last mod date

2018-03-12

## Status

This public repository is undergoing development.

Accordingly it is draft work.

## Installation

This repository is under development.

Here are draft install instructions.

#Step 1

Add a composer.json file or edit yours to include the following.

```json
{
    "require": {
        "raymond-byczko/toolboxphp": "dev-master"
    }
}
```
#Step 2

Edit the file that contains your database credentials.
For toolboxphp, this is:

vendor/raymond-byczko/toolboxphp/hasdbchanged/test/TestAttributes.php

#Step 3

Create a test file to make sure you can autoload correctly.
Here is an example
```php
<?php

	$al = __DIR__."/../vendor/autoload.php";
	require $al;
	echo '<pre>Inside hitoolbox.php</pre>';
	echo '<pre>'.$al.'</pre>';
	$objTU = new \hasdbchanged\TableUtility();
	$dbattrib = new \hasdbchanged\test\TestAttributes();
	$objTU->setInformation($dbattrib);
	$fullFormat = $objTU->getFullFormat();
	echo '<pre>'."\n";
	echo 'fullFormat='.var_export($fullFormat, TRUE)."\n";
	echo '</pre>'."\n";

?>
```


Specific installation instructions will be added soon.

## Change log

date: 2012-02-12 - added ctlwebservice
date: 2012-02-13 - added some DB functionality to ctlwebservice
date: 2012-02-14 - pushed code to shared server for a deployment test.
To this end, used env variables in .htaccess (SetEnv).
date: 2013-02-18 - added dbimport and started populating it.
date: 2018-03-02 - added Travis CI.  Got it to pass.   Need to enhance.

## Purpose

The purpose of this repo is to contain a set of PHP utilities
that serve a purpose in software development.  Essentially
it should make life easier and faster.

This can include anything from php code that looks at mysql
databases, to general frameworks to help come up with a 
web page fast.  (This is much better than coming up with
a set of pages too slowly for an impatient client.

Every utility is given its own directory in the toolboxphp
repository.

## Utilities

* hasdbchanged - a set of php files for querying into
running mysql databases, and determines if the database has
changed.  It is envisioned this would be a script running
under crontab, so that you the developer can see if the
database admin guy/gal has pulled the rug from under php
code by changing column names etc. 

* ctlwebservice - a demo code set for control something via
a web service (SOAP).  The 'something' is a table whose
height and angle can be adjusted.  (The table is assumed to
be on a central axle and can be rotated.)  This code demonstrates
using GET (or POST) along with SOAP and logging via syslog.
Database capability is included.  See the sql subdirectory
for the table create script.  Deployment is based on
environment variables.  See the file: .htaccess.

* facebookapi - TODO

* dbimport - this is a set of php code and apache2 files to allow
database import to happen, but actually, it will provide more
that that.  For example, it will allow excel spreadsheet data
to be pushed up to a web site and then used to populate one
of several types of relational or even NoSQL databases.
Basically it allows the movement of data out of spreadsheets.
Further, it provides reviewing spreadsheet data via various
graphing utilities.  Its status is: incomplete, on-going.
