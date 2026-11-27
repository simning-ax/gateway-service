<?php

declare(strict_types=1);

namespace Tests\Integration\System\Http\Proxy;

use GuzzleHttp\Client;
use PHPUnit\Framework\Attributes\DataProvider;

final class ProxyDocsEndpointTest extends SystemEndpointTestCases {

    #[DataProvider('services')]
    public function testAllServicesExposeDocsEndpoint(string $service):void {
        $client = new Client();

        $response = $client->request(
            'GET',
            sprintf(
                '%s/%s/docs',
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
