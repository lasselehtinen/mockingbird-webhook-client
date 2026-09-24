<?php

namespace Lasselehtinen\MockingbirdWebhookClient;

use Illuminate\Support\Facades\Route;
use Lasselehtinen\MockingbirdWebhookClient\Jobs\ProcessMockingbirdWebhookJob;
use Lasselehtinen\MockingbirdWebhookClient\SignatureValidators\NoSignatureValidator;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\WebhookClient\Models\WebhookCall;
use Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile;
use Spatie\WebhookClient\WebhookResponse\DefaultRespondsTo;

class MockingbirdWebhookClientServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('mockingbird-webhook-client');
    }

    public function packageBooted(): void
    {
        $this->registerWebhookConfiguration();
        $this->registerWebhookRoute();
    }

    private function registerWebhookConfiguration(): void
    {
        config()->set('webhook-client.configs', [
            [
                'name' => 'mockingbird',
                'signing_secret' => '',
                'signature_header_name' => 'X-Mockingbird-Signature',
                'signature_validator' => NoSignatureValidator::class,
                'webhook_profile' => ProcessEverythingWebhookProfile::class,
                'webhook_response' => DefaultRespondsTo::class,
                'webhook_model' => WebhookCall::class,
                'store_headers' => [],
                'store_attachments' => false,
                'process_webhook_job' => ProcessMockingbirdWebhookJob::class,
            ],
        ]);
    }

    private function registerWebhookRoute(): void
    {
        Route::webhooks('webhooks/mockingbird', 'mockingbird');
    }
}
