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

interface ResponseAsserter
{
    public function assertResponse(Response $response, int $code, string $expectedContent): void;

    public function assertHeader(Response $response): void;

    public function assertResponseCode(Response $response, int $code): void;

    public function assertResponseContent(Response $response, string $expectedContent): void;
}
