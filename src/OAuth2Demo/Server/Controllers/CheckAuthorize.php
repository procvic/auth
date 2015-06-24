<?php

namespace OAuth2Demo\Server\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthorize
{
    public static function addRoutes($routing)
    {
        $routing->get('/check-authorize', array(new self(), 'checkAuthorize'))->bind('access');
    }

    public function checkAuthorize(Application $app)
    {
        $server = $app['oauth_server'];
        $response = $app['oauth_response'];
        if (!$server->verifyResourceRequest($app['request'], $response)) {
            $api_response = array(
                'is-authorize' => 'false'
            );
        } else {
            $api_response = array(
                'is-authorize' => 'true'
            );
        }
        return new Response(json_encode($api_response));
    }
}
