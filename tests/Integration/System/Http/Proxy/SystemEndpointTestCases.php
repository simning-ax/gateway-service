<?php

declare(strict_types=1);

namespace Tests\Integration\System\Http\Proxy;

use PHPUnit\Framework\TestCase;

class SystemEndpointTestCases extends TestCase {
    public const GATEWAY_BASE_URL = 'http://localhost:8080';

    /**
     * @return array<int, list<string>>
     */
    public static function services() : array {
        return [
            ['auth'],
            ['group'],
        ];
    }
}
