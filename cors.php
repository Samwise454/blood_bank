<?php
    if (isset($_SERVER["HTTP_ORIGIN"])) {
        header("Access-Control-Allow-Origin: https://blood-bank-db.vercel.app/");//this will be edited when we are done developing 
        header("Access-Control-Allow-Credentials: true");
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header("Access-Control-Max-Age: 600");//caching for 10 minutes
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT");
    }
    