<?php
    class Login extends Db {
        //response handler
        public function resHandler($code, $msg) {
            /*
                we are just creating an assoc array which
                will send back the reponse based on what we have 
                processed for example, assuming we have an 
                empty input, we can send the following as 
                response: 

                code = "bbe_001" and
                msg = "empty or invalid input!".

                The bbe in the code stands for blood bank error,
                this will be split using "_" in the front end
                and since bbe was returned, the developer will 
                use color of red, but if bbs, which stands for 
                blood bank success is returned, the message 
                to be displayed in the front will be green.
            */
            $response = [
                "code"=>$code,
                "msg"=>$msg
            ];
            return $response;
        }

        public function loginUser($data) {
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
            
            $email = $data["email"];
            $password = $data["password"];

            if (empty($email) || empty($password)) {
                return $this->resHandler("el01", "Empty/invalid input!");
            }
            else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $this->resHandler("el02", "Check email!");
            }
            else {
                //let's check userData table for email existence
                $sql = "SELECT email, token, password FROM userData WHERE email=? LIMIT 1";
                $stmt = $this->con()->prepare($sql);
                $stmt->execute([$email]);
                $result = $stmt->fetchAll();

                if (count($result) > 0) {
                    $passwordVerify = password_verify($password, $result[0]["password"]);

                    if ($passwordVerify === true) {
                        //data verified, regenerate token
                        $token = bin2hex(random_bytes(32));

                        // Optional expiry (24 hrs)
                        // $expiry = date("Y-m-d H:i:s", strtotime("+1 day"));

                        //now we update the table with the regenerated token to keep it fresh
                        $sql = "UPDATE userData SET token=? WHERE email=?";
                        $stmt = $this->con()->prepare($sql);
                        $stmt->execute([$token, $email]);
                        
                        $data = [
                            "id"=>$result[0]["id"],
                            "lastname"=>$result[0]["lastname"],
                            "tel"=>$result[0]["tel"],
                            "token"=>$token
                        ];
                        return $data;
                    }
                    else if ($passwordVerify === false) {
                        return $this->resHandler("el03", "Invalid email or password!");
                    }
                }
                else {
                    return $this->resHandler("el04", "User doesn't exist!");
                }
            }
        }
    }