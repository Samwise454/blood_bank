# blood_bank
This is where the blood bank control system will live.
# Kindly update this README.md file for any script you push.
# Also, don't forget to add messages when commiting codes.

# autoloader.php
There is an autoloader script which links all
the classes together once you name the class properly.
To name a class, kindly start with uppercase letter 
for example creating a class to control newsletter request 
# Newsletter_class.php

# cors.php
This script will controls cross origin resource sharing

# About the database connection
# Db_class.php
The database connection has been set up
and running on the server, to call the 
database class, just extend 
the Db class from the class you are 
working on. Then to create a connection,
just call the con() method.

# signup.php
This is like the landing page for the 
signup request coming from the front.
We will collect data in JSON format 
but the validations and checks will happen 
in the Signup_class.php script.

# login.php
This is like the landing page for the 
login request coming from the front.
We will collect data in JSON format 
but the validations and checks will happen 
in the Login_class.php script.

# Signup_class.php
Here, the developer will have to add different methods
depending on how it's required. I have created the first one
# addUser method.

# Login_class.php
Here, the developer will have to add different methods
depending on how it's required. I have created the first one
# loginUser method.