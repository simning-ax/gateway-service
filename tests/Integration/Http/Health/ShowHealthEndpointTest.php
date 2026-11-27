<?php

declare(strict_types=1);

namespace Tests\Integration\Http\Health;

use App\Config\ServiceRegistry;
use Slim\Psr7\Factory\ServerRequestFactory;
use Tests\Integration\BaseApiTestCases;

final class ShowHealthEndpointTest extends BaseApiTestCases {
    public function testReturns200() : void {
        $request = (new ServerRequestFactory())
            ->createServerRequest('GET', '/health');

        $response = $this->app->handle($request);

        self::assertSame(200, $response->getStatusCode());

        $payload = json_decode((string)$response->getBody(), true);

        self::assertIsArray($payload);

        self::assertArrayHasKey('data', $payload);

        self::assertIsArray($payload['data']);

        self::assertArrayHasKey('status', $payload['data']);

        self::assertArrayHasKey('service', $payload['data']);

        self::assertArrayHasKey('version', $payload['data']);

        self::assertArrayHasKey('services', $payload['data']);

        self::assertSame('gateway-service', $payload['data']['service']);

        self::assertContains(
            $payload['data']['status'],
            [
                'ok',
                'degraded',
                'down',
            ],
        );

        self::assertIsArray($payload['data']['services']);
    }

    public function testReturnsRegisteredServices() : void {
        $request = (new ServerRequestFactory())
            ->createServerRequest('GET', '/health');

        $response = $this->app->handle($request);

        $payload = json_decode((string)$response->getBody(), true);

        self::assertIsArray($payload);

        /** @var ServiceRegistry $registry */
        $registry = $this->app
            ->getContainer()
            ->get(ServiceRegistry::class);

        foreach (array_keys($registry->all()) as $service) {
            self::assertArrayHasKey($service, $payload['data']['services']);
        }
    }
}
