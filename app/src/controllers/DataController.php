<?php
namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

include_once('database.php');

final class DataController extends BaseController
{
    public function AQInsert(Request $request, Response $response, $args)
    {
    }

    public function HRInsert(Request $request, Response $response, $args)
    {
    }

    public function GetRealtimeAQ(Request $request, Response $response, $args)
    {
    }

    public function GetRealtimeHR(Request $request, Response $response, $args)
    {
    }

    public function GetHistoricalAQ(Request $request, Response $response, $args)
    {
    }

    public function GetHistoricalHR(Request $request, Response $response, $args)
    {
    }
}
