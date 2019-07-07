<?php

include_once "src/controller/userLoginService.php";
include_once "./config/headers.php";

//include_once './config/db.php';
//include_once "./config/constant.php";

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->email)) {
    $loginService= new userLoginservice();
    $response = $loginService->userLogin($data);
    echo $response;
    //userLogin($data) ;
}else{
    http_response_code(400);
    // display fail message
    echo json_encode(array("message" => "Login Failed.",
        "status" => "Failed",
        "code" => "400"));
}
