<?php

use App\Http\Controllers\DomainController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('domains.search');
});

Route::get('/domains/search', function () {
    return view('domains.search');
})->name('domains.search');
Route::post('/domains/search', [DomainController::class, 'search'])->name('domains.search');
Route::post('/cart/add', [DomainController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [DomainController::class, 'cart'])->name('cart.index');
Route::post('/cart/remove', [DomainController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

// Tijdelijke testroute - verwijder dit later weer
Route::get('/test-api', function() {
    $client = new \GuzzleHttp\Client([
        'base_uri' => 'https://dev.api.mintycloud.nl/api/v2.1',
        'headers' => [
            'Authorization' => 'Basic 072dee999ac1a7931c205814c97cb1f4d1261559c0f6cd15f2a7b27701954b8d',
            'Accept' => 'application/json',
        ],
        'verify' => false,
        'http_errors' => false
    ]);

    $response = $client->post('/domains/search', [
        'query' => ['with_price' => 'true'],
        'json' => [
            ['name' => 'test', 'extension' => 'com'],
            ['name' => 'test', 'extension' => 'nl']
        ]
    ]);

    return [
        'status' => $response->getStatusCode(),
        'headers' => $response->getHeaders(),
        'body' => (string) $response->getBody()
    ];
});
