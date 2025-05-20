@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-bold text-gray-900">Winkelwagen</h1>
            <p class="mt-2 text-sm text-gray-700">Bekijk en beheer uw geselecteerde domeinen.</p>
        </div>
    </div>

    <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
        @if($cart)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Domein</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prijs</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actie</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($cart as $index => $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $item['domain'] }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">€ {{ number_format($item['price'], 2, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('cart.remove') }}">
                                        @csrf
                                        <input type="hidden" name="index" value="{{ $index }}">
                                        <button class="text-red-600 hover:text-red-800 text-sm font-medium" type="submit">
                                            Verwijderen
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-gray-50 text-right">
                <a href="{{ route('checkout') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-white text-sm font-medium hover:bg-indigo-700 transition">
                    Naar Checkout
                </a>
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <h3 class="text-lg font-medium text-gray-900">Uw winkelwagen is leeg</h3>
                <p class="mt-1 text-gray-500">U heeft nog geen domeinen geselecteerd.</p>
                <div class="mt-6">
                    <a href="{{ route('domains.search') }}" class="btn inline-flex items-center">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Nieuwe domein zoeken
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
