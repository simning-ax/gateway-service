<?php

declare(strict_types=1);

namespace Tests\Integration\System\Http\Proxy;

use GuzzleHttp\Client;
use PHPUnit\Framework\Attributes\DataProvider;
use Slim\Psr7\Factory\ServerRequestFactory;
use Tests\Integration\BaseApiTestCases;

final class ProxyEndpointTest extends SystemEndpointTestCases {
    #[DataProvider('endpointProvider')]
    public function testEndpoints(
        string $method,
        string $endpoint,
        int $expectedStatusCode,
    ) : void {
        $client = new Client();

        $response = $client->request(
            $method,
            sprintf(
                '%s%s',
                self::GATEWAY_BASE_URL,
                $endpoint,
            ),
        );

        self::assertSame(
            $expectedStatusCode,
            $response->getStatusCode(),
            sprintf(
                '%s %s returned unexpected status code',
                $method,
                $endpoint,
            ),
        );
    }

    /**
     * @return array<string,array{0:string,1:string,2:int}>
     */
    public static function endpointProvider() : array {
        return [
            'auth users' => ['GET', '/auth/users', 200, ],
            'group levels' => ['GET', '/group/group-levels', 200, ],
            'time users' => ['GET', '/time/users', 200, ],

            // Exempel på skyddad endpoint
//            'list users requires authentication' => ['GET', '/time/users', 401, ],

            // Lägg till fler endpoints här efter hand
        ];
    }
}
