<?php
use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Routing\RouteContext;
use Tuupola\Middleware\CorsMiddleware;

return function (App $app)
{
  $app->getContainer()->get('settings');
  $app->add(
      new \Tuupola\Middleware\JwtAuthentication([
          "secure" => false,
          "attribute" => "jwt",
          "ignore"=>[
                "/api/auth/login",
            ],
          "secret"=>\App\Interfaces\SecretKeyInterface::JWT_SECRET_KEY,
          "error"=>function($response,$arguments)
          {
              $data["success"] = false;
              $data["response"]=$arguments["message"];
              $data["status_code"]= "401";

              return $response->withHeader("Content-type","application/json")
                  ->getBody()->write(json_encode($data,JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ));
          }
      ])
  );

  $app->addBodyParsingMiddleware();

  //$app->add(new Tuupola\Middleware\CorsMiddleware);
/*   $app->add(new Tuupola\Middleware\CorsMiddleware([
    "origin" => ["*"],
    "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
    "headers.allow" => [],
    "headers.expose" => [],
    "credentials" => false,
    "cache" => 0,
]));
 */
$app->add(new Tuupola\Middleware\CorsMiddleware([
    "origin" => ["*"],
    "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
    "headers.allow" => ["Authorization", "If-Match", "If-Unmodified-Since"],
    "headers.expose" => ["Etag"],
    "credentials" => true,
    "cache" => 86400
]));
// This middleware will append the response header Access-Control-Allow-Methods with all allowed methods
$app->add(function (Request $request, RequestHandlerInterface $handler): Response {
    $routeContext = RouteContext::fromRequest($request);
    $routingResults = $routeContext->getRoutingResults();
    $methods = $routingResults->getAllowedMethods();
    $requestHeaders = $request->getHeaderLine('Access-Control-Request-Headers');

    $response = $handler->handle($request);

    $response = $response->withHeader('Access-Control-Allow-Origin','*');
    $response = $response->withHeader('Access-Control-Allow-Methods', implode(',', $methods));
    $response = $response->withHeader('Access-Control-Allow-Headers', $requestHeaders);
    $response = $response->withHeader('Access-Control-Allow-Credentials', 'true');

    return $response;
});
 
/*  $app->add(function ($request, $handler) {
            $resp = $handler->handle($request);
            return $resp
                    ->withHeader('Access-Control-Allow-Origin', '*','http://localhost:3000')
                    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Access-Control-Request-Method, Accept, Origin, Authorization')
                    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
                    ->withHeader('Allow', 'GET, POST, PUT, DELETE,OPTIONS')
                    ->withHeader('Access-Control-Max-Age', '3600')
                    ->withHeader('Content-type', 'application/json, charset=utf-8');
        }); */

  $app->addRoutingMiddleware();
  $app->addErrorMiddleware(true,true,true);
};