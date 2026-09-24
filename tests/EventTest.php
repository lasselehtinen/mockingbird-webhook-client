<?php

use Lasselehtinen\MockingbirdWebhookClient\Data\MockingbirdWebhookData;
use Lasselehtinen\MockingbirdWebhookClient\Events\AssetUpdated;
use Lasselehtinen\MockingbirdWebhookClient\Events\ContactUpdated;
use Lasselehtinen\MockingbirdWebhookClient\Events\DistributionRulesUpdated;
use Lasselehtinen\MockingbirdWebhookClient\Events\EditionContributorsUpdated;
use Lasselehtinen\MockingbirdWebhookClient\Events\EditionPriceUpdated;
use Lasselehtinen\MockingbirdWebhookClient\Events\EditionTextsUpdated;
use Lasselehtinen\MockingbirdWebhookClient\Events\EditionUpdated;
use Lasselehtinen\MockingbirdWebhookClient\Events\PrintTimePlanUpdated;

it('edition event returns the edition id', function () {
    $data = new MockingbirdWebhookData(
        eventType: 'product.changed.v1',
        specVersion: '1.0',
        entityId: 'product/e79f7e2e-e7b9-449c-85f1-cbc59e8a818f',
        deliveryId: '4e81512a-4f09-4c67-b9d1-b727e0a85d17',
        occurredAt: now()->toImmutable(),
        payload: [],
    );

    $event = new EditionUpdated($data);

    expect($event->editionId())->toBe('e79f7e2e-e7b9-449c-85f1-cbc59e8a818f');

    expect($event->webhook())
        ->toBe($data);
});

it('contact event returns the contact id', function () {
    $data = new MockingbirdWebhookData(
        eventType: 'contact.changed.v1',
        specVersion: '1.0',
        entityId: 'contactId/77060',
        deliveryId: '4e81512a-4f09-4c67-b9d1-b727e0a85d17',
        occurredAt: now()->toImmutable(),
        payload: [],
    );

    $event = new ContactUpdated($data);

    expect($event->contactId())->toBe('77060');

    expect($event->webhook())
        ->toBe($data);
});

it('asset event returns the asset id', function () {
    $data = new MockingbirdWebhookData(
        eventType: 'asset.changed.v1',
        specVersion: '1.0',
        entityId: 'asset/df3de068-1e81-48ed-9708-e6c211d16fde',
        deliveryId: '26f5731c-1398-49de-9f2f-ad013ae9ed8b',
        occurredAt: now()->toImmutable(),
        payload: [],
    );

    $event = new AssetUpdated($data);

    expect($event->assetId())->toBe('df3de068-1e81-48ed-9708-e6c211d16fde');

    expect($event->webhook())
        ->toBe($data);
});

it('edition contributors event returns the edition id', function () {
    $data = new MockingbirdWebhookData(
        eventType: 'product.contributors.changed.v1',
        specVersion: '1.0',
        entityId: 'productid/b934c51d-a6cf-4f76-a14f-08df15788b53',
        deliveryId: '50a8cca2-8e3a-40de-b0e8-a102ca544844',
        occurredAt: now()->toImmutable(),
        payload: [],
    );

    $event = new EditionContributorsUpdated($data);

    expect($event->editionId())->toBe('b934c51d-a6cf-4f76-a14f-08df15788b53');

    expect($event->webhook())
        ->toBe($data);
});

it('distribution rules event returns the edition id', function () {
    $data = new MockingbirdWebhookData(
        eventType: 'distributionrules.changed.v1',
        specVersion: '1.0',
        entityId: 'productid/f27ce5c3-4ccf-4687-868f-c209fab4768e',
        deliveryId: '0587efa5-1123-46bf-9d5a-d2ca04893f26',
        occurredAt: now()->toImmutable(),
        payload: [],
    );

    $event = new DistributionRulesUpdated($data);

    expect($event->editionId())->toBe('f27ce5c3-4ccf-4687-868f-c209fab4768e');

    expect($event->webhook())
        ->toBe($data);
});

it('edition price event returns the edition id', function () {
    $data = new MockingbirdWebhookData(
        eventType: 'product.price.changed.v1',
        specVersion: '1.0',
        entityId: 'productid/713cf580-2e29-4877-829b-76fc4636c649',
        deliveryId: '7fdfaa2a-87ec-4ac1-afb9-9ddbaad2aca9',
        occurredAt: now()->toImmutable(),
        payload: [],
    );

    $event = new EditionPriceUpdated($data);

    expect($event->editionId())->toBe('713cf580-2e29-4877-829b-76fc4636c649');

    expect($event->webhook())
        ->toBe($data);
});

it('edition texts event returns the edition id', function () {
    $data = new MockingbirdWebhookData(
        eventType: 'product.texts.changed.v1',
        specVersion: '1.0',
        entityId: 'productid/63a4b719-efc6-46f5-a6ce-08de8a5150d4',
        deliveryId: '5c246117-f3ce-485b-8d9e-19880add7482',
        occurredAt: now()->toImmutable(),
        payload: [],
    );

    $event = new EditionTextsUpdated($data);

    expect($event->editionId())->toBe('63a4b719-efc6-46f5-a6ce-08de8a5150d4');

    expect($event->webhook())
        ->toBe($data);
});

it('print time plan event returns the edition id', function () {
    $data = new MockingbirdWebhookData(
        eventType: 'product.timeplan.changed.v1',
        specVersion: '1.0',
        entityId: 'productid/a20e7e91-e898-425e-a2af-e1f98cb53d2a/printnumber/2',
        deliveryId: '5c246117-f3ce-485b-8d9e-19880add7482',
        occurredAt: now()->toImmutable(),
        payload: [],
    );

    $event = new PrintTimePlanUpdated($data);

    expect($event->editionId())->toBe('a20e7e91-e898-425e-a2af-e1f98cb53d2a');
    expect($event->printNumber())->toBe(2);

    expect($event->webhook())
        ->toBe($data);
});

it('returns the edition gtin if exists', function () {
    $data = new MockingbirdWebhookData(
        eventType: 'product.changed.v1',
        specVersion: '1.0',
        entityId: 'product/e79f7e2e-e7b9-449c-85f1-cbc59e8a818f',
        deliveryId: '4e81512a-4f09-4c67-b9d1-b727e0a85d17',
        occurredAt: now()->toImmutable(),
        payload: ['data' => ['Ean' => '9789524033480']],
    );

    $event = new EditionUpdated($data);

    expect($event->editionId())->toBe('e79f7e2e-e7b9-449c-85f1-cbc59e8a818f');
    expect($event->gtin())->toBeInt()->toBe(9789524033480);

    expect($event->webhook())
        ->toBe($data);
});
