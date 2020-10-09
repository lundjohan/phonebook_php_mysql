# phonebook_php_mysql

Simple (I guess typical) "phonebook" application written in PHP towards a MySQL database.
I am using PDO and mysqli_real_escape_string to remove risk of SQL Injections.

You can run the program here:
https://phonebookphp.000webhostapp.com/show_contacts.php

## For myself:
Don't use 000webhostapp as server again:
  it has gotten stuck on the wrong login and saved the cache, and navigation is quite illogical.
  
When setting up project on server, run this SQL command to set up database (only one table in this simple project):

CREATE TABLE `persons` (
 `id` int(3) NOT NULL AUTO_INCREMENT,
 `first_name` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
 `last_name` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
 `email_address` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
 `phone_number` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
 PRIMARY KEY (`id`)
) 

Above was retrieved in PHPMyAdmin with SQL Command:
  SHOW CREATE TABLE persons



