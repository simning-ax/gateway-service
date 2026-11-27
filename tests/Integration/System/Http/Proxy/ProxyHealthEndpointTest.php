<?php

declare(strict_types=1);

namespace Tests\System\Http\Proxy;

use GuzzleHttp\Client;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Integration\System\Http\Proxy\SystemEndpointTestCases;

final class ProxyHealthEndpointTest extends SystemEndpointTestCases {
    #[DataProvider('services')]
    public function testAllServicesExposeHealthEndpoint(string $service) : void {
        $client = new Client();

        $response = $client->request(
            'GET',
            sprintf(
                '%s/%s/health',
                self::GATEWAY_BASE_URL,
                $service,
            ),
        );

        self::assertSame(
            200,
            $response->getStatusCode(),
            sprintf(
                'Health endpoint failed for service "%s"',
                $service,
            ),
        );
    }
}
