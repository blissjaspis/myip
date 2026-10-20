<?php

namespace Tests\Unit;

use App\Support\Cloudflare;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class CloudflareClientIpTest extends TestCase
{
    public function test_it_uses_the_cloudflare_visitor_header_from_a_cloudflare_address(): void
    {
        $request = Request::create('/', 'GET', server: [
            'REMOTE_ADDR' => '104.16.1.1',
            'HTTP_CF_CONNECTING_IP' => '8.8.8.8',
            'HTTP_X_FORWARDED_FOR' => '9.9.9.9, 8.8.8.8',
        ]);

        $this->assertSame('8.8.8.8', Cloudflare::clientIp($request));
    }

    public function test_it_uses_an_ipv6_visitor_header_from_a_cloudflare_address(): void
    {
        $request = Request::create('/', 'GET', server: [
            'REMOTE_ADDR' => '2606:4700:1::1',
            'HTTP_CF_CONNECTING_IP' => '2001:4860:4860::8888',
        ]);

        $this->assertSame('2001:4860:4860::8888', Cloudflare::clientIp($request));
    }

    public function test_it_ignores_the_visitor_header_from_a_direct_connection(): void
    {
        $request = Request::create('/', 'GET', server: [
            'REMOTE_ADDR' => '9.9.9.9',
            'HTTP_CF_CONNECTING_IP' => '8.8.8.8',
        ]);

        $this->assertSame('9.9.9.9', Cloudflare::clientIp($request));
    }

    public function test_it_ignores_a_private_visitor_header(): void
    {
        $request = Request::create('/', 'GET', server: [
            'REMOTE_ADDR' => '172.64.1.1',
            'HTTP_CF_CONNECTING_IP' => '10.1.1.1',
        ]);

        $this->assertSame('172.64.1.1', Cloudflare::clientIp($request));
    }
}
