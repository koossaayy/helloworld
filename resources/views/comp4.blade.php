<div>
    <div class="max-w-7xl mx-auto mt-8 p-6">
        <h1 class="text-4xl font-bold mb-2 text-gray-800">{{ self::$title }}</h1>
        <p class="text-lg text-gray-600 mb-8">{{ self::$description }}</p>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Generator Section (Left - 2 columns) -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Generated Numbers Display -->
                <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold">📱 Generated Numbers</h2>
                        <span class="bg-white bg-opacity-20 px-4 py-2 rounded-full text-sm font-semibold">
                            {{ count($generatedNumbers) }} {{ count($generatedNumbers) === 1 ? 'number' : 'numbers' }}
                        </span>
                    </div>

                    <div class="bg-white rounded-lg p-4 min-h-[400px] max-h-[600px] overflow-y-auto">
                        @if (count($generatedNumbers) > 0)
                            <div class="space-y-3">
                                @foreach ($generatedNumbers as $index => $number)
                                    <div
                                        class="border-l-4 border-blue-500 bg-gray-50 p-4 rounded-r-lg hover:bg-gray-100 transition-colors duration-200">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3 mb-2">
                                                    <span
                                                        class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded">
                                                        #{{ $index + 1 }}
                                                    </span>
                                                    <span class="text-2xl font-bold text-gray-800 font-mono">
                                                        {{ $number['formatted'] }}
                                                    </span>
                                                </div>
                                                <div class="flex flex-wrap gap-2 text-sm text-gray-600">
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        {{ $number['location'] }}
                                                    </span>
                                                    <span class="text-gray-400">•</span>
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm3 1h6v4H7V5zm8 8v2h1v-2h-1zm-2-2H7v4h6v-4z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        Area Code: {{ $number['area_code'] }}
                                                    </span>
                                                    <span class="text-gray-400">•</span>
                                                    <span
                                                        class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-semibold">
                                                        {{ $number['country'] }}
                                                    </span>
                                                </div>
                                            </div>
                                            <button onclick="copyNumber('{{ $number['formatted'] }}')"
                                                class="ml-4 text-blue-600 hover:text-blue-800 transition-colors">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400">
                                <div class="text-center">
                                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <p class="text-lg">No numbers generated yet</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-wrap gap-2 mt-4">
                        <button wire:click="generateNumbers"
                            class="flex-1 min-w-[150px] bg-white text-blue-600 hover:bg-gray-100 font-semibold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Generate Numbers
                        </button>
                        <button onclick="copyAllNumbers()"
                            class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            Copy All
                        </button>
                        <button wire:click="exportToFile"
                            class="bg-purple-500 hover:bg-purple-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            TXT
                        </button>
                        <button wire:click="exportToCsv"
                            class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            CSV
                        </button>
                    </div>
                </div>

                <!-- Settings Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Location Settings -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-xl font-bold mb-4 text-gray-800 flex items-center">
                            <span class="mr-2">🌍</span> Location Settings
                        </h3>

                        <!-- Country Selection -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                            <div class="grid grid-cols-2 gap-2">
                                <button wire:click="$set('country', 'US')"
                                    class="p-4 rounded-lg border-2 transition-all duration-200 {{ $country === 'US' ? 'border-blue-500 bg-blue-50 text-blue-700 font-semibold' : 'border-gray-300 hover:border-blue-300' }}">
                                    🇺🇸 United States
                                </button>
                                <button wire:click="$set('country', 'CA')"
                                    class="p-4 rounded-lg border-2 transition-all duration-200 {{ $country === 'CA' ? 'border-blue-500 bg-blue-50 text-blue-700 font-semibold' : 'border-gray-300 hover:border-blue-300' }}">
                                    🇨🇦 Canada
                                </button>
                            </div>
                        </div>

                        <!-- State/Province Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $country === 'US' ? 'State' : 'Province' }} (Optional)
                            </label>
                            <select wire:model.live="state"
                                class="w-full p-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                                <option value="">All {{ $country === 'US' ? 'States' : 'Provinces' }}</option>
                                @foreach ($this->states as $code => $name)
                                    <option value="{{ $code }}">{{ $name }} ({{ $code }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">
                                Leave blank for random {{ $country === 'US' ? 'state' : 'province' }} selection
                            </p>
                        </div>
                    </div>

                    <!-- Format Settings -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-xl font-bold mb-4 text-gray-800 flex items-center">
                            <span class="mr-2">🎨</span> Format & Options
                        </h3>

                        <!-- Quantity -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Quantity: <span class="text-blue-600 font-bold">{{ $quantity }}</span>
                            </label>
                            <input type="range" wire:model.live="quantity" min="1" max="100"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-blue-500">
                            <div class="flex justify-between text-xs text-gray-500 mt-1">
                                <span>1</span>
                                <span>100</span>
                            </div>
                        </div>

                        <!-- Format Selection -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Number Format</label>
                            <select wire:model.live="format"
                                class="w-full p-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                                <option value="standard">(555) 123-4567</option>
                                <option value="parentheses">(555) 123-4567</option>
                                <option value="dashes">555-123-4567</option>
                                <option value="dots">555.123.4567</option>
                                <option value="international">+1 555 123 4567</option>
                                <option value="digits">5551234567</option>
                            </select>
                        </div>

                        <!-- Extension Option -->
                        <div>
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" wire:model.live="includeExtension"
                                    class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Include Extension (e.g., ext. 1234)</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Format Examples -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">📋 Format Examples</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div
                            class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-all duration-200">
                            <h4 class="font-bold text-gray-700 mb-2">Standard</h4>
                            <p class="text-sm font-mono text-gray-600">(555) 123-4567</p>
                        </div>

                        <div
                            class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-all duration-200">
                            <h4 class="font-bold text-gray-700 mb-2">Dashes</h4>
                            <p class="text-sm font-mono text-gray-600">555-123-4567</p>
                        </div>

                        <div
                            class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-all duration-200">
                            <h4 class="font-bold text-gray-700 mb-2">Dots</h4>
                            <p class="text-sm font-mono text-gray-600">555.123.4567</p>
                        </div>

                        <div
                            class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-all duration-200">
                            <h4 class="font-bold text-gray-700 mb-2">International</h4>
                            <p class="text-sm font-mono text-gray-600">+1 555 123 4567</p>
                        </div>

                        <div
                            class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-all duration-200">
                            <h4 class="font-bold text-gray-700 mb-2">Digits Only</h4>
                            <p class="text-sm font-mono text-gray-600">5551234567</p>
                        </div>

                        <div class="border-2 border-blue-300 bg-blue-50 rounded-lg p-4">
                            <h4 class="font-bold text-blue-700 mb-2">Current</h4>
                            <p class="text-sm font-mono text-blue-600">{{ $format }}</p>
                        </div>
                    </div>
                </div>

                <!-- Info Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div
                        class="bg-gradient-to-br from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg p-6">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-green-600 mr-3 flex-shrink-0 mt-1" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h4 class="font-bold text-gray-800 mb-2">Valid Area Codes</h4>
                                <p class="text-sm text-gray-700">
                                    All generated numbers use real area codes mapped to actual US states and Canadian
                                    provinces.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gradient-to-br from-yellow-50 to-orange-50 border-l-4 border-yellow-500 rounded-lg p-6">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-yellow-600 mr-3 flex-shrink-0 mt-1" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h4 class="font-bold text-gray-800 mb-2">For Testing Only</h4>
                                <p class="text-sm text-gray-700">
                                    These numbers are randomly generated for testing and development purposes. They may
                                    not be active numbers.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Section (Right - 1 column) -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-8">
                    <h2 class="text-2xl font-bold mb-4 text-gray-800">About Phone Generator</h2>

                    <p class="text-gray-700 mb-4">
                        Generate realistic phone numbers for the United States and Canada with valid area codes mapped
                        to specific states and provinces.
                    </p>

                    <h3 class="text-xl font-semibold mb-3 text-gray-800">How to Use</h3>
                    <ol class="list-decimal list-inside text-gray-700 mb-4 space-y-2">
                        <li><strong>Select country:</strong> Choose US or Canada</li>
                        <li><strong>Pick location:</strong> Select a specific state/province or leave blank for random
                        </li>
                        <li><strong>Set quantity:</strong> Generate 1-100 numbers at once</li>
                        <li><strong>Choose format:</strong> Pick your preferred number format</li>
                        <li><strong>Add extensions:</strong> Optionally include extensions</li>
                        <li><strong>Export:</strong> Copy or download as TXT or CSV</li>
                    </ol>

                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Features</h3>
                    <ul class="space-y-2 text-gray-700 mb-4">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span><strong>Real Area Codes:</strong> All area codes are valid and
                                location-specific</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span><strong>Multiple Formats:</strong> 6 different formatting styles</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span><strong>Location Data:</strong> Shows state/province for each number</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span><strong>Bulk Generation:</strong> Create up to 100 numbers at once</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span><strong>Export Options:</strong> Download as TXT or CSV files</span>
                        </li>
                    </ul>

                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Use Cases</h3>
                    <ul class="list-disc list-inside text-gray-700 mb-4 space-y-1">
                        <li>Testing contact forms</li>
                        <li>Database seeding</li>
                        <li>UI/UX mockups</li>
                        <li>QA testing</li>
                        <li>Development environments</li>
                        <li>Training materials</li>
                    </ul>

                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg mt-6">
                        <p class="text-sm text-blue-800">
                            <strong>💡 Pro Tip:</strong> Select a specific state to generate numbers with area codes
                            from that region only.
                        </p>
                    </div>

                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mt-4">
                        <p class="text-sm text-red-800">
                            <strong>⚠️ Important:</strong> Do not use these numbers for actual communication. They are
                            randomly generated and may belong to real people or businesses.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6">
            <livewire:related-tools :current-slug="self::$slug" :related-slugs="self::$relatedTools ?? []" />
        </div>

    </div>

    <script>
        function copyNumber(number) {
            navigator.clipboard.writeText(number).then(() => {
                // Create a temporary success message
                const message = document.createElement('div');
                message.textContent = 'Number copied!';
                message.className =
                    'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in';
                document.body.appendChild(message);
                setTimeout(() => message.remove(), 2000);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }

        function copyAllNumbers() {
            const numbers = @js(collect($generatedNumbers)->pluck('formatted')->toArray());
            const text = numbers.join('\n');
            navigator.clipboard.writeText(text).then(() => {
                const message = document.createElement('div');
                message.textContent = `${numbers.length} numbers copied!`;
                message.className =
                    'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in';
                document.body.appendChild(message);
                setTimeout(() => message.remove(), 2000);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }
    </script>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>
</div>
