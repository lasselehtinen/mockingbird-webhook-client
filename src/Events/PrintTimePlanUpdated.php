<?php

namespace Lasselehtinen\MockingbirdWebhookClient\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use InvalidArgumentException;
use Lasselehtinen\MockingbirdWebhookClient\Contracts\MockingbirdWebhookEvent;
use Lasselehtinen\MockingbirdWebhookClient\Data\MockingbirdWebhookData;

final class PrintTimePlanUpdated implements MockingbirdWebhookEvent
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public readonly MockingbirdWebhookData $data
    ) {}

    public function webhook(): MockingbirdWebhookData
    {
        return $this->data;
    }

    public function editionId(): string
    {
        preg_match(
            '/([0-9a-f\-]{36})/',
            $this->data->entityId,
            $matches
        );

        return $matches[1];
    }

    public function printNumber(): int
    {
        $subject = $this->data->payload['subject'] ?? null;

        if (! is_string($subject)) {
            throw new InvalidArgumentException(
                'Webhook subject is missing.'
            );
        }

        preg_match(
            '#/printnumber/(\d+)$#',
            $subject,
            $matches
        );

        if (! isset($matches[1])) {
            throw new InvalidArgumentException(
                sprintf(
                    'Unable to determine print number from subject "%s".',
                    $subject
                )
            );
        }

        return (int) $matches[1];
    }

    public function gtin(): ?int
    {
        // Return GTIN if exists
        if (array_key_exists('Ean', $this->data->payload['data']) && ! empty($this->data->payload['data']['Ean'])) {
            return intval($this->data->payload['data']['Ean']);
        }

        return null;
    }
}
