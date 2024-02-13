<?php

namespace  App\Response;

class CustomResponse
{
    public function is201Response($response,$responseMessage)
    {
        $responseMessage = json_encode([
            "code"=>201,
            "success"=>true,
            "data"=>$responseMessage
        ]);
        $response->getBody()->write($responseMessage);
        return $response->withHeader("Content-Type","application/json")
                        ->withStatus(201);
    }
    public function is200Response($response,$responseMessage)
    {
        $responseMessage = json_encode([
            "code"=>200,
            "success"=>true,
            "data"=>$responseMessage
        ]);
        $response->getBody()->write($responseMessage);
        return $response->withHeader("Content-Type","application/json")
                        ->withStatus(200);
    }


    public function is400Response($response,$responseMessage)
    {
        $responseMessage = json_encode([
            "code"=>400,
            "success"=>false,
            "response"=>$responseMessage]);
        $response->getBody()->write($responseMessage);
        return $response->withHeader("Content-Type","application/json")
                        ->withStatus(400);
    }

    public function is422Response($response,$responseMessage)
    {
        $responseMessage = json_encode([
            "code"=>422,"success"=>true,
            "response"=>$responseMessage]);
        $response->getBody()->write($responseMessage);
        return $response->withHeader("Content-Type","application/json")
                        ->withStatus(422);
    } 
  public function is101Response($response,$responseMessage)
    {
        $responseMessage = json_encode([
            "code"=>101,
            "success"=>false,
            "response"=>$responseMessage]);
        $response->getBody()->write($responseMessage);
        return $response->withHeader("Content-Type","application/json")
            ->withStatus(101);
    }
}