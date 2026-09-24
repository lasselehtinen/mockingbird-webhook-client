<?php

namespace Lasselehtinen\MockingbirdWebhookClient\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Lasselehtinen\MockingbirdWebhookClient\Contracts\MockingbirdWebhookEvent;
use Lasselehtinen\MockingbirdWebhookClient\Data\MockingbirdWebhookData;

final class ContactUpdated implements MockingbirdWebhookEvent
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

    public function contactId(): string
    {
        return str_replace('contactId/', '', $this->data->entityId);
    }
}
