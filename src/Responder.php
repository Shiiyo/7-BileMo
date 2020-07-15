<?php

namespace App;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Responder
{
    public function createReponse(Request $request, $data, $httpCode)
    {
        $response = new JsonResponse($data, $httpCode, [], true);
        $response->setEncodingOptions(JSON_UNESCAPED_SLASHES);
        
        if ($request->isMethodCacheable()){
            $response->setEtag(md5($response->getContent()));
            $response->setPublic();
            $response->setMaxAge(3500);
            $response->isNotModified($request);
        }
        return $response;
    }
}