<?php

use Livewire\Component;
use Illuminate\Support\Facades\Http;

new class extends Component
{
    public $ip;
    public $data = [];
    public $loading = true;

    public function mount()
    {
        $this->fetchIpDetails();
    }

    public function fetchIpDetails()
    {
        $this->loading = true;
        
        // Get the IP address
        $this->ip = request()->ip();

        // Handle local environment
        if (app()->environment('local') && in_array($this->ip, ['127.0.0.1', '::1'])) {
            $this->ip = '8.8.8.8'; // Use Google DNS IP for testing locally
        }

        // Fetch location data
        try {
            $response = Http::timeout(3)->get("http://ipwho.is/{$this->ip}");
            
            if ($response->successful()) {
                $this->data = $response->json();
            } else {
                $this->data = ['error' => 'Failed to fetch location data'];
            }
        } catch (\Exception $e) {
            $this->data = ['error' => 'Connection error'];
        }

        $this->loading = false;
    }

    public function refresh()
    {
        $this->fetchIpDetails();
    }
};