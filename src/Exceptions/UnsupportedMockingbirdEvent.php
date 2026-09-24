<?php

namespace Lasselehtinen\MockingbirdWebhookClient\Exceptions;

use RuntimeException;

final class UnsupportedMockingbirdEvent extends RuntimeException
{
    public static function forType(string $eventType): self
    {
        return new self(
            sprintf(
                'Unsupported Mockingbird event type "%s".',
                $eventType
            )
        );
    }
}
