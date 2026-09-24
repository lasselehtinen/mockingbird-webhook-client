<?php

namespace Lasselehtinen\MockingbirdWebhookClient\Support;

use Illuminate\Contracts\Container\Container;
use Lasselehtinen\MockingbirdWebhookClient\Contracts\MockingbirdWebhookEvent;
use Lasselehtinen\MockingbirdWebhookClient\Data\MockingbirdWebhookData;
use Lasselehtinen\MockingbirdWebhookClient\Events\AssetUpdated;
use Lasselehtinen\MockingbirdWebhookClient\Events\ContactUpdated;
use Lasselehtinen\MockingbirdWebhookClient\Events\EditionContributorsUpdated;
use Lasselehtinen\MockingbirdWebhookClient\Events\EditionPriceUpdated;
use Lasselehtinen\MockingbirdWebhookClient\Events\EditionTextsUpdated;
use Lasselehtinen\MockingbirdWebhookClient\Events\EditionUpdated;
use Lasselehtinen\MockingbirdWebhookClient\Events\PrintTimePlanUpdated;
use Lasselehtinen\MockingbirdWebhookClient\Exceptions\UnsupportedMockingbirdEvent;

final class MockingbirdEventFactory
{
    /**
     * TODO:
     *
     * Bundle
     * PrintDeforestationRegulation
     * Education
     * DeliverySpecification
     * DeliverySpecificationDelete
     * SeriesTree
     */
    private const EVENT_MAP = [
        'asset.changed.v1' => AssetUpdated::class,
        'product.changed.v1' => EditionUpdated::class,
        'contact.changed.v1' => ContactUpdated::class,
        'product.contributors.changed.v1' => EditionContributorsUpdated::class,
        'product.price.changed.v1' => EditionPriceUpdated::class,
        'product.texts.changed.v1' => EditionTextsUpdated::class,
        'product.timeplan.changed.v1' => PrintTimePlanUpdated::class,
    ];

    public function __construct(private readonly Container $container) {}

    public function make(MockingbirdWebhookData $data): MockingbirdWebhookEvent
    {
        $eventClass = self::EVENT_MAP[$data->eventType] ?? throw UnsupportedMockingbirdEvent::forType($data->eventType);

        return $this->container->make(
            $eventClass,
            ['data' => $data]
        );
    }
}
