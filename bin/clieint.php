<?php
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Kevinrob\GuzzleCache\CacheMiddleware;

require dirname(__DIR__) . '/vendor/autoload.php';

request();
request();

function request()
{
// Create default HandlerStack
    $stack = HandlerStack::create();

// Add this middleware to the top with `push`
    $stack->push(new CacheMiddleware(), 'cache');

// Initialize the client with the handler option
    $client = new Client(['handler' => $stack]);
    $response = $client->get('http://127.0.0.1:8080/');
    $headers = $response->getHeaders();
    $headersString = '';
    foreach ($headers as $key => $header) {
        $headersString .= sprintf("%s: %s\n", $key, $header[0]);
    }
    printf("Code:%s\nHeaders:\n%s", $response->getStatusCode(), $headersString);
}
