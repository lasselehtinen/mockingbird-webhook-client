<?php

namespace Lasselehtinen\MockingbirdWebhookClient\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Lasselehtinen\MockingbirdWebhookClient\Contracts\MockingbirdWebhookEvent;
use Lasselehtinen\MockingbirdWebhookClient\Data\MockingbirdWebhookData;

final class EditionUpdated implements MockingbirdWebhookEvent
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
        // Return everything after product/ or productId/
        return substr($this->data->entityId, ($pos = strpos($this->data->entityId, '/')) === false ? 0 : $pos + 1);
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
