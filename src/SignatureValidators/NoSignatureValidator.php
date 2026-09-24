<?php

namespace Lasselehtinen\MockingbirdWebhookClient\SignatureValidators;

use Illuminate\Http\Request;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookConfig;

final class NoSignatureValidator implements SignatureValidator
{
    public function isValid(
        Request $request,
        WebhookConfig $config
    ): bool {
        return true;
    }
}
