<?php

namespace Tests\Integration\System;

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
            ['time'],
        ];
    }


}