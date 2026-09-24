<?php

namespace Lasselehtinen\MockingbirdWebhookClient\Contracts;

use Lasselehtinen\MockingbirdWebhookClient\Data\MockingbirdWebhookData;

interface MockingbirdWebhookEvent
{
    public function webhook(): MockingbirdWebhookData;
}
