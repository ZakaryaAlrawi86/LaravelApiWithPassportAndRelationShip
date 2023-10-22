<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;

class BaseController extends Controller
{
    public function sendResponse($result , $message)
    {
        $response = [
            'success'=> true,
            'data' => $result,
            'message'=> $message
        ];
        return response()->json($response,200);
    }

    public function sendError($error , $errorMessage = [] , $code = 404)
    {
        $response = [
            'success'=> false,
            'data' => $error
        ];
        if(!empty($errorMessage)){
            $response['data'] = $errorMessage;
        }
        return response()->json($response,$code);
    }
}
