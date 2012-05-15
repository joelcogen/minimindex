# minimindex

PHP web folder listing script [demo](http://joelcogen.com/pub/minimindex/)

### Difference between 0.1 and 1.x

Versions 0.1 and 1.x have important differences, please read this before choosing which one you’re going to use.

Version 0.1 is a single `index.php` file, that you have to copy into each public folder (it only lists the current folder). The copy part can be a hassle, but it’s a lot easier to configure and can be a good choice if you have few folders. It has a less features and download count can be buggy, but it’s still pretty nice.

Version 1.x is a set of files used to list a sub-folder. It only works with Apache because it uses an `.htaccess` file. It’s a little more complicated to configure (read: you have 4 parameters to change instead of none), but once it’s setup, you can just forget about it and create your subfolders. You can also store the download count in a MySQL database, which is a lot less buggy that using a file.

### Installation

#### 0.1

Just rename the file to index.php and copy it in all your public folders.

#### 1.x

Extract all the files to your root public folder (e.g. `/var/www/pub/`) and edit `config.php`:

* `basedir` is the URL of your public folder, without the domain (e.g. /pub for http://joelcogen.com/pub)
* `realdir` is the sub-folder where your files actually are (e.g. files)

Then edit `.htaccess` and change `/pub/` by your `basedir`, adding a trailing slash.