<?php

declare(strict_types=1);

namespace Tests\System\Http\Proxy;

use GuzzleHttp\Client;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class ProxyHealthEndpointTest extends TestCase {
    private const GATEWAY_BASE_URL = 'http://localhost:8080';

    /**
     * @return array<int, list<string>>
     */
    public static function services() : array {
        return [
            ['auth'],
            ['group'],
        ];
    }

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
