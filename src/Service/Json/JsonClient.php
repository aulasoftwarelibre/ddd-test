<?php

declare(strict_types=1);

/*
 * This file is part of the `ddd-test` project.
 *
 * (c) Aula de Software Libre de la UCO <aulasoftwarelibre@uco.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AulaSoftwareLibre\DDD\TestsBundle\Service\Json;

use AulaSoftwareLibre\DDD\TestsBundle\Service\HttpClient;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

class JsonClient implements HttpClient
{
    private const CONTENT_TYPE = 'application/ld+json';
    private const ACCEPT = 'application/json';

    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $headers;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->headers = [
            'CONTENT_TYPE' => self::CONTENT_TYPE,
            'HTTP_ACCEPT' => self::ACCEPT,
        ];
    }

    public function addHeader(string $key, string $value): void
    {
        $this->headers[$key] = $value;
    }

    public function delete(string $url, array $parameters = []): void
    {
        $this->client->restart();
        $this->client->request(Request::METHOD_DELETE, $url, $parameters, [], $this->headers);
    }

    public function get(string $url, array $parameters = []): void
    {
        $this->client->restart();
        $this->client->request(Request::METHOD_GET, $url, $parameters, [], $this->headers);
    }

    public function post(string $url, array $parameters = [], array $content = []): void
    {
        $this->client->restart();
        $this->client->request(Request::METHOD_POST, $url, $parameters, [], $this->headers, json_encode($content));
    }

    public function put(string $url, array $parameters = [], array $content = []): void
    {
        $this->client->restart();
        $this->client->request(Request::METHOD_PUT, $url, $parameters, [], $this->headers, json_encode($content));
    }

    public function response(): Response
    {
        $response = $this->client->getResponse();

        Assert::isInstanceOf($response, Response::class);

        return $response;
    }
}
