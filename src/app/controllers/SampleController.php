<?php


namespace Classes\Controller;



use Classes\Lib\Controller;
use Slim\Http\Request;
use Slim\Http\Response;

class SampleController extends Controller
{

    public function index(Request $request, Response $response)
    {
        echo "Hello Sample.";
    }
}