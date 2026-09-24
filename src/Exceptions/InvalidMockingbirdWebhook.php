<?php

namespace Lasselehtinen\MockingbirdWebhookClient\Exceptions;

use InvalidArgumentException;

final class InvalidMockingbirdWebhook extends InvalidArgumentException
{
    public static function missingField(string $field): self
    {
        return new self(
            sprintf(
                'Mockingbird webhook is missing required field "%s".',
                $field
            )
        );
    }

    public static function invalidFieldType(
        string $field,
        string $expectedType,
        mixed $actualValue
    ): self {
        return new self(
            sprintf(
                'Mockingbird webhook field "%s" must be of type "%s", got "%s".',
                $field,
                $expectedType,
                get_debug_type($actualValue)
            )
        );
    }

    public static function invalidPayload(
        string $reason
    ): self {
        return new self(
            sprintf(
                'Invalid Mockingbird webhook payload: %s.',
                $reason
            )
        );
    }
}
