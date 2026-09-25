[![Latest Version on Packagist](https://img.shields.io/packagist/v/lasselehtinen/mockingbird-webhook-client.svg?style=flat-square)](https://packagist.org/packages/lasselehtinen/mockingbird-webhook-client)
[![run-tests](https://github.com/lasselehtinen/mockingbird-webhook-client/actions/workflows/run-tests.yml/badge.svg)](https://github.com/lasselehtinen/mockingbird-webhook-client/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/lasselehtinen/mockingbird-webhook-client.svg?style=flat-square)](https://packagist.org/packages/lasselehtinen/mockingbird-webhook-client)

# Mockingbird Webhook Client

This package receives Mockingbird webhooks and convert them into strongly typed Laravel events. Applications consume normal Laravel events and do not need to interact with raw webhook requests.

The package is built on top of `spatie/laravel-webhook-client` and provides:

- Webhook endpoint registration
- Payload parsing
- Event mapping
- Laravel event dispatching

---

# Installation

```bash
composer require lasselehtinen/mockingbird-webhook-client
php artisan vendor:publish --tag="webhook-client-migrations"
php artisan migrate
```
---

# Workflow

The package processes webhooks using the following flow:

```text
Mockingbird
    ▼
POST /webhooks/mockingbird
    ▼
Spatie Webhook Controller
    ▼
WebhookCall persisted
    ▼
ProcessMockingbirdWebhookJob
    ▼
MockingbirdWebhookData DTO
    ▼
MockingbirdEventFactory
    ▼
Laravel Event
    ▼
Application Event Listener
```

---

# Supported Event Types

Mockingbird event types are mapped to Laravel events.

- AssetUpdated
- EditionUpdated
- ContactUpdated
- EditionContributorsUpdated
- EditionPriceUpdated
- EditionTextsUpdated
- PrintTimePlanUpdated

---

# Webhook Endpoint

The package automatically registers:

```text
POST /webhooks/mockingbird
```

Incoming requests are validated, stored and processed asynchronously.

---
# Example usage

```php
<?php

namespace App\Providers;

use App\Listeners\UpdateOnixMessage;
use App\Listeners\SyncContributorData;
use App\Listeners\UpdateMetadataInExternalAssetManagement;
use Lasselehtinen\MockingbirdWebhookClient\Events\AssetUpdated;
use Lasselehtinen\MockingbirdWebhookClient\Events\EditionContributorsUpdated;
use Lasselehtinen\MockingbirdWebhookClient\Events\EditionUpdated;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [

        EditionUpdated::class => [
            UpdateOnixMessage::class,
        ],

        EditionContributorsUpdated::class => [
            SyncContributorData::class,
        ],

        AssetUpdated::class => [
            UpdateMetadataInExternalAssetManagement::class,
        ],
    ];
}
```
---

# Data Transfer Object

Every webhook is converted into a `MockingbirdWebhookData` DTO.

```php
final readonly class MockingbirdWebhookData
{
    public string $eventType;
    public string $specVersion;
    public string $entityId;
    public string $deliveryId;
    public CarbonImmutable $occurredAt;
    public array $payload
}
```
## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Lasse Lehtinen](https://github.com/lasselehtinen)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
