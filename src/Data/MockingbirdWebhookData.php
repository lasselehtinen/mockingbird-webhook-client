<?php

declare(strict_types=1);

namespace Lasselehtinen\MockingbirdWebhookClient\Data;

use Carbon\CarbonImmutable;
use Lasselehtinen\MockingbirdWebhookClient\Exceptions\InvalidMockingbirdWebhook;

final readonly class MockingbirdWebhookData
{
    public function __construct(
        public string $eventType,
        public string $specVersion,
        public string $entityId,
        public string $deliveryId,
        public CarbonImmutable $occurredAt,
        public array $payload,
    ) {}

    public static function fromPayload(array $payload): self
    {
        $eventType = $payload['type'] ?? null;
        $specVersion = $payload['specversion'] ?? null;
        $entityId = $payload['subject'] ?? null;
        $deliveryId = $payload['id'] ?? null;
        $occurredAt = $payload['time'] ?? null;

        if (! is_string($eventType) || $eventType === '') {
            throw InvalidMockingbirdWebhook::missingField('eventType');
        }

        if (! is_string($specVersion) || $specVersion === '') {
            throw InvalidMockingbirdWebhook::missingField('specVersion');
        }

        if (! is_string($entityId) || $entityId === '') {
            throw InvalidMockingbirdWebhook::missingField('entityId');
        }

        if (! is_string($deliveryId) || $deliveryId === '') {
            throw InvalidMockingbirdWebhook::missingField('deliveryId');
        }

        if (! is_string($occurredAt) || $occurredAt === '') {
            throw InvalidMockingbirdWebhook::missingField('occurredAt');
        }

        try {
            $occurredAt = CarbonImmutable::parse($occurredAt);
        } catch (\Throwable) {
            throw InvalidMockingbirdWebhook::invalidFieldType(
                'occurredAt',
                'ISO-8601 datetime',
                $occurredAt
            );
        }

        return new self(
            eventType: $eventType,
            specVersion: $specVersion,
            entityId: $entityId,
            deliveryId: $deliveryId,
            occurredAt: $occurredAt,
            payload: $payload,
        );
    }
}
