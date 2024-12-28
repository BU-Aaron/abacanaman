<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />

        <meta name="application-name" content="{{ config('app.name') }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>{{ config('app.name') }}</title>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        @filamentStyles
        @vite('resources/css/app.css')
    </head>

    <body class="antialiased">
        <!-- Header with Categories -->
        <header class="bg-white shadow">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-xl font-bold">{{ config('app.name') }}</a>
                <nav>
                    <ul class="flex space-x-4">
                        @php
                            use App\Models\Shop\Category;
                            $categories = Category::whereNull('parent_id')->where('is_visible', true)->get();
                        @endphp
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ route('home', ['category' => $category->id]) }}" class="text-gray-600 hover:text-green-500">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                        <li>
                            <a href="{{ route('home') }}" class="text-gray-600 hover:text-green-500">
                                All Products
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <main>
            {{ $slot }}
        </main>

        @filamentScripts
        @vite('resources/js/app.js')
    </body>
</html>
