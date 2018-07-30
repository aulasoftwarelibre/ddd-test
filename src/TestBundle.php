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

namespace AulaSoftwareLibre\DDD\TestsBundle;

use AulaSoftwareLibre\DDD\TestsBundle\DependencyInjection\TestExtension;
use Symfony\Component\Console\Application;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class TestBundle extends Bundle
{
    public function registerCommands(Application $application)
    {
        return [];
    }

    public function getContainerExtension()
    {
        return new TestExtension();
    }
}
