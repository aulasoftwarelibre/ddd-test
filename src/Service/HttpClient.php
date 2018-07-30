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

namespace AulaSoftwareLibre\DDD\TestsBundle\Service;

use Symfony\Component\HttpFoundation\Response;

interface HttpClient
{
    public function addHeader(string $key, string $value): void;

    public function delete(string $url, array $parameters = []): void;

    public function get(string $url, array $parameters = []): void;

    public function post(string $url, array $parameters = []): void;

    public function put(string $url, array $parameters = []): void;

    public function response(): Response;
}
