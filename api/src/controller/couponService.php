<?php

require "../vendor/autoload.php";
use \Firebase\JWT\JWT;

include_once "src/coupon.php";
include_once './config/db.php';
include_once "./config/constant.php";

class CouponService{
    public $newCoupon;

    public function __construct(){
        $databaseService = new DatabaseService();
        $conn = $databaseService->getConnection();
        $this->newCoupon = new Coupon($conn);
    }

    public function listCoupon($data){
        try {
            // decode jwt
            $decoded = JWT::decode($data->jwt, SECRET_KEY, array('HS256'));

            if ($decoded->data->type == 1 || $decoded->data->type ==0 ) { //only Admin and Customer user can update Coupon
                 $this->getListofCoupens($data) ;
            } else {
                // show user details
                echo json_encode(array(
                    "message" => "Do not have admin access",
                    "data" => $decoded->data
                ));
            }
        }catch (Exception $e){

            http_response_code(401);
            // user access denied  & show error message
            echo json_encode(array(
                "message" => "Access denied.",
                "status" => "Failed",
                "code" => "401",
                "error" => $e->getMessage(),
                "jwt" =>$data->jwt,
            ));
        }
    }

    public function getListofCoupens($data){
        $coupons = $this->newCoupon;

            if(!empty($data->name))  {
                $response = $coupons->findbyName($data->name, $data->limit, $data->sortbydate);
                echo json_encode(array("message" => "Success",
                    "count" => count($response),
                    "data" => $response,
                ));
            }elseif (!empty($data->value))  {
                $response = $coupons->findbyValue($data->value,$data->limit, $data->sortbydate);
                echo json_encode(array("message" => "Success",
                    "count" => count($response),
                    "data" => $response,
                ));
            }elseif (!empty($data->brand))  {
                $response = $coupons->findbyBrand($data->brand,$data->limit, $data->sortbydate);
                echo json_encode(array("message" => "Success",
                    "count" => count($response),
                    "data" => $response,
                ));
            }else{
                $response = $coupons->findAll();
                http_response_code(200);
                // display success message
                echo json_encode(array("message" => "Success",
                    "count" => count($response),
                    "data" => $response,
                ));
            }
    }

    public function updateCoupon($data){

        $search_id = $data->id;
        $inputParams['name'] =$data->name ;
        $inputParams['brand'] = $data->brand ;
        $inputParams['value']  =  $data->value;
        $inputParams['expiry']  = $data->expiry ;
        $jwt =$data->jwt;
        
        try {
            // decode jwt
            $decoded = JWT::decode($jwt, SECRET_KEY, array('HS256'));

            if ($decoded->data->type == 1) { //only Admin user can update Coupon
                //admin user can create coupon
                if (
                    !empty($inputParams['name']) &&
                    !empty($inputParams['value']) &&
                    !empty($inputParams['brand']) &&
                    !empty($inputParams['expiry']) &&
                    !empty($search_id)
                ) {
                    $response = $this->newCoupon->updateCoupon($search_id, $inputParams);

                    http_response_code(200);
                    // display success message
                    echo json_encode(array("message" => "Access granted. Coupon was updated.",
                        "status" => "Success",
                        "code" => "200"));
                } else {
                    http_response_code(400);
                    // display fail message
                    echo json_encode(array("message" => "Access granted. Unable to update Coupon.",
                        "status" => "Failed",
                        "code" => "400"));
                }
            }else {
                // show user details
                echo json_encode(array(
                    "message" => "Do not have admin access",
                    "data" => $decoded->data
                ));
            }
        }catch (Exception $e){
            
            http_response_code(401);
            // user access denied  & show error message
            echo json_encode(array(
                "message" => "Access denied.",
                "status" => "Failed",
                "code" => "401",
                "error" => $e->getMessage(),
                "jwt" =>$jwt,
            ));
        }
    }


     public function findCoupon($data){
         try {
             // decode jwt
             $decoded = JWT::decode($data->jwt, SECRET_KEY, array('HS256'));

             if (!empty($data->id)) {
                 $response = $this->newCoupon->findCoupon($data->id);
                 if ($response) {
                     // set response code
                     http_response_code(200);

                     // display success message
                     echo json_encode(array("message" => "Success", "data" => $response));
                 } else {
                     http_response_code(400);
                     // display not found message
                     echo json_encode(array("message" => "Not Found"));
                 }
             } else {
                 http_response_code(400);

                 // display fail message
                 echo json_encode(array("message" => "Fail"));
             }
         }catch (Exception $e){
             // set response code
             http_response_code(401);
             // user access denied  & show error message
             echo json_encode(array(
                 "message" => "Access denied.",
                 "status" => "Failed",
                 "code" => "401",
                 "error" => $e->getMessage(),
                 "jwt" =>$this->jwt,
             ));
         }
     }


     public function createCoupon($data){
         $inputParams['name'] =$data->name ;
         $inputParams['brand'] = $data->brand ;
         $inputParams['value']  =  $data->value;
         $inputParams['expiry']  = $data->expiry ;
         try {
             // decode jwt
             $decoded = JWT::decode($data->jwt, SECRET_KEY, array('HS256'));

             if($decoded->data->type == 1){ //only Admin user can create Coupon
                 //admin user can create coupon
                 if(
                     !empty($inputParams['name']) &&
                     !empty($inputParams['value']) &&
                     !empty($inputParams['brand']) &&
                     !empty($inputParams['expiry'])

                 ) {
                     $this->newCoupon->createCoupon($inputParams);
                     // set response code
                     http_response_code(200);

                     // display success message
                     echo json_encode(array("message" => "Access granted. Coupon was created.",
                         "status" => "Success",
                         "code" => "200"));
                 }else{
                     http_response_code(400);
                     // display fail message
                     echo json_encode(array("message" => "Access granted. Unable to create Coupon.",
                         "status" => "Failed",
                         "code" => "400"));
                 }
             }else {
                 // show user details
                 echo json_encode(array(
                     "message" => "Do not have admin access",
                     "status" => "Failed"
                 ));
             }
         }catch (Exception $e){
             // set response code
             http_response_code(401);
             // user access denied  & show error message
             echo json_encode(array(
                 "message" => "Access denied.",
                 "status" => "Failed",
                 "code" => "401",
                 "error" => $e->getMessage(),
                 "jwt" =>$data->jwt,
             ));
         }
     }
}