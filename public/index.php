<?php
require_once '../vendor/autoload.php';

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

try
{
    $containerBuilder = new ContainerBuilder();

    $loader = new \Symfony\Component\DependencyInjection\Loader\YamlFileLoader($containerBuilder, new FileLocator(__DIR__));
    $loader->load('../config/services.yaml');

    $fileLocator = new FileLocator(array(__DIR__));
    $loader = new YamlFileLoader($fileLocator);
    $routes = $loader->load('../config/routes.yaml');
    $request = Request::createFromGlobals();

    $context = new RequestContext();
    $context->fromRequest($request);

    $matcher = new UrlMatcher($routes, $context);

    $parameters = $matcher->match($context->getPathInfo());

    $controller = $containerBuilder->get(explode('::', $parameters['controller'])[0]);
    $method     = explode('::', $parameters['controller'])[1];


    try {
        $response  = $controller->$method($request);
        header('Content-Type: '.$response->getContentType());
        header('Access-Control-Allow-Origin: *');
        print json_encode($response->getBody());

    } catch (Exception $e) {
        $response = ['error' => $e->getMessage()];
        header(
            'Content-Type: '.'application/json',
            true,
            Response::HTTP_BAD_REQUEST
        );
        header('Access-Control-Allow-Origin');
        echo json_encode($response);
    }
    exit;
}
catch (ResourceNotFoundException $e)
{
    echo $e->getMessage();
}