<?php

namespace Lasselehtinen\MockingbirdWebhookClient\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Lasselehtinen\MockingbirdWebhookClient\MockingbirdWebhookClientServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\WebhookClient\WebhookClientServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        if (! Schema::hasTable('webhook_calls')) {
            Schema::create('webhook_calls', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamps();
                $table->string('name');
                $table->string('url', 512);
                $table->json('headers')->nullable();
                $table->json('payload')->nullable();
                $table->json('attachments')->nullable();
                $table->text('exception')->nullable();
            });
        }

    }

    protected function getPackageProviders($app)
    {
        return [
            WebhookClientServiceProvider::class,
            MockingbirdWebhookClientServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
         foreach (\Illuminate\Support\Facades\File::allFiles(__DIR__ . '/../database/migrations') as $migration) {
            (include $migration->getRealPath())->up();
         }
         */

    }
}
