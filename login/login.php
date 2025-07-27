<?php   
    require_once '../cors.php';
    require_once '../autoloader.php';

    /*
        this page will receive the signup input 
        data from the front and then pass it to a 
        signup class that will process it.
    */

    //we will use a header to describe the type of data to be allowed
    header('Content-Type: application/json');

    //the data variable(array) will contain the inputs coming from the front
    $data = json_decode(file_get_contents('php://input'), true);

    // let's get the method used to send the http request
    $method = $_SERVER["REQUEST_METHOD"];

    // check the method used and make sure it's a POST method for signup
    if ($method === "POST") {
        // now we instantiate a class and pass the data to a method in the class
        $userData = new Login();

        /*
            below, we are sending back response to the front,
            on completion of the processing.
        */
        echo json_encode($userData->loginUser($data));
    }
    else {
        echo json_encode(["error"=>"No data sent!!"]);
    }