<?php

use Doctrine\Common\Cache\ArrayCache;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\DoctrineCacheStorage;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;

require dirname(__DIR__) . '/vendor/autoload.php';

$stack = HandlerStack::create();

// Add this middleware to the top with `push`
$stack->push(new CacheMiddleware(
    new PrivateCacheStrategy(
        new DoctrineCacheStorage(
            new ArrayCache()
        )
    )
), 'cache');

// Initialize the client with the handler option
$client = new Client(['handler' => $stack]);
$client->
request($client);
request($client);
sleep(2);
request($client);
request($client);

function request(Client $client)
{
    $t = microtime(true);
// Create default HandlerStack
    $response = $client->get('http://127.0.0.1:8080/');
    $headers = $response->getHeaders();
    $headersString = '';
    foreach ($headers as $key => $header) {
        $headersString .= sprintf("%s: %s\n", $key, $header[0]);
    }
    $body = $response->getBody();
    printf("\n%s\n%s\n%s\ntime(msec): %f\n", $response->getStatusCode(), $headersString, $body, (microtime(true) - $t) * 1000);
}
