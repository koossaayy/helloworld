@section('seo')
    <meta name="description"
        content="Generate random data instantly — people, numbers, colors, passwords, text, and more. Rand.tn offers fast, free online generators for developers, designers, and everyday users.">
    <meta name="keywords"
        content="random generator, random data, random person, random number, random password, random color, fake data generator, online tools, developer utilities, base converter, QR code generator, barcode generator, uuid generator, lorem ipsum, random api, tunisian tools">
    <meta property="og:title" content="Rand.tn — Free Random Generators & Tools">
    <meta property="og:description" content="Generate random data instantly — numbers, passwords, people, colors, and more.">
    <meta property="og:image" content="{{ asset('poster.png') }}">
    <meta property="og:url" content="https://rand.tn">
    <meta property="og:type" content="website">
@endsection
<div class="min-h-screen  py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-16 animate-fade-in">
            <h1 class="text-5xl md:text-6xl font-bold  mb-4">
                Rand.tn
            </h1>
            <p class="text-xl -300 mb-8">
                Discover powerful utilities to simplify your workflow
            </p>
            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto">
                <div class="relative">
                    <input type="search" wire:model.live="search" placeholder="Search tools..."
                        class="w-full px-6 py-4 rounded-lg bg-white text-gray-900 placeholder-gray-400 border-2 border-gray-200 focus:border-blue-500 focus:outline-none transition duration-300 shadow-lg">
                </div>
            </div>
        </div>

        <!-- Tools Grid -->
        @if (count($filteredTools) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($filteredTools as $tool)
                    <a href="{{ route('tools', $tool->slug) }}" wire:navigate.hover class="group">
                        <div
                            class="h-full bg-white rounded-xl p-6 border border-gray-200 hover:border-blue-400 hover:shadow-xl transition duration-300 transform hover:scale-105">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition">
                                        {{ $tool->name }}
                                    </h3>
                                    <p class="text-gray-600 text-sm mt-2">
                                        {{ $tool->description ?? 'No description available' }}
                                    </p>
                                </div>
                                <div class="ml-4 p-3 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-gray-600 text-lg">No tools found matching your search</p>
                <p class="text-gray-500 text-sm mt-2">Try adjusting your search terms</p>
            </div>
        @endif
    </div>
</div>
