<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class DomainService
{
    protected $client;
    protected $baseUrl = 'https://dev.api.mintycloud.nl/api/v2.1';
    protected $apiKey = '072dee999ac1a7931c205814c97cb1f4d1261559c0f6cd15f2a7b27701954b8d';

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => 'Basic ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'timeout' => 10,
            'verify' => false,
            'http_errors' => false,
        ]);
    }

    public function searchDomains(string $name, array $extensions): array
    {
        try {
            // Genereer mock data voor elke extensie
            $mockData = array_map(function($ext) use ($name) {
                $basePrice = rand(5, 20); // Willekeurige basisprijs tussen 5 en 20
                $isAvailable = rand(0, 1); // 50% kans dat het domein beschikbaar is
                
                return [
                    'domain' => $name . '.' . $ext,
                    'status' => $isAvailable ? 'free' : 'taken',
                    'price' => $basePrice,
                    'price_with_vat' => round($basePrice * 1.21, 2), // Prijs inclusief 21% BTW
                    'currency' => 'EUR',
                    'period' => 1 // 1 jaar
                ];
            }, $extensions);

            // Log de gegenereerde mock data
            Log::info('Mock data gegenereerd voor domein zoekopdracht', [
                'name' => $name,
                'extensions' => $extensions,
                'mock_results' => $mockData
            ]);

            return $mockData;

        } catch (\Exception $e) {
            Log::error('Fout bij het genereren van mock data: ' . $e->getMessage(), [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw new \Exception('Fout bij het ophalen van domeingegevens: ' . $e->getMessage());
        }
    }
}
