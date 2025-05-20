<?php

namespace App\Http\Controllers;

use App\Services\DomainService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class DomainController extends Controller
{
    protected $domainService;

    public function __construct(DomainService $domainService)
    {
        $this->domainService = $domainService;
    }

    public function search(Request $request)
    {
        try {
            $request->validate([
                'domain' => 'required|string|min:1|max:63|regex:/^[a-zA-Z0-9\-]+$/',
            ]);

            $domainName = $request->input('domain');
            $extensions = ['com', 'nl', 'org', 'net', 'info', 'biz', 'eu', 'de', 'co.uk', 'fr'];

            $results = $this->domainService->searchDomains($domainName, $extensions);

            return view('domains.search', compact('results', 'domainName'));
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Fout bij het zoeken: ' . $e->getMessage())->withInput();
        }
    }

    public function addToCart(Request $request)
    {
        try {
            $request->validate([
                'domain' => 'required|string',
                'price' => 'required|numeric|min:0',
                'status' => 'required|string|in:free,unavailable',
            ]);

            $domain = $request->input('domain');
            $price = $request->input('price');
            $status = $request->input('status');

            if ($status !== 'free') {
                return redirect()->back()->with('error', 'Domein is niet beschikbaar.');
            }

            $cart = Session::get('cart', []);
            $cart[] = ['domain' => $domain, 'price' => (float) $price];
            Session::put('cart', $cart);

            return redirect()->route('cart.index')->with('success', 'Domein toegevoegd aan winkelwagen.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        }
    }

    public function cart()
    {
        $cart = Session::get('cart', []);
        return view('domains.cart', compact('cart'));
    }

    public function removeFromCart(Request $request)
    {
        try {
            $request->validate([
                'index' => 'required|integer|min:0',
            ]);

            $index = $request->input('index');
            $cart = Session::get('cart', []);

            if (isset($cart[$index])) {
                unset($cart[$index]);
                Session::put('cart', array_values($cart));
                return redirect()->back()->with('success', 'Domein verwijderd uit winkelwagen.');
            }

            return redirect()->back()->with('error', 'Domein niet gevonden in winkelwagen.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        }
    }
}