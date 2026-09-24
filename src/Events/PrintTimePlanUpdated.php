<?php

namespace Lasselehtinen\MockingbirdWebhookClient\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
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
        // Remove productid and print number
        $editionId = str_replace('productid/', '', $this->data->entityId);

        return substr($editionId, 0, strpos($editionId, '/'));
    }

    public function printNumber(): int
    {
        return intval(substr($this->data->entityId, strrpos($this->data->entityId, '/') + 1));
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
