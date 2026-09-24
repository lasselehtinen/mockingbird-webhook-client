<?php

use Illuminate\Support\Facades\Event;
use Lasselehtinen\MockingbirdWebhookClient\Events\EditionUpdated;
use Spatie\WebhookClient\Models\WebhookCall;

it('dispatches edition updated event from incoming webhook', function () {
    config()->set('queue.default', 'sync');
    Event::fake();

    $payload = json_decode(file_get_contents(__DIR__.'/Fixtures/edition-updated.json'), true, flags: JSON_THROW_ON_ERROR);
    $response = $this->postJson('/webhooks/mockingbird', $payload);
    $response->assertSuccessful();

    $webhookCall = WebhookCall::query()->sole();

    expect($webhookCall->name)->toBe('mockingbird');
    expect($webhookCall->payload)->toMatchArray($payload);

    Event::assertDispatched(EditionUpdated::class);
    Event::assertDispatched(
        EditionUpdated::class,
        function (EditionUpdated $event): bool {
            expect($event->data->eventType)->toBe('product.changed.v1');
            expect($event->data->specVersion)->toBe('1.0');
            expect($event->data->entityId)->toBe('productid/e79f7e2e-e7b9-449c-85f1-cbc59e8a818f');
            expect($event->data->deliveryId)->toBe('4e81512a-4f09-4c67-b9d1-b727e0a85d17');
            expect($event->data->occurredAt->toDateTimeString())->toBe('2026-09-23 10:12:38');

            return true;
        }
    );
});
