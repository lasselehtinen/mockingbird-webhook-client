<?php

namespace Lasselehtinen\MockingbirdWebhookClient\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Lasselehtinen\MockingbirdWebhookClient\MockingbirdWebhookClient
 */
class MockingbirdWebhookClient extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Lasselehtinen\MockingbirdWebhookClient\MockingbirdWebhookClient::class;
    }
}
