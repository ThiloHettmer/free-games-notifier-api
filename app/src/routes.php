<?php

use Offers\Epic;
use Slim\App as App;

return function (App $app)
{
    /**
     * Placeholder route until the grouping is fixed
     */
    $app->get('/api/offers/epic/all', function ($request, $response, $args) {
        $url = 'https://store-site-backend-static.ak.epicgames.com/freeGamesPromotions'; // TODO: as env variable
        $Epic = new Epic($url);
        $Epic->fetchData();
        $Epic->prepareData();
        $payload = json_encode($Epic->getOffers());
        $response->getBody()->write($payload);
        return $response;
    });

    /**
     * Api Route
     */
    /*
    $app->group('/api', function (App $app) // TODO: RouteCollectorProxy
    {
        $app->group('/offers', function (App $app) // TODO: RouteCollectorProxy
        {
            $app->group('epic', function (App $app) // TODO: RouteCollectorProxy
            {

                $app->get('/all', function (Request $request, Response $response, $args) {
                    $url = 'https://store-site-backend-static.ak.epicgames.com/freeGamesPromotions'; // TODO: as env variable
                    $Epic = new Epic($url);
                    $Epic->fetchData();
                    $Epic->prepareData();
                    $payload = json_encode($Epic->getOffers());
                    $response->getBody()->write($payload);
                    return $response;
                });
            });
        });
    });
    */
};
