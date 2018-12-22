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

namespace AulaSoftwareLibre\DDD\TestsBundle\Service\Messenger\Middleware;

use AulaSoftwareLibre\DDD\TestsBundle\Service\Prooph\Plugin\CollectedMessage;
use AulaSoftwareLibre\DDD\TestsBundle\Service\Prooph\Plugin\EventsRecorder;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Prooph\Common\Messaging\DomainEvent;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

final class EventCollectorMiddleware implements MiddlewareInterface, EventsRecorder
{
    /** @var Collection */
    private $messages;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $envelope->getMessage();

        $envelope = $stack->next()->handle($envelope, $stack);

        if ($message instanceof DomainEvent) {
            $this->messages->add(new CollectedMessage(
                $message,
                true
            ));
        }

        return $envelope;
    }

    public function getLastMessage(): ?CollectedMessage
    {
        return $this->messages->last() ?? null;
    }

    public function getAllMessages(): Collection
    {
        return $this->messages;
    }
}
