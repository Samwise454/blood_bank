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

        $firstname = ucfirst(trim($data["firstname"]));
        $middlename = ucfirst(trim($data["middlename"]));
        $othername = ucfirst(trim($data["othername"]));
        $email = $data["email"];
        $tel = $data["tel"];
        $gender = strtolower($data["gender"]);
        $password = $data["password"];
        // Generate secure token
        $token = bin2hex(random_bytes(32));

        /*
            respHandler usage sample
            Assuming an input is empty, all you need do is

            if (empty($input)) {
                return $this->resHandler("bbe_001", "Empty or invalid input");
            }
        */
        $genderArray = ["male", "female"];

        if (empty($firstname) || empty($middlename) || empty($othername) || empty($email) || empty($tel) || empty($gender) || empty($password)) {
            return $this->resHandler("er01", "Check for empty input");
        }
        else if (!preg_match("/^[A-Za-z-']*$/", $firstname)) {
            return $this->resHandler("er02", "Invalid name");
        }
        else if (!preg_match("/^[A-Za-z-']*$/", $middlename)) {
            return $this->resHandler("er02", "Invalid name");
        }
        else if (!preg_match("/^[A-Za-z-']*$/", $othername)) {
            return $this->resHandler("er02", "Invalid name");
        }
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->resHandler("er03", "Check email");
        }
        else if (mb_strlen($tel) < 11) {
            return $this->resHandler("er04", "Check Phone number");
        }
        else if (!in_array($gender, $genderArray)) {
            return $this->resHandler("er05", "Invalid gender");
        }
        else if (strlen($data['password']) < 6) {// Password length check
            return $this->resHandler("er06", "Password must be at least 6 characters!");
        }
        else {
            // Check if email exists
            $sql = "SELECT email FROM userData WHERE email=? LIMIT 1";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute([$email]);
            $result = $stmt->fetchColumn();//eg sammy@gmail.com

            if ($result) {
                return $this->resHandler("er07", "Already registerd!");
            }
            else {
                // Hash password
                $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

                // Insert user
                $sql = "INSERT INTO userData (firstName, lastName, middleName, gender, email, tel, password, token) 
                VALUES (?,?,?,?,?,?,?,?)";
                $stmt = $this->con()->prepare($sql);
                $stmt->execute([$firstname, $middlename, $othername, $gender, $email, $tel, $hashedPassword, $token]);

                return $this->resHandler("su01", "Signup successful!");
            }
        }
    }
}