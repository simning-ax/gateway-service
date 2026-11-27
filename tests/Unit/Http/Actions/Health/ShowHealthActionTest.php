<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Actions\Health;

use App\Application\Services\HealthService;
use App\Http\Actions\Health\ShowHealthAction;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

final class ShowHealthActionTest extends TestCase {
    public function testReturnsHealthStatusFromHealthService() : void {
        $request = $this->createMock(ServerRequestInterface::class);

        $response = $this->createMock(ResponseInterface::class);

        $expectedResponse = $this->createMock(ResponseInterface::class);

        $healthStatus = [
            'status' => 'ok',
            'service' => 'gateway-service',
            'version' => '1.0.7',
        ];

        $healthService = $this->createMock(HealthService::class);

        $healthService
            ->expects(self::once())
            ->method('getHealthStatus')
            ->willReturn($healthStatus);

        $action = $this->getMockBuilder(ShowHealthAction::class)
                       ->setConstructorArgs([
                           $this->createMock(LoggerInterface::class),
                           $healthService,
                       ])
                       ->onlyMethods(['respondWithData'])
                       ->getMock();

        $action
            ->expects(self::once())
            ->method('respondWithData')
            ->with($healthStatus)
            ->willReturn($expectedResponse);

        $result = $action($request, $response, []);

        self::assertSame($expectedResponse, $result);
    }
}
