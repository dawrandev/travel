<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "Travel API",
    description: "Sayohat veb-sayti uchun API"
)]
#[OA\Server(
    url: "/api",
    description: "API Server"
)]
abstract class Controller
{
    //
}
