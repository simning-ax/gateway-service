<?php

declare(strict_types=1);

namespace Tests\Integration\System\Http\Proxy;

use PHPUnit\Framework\Attributes\DataProvider;
use Slim\Psr7\Factory\ServerRequestFactory;
use Tests\Integration\BaseApiTestCases;

final class ProxyEndpointTest extends BaseApiTestCases {
    #[DataProvider('endpointProvider')]
    public function testEndpoints(
        string $method,
        string $endpoint,
        int $expectedStatusCode,
    ) : void {
        $request = (new ServerRequestFactory())
            ->createServerRequest(
                $method,
                $endpoint,
            );

        $response = $this->app->handle($request);

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
            'group levels' => ['GET', '/groups/group-levels', 200, ],

            // Exempel på skyddad endpoint
            'list users requires authentication' => ['GET', '/auth/users', 401, ],

            // Lägg till fler endpoints här efter hand
        ];
    }
}
