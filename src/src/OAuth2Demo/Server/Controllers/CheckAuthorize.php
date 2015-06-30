<?php

namespace OAuth2Demo\Server\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthorize
{
    public static function addRoutes($routing)
    {
        $routing->get('/authorize', array(new self(), 'checkAuthorize'))->bind('access');
    }

    public function checkAuthorize(Application $app)
    {
        $server = $app['oauth_server'];
        $response = $app['oauth_response'];
        $api_response = array(
            'is-authorize' => $server->verifyResourceRequest($app['request'], $response),
        );
        return new Response(json_encode($api_response));
    }
}
