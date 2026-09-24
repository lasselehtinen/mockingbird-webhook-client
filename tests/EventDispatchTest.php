<?php

use Lasselehtinen\MockingbirdWebhookClient\Data\MockingbirdWebhookData;
use Lasselehtinen\MockingbirdWebhookClient\Events\EditionUpdated;
use Lasselehtinen\MockingbirdWebhookClient\Exceptions\UnsupportedMockingbirdEvent;
use Lasselehtinen\MockingbirdWebhookClient\Support\MockingbirdEventFactory;

it('creates product updated event', function () {

    config()->set('mockingbird-webhook-client.events', [
        'product.changed.v1' => EditionUpdated::class,
    ]);

    $factory = app(MockingbirdEventFactory::class);

    $event = $factory->make(
        new MockingbirdWebhookData(
            eventType: 'product.changed.v1',
            specVersion: '1.0',
            entityId: 'e79f7e2e-e7b9-449c-85f1-cbc59e8a818f',
            deliveryId: '4e81512a-4f09-4c67-b9d1-b727e0a85d17',
            occurredAt: now()->toImmutable(),
            payload: [],
        )
    );

    expect($event)
        ->toBeInstanceOf(EditionUpdated::class);
});

it('throws exception for unknown event type', function () {
    $data = new MockingbirdWebhookData(
        eventType: 'foobar.changed.v1',
        specVersion: '1.0',
        entityId: 'foobar/12345',
        deliveryId: 'test-delivery-id',
        occurredAt: now()->toImmutable(),
        payload: [],
    );

    app(MockingbirdEventFactory::class)->make($data);

})->throws(UnsupportedMockingbirdEvent::class, 'Unsupported Mockingbird event type "foobar.changed.v1".'
);
