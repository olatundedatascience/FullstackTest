# FullstackTest
this repository is for test given to me by Aureole Consulting
------------------------------------------------------------
It was developed with Laravel and mysql running on my localhost....
set up local database connection by editing .env file. change the db username and password to the desired one. You can as well go to config folder then database.php to setp up your database connection there..

create database called BooksAPI (mysql preferred)
Then..look for the following files in database ->  migration folder
  1)  2020_06_22_065712_book.php - books migration file
  2)  2020_06_22_070327_authors.php - authors migration file
  3)  2020_06_22_173435_error_log.php - error log migration file

put out the comment tag...after this, run php artisan migrate..to update the databse earlier created.
after this...you might run php artisan serve.


Thanks..
