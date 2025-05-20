@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-bold text-gray-900">Domein Zoeken</h1>
            <p class="mt-2 text-sm text-gray-700">Voer een domeinnaam in om te controleren of deze beschikbaar is.</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-auto">
            <a href="{{ route('cart.index') }}" class="inline-flex items-center bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                </svg>
                Winkelwagen
            </a>
        </div>
    </div>

    <div class="mt-8 bg-white p-6 rounded-lg shadow">
        <form method="POST" action="{{ route('domains.search') }}" class="space-y-4">
            @csrf
            <div class="flex flex-col sm:flex-row gap-2">
                <input 
                    type="text" 
                    name="domain" 
                    placeholder="Bijv. voorbeeld.nl" 
                    value="{{ old('domain') }}"
                    class="flex-1 border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    required
                >
                <button 
                    type="submit" 
                    class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition"
                >
                    Zoeken
                </button>
            </div>
            @error('domain')
                <p class="text-red-500 text-sm text-center">{{ $message }}</p>
            @enderror
        </form>
    </div>

    @if(isset($results))
    <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Domein</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prijs</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actie</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($results as $result)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $result['domain'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm {{ $result['status'] == 'free' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $result['status'] == 'free' ? 'Beschikbaar' : 'Niet beschikbaar' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            € {{ number_format($result['price'], 2, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($result['status'] == 'free')
                            <form method="POST" action="{{ route('cart.add') }}">
                                @csrf
                                <input type="hidden" name="domain" value="{{ $result['domain'] }}">
                                <input type="hidden" name="price" value="{{ $result['price'] }}">
                                <input type="hidden" name="status" value="{{ $result['status'] }}">
                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition">
                                    Toevoegen
                                </button>
                            </form>
                            @else
                            <span class="text-gray-400">Niet beschikbaar</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
