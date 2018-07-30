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

use AulaSoftwareLibre\DDD\TestsBundle\Service\ResponseAsserter;
use Coduo\PHPMatcher\Factory\SimpleFactory;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

class JsonResponseAsserter implements ResponseAsserter
{
    /**
     * @var \Coduo\PHPMatcher\Matcher
     */
    private $matcher;

    public function __construct()
    {
        $this->matcher = (new SimpleFactory())->createMatcher();
    }

    public function assertResponse(Response $response, int $code, string $expectedContent): void
    {
        $this->assertHeader($response);
        $this->assertResponseCode($response, $code);
        $this->assertResponseContent($response, $expectedContent);
    }

    public function assertHeader(Response $response): void
    {
        $responseHeaderBag = $response->headers;

        Assert::contains(
            $contentType = $responseHeaderBag->get('content-type'),
            'application/json',
            sprintf(
                'Expected response content-type header was \'application/json\'. Got: %s',
                $contentType
            )
        );
    }

    public function assertResponseCode(Response $response, int $code): void
    {
        $responseCode = $response->getStatusCode();

        Assert::same($code, $responseCode, sprintf(
            'Expected code %s number("%s"), but %s("%s") received',
            $code,
            Response::$statusTexts[$code],
            $responseCode,
            Response::$statusTexts[$responseCode]
        ));
    }

    public function assertResponseContent(Response $response, string $expectedContent): void
    {
        $result = $this->matcher->match($response->getContent(), $expectedContent);

        if (!$result) {
            $diff = new \Diff(explode(PHP_EOL, $expectedContent), explode(PHP_EOL, $response->getContent()), []);

            throw new \InvalidArgumentException($diff->render(new \Diff_Renderer_Text_Unified()));
        }
    }
}
