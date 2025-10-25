<div class="max-w-7xl mx-auto mt-8 p-6">
    <h1 class="text-4xl font-bold mb-2 text-gray-800">{{ self::$title }}</h1>
    <p class="text-lg text-gray-600 mb-8">{{ self::$description }}</p>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Generator Section (Left - 2 columns) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Type Selector -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="grid grid-cols-2 gap-4">
                    <button wire:click="$set('generatorType', 'mask')"
                        class="p-6 rounded-lg border-2 transition-all duration-200 {{ $generatorType === 'mask' ? 'border-green-500 bg-green-50' : 'border-gray-300 hover:border-green-300' }}">
                        <div class="text-4xl mb-2">🎭</div>
                        <div class="font-bold text-lg text-gray-800">{{ __('Mask Generator') }}</div>
                        <div class="text-sm text-gray-600 mt-1">{{ __('Simple pattern-based generation') }}</div>
                    </button>
                    <button wire:click="$set('generatorType', 'regex')"
                        class="p-6 rounded-lg border-2 transition-all duration-200 {{ $generatorType === 'regex' ? 'border-blue-500 bg-blue-50' : 'border-gray-300 hover:border-blue-300' }}">
                        <div class="text-4xl mb-2">⚡</div>
                        <div class="font-bold text-lg text-gray-800">{{ __('Regex Generator') }}</div>
                        <div class="text-sm text-gray-600 mt-1">{{ __('Advanced regex-based generation') }}</div>
                    </button>
                </div>
            </div>

            <!-- Generated Results Display -->
            <div
                class="bg-gradient-to-br from-{{ $generatorType === 'mask' ? 'green' : 'blue' }}-500 to-{{ $generatorType === 'mask' ? 'teal' : 'indigo' }}-600 rounded-lg shadow-lg p-6 text-white">
                <h2 class="text-2xl font-bold mb-4">{{ __('Generated Results') }}</h2>

                @if ($errorMessage)
                    <div class="bg-red-500 bg-opacity-90 text-white px-4 py-3 rounded mb-4">
                        <strong>{{ __('Error:') }}</strong> {{ $errorMessage }}
                    </div>
                @endif

                <div
                    class="bg-white bg-opacity-10 backdrop-blur-sm rounded-lg p-4 min-h-[150px] max-h-[400px] overflow-y-auto">
                    @if (count($generatedResults) > 0)
                        <div class="space-y-2">
                            @foreach ($generatedResults as $index => $result)
                                <div
                                    class="bg-white bg-opacity-20 hover:bg-opacity-30 p-3 rounded-lg transition-all duration-200 group">
                                    <div class="flex items-center justify-between gap-2">
                                        <span
                                            class="text-xs text-white text-opacity-70 font-semibold">{{ $index + 1 }}</span>
                                        <code class="flex-1 font-mono text-sm break-all">{{ $result }}</code>
                                        <button onclick="copyToClipboard('{{ $result }}')"
                                            class="opacity-0 group-hover:opacity-100 transition-opacity bg-white bg-opacity-20 hover:bg-opacity-30 p-2 rounded text-xs">
                                            📋
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-white text-opacity-70 py-12">{{ __('No results generated yet') }}</p>
                    @endif
                </div>

                <div class="flex flex-wrap gap-2 mt-4">
                    <button wire:click="generate"
                        class="flex-1 bg-white text-{{ $generatorType === 'mask' ? 'green' : 'blue' }}-600 hover:bg-gray-100 font-semibold py-3 px-6 rounded-lg transition duration-200">
                        {{ __('✨ Generate') }}
                    </button>
                    @if (count($generatedResults) > 0)
                        <button onclick="copyAllResults()"
                            class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                            {{ __('📋 Copy All') }}
                        </button>
                        <button wire:click="exportToCsv"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-200">
                            {{ __('CSV') }}
                        </button>
                        <button wire:click="exportToTxt"
                            class="bg-gray-700 hover:bg-gray-800 text-white font-semibold py-3 px-4 rounded-lg transition duration-200">
                            {{ __('TXT') }}
                        </button>
                        <button wire:click="exportToJson"
                            class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-200">
                            {{ __('JSON') }}
                        </button>
                        <button wire:click="clearResults"
                            class="bg-red-500 hover:bg-red-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-200">
                            🗑️
                        </button>
                    @endif
                </div>
            </div>

            <!-- Mask Settings -->
            @if ($generatorType === 'mask')
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">{{ __('⚙️ Mask Settings') }}</h3>

                    <!-- Preset Patterns -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">{{ __('Quick Presets') }}</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                            @foreach ($maskPresets as $key => $preset)
                                <button wire:click="useMaskPreset('{{ $key }}')"
                                    class="p-3 rounded-lg border-2 transition-all duration-200 text-left text-sm
                                        {{ $maskPattern === $preset['pattern'] ? 'border-green-500 bg-green-50' : 'border-gray-300 hover:border-green-300' }}">
                                    <div class="font-bold text-gray-800">{{ $preset['name'] }}</div>
                                    <div class="text-xs text-gray-500 font-mono mt-1">{{ $preset['example'] }}</div>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Mask Pattern Input -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Mask Pattern') }}</label>
                        <input type="text" wire:model.blur="maskPattern" wire:change="generateFromMask"
                            placeholder="e.g., ###-###-####"
                            class="w-full p-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500 font-mono">

                        <!-- Mask Symbols Legend -->
                        <div class="mt-3 p-4 bg-green-50 rounded-lg">
                            <div class="text-sm font-semibold text-gray-700 mb-2">{{ __('Available Mask Symbols:') }}</div>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 text-xs">
                                <div><code class="bg-white px-2 py-1 rounded">#</code> {{ __('= Digit (0-9)') }}</div>
                                <div><code class="bg-white px-2 py-1 rounded">@</code> {{ __('= Uppercase (A-Z)') }}</div>
                                <div><code class="bg-white px-2 py-1 rounded">?</code> {{ __('= Lowercase (a-z)') }}</div>
                                <div><code class="bg-white px-2 py-1 rounded">!</code> {{ __('= Any Letter') }}</div>
                                <div><code class="bg-white px-2 py-1 rounded">$</code> {{ __('= Alphanumeric') }}</div>
                                <div><code class="bg-white px-2 py-1 rounded">%</code> {{ __('= Special Char') }}</div>
                            </div>
                            <div class="text-xs text-gray-600 mt-2">
                                {{ __('Use') }} <code class="bg-white px-1 rounded">\</code> to escape symbols.
                                Add <code class="bg-white px-1 rounded">{n}</code> for repetition (e.g., <code
                                    class="bg-white px-1 rounded">#{5}</code> = 5 digits)
                            </div>
                        </div>
                    </div>

                    <!-- Count and Seed -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Number of Results (1-1000)') }}
                            </label>
                            <input type="number" wire:model="maskCount" min="1" max="1000"
                                class="w-full p-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Random Seed (optional)') }}
                            </label>
                            <div class="flex gap-2">
                                <input type="text" wire:model.blur="maskSeed" wire:change="generateFromMask"
                                    placeholder="Leave empty for random"
                                    class="flex-1 p-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500 font-mono text-sm">
                                <button wire:click="generateRandomSeed"
                                    class="bg-green-500 hover:bg-green-600 text-white px-4 rounded-lg transition">
                                    🎲
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">{{ __('Same seed = reproducible results') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Regex Settings -->
            @if ($generatorType === 'regex')
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">{{ __('⚙️ Regex Settings') }}</h3>

                    <!-- Preset Patterns -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">{{ __('Quick Presets') }}</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                            @foreach ($regexPresets as $key => $preset)
                                <button wire:click="useRegexPreset('{{ $key }}')"
                                    class="p-3 rounded-lg border-2 transition-all duration-200 text-left text-sm
                                        {{ $regexPattern === $preset['pattern'] ? 'border-blue-500 bg-blue-50' : 'border-gray-300 hover:border-blue-300' }}">
                                    <div class="font-bold text-gray-800">{{ $preset['name'] }}</div>
                                    <div class="text-xs text-gray-500 font-mono mt-1 break-all">
                                        {{ $preset['example'] }}</div>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Regex Pattern Input -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Regex Pattern') }}</label>
                        <input type="text" wire:model.blur="regexPattern" wire:change="generateFromRegex"
                            placeholder="e.g., [A-Z]{3}-\d{4}"
                            class="w-full p-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 font-mono">

                        <!-- Regex Syntax Legend -->
                        <div class="mt-3 p-4 bg-blue-50 rounded-lg">
                            <div class="text-sm font-semibold text-gray-700 mb-2">{{ __('Supported Regex Features:') }}</div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs">
                                <div><code class="bg-white px-2 py-1 rounded">[A-Z]</code> {{ __('Character ranges') }}</div>
                                <div><code class="bg-white px-2 py-1 rounded">\d</code> {{ __('Digits (0-9)') }}</div>
                                <div><code class="bg-white px-2 py-1 rounded">\w</code> {{ __('Word chars (A-Za-z0-9_)') }}</div>
                                <div><code class="bg-white px-2 py-1 rounded">\s</code> {{ __('Whitespace') }}</div>
                                <div><code class="bg-white px-2 py-1 rounded">.</code> {{ __('Any character') }}</div>
                                <div><code class="bg-white px-2 py-1 rounded">*</code> {{ __('0 or more') }}</div>
                                <div><code class="bg-white px-2 py-1 rounded">+</code> {{ __('1 or more') }}</div>
                                <div><code class="bg-white px-2 py-1 rounded">?</code> {{ __('0 or 1') }}</div>
                                <div><code class="bg-white px-2 py-1 rounded">{n}</code> {{ __('Exactly n times') }}</div>
                                <div><code class="bg-white px-2 py-1 rounded">{n,m}</code> {{ __('Between n and m') }}</div>
                                <div><code class="bg-white px-2 py-1 rounded">(abc)</code> {{ __('Grouping') }}</div>
                                <div><code class="bg-white px-2 py-1 rounded">(a|b)</code> {{ __('Alternation') }}</div>
                            </div>
                            <div class="text-xs text-gray-600 mt-2">
                                {{ __('Note: Anchors (^, $) are ignored. Complex lookaheads/lookbehinds not supported.') }}
                            </div>
                        </div>
                    </div>

                    <!-- Count, Seed, and Max Length -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Number of Results (1-1000)') }}
                            </label>
                            <input type="number" wire:model="regexCount" min="1" max="1000"
                                class="w-full p-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Max Length') }}
                            </label>
                            <input type="number" wire:model="maxLength" min="10" max="1000"
                                class="w-full p-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <p class="text-xs text-gray-500 mt-1">{{ __('Truncate if exceeded') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Random Seed') }}
                            </label>
                            <div class="flex gap-2">
                                <input type="text" wire:model.blur="regexSeed" wire:change="generateFromRegex"
                                    placeholder="Optional"
                                    class="flex-1 p-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 font-mono text-sm">
                                <button wire:click="generateRandomSeed"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 rounded-lg transition">
                                    🎲
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>

        <!-- Information Section (Right - 1 column) -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-6 sticky top-8">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">{{ __('About Data Generator') }}</h2>

                @if ($generatorType === 'mask')
                    <p class="text-gray-700 mb-4">
                        {{ __("The Mask Generator uses simple pattern templates to create structured data. It's perfect for generating formatted strings like phone numbers, IDs, serial numbers, and more.") }}
                    </p>

                    <h3 class="text-xl font-semibold mb-3 text-gray-800">{{ __('Mask Symbols') }}</h3>
                    <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2 text-sm">
                        <li><strong>#</strong> {{ __('- Random digit (0-9)') }}</li>
                        <li><strong>@</strong> {{ __('- Random uppercase letter (A-Z)') }}</li>
                        <li><strong>?</strong> {{ __('- Random lowercase letter (a-z)') }}</li>
                        <li><strong>!</strong> {{ __('- Random letter (upper or lower)') }}</li>
                        <li><strong>$</strong> {{ __('- Random alphanumeric character') }}</li>
                        <li><strong>%</strong> {{ __('- Random special character') }}</li>
                        <li>{{ __('Any other character is kept as-is') }}</li>
                    </ul>

                    <h3 class="text-xl font-semibold mb-3 text-gray-800">{{ __('Advanced Features') }}</h3>
                    <ul class="list-disc list-inside text-gray-700 mb-4 space-y-1 text-sm">
                        <li><strong>{{ __('Quantifiers:') }}</strong> {{ __('Use') }} <code class="bg-gray-100 px-1 rounded">{n}</code> for
                            repetition</li>
                        <li><strong>{{ __('Ranges:') }}</strong> <code class="bg-gray-100 px-1 rounded">{n,m}</code> for random
                            count</li>
                        <li><strong>{{ __('Escaping:') }}</strong> {{ __('Use') }} <code class="bg-gray-100 px-1 rounded">\</code> before
                            symbols</li>
                        <li><strong>{{ __('Seeds:') }}</strong> {{ __('Same seed produces same results') }}</li>
                    </ul>

                    <h3 class="text-xl font-semibold mb-3 text-gray-800">{{ __('Examples') }}</h3>
                    <div class="space-y-2 text-sm">
                        <div class="bg-gray-50 p-2 rounded">
                            <code class="text-green-600">###-####</code>
                            <div class="text-gray-600 text-xs mt-1">→ 123-4567</div>
                        </div>
                        <div class="bg-gray-50 p-2 rounded">
                            <code class="text-green-600">@@#{5}</code>
                            <div class="text-gray-600 text-xs mt-1">{{ __('→ AB12345') }}</div>
                        </div>
                        <div class="bg-gray-50 p-2 rounded">
                            <code class="text-green-600">USER-?{6,10}</code>
                            <div class="text-gray-600 text-xs mt-1">{{ __('→ USER-abcdefgh') }}</div>
                        </div>
                    </div>
                @else
                    <p class="text-gray-700 mb-4">
                        {{ __('The Regex Generator creates strings that match regular expression patterns. It supports character classes, quantifiers, groups, ranges, and more for complex data generation.') }}
                    </p>

                    <h3 class="text-xl font-semibold mb-3 text-gray-800">{{ __('Supported Features') }}</h3>
                    <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2 text-sm">
                        <li><strong>{{ __('Character Classes:') }}</strong> {{ __('[A-Z], [a-z], [0-9], [^abc]') }}</li>
                        <li><strong>{{ __('Quantifiers:') }}</strong> {{ __('*, +, ?, {n}, {n,m}') }}</li>
                        <li><strong>{{ __('Escape Sequences:') }}</strong> {{ __('\d, \w, \s, \D, \W, \S') }}</li>
                        <li><strong>{{ __('Groups:') }}</strong> {{ __('(abc), (a|b|c)') }}</li>
                        <li><strong>{{ __('Ranges:') }}</strong> {{ __('[A-Za-z0-9]') }}</li>
                        <li><strong>{{ __('Dot:') }}</strong> {{ __('. matches any character') }}</li>
                    </ul>

                    <h3 class="text-xl font-semibold mb-3 text-gray-800">{{ __('Limitations') }}</h3>
                    <ul class="list-disc list-inside text-gray-700 mb-4 space-y-1 text-sm">
                        <li>{{ __('Anchors (^, $) are ignored') }}</li>
                        <li>{{ __('Lookaheads/lookbehinds not supported') }}</li>
                        <li>{{ __('Backreferences not supported') }}</li>
                        <li>{{ __('Max length prevents infinite loops') }}</li>
                    </ul>

                    <h3 class="text-xl font-semibold mb-3 text-gray-800">{{ __('Examples') }}</h3>
                    <div class="space-y-2 text-sm">
                        <div class="bg-gray-50 p-2 rounded">
                            <code class="text-blue-600">\d{3}-\d{4}</code>
                            <div class="text-gray-600 text-xs mt-1">→ 123-4567</div>
                        </div>
                        <div class="bg-gray-50 p-2 rounded">
                            <code class="text-blue-600">[A-Z]{2}\d{4}</code>
                            <div class="text-gray-600 text-xs mt-1">{{ __('→ AB1234') }}</div>
                        </div>
                        <div class="bg-gray-50 p-2 rounded">
                            <code class="text-blue-600">\w+@\w+\.(com|net)</code>
                            <div class="text-gray-600 text-xs mt-1">→ user@site.com</div>
                        </div>
                    </div>
                @endif

                <div
                    class="bg-{{ $generatorType === 'mask' ? 'green' : 'blue' }}-50 border-l-4 border-{{ $generatorType === 'mask' ? 'green' : 'blue' }}-400 p-4 mt-6">
                    <p class="text-sm text-{{ $generatorType === 'mask' ? 'green' : 'blue' }}-800">
                        <strong>{{ __('💡 Tip:') }}</strong> {{ __('Use seeds for reproducible test data. Export results for use in your applications, testing, or databases.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-6">
        <livewire:related-tools :current-slug="self::$slug" :related-slugs="self::$relatedTools ?? []" />
    </div>

    <!-- Comprehensive Guide Section -->
    <div class="mt-12 bg-white rounded-lg shadow-lg p-8">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl font-bold mb-6 text-gray-800">{{ __('Complete Guide to Pattern-Based Data Generation') }}</h2>

            <div class="prose prose-lg max-w-none">
                <h3 class="text-2xl font-semibold mb-4 text-gray-800 mt-8">{{ __('What is Pattern-Based Data Generation?') }}</h3>
                <p class="text-gray-700 mb-4">
                    {{ __('Pattern-based data generation is a technique for creating structured, formatted data by defining templates or patterns that specify the format and characteristics of the output. This is invaluable for testing, populating databases, creating mock data, and generating realistic sample datasets without manual entry.') }}
                </p>

                <h3 class="text-2xl font-semibold mb-4 text-gray-800 mt-8">{{ __('Mask Generator: Simple and Intuitive') }}</h3>
                <p class="text-gray-700 mb-4">
                    {{ __('The Mask Generator uses intuitive symbols to represent different types of characters. Each symbol in your pattern is replaced with a random character from its category. This makes it extremely easy to create formatted data like phone numbers, IDs, license plates, and serial numbers without needing to understand regular expressions.') }}
                </p>

                <h4 class="text-xl font-semibold mb-3 text-gray-800 mt-6">{{ __('Mask Symbol Reference') }}</h4>
                <div class="overflow-x-auto mb-6">
                    <table class="min-w-full border-collapse border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2 text-left">{{ __('Symbol') }}</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">{{ __('Generates') }}</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">{{ __('Example Pattern') }}</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">{{ __('Sample Output') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 font-mono">#</td>
                                <td class="border border-gray-300 px-4 py-2">{{ __('Digit (0-9)') }}</td>
                                <td class="border border-gray-300 px-4 py-2 font-mono">###-####</td>
                                <td class="border border-gray-300 px-4 py-2">123-4567</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 font-mono">@</td>
                                <td class="border border-gray-300 px-4 py-2">{{ __('Uppercase Letter (A-Z)') }}</td>
                                <td class="border border-gray-300 px-4 py-2 font-mono">@@@-###
                                </td>
                                <td class="border border-gray-300 px-4 py-2">{{ __('ABC-123') }}</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 font-mono">?</td>
                                <td class="border border-gray-300 px-4 py-2">{{ __('Lowercase Letter (a-z)') }}</td>
                                <td class="border border-gray-300 px-4 py-2 font-mono">???###</td>
                                <td class="border border-gray-300 px-4 py-2">{{ __('abc123') }}</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 font-mono">!</td>
                                <td class="border border-gray-300 px-4 py-2">{{ __('Any Letter (A-Z, a-z)') }}</td>
                                <td class="border border-gray-300 px-4 py-2 font-mono">!!!-###</td>
                                <td class="border border-gray-300 px-4 py-2">{{ __('ABC-123') }}</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 font-mono">$</td>
                                <td class="border border-gray-300 px-4 py-2">{{ __('Alphanumeric (A-Z, a-z, 0-9)') }}</td>
                                <td class="border border-gray-300 px-4 py-2 font-mono">$$$</td>
                                <td class="border border-gray-300 px-4 py-2">{{ __('aB3x9Z') }}</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 font-mono">%</td>
                                <td class="border border-gray-300 px-4 py-2">{{ __('Special Character') }}</td>
                                <td class="border border-gray-300 px-4 py-2 font-mono">{{ __('Pass%%##') }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ __('Pass!@12') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h4 class="text-xl font-semibold mb-3 text-gray-800 mt-6">{{ __('Using Quantifiers in Masks') }}</h4>
                <p class="text-gray-700 mb-4">
                    {{ __('Quantifiers allow you to repeat a mask symbol multiple times without typing it repeatedly. Place the quantifier immediately after the symbol you want to repeat. This makes patterns more concise and easier to read.') }}
                </p>
                <ul class="text-gray-700 mb-4 space-y-2 list-disc list-inside">
                    <li><code class="bg-gray-100 px-2 py-1 rounded">#{5}</code> {{ __('- Exactly 5 digits (equivalent to #####)') }}</li>
                    <li><code class="bg-gray-100 px-2 py-1 rounded">@{3,6}</code> {{ __('- Between 3 and 6 uppercase letters') }}
                    </li>
                    <li><code class="bg-gray-100 px-2 py-1 rounded">?{8}</code> {{ __('- Exactly 8 lowercase letters') }}</li>
                    <li><code class="bg-gray-100 px-2 py-1 rounded">${10,15}</code> {{ __('- Between 10 and 15 alphanumeric characters') }}</li>
                </ul>

                <h3 class="text-2xl font-semibold mb-4 text-gray-800 mt-8">{{ __('Regex Generator: Advanced Pattern Matching') }}
                </h3>
                <p class="text-gray-700 mb-4">
                    {{ __("The Regex Generator interprets regular expression patterns and generates strings that match them. This provides far more flexibility and power than masks, allowing complex patterns with alternation, negation, and sophisticated character matching. It's perfect for generating email addresses, URLs, complex IDs, and data that follows intricate rules.") }}
                </p>

                <h4 class="text-xl font-semibold mb-3 text-gray-800 mt-6">{{ __('Character Classes') }}</h4>
                <p class="text-gray-700 mb-4">
                    {{ __('Character classes define a set of characters, and the generator picks one randomly from that set.') }}
                </p>
                <div class="space-y-3 mb-6">
                    <div class="bg-gray-50 p-4 rounded">
                        <code class="text-blue-600 font-semibold">[A-Z]</code>
                        <p class="text-gray-700 text-sm mt-2">{{ __('Matches any uppercase letter from A to Z') }}</p>
                        <p class="text-gray-500 text-xs">{{ __('Example: A, M, Z') }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded">
                        <code class="text-blue-600 font-semibold">[a-z0-9]</code>
                        <p class="text-gray-700 text-sm mt-2">{{ __('Matches any lowercase letter or digit') }}</p>
                        <p class="text-gray-500 text-xs">{{ __('Example: a, m, 5') }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded">
                        <code class="text-blue-600 font-semibold">[^0-9]</code>
                        <p class="text-gray-700 text-sm mt-2">{{ __('Negated class - matches anything except digits') }}</p>
                        <p class="text-gray-500 text-xs">{{ __('Example: a, X, !') }}</p>
                    </div>
                </div>

                <h4 class="text-xl font-semibold mb-3 text-gray-800 mt-6">{{ __('Escape Sequences') }}</h4>
                <p class="text-gray-700 mb-4">
                    {{ __('Shorthand escape sequences provide quick access to common character sets.') }}
                </p>
                <ul class="text-gray-700 mb-4 space-y-2 list-disc list-inside">
                    <li><code class="bg-gray-100 px-2 py-1 rounded">\d</code> {{ __('- Any digit (0-9)') }}</li>
                    <li><code class="bg-gray-100 px-2 py-1 rounded">\w</code> {{ __('- Word character (A-Z, a-z, 0-9, _)') }}</li>
                    <li><code class="bg-gray-100 px-2 py-1 rounded">\s</code> {{ __('- Whitespace (space, tab)') }}</li>
                    <li><code class="bg-gray-100 px-2 py-1 rounded">\D</code> {{ __('- Non-digit') }}</li>
                    <li><code class="bg-gray-100 px-2 py-1 rounded">\W</code> {{ __('- Non-word character') }}</li>
                    <li><code class="bg-gray-100 px-2 py-1 rounded">\S</code> {{ __('- Non-whitespace') }}</li>
                </ul>

                <h4 class="text-xl font-semibold mb-3 text-gray-800 mt-6">{{ __('Quantifiers in Regex') }}</h4>
                <p class="text-gray-700 mb-4">
                    {{ __('Quantifiers specify how many times the preceding element should appear.') }}
                </p>
                <div class="overflow-x-auto mb-6">
                    <table class="min-w-full border-collapse border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2 text-left">{{ __('Quantifier') }}</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">{{ __('Meaning') }}</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">{{ __('Example') }}</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">{{ __('Generates') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 font-mono">*</td>
                                <td class="border border-gray-300 px-4 py-2">{{ __('0 or more') }}</td>
                                <td class="border border-gray-300 px-4 py-2 font-mono">{{ __('a*') }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ __('"", "a", "aa", "aaa"') }}</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 font-mono">+</td>
                                <td class="border border-gray-300 px-4 py-2">{{ __('1 or more') }}</td>
                                <td class="border border-gray-300 px-4 py-2 font-mono">{{ __('\d+') }}</td>
                                <td class="border border-gray-300 px-4 py-2">"1", "23", "456"</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 font-mono">?</td>
                                <td class="border border-gray-300 px-4 py-2">{{ __('0 or 1 (optional)') }}</td>
                                <td class="border border-gray-300 px-4 py-2 font-mono">{{ __('colou?r') }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ __('"color", "colour"') }}</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 font-mono">{{ __('{n}') }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ __('Exactly n times') }}</td>
                                <td class="border border-gray-300 px-4 py-2 font-mono">{{ __('\d{4}') }}</td>
                                <td class="border border-gray-300 px-4 py-2">"1234", "5678"</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 font-mono">{{ __('{n,m}') }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ __('Between n and m') }}</td>
                                <td class="border border-gray-300 px-4 py-2 font-mono">{{ __('[A-Z]{2,4}') }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ __('"AB", "XYZ", "ABCD"') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h4 class="text-xl font-semibold mb-3 text-gray-800 mt-6">{{ __('Groups and Alternation') }}</h4>
                <p class="text-gray-700 mb-4">
                    {{ __('Groups allow you to apply quantifiers to multiple characters, while alternation lets you choose between different options.') }}
                </p>
                <div class="space-y-3 mb-6">
                    <div class="bg-gray-50 p-4 rounded">
                        <code class="text-blue-600 font-semibold">(abc)+</code>
                        <p class="text-gray-700 text-sm mt-2">{{ __('Repeats the entire group "abc" one or more times') }}</p>
                        <p class="text-gray-500 text-xs">{{ __('Example: "abc", "abcabc", "abcabcabc"') }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded">
                        <code class="text-blue-600 font-semibold">(com|net|org)</code>
                        <p class="text-gray-700 text-sm mt-2">{{ __('Matches one of: "com", "net", or "org"') }}</p>
                        <p class="text-gray-500 text-xs">{{ __('Example: "com", "net", "org"') }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded">
                        <code class="text-blue-600 font-semibold">user(1|2|3)@example\.(com|net)</code>
                        <p class="text-gray-700 text-sm mt-2">{{ __('Complex pattern with multiple alternations') }}</p>
                        <p class="text-gray-500 text-xs">{{ __('Example: "') }}user1@example.com", "user2@example.net"</p>
                    </div>
                </div>

                <h3 class="text-2xl font-semibold mb-4 text-gray-800 mt-8">{{ __('Understanding Seeds for Reproducible Data') }}
                </h3>
                <p class="text-gray-700 mb-4">
                    {{ __("A seed is a starting value for a random number generator. When you provide the same seed, you'll get the exact same sequence of \"random\" results. This is incredibly useful for testing, debugging, and creating reproducible datasets that multiple team members can generate independently.") }}
                </p>

                <h4 class="text-xl font-semibold mb-3 text-gray-800 mt-6">{{ __('When to Use Seeds') }}</h4>
                <ul class="text-gray-700 mb-4 space-y-2 list-disc list-inside">
                    <li><strong>{{ __('Testing:') }}</strong> {{ __('Generate the same test data across different environments') }}</li>
                    <li><strong>{{ __('Debugging:') }}</strong> {{ __('Reproduce issues with identical data') }}</li>
                    <li><strong>{{ __('Team Collaboration:') }}</strong> {{ __('Share a seed so everyone generates the same dataset') }}</li>
                    <li><strong>{{ __('Version Control:') }}</strong> {{ __('Document seeds in your tests for consistency') }}</li>
                    <li><strong>{{ __('Auditing:') }}</strong> {{ __('Prove that data was generated with specific parameters') }}</li>
                </ul>

                <p class="text-gray-700 mb-4">
                    {{ __('Leave the seed empty if you want truly random results each time. Use the random seed button (🎲) to generate a new seed value that you can save for later use.') }}
                </p>

                <h3 class="text-2xl font-semibold mb-4 text-gray-800 mt-8">{{ __('Real-World Use Cases') }}</h3>

                <div class="space-y-4 mb-6">
                    <div class="border-l-4 border-green-500 pl-4">
                        <h4 class="font-semibold text-gray-800 mb-1">{{ __('Software Testing') }}</h4>
                        <p class="text-gray-600 text-sm">{{ __('Generate test data for unit tests, integration tests, and UI testing. Create phone numbers, emails, usernames, and IDs that look realistic but are completely fake.') }}</p>
                        <code
                            class="text-xs bg-gray-100 px-2 py-1 rounded mt-2 inline-block">test_user_?{8}@example.com</code>
                    </div>

                    <div class="border-l-4 border-blue-500 pl-4">
                        <h4 class="font-semibold text-gray-800 mb-1">{{ __('Database Population') }}</h4>
                        <p class="text-gray-600 text-sm">{{ __('Populate development and staging databases with realistic-looking data for demos, performance testing, and development. Generate thousands of records quickly.') }}
                        </p>
                        <code class="text-xs bg-gray-100 px-2 py-1 rounded mt-2 inline-block">USER-\d{8}</code>
                    </div>

                    <div class="border-l-4 border-purple-500 pl-4">
                        <h4 class="font-semibold text-gray-800 mb-1">{{ __('API Development') }}</h4>
                        <p class="text-gray-600 text-sm">{{ __('Create mock API responses, generate API keys, session tokens, and test identifiers for API endpoint testing and documentation.') }}</p>
                        <code class="text-xs bg-gray-100 px-2 py-1 rounded mt-2 inline-block">[A-Z0-9]{32}</code>
                    </div>

                    <div class="border-l-4 border-orange-500 pl-4">
                        <h4 class="font-semibold text-gray-800 mb-1">{{ __('Form Testing') }}</h4>
                        <p class="text-gray-600 text-sm">{{ __('Generate valid-looking data for form validation testing, ensuring your forms handle various input formats correctly.') }}</p>
                        <code class="text-xs bg-gray-100 px-2 py-1 rounded mt-2 inline-block">(###) ###-####</code>
                    </div>

                    <div class="border-l-4 border-red-500 pl-4">
                        <h4 class="font-semibold text-gray-800 mb-1">{{ __('Load Testing') }}</h4>
                        <p class="text-gray-600 text-sm">{{ __('Create large volumes of unique test data for load testing and stress testing applications, ensuring performance under realistic conditions.') }}</p>
                        <code class="text-xs bg-gray-100 px-2 py-1 rounded mt-2 inline-block">TXN-[A-Z0-9]{12}</code>
                    </div>

                    <div class="border-l-4 border-yellow-500 pl-4">
                        <h4 class="font-semibold text-gray-800 mb-1">{{ __('Documentation Examples') }}</h4>
                        <p class="text-gray-600 text-sm">{{ __('Generate consistent example data for documentation, tutorials, and training materials using seeds to ensure examples remain stable.') }}</p>
                        <code class="text-xs bg-gray-100 px-2 py-1 rounded mt-2 inline-block">example_\w{5,10}</code>
                    </div>
                </div>

                <h3 class="text-2xl font-semibold mb-4 text-gray-800 mt-8">{{ __('Practical Examples Library') }}</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-bold text-gray-800 mb-2">{{ __('📱 Phone Numbers') }}</h4>
                        <div class="space-y-2 text-sm">
                            <div><code class="bg-green-50 px-2 py-1 rounded">(###) ###-####</code></div>
                            <div><code class="bg-blue-50 px-2 py-1 rounded">\(\d{3}\) \d{3}-\d{4}</code></div>
                            <p class="text-gray-600 text-xs">{{ __('US format: (555) 123-4567') }}</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-bold text-gray-800 mb-2">{{ __('✉️ Email Addresses') }}</h4>
                        <div class="space-y-2 text-sm">
                            <div><code class="bg-green-50 px-2 py-1 rounded">????@????.com</code></div>
                            <div><code class="bg-blue-50 px-2 py-1 rounded">\w{5,10}@\w{5,8}\.(com|net)</code></div>
                            <p class="text-gray-600 text-xs">user@domain.com</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-bold text-gray-800 mb-2">{{ __('💳 Credit Cards') }}</h4>
                        <div class="space-y-2 text-sm">
                            <div><code class="bg-green-50 px-2 py-1 rounded">####-####-####-####</code></div>
                            <div><code class="bg-blue-50 px-2 py-1 rounded">\d{4}-\d{4}-\d{4}-\d{4}</code></div>
                            <p class="text-gray-600 text-xs">1234-5678-9012-3456</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-bold text-gray-800 mb-2">{{ __('🔑 API Keys') }}</h4>
                        <div class="space-y-2 text-sm">
                            <div><code class="bg-green-50 px-2 py-1 rounded">${32}</code></div>
                            <div><code class="bg-blue-50 px-2 py-1 rounded">[A-Za-z0-9]{32}</code></div>
                            <p class="text-gray-600 text-xs">{{ __('aB3xY9zK4m...') }}</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-bold text-gray-800 mb-2">{{ __('🚗 License Plates') }}</h4>
                        <div class="space-y-2 text-sm">
                            <div><code class="bg-green-50 px-2 py-1 rounded">@@@-####</code>
                            </div>
                            <div><code class="bg-blue-50 px-2 py-1 rounded">[A-Z]{3}-\d{4}</code></div>
                            <p class="text-gray-600 text-xs">{{ __('ABC-1234') }}</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-bold text-gray-800 mb-2">{{ __('🌐 URLs') }}</h4>
                        <div class="space-y-2 text-sm">
                            <div><code class="bg-green-50 px-2 py-1 rounded">https://????.com</code></div>
                            <div><code class="bg-blue-50 px-2 py-1 rounded">https?://\w{5,10}\.(com|org)</code></div>
                            <p class="text-gray-600 text-xs">https://example.com</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-bold text-gray-800 mb-2">{{ __('🏦 IBAN Numbers') }}</h4>
                        <div class="space-y-2 text-sm">
                            <div><code class="bg-green-50 px-2 py-1rounded">@@##${20}</code>
                            </div>
                            <div><code class="bg-blue-50 px-2 py-1 rounded">[A-Z]{2}\d{2}[A-Z0-9]{20}</code></div>
                            <p class="text-gray-600 text-xs">{{ __('GB29NWBK60161331926819') }}</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-bold text-gray-800 mb-2">{{ __('🎨 Hex Colors') }}</h4>
                        <div class="space-y-2 text-sm">
                            <div><code
                                    class="bg-green-50 px-2 py-1 rounded">#@@@@@@</code>
                            </div>
                            <div><code class="bg-blue-50 px-2 py-1 rounded">#[0-9A-F]{6}</code></div>
                            <p class="text-gray-600 text-xs">{{ __('#FF5733') }}</p>
                        </div>
                    </div>
                </div>

                <h3 class="text-2xl font-semibold mb-4 text-gray-800 mt-8">{{ __('Advanced Techniques') }}</h3>

                <h4 class="text-xl font-semibold mb-3 text-gray-800 mt-6">{{ __('Combining Masks for Complex Patterns') }}</h4>
                <p class="text-gray-700 mb-4">
                    {{ __('You can mix different mask symbols and literal text to create sophisticated patterns. For example, to generate product codes with a prefix, version, and serial:') }}
                </p>
                <div class="bg-gray-50 p-4 rounded mb-4">
                    <code class="text-green-600">PROD-v#.#-${8}-###</code>
                    <p class="text-gray-600 text-sm mt-2">{{ __('Generates: PROD-v2.1-aB3xY9zK-456') }}</p>
                </div>

                <h4 class="text-xl font-semibold mb-3 text-gray-800 mt-6">{{ __('Variable-Length Regex Patterns') }}</h4>
                <p class="text-gray-700 mb-4">
                    {{ __('Use ranges in quantifiers to generate variable-length data, useful for testing edge cases and ensuring your application handles different lengths properly:') }}
                </p>
                <div class="bg-gray-50 p-4 rounded mb-4">
                    <code class="text-blue-600">\w{5,15}@(gmail|yahoo|outlook)\.(com|net)</code>
                    <p class="text-gray-600 text-sm mt-2">{{ __('Generates emails with usernames between 5-15 chars') }}</p>
                </div>

                <h4 class="text-xl font-semibold mb-3 text-gray-800 mt-6">{{ __('Escaping Special Characters') }}</h4>
                <p class="text-gray-700 mb-4">
                    {{ __('When you need to include a mask symbol or regex metacharacter as a literal character, use the backslash escape:') }}
                </p>
                <ul class="text-gray-700 mb-4 space-y-1 list-disc list-inside text-sm">
                    <li>{{ __('Mask:') }} <code class="bg-gray-100 px-2 py-1 rounded">\#TAG-###</code> → #TAG-123</li>
                    <li>{{ __('Regex:') }} <code class="bg-gray-100 px-2 py-1 rounded">Price: \$\d{1,4}\.\d{2}</code> → Price:
                        $99.99</li>
                </ul>

                <h3 class="text-2xl font-semibold mb-4 text-gray-800 mt-8">{{ __('Export Formats Explained') }}</h3>

                <div class="space-y-4 mb-6">
                    <div class="bg-gray-50 p-4 rounded">
                        <h4 class="font-semibold text-gray-800 mb-2">{{ __('📄 CSV (Comma-Separated Values)') }}</h4>
                        <p class="text-gray-600 text-sm">{{ __('Best for importing into spreadsheets like Excel or Google Sheets, or for bulk imports into databases. Includes index, value, and timestamp columns.') }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded">
                        <h4 class="font-semibold text-gray-800 mb-2">{{ __('📝 TXT (Plain Text)') }}</h4>
                        <p class="text-gray-600 text-sm">{{ __('Simple line-by-line format perfect for scripts, command-line tools, or manual review. Includes header comments with generation metadata.') }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded">
                        <h4 class="font-semibold text-gray-800 mb-2">{{ __('🔧 JSON (JavaScript Object Notation)') }}</h4>
                        <p class="text-gray-600 text-sm">{{ __('Structured format ideal for APIs, web applications, and automated systems. Includes full metadata about pattern, seed, count, and timestamp.') }}</p>
                    </div>
                </div>

                <h3 class="text-2xl font-semibold mb-4 text-gray-800 mt-8">{{ __('Tips and Best Practices') }}</h3>

                <div class="bg-blue-50 rounded-lg p-6 mb-6">
                    <ul class="text-gray-700 space-y-3 list-disc list-inside">
                        <li><strong>{{ __('Start Simple:') }}</strong> {{ __("Begin with mask patterns if you're new to data generation. They're easier to understand and perfect for most common formats.") }}</li>
                        <li><strong>{{ __('Use Presets:') }}</strong> {{ __('The preset buttons provide tested patterns for common formats. Modify them to suit your specific needs.') }}</li>
                        <li><strong>{{ __('Test Incrementally:') }}</strong> {{ __('Generate a few results first to verify your pattern works correctly before generating thousands.') }}</li>
                        <li><strong>{{ __('Document Seeds:') }}</strong> {{ __('If using seeds for reproducible data, document them in your code comments or test documentation.') }}</li>
                        <li><strong>{{ __('Consider Length:') }}</strong> {{ __('For regex patterns, set an appropriate max length to prevent excessive output from patterns with * or + quantifiers.') }}</li>
                        <li><strong>{{ __('Export Smart:') }}</strong> {{ __('Use JSON for programmatic access, CSV for databases, and TXT for quick manual use.') }}</li>
                        <li><strong>{{ __('Validate Output:') }}</strong> {{ __('After generation, validate a sample of results to ensure they meet your requirements.') }}</li>
                        <li><strong>{{ __('Batch Generation:') }}</strong> {{ __('Generate larger batches rather than multiple small ones for better performance.') }}</li>
                    </ul>
                </div>

                <h3 class="text-2xl font-semibold mb-4 text-gray-800 mt-8">{{ __('Frequently Asked Questions') }}</h3>

                <div class="space-y-4">
                    <div class="border-b border-gray-200 pb-4">
                        <h4 class="font-semibold text-gray-800 mb-2">{{ __("What's the difference between mask and regex generation?") }}</h4>
                        <p class="text-gray-600">{{ __('Masks use simple symbols (like # for digits) and are easier to learn. Regex provides more power with features like alternation, negation, and complex quantifiers. Use masks for simple formats, regex for complex patterns.') }}</p>
                    </div>

                    <div class="border-b border-gray-200 pb-4">
                        <h4 class="font-semibold text-gray-800 mb-2">{{ __('Why would I use a seed?') }}</h4>
                        <p class="text-gray-600">{{ __('Seeds make your data generation reproducible. The same seed always produces the same sequence of results. This is invaluable for testing, debugging, sharing datasets with teammates, and version control.') }}</p>
                    </div>

                    <div class="border-b border-gray-200 pb-4">
                        <h4 class="font-semibold text-gray-800 mb-2">{{ __('Can I generate truly unique values?') }}</h4>
                        <p class="text-gray-600">{{ __('The generator uses random selection, so duplicates are possible, especially with simple patterns or large quantities. For guaranteed uniqueness, use patterns with high variability or add sequential numbers to your pattern.') }}</p>
                    </div>

                    <div class="border-b border-gray-200 pb-4">
                        <h4 class="font-semibold text-gray-800 mb-2">{{ __("What regex features aren't supported?") }}</h4>
                        <p class="text-gray-600">{{ __("Lookaheads, lookbehinds, backreferences, and some advanced features aren't supported. Anchors (^ and $) are ignored. The generator focuses on practical pattern matching for data generation rather than full regex validation.") }}</p>
                    </div>

                    <div class="border-b border-gray-200 pb-4">
                        <h4 class="font-semibold text-gray-800 mb-2">{{ __('How do I generate emails that look realistic?') }}</h4>
                        <p class="text-gray-600">{{ __('Use patterns like') }} <code
                                class="bg-gray-100 px-1 rounded">\w{5,10}@(gmail|yahoo|outlook)\.(com|net)</code>
                            for varied but realistic email addresses. Combine lowercase letters and numbers for more
                            authentic-looking usernames.</p>
                    </div>

                    <div class="pb-4">
                        <h4 class="font-semibold text-gray-800 mb-2">{{ __('Can I use this for production data?') }}</h4>
                        <p class="text-gray-600">{{ __('This tool generates random data suitable for testing, development, and demos. Never use it for security-sensitive data like real passwords, encryption keys, or anything requiring cryptographic strength. For production IDs, use proper UUID generators.') }}
                        </p>
                    </div>
                </div>

                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 mt-8">
                    <p class="text-sm text-yellow-800">
                        <strong>{{ __('⚠️ Privacy Notice:') }}</strong> {{ __('The data generated by this tool is completely random and does not represent real people, places, or entities. Always use fake data for testing and never use real personal information. Generated data should never be considered secure for cryptographic purposes.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Copied to clipboard!');
        });
    }

    function copyAllResults() {
        const results = @json($generatedResults);
        const text = results.join('\n');
        navigator.clipboard.writeText(text).then(() => {
            alert('All results copied to clipboard!');
        });
    }
</script>
