<?php
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;

include_once "src/coupon.php";
include_once './config/db.php';

include_once "./config/constant.php";
include_once "./config/headers.php";
include_once "src/controller/couponService.php";


$data = json_decode(file_get_contents("php://input"));

$jwt=isset($data->jwt) ? $data->jwt : "";

if($jwt) {
    $couponService = new CouponService();
    $couponService->listCoupon($data);
}else {
    http_response_code(401);
    //user access denied
    echo json_encode(array("message" => "Access denied.",
        "status" => "Failed",
        "code" => "401"));
}

