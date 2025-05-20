@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-bold text-gray-900">Checkout</h1>
            <p class="mt-2 text-sm text-gray-700">Bevestig uw bestelling en rond de betaling af.</p>
        </div>
    </div>

    <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Domein</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prijs</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($cart as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $item['domain'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">€ {{ number_format($item['price'], 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 py-6 border-t border-gray-200 space-y-2 text-sm text-gray-900 bg-gray-50">
            <div class="flex justify-between">
                <span>Subtotaal</span>
                <span>€ {{ number_format($subtotal, 2, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span>BTW (21%)</span>
                <span>€ {{ number_format($vat, 2, ',', '.') }}</span>
            </div>
            <div class="flex justify-between font-semibold text-base">
                <span>Totaal</span>
                <span>€ {{ number_format($total, 2, ',', '.') }}</span>
            </div>
        </div>

        <div class="px-6 py-4 bg-white border-t border-gray-200">
            <form method="POST" action="{{ route('orders.store') }}">
                @csrf
                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transition">
                    Bestelling Plaatsen
                </button>
            </form>
            <div class="mt-4 text-center">
                <a href="{{ route('cart.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">← Terug naar winkelwagen</a>
            </div>
        </div>
    </div>
</div>
@endsection
