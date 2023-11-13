<?php

namespace PHPMaker2023\new2023;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * printtermsconditions controller
 */
class PrinttermsconditionsController extends ControllerBase
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "Printtermsconditions");
    }
}
