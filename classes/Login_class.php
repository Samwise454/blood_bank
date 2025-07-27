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

            $username = "Sam";

            $sql = "SELECT * FROM users WHERE username=?";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute([$username]);
            $result = $stmt->fetchAll();

            $count_result = count($result);

            if ($count_result > 0) {
                return $this->resHandler("testing", "Everything is working");
            }
            else {
                return $this->resHandler("testing", "Everything is not working");
            }

        }
    }