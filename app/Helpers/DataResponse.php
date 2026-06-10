<?php

namespace App\Helpers;

class DataResponse
{

    static function ValidateFail($message = null, $errors = [])
    {
        return (object)[
            'statusCode' => 422,
            'error'      => true,
            'status'     => 'Unprocessable',
            'errors'     => $errors,
            'message'    => $message
        ];
    }

    static function BadRequest($message = "Bad Request", $errors = [])
    {
        return (object)[
            'statusCode' => 400,
            'error'      => true,
            'status'     => 'Bad Request',
            'errors'     => $errors,
            'message'    => $message
        ];
    }

    static function Duplicated($message, $errors = [])
    {
        return (object)[
            'statusCode' => 409,
            'error'      => true,
            'status'     => 'Conflict',
            'errors'     => $errors,
            'message'    => $message
        ];
    }

    static function Unauthorized($err_msg = 'Unauthorized')
    {
        return (object)[
            'statusCode' => 401,
            'error'      => true,
            'status'     => 'Unauthorized',
            'message'    => $err_msg
        ];
    }

    static function JsonResult($data, $error = false, $message = null, $errors=[], $statusCode = 200, $status = "OK", $additionalKeys=[])
    {
        $obj = (object)[
            'error' => $error,
            'status' => $status,
            'message' => $message,
            'statusCode' => $statusCode,
            'errors' => $errors,
            'data' => $data,
        ];
        if (is_array($additionalKeys) || is_object($additionalKeys)) {
            foreach ($additionalKeys as $key => $value) {
                $obj->$key = $value;
            }
        }
        return $obj;
    }

    static function JsonRaw($json, $status = null)
    {
        $jsonRes = (object)[];
        foreach($json as $key => $j){
            $jsonRes->{$key} = $j;
        }
        return $jsonRes;
    }

    static function NotFound($message)
    {
        return (object)[
            'statusCode' => 404,
            'error'      => true,
            'status'     => 'Not Found',
            'message'    => $message,
            'errors'     => []
        ];
    }

    static function Error($message, $errors = [])
    {
        return (object)[
            'statusCode' => 500,
            'error' => true,
            'status' => 'Error',
            'message' => $message,
            'data' => null,
            'errors' => $errors
        ];
    }
}
