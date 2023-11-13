<?php

namespace PHPMaker2023\new2023;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class StatsMonthController extends ControllerBase
{
    // list
    public function list(Request $request, Response $response, array $args): Response
    {
        $args = $this->getKeyParams($args);
        return $this->runPage($request, $response, $args, "StatsMonthList");
    }

    // add
    public function add(Request $request, Response $response, array $args): Response
    {
        $args = $this->getKeyParams($args);
        return $this->runPage($request, $response, $args, "StatsMonthAdd");
    }

    // view
    public function view(Request $request, Response $response, array $args): Response
    {
        $args = $this->getKeyParams($args);
        return $this->runPage($request, $response, $args, "StatsMonthView");
    }

    // edit
    public function edit(Request $request, Response $response, array $args): Response
    {
        $args = $this->getKeyParams($args);
        return $this->runPage($request, $response, $args, "StatsMonthEdit");
    }

    // delete
    public function delete(Request $request, Response $response, array $args): Response
    {
        $args = $this->getKeyParams($args);
        return $this->runPage($request, $response, $args, "StatsMonthDelete");
    }

    protected function getKeyParams($args)
    {
        $sep = Container("stats_month")->RouteCompositeKeySeparator;
        if (array_key_exists("keys", $args)) {
            $keys = explode($sep, $args["keys"]);
            return count($keys) == 2 ? array_combine(["Year","Month"], $keys) : $args;
        }
        return $args;
    }
}
