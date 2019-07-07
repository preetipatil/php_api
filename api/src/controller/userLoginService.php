<?php
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;

include_once "./src/user.php";
include_once './config/db.php';
include_once "./config/constant.php";


class UserLoginService{
    public $issuedat_claim;
    public $notbefore_claim;
    public $expire_claim;

    public function __construct()
    {
        $this->issuedat_claim = time(); // issued at
        $this->notbefore_claim = $this->issuedat_claim + 10; //not before in seconds
        $this->expire_claim = $this->issuedat_claim + 60; // expire time in seconds
    }

    public function userLogin($data){
                             // echo "secret:".Secret_key;die;
        $databaseService = new DatabaseService();
        $conn = $databaseService->getConnection();

        $newUser = new User($conn);

        $response = $newUser->findUser($data->email);
        $output = "";
        if(!$response){
            http_response_code(404);
            $output = json_encode(array("message" => "NOT FOUND",
                "status" => "Failed",
                "code" => "404"));
        }else {
            //if user found match passwords
            //if(password_verify($passwordInput, $passwordDB))
            if ($response["password"] == $data->password) {
                //create token
                $token = array(
                    "iss" => ISSUER_CLAIM,
                    "aud" => AUDIENCE_CLAIM,
                    "iat" => $this->issuedat_claim,
                    "nbf" => $this->notbefore_claim,
                    "exp" => $this->expire_claim,
                    "data" => array(
                        "type" => $response["type"],
                        "email" => $response["email"],
                    ));

                $jwt = JWT::encode($token, SECRET_KEY);
                http_response_code(200);
                // display success message
                $output = json_encode(array("message" => "Successful login.",
                    "status" => "Success",
                    "code" => "200",
                    "jwt" => $jwt));
            } else {
                http_response_code(400);
                $output= json_encode(array("message" => "Incorrect password",
                    "status" => "Failed",
                    "code" => "400"));
            }
        }
        return $output;
    }
    
}