<?php

class Signup extends Db
{
    //response handler
    public function resHandler($code, $msg)
    {
        /*
            we are just creating an assoc array which
            will send back the reponse based on what we have 
            processed for example, assuming we have an 
            empty input, we can send the following as 
            response: 

            code = "bbe_001" and
            msg = "error".

            The bbe in the code stands for blood bank error,
            this will be split using "_" in the front end
            and since bbe was returned, the developer will 
            use color of red, but if bbs, which stands for 
            blood bank success is returned, the message 
            to be displayed in the front will be green.
        */
        $response = [
            "code" => $code,
            "msg" => $msg
        ];
        return $response;
    }

    public function addUser($data)
    {
        //now you create all your signup code
        //don't forget to return responses.
        //remember, $data is an array containing user data


        /*
            respHandler usage sample
            Assuming an input is empty, all you need do is

            if (empty($input)) {
                return $this->resHandler("bbe_001", "Empty or invalid input");
            }
        */

        if (empty($data['username']) || empty($data['password'])) {
            return $this->resHandler("bbe_001", "Username and password are required!");
        }

        // Password length check
        if (strlen($data['password']) < 6) {
            return $this->resHandler("bbe_003", "Password must be at least 6 characters!");
        }

        // Check if username exists
        $sql = "SELECT id FROM userData WHERE username = :username LIMIT 1";
        $stmt = $this->con()->prepare($sql);
        $stmt->bindParam(":username", $data['username']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $this->resHandler("bbe_004", "Username already exists!");
        }

        // Hash password
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

        // Insert user
        $sql = "INSERT INTO userData (username, password) 
        VALUES (:username, :password)";
        $stmt = $this->con()->prepare($sql);

        $stmt->bindParam(":username", $data['username']);
        $stmt->bindParam(":password", $hashedPassword);

        if ($stmt->execute()) {
            return $this->resHandler("bbs_001", "Signup successful!");
        } else {
            return $this->resHandler("bbe_005", "Something went wrong, please try again.");
        }

        return $this->resHandler("testing", "Everything is working");

    }
}