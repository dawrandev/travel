<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "Travel API",
    description: "Sayohat veb-sayti uchun API"
)]
#[OA\Server(
    url: "https://toqtarbay.dbc.uz/api",
    description: "Production Server"
)]
#[OA\Server(
    url: "http://travel.test/api",
    description: "Local Development Server"
)]
abstract class Controller
{
    //
}
