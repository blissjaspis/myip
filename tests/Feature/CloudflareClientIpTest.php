<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CloudflareClientIpTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Http::fake([
            'http://ipwho.is/*' => Http::response([
                'success' => true,
                'city' => 'Jakarta',
                'region_code' => 'JK',
                'country' => 'Indonesia',
                'continent' => 'Asia',
                'flag' => ['emoji' => 'ID'],
                'connection' => ['isp' => 'Example ISP', 'asn' => 1],
                'timezone' => ['id' => 'Asia/Jakarta'],
            ]),
        ]);
    }

    public function test_the_page_shows_the_visitor_address_behind_cloudflare(): void
    {
        $response = $this
            ->withServerVariables(['REMOTE_ADDR' => '104.16.1.1'])
            ->withHeaders([
                'CF-Connecting-IP' => '8.8.8.8',
                'X-Forwarded-For' => '9.9.9.9, 8.8.8.8',
            ])
            ->get('/');

        $response->assertOk();
        $response->assertSee('8.8.8.8', false);
        $response->assertDontSee('104.16.1.1', false);
        $response->assertDontSee('9.9.9.9', false);
    }

    public function test_the_page_uses_the_forwarded_chain_when_the_visitor_header_is_absent(): void
    {
        $response = $this
            ->withServerVariables(['REMOTE_ADDR' => '104.16.1.1'])
            ->withHeaders([
                'X-Forwarded-For' => '9.9.9.9, 8.8.8.8',
            ])
            ->get('/');

        $response->assertOk();
        $response->assertSee('8.8.8.8', false);
        $response->assertDontSee('104.16.1.1', false);
        $response->assertDontSee('9.9.9.9', false);
    }

    public function test_a_direct_request_cannot_replace_the_connection_address(): void
    {
        $response = $this
            ->withServerVariables(['REMOTE_ADDR' => '9.9.9.9'])
            ->withHeaders([
                'CF-Connecting-IP' => '8.8.8.8',
                'X-Forwarded-For' => '8.8.8.8',
            ])
            ->get('/');

        $response->assertOk();
        $response->assertSee('9.9.9.9', false);
        $response->assertDontSee('8.8.8.8', false);
    }
}
