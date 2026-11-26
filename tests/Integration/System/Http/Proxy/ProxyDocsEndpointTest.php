<?php

declare(strict_types=1);

namespace Tests\Integration\System\Http\Proxy;

use App\Config\ServiceRegistry;
use Slim\Psr7\Factory\ServerRequestFactory;
use Tests\Integration\BaseApiTestCases;

final class ProxyDocsEndpointTest extends BaseApiTestCases {
    public function testAllServicesExposeDocsEndpoint() : void {
        /** @var ServiceRegistry $registry */
        $registry = $this->app
            ->getContainer()
            ->get(ServiceRegistry::class);

        foreach (array_keys($registry->all()) as $service) {
            $request = (new ServerRequestFactory())
                ->createServerRequest(
                    'GET',
                    sprintf('/%s/docs', $service),
                );

            $response = $this->app->handle($request);

            self::assertSame(
                200,
                $response->getStatusCode(),
                sprintf('/docs endpoint failed for service "%s"', $service),
            );
        }
    }
}
