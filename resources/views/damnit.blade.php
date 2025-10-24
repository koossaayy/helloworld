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
                        <div class="font-bold text-lg text-gray-800">Mask Generator</div>
                        <div class="text-sm text-gray-600 mt-1">Simple pattern-based generation</div>
                    </button>
                    <button wire:click="$set('generatorType', 'regex')"
                        class="p-6 rounded-lg border-2 transition-all duration-200 {{ $generatorType === 'regex' ? 'border-blue-500 bg-blue-50' : 'border-gray-300 hover:border-blue-300' }}">
                        <div class="text-4xl mb-2">⚡</div>
                        <div class="font-bold text-lg text-gray-800">Regex Generator</div>
                        <div class="text-sm text-gray-600 mt-1">Advanced regex-based generation</div>
                    </button>
                </div>
            </div>

            <!-- Generated Results Display -->
            <div
                class="bg-gradient-to-br from-{{ $generatorType === 'mask' ? 'green' : 'blue' }}-500 to-{{ $generatorType === 'mask' ? 'teal' : 'indigo' }}-600 rounded-lg shadow-lg p-6 text-white">
                <h2 class="text-2xl font-bold mb-4">Generated Results</h2>

                @if ($errorMessage)
                    <div class="bg-red-500 bg-opacity-90 text-white px-4 py-3 rounded mb-4">
                        <strong>Error:</strong> {{ $errorMessage }}
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
                        <p class="text-center text-white text-opacity-70 py-12">No results generated yet</p>
                    @endif
                </div>

                <div class="flex flex-wrap gap-2 mt-4">
                    <button wire:click="generate"
                        class="flex-1 bg-white text-{{ $generatorType === 'mask' ? 'green' : 'blue' }}-600 hover:bg-gray-100 font-semibold py-3 px-6 rounded-lg transition duration-200">
                        ✨ Generate
                    </button>
                    @if (count($generatedResults) > 0)
                        <button onclick="copyAllResults()"
                            class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                            📋 Copy All
                        </button>
                        <button wire:click="exportToCsv"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-200">
                            CSV
                        </button>
                        <button wire:click="exportToTxt"
                            class="bg-gray-700 hover:bg-gray-800 text-white font-semibold py-3 px-4 rounded-lg transition duration-200">
                            TXT
                        </button>
                        <button wire:click="exportToJson"
                            class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-200">
                            JSON
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
                    <h3 class="text-xl font-bold mb-4 text-gray-800">⚙️ Mask Settings</h3>

                    <!-- Preset Patterns -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Quick Presets</label>
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
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mask Pattern</label>
                        <input type="text" wire:model.blur="maskPattern" wire:change="generateFromMask"
                            placeholder="e.g., ###-###-####"
                            class="w-full p-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500 font-mono">

                        <!-- Mask Symbols Legend -->
                        <div class="mt-3 p-4 bg-green-50 rounded-lg">
                            <div class="text-sm font-semibold text-gray-700 mb-2">Available Mask Symbols:</div>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 text-xs">
                                <div><code class="bg-white px-2 py-1 rounded">#</code> = Digit (0-9)</div>
                                <div><code class="bg-white px-2 py-1 rounded">@</code> = Uppercase (A-Z)</div>
                                <div><code class="bg-white px-2 py-1 rounded">?</code> = Lowercase (a-z)</div>
                                <div><code class="bg-white px-2 py-1 rounded">!</code> = Any Letter</div>
                                <div><code class="bg-white px-2 py-1 rounded">$</code> = Alphanumeric</div>
                                <div><code class="bg-white px-2 py-1 rounded">%</code> = Special Char</div>
                            </div>
                            <div class="text-xs text-gray-600 mt-2">
                                Use <code class="bg-white px-1 rounded">\</code> to escape symbols.
                                Add <code class="bg-white px-1 rounded">{n}</code> for repetition (e.g., <code
                                    class="bg-white px-1 rounded">#{5}</code> = 5 digits)
                            </div>
                        </div>
                    </div>

                    <!-- Count and Seed -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Number of Results (1-1000)
                            </label>
                            <input type="number" wire:model="maskCount" min="1" max="1000"
                                class="w-full p-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Random Seed (optional)
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
                            <p class="text-xs text-gray-500 mt-1">Same seed = reproducible results</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Regex Settings -->
            @if ($generatorType === 'regex')
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">⚙️ Regex Settings</h3>

                    <!-- Preset Patterns -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Quick Presets</label>
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
                        <label class="block text-sm font-medium text-gray-700 mb-2">Regex Pattern</label>
                        <input type="text" wire:model.blur="regexPattern" wire:change="generateFromRegex"
                            placeholder="e.g., [A-Z]{3}-\d{4}"
                            class="w-full p-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 font-mono">

                        <!-- Regex Syntax Legend -->
                        <div class="mt-3 p-4 bg-blue-50 rounded-lg">
                            <div class="text-sm font-semibold text-gray-700 mb-2">Supported Regex Features:</div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs">
                                <div><code class="bg-white px-2 py-1 rounded">[A-Z]</code> Character ranges</div>
                                <div><code class="bg-white px-2 py-1 rounded">\d</code> Digits (0-9)</div>
                                <div><code class="bg-white px-2 py-1 rounded">\w</code> Word chars (A-Za-z0-9_)</div>
                                <div><code class="bg-white px-2 py-1 rounded">\s</code> Whitespace</div>
                                <div><code class="bg-white px-2 py-1 rounded">.</code> Any character</div>
                                <div><code class="bg-white px-2 py-1 rounded">*</code> 0 or more</div>
                                <div><code class="bg-white px-2 py-1 rounded">+</code> 1 or more</div>
                                <div><code class="bg-white px-2 py-1 rounded">?</code> 0 or 1</div>
                                <div><code class="bg-white px-2 py-1 rounded">{n}</code> Exactly n times</div>
                                <div><code class="bg-white px-2 py-1 rounded">{n,m}</code> Between n and m</div>
                                <div><code class="bg-white px-2 py-1 rounded">(abc)</code> Grouping</div>
                                <div><code class="bg-white px-2 py-1 rounded">(a|b)</code> Alternation</div>
                            </div>
                            <div class="text-xs text-gray-600 mt-2">
                                Note: Anchors (^, $) are ignored. Complex lookaheads/lookbehinds not supported.
                            </div>
                        </div>
                    </div>

                    <!-- Count, Seed, and Max Length -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Number of Results (1-1000)
                            </label>
                            <input type="number" wire:model="regexCount" min="1" max="1000"
                                class="w-full p-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Max Length
                            </label>
                            <input type="number" wire:model="maxLength" min="10" max="1000"
                                class="w-full p-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Truncate if exceeded</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Random Seed
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
                <h2 class="text-2xl font-bold mb-4 text-gray-800">About Data Generator</h2>

                @if ($generatorType === 'mask')
                    <p class="text-gray-700 mb-4">
                        The Mask Generator uses simple pattern templates to create structured data. It's perfect for
                        generating
                        formatted strings like phone numbers, IDs, serial numbers, and more.
                    </p>

                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Mask Symbols</h3>
                    <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2 text-sm">
                        <li><strong>#</strong> - Random digit (0-9)</li>
                        <li><strong>@</strong> - Random uppercase letter (A-Z)</li>
                        <li><strong>?</strong> - Random lowercase letter (a-z)</li>
                        <li><strong>!</strong> - Random letter (upper or lower)</li>
                        <li><strong>$</strong> - Random alphanumeric character</li>
                        <li><strong>%</strong> - Random special character</li>
                        <li>Any other character is kept as-is</li>
                    </ul>

                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Advanced Features</h3>
                    <ul class="list-disc list-inside text-gray-700 mb-4 space-y-1 text-sm">
                        <li><strong>Quantifiers:</strong> Use <code class="bg-gray-100 px-1 rounded">{n}</code> for
                            repetition</li>
                        <li><strong>Ranges:</strong> <code class="bg-gray-100 px-1 rounded">{n,m}</code> for random
                            count</li>
                        <li><strong>Escaping:</strong> Use <code class="bg-gray-100 px-1 rounded">\</code> before
                            symbols</li>
                        <li><strong>Seeds:</strong> Same seed produces same results</li>
                    </ul>

                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Examples</h3>
                    <div class="space-y-2 text-sm">
                        <div class="bg-gray-50 p-2 rounded">
                            <code class="text-green-600">###-####</code>
                            <div class="text-gray-600 text-xs mt-1">→ 123-4567</div>
                        </div>
                        <div class="bg-gray-50 p-2 rounded">
                            <code class="text-green-600">@@#{5}</code>
                            <div class="text-gray-600 text-xs mt-1">→ AB12345</div>
                        </div>
                        <div class="bg-gray-50 p-2 rounded">
                            <code class="text-green-600">USER-?{6,10}</code>
                            <div class="text-gray-600 text-xs mt-1">→ USER-abcdefgh</div>
                        </div>
                    </div>
                @else
                    <p class="text-gray-700 mb-4">
                        The Regex Generator creates strings that match regular expression patterns. It supports
                        character
                        classes, quantifiers, groups, ranges, and more for complex data generation.
                    </p>

                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Supported Features</h3>
                    <ul class="list-disc list-inside text-gray-700 mb-4 space-y-2 text-sm">
                        <li><strong>Character Classes:</strong> [A-Z], [a-z], [0-9], [^abc]</li>
                        <li><strong>Quantifiers:</strong> *, +, ?, {n}, {n,m}</li>
                        <li><strong>Escape Sequences:</strong> \d, \w, \s, \D, \W, \S</li>
                        <li><strong>Groups:</strong> (abc), (a|b|c)</li>
                        <li><strong>Ranges:</strong> [A-Za-z0-9]</li>
                        <li><strong>Dot:</strong> . matches any character</li>
                    </ul>

                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Limitations</h3>
                    <ul class="list-disc list-inside text-gray-700 mb-4 space-y-1 text-sm">
                        <li>Anchors (^, $) are ignored</li>
                        <li>Lookaheads/lookbehinds not supported</li>
                        <li>Backreferences not supported</li>
                        <li>Max length prevents infinite loops</li>
                    </ul>

                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Examples</h3>
                    <div class="space-y-2 text-sm">
                        <div class="bg-gray-50 p-2 rounded">
                            <code class="text-blue-600">\d{3}-\d{4}</code>
                            <div class="text-gray-600 text-xs mt-1">→ 123-4567</div>
                        </div>
                        <div class="bg-gray-50 p-2 rounded">
                            <code class="text-blue-600">[A-Z]{2}\d{4}</code>
                            <div class="text-gray-600 text-xs mt-1">→ AB1234</div>
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
                        <strong>💡 Tip:</strong> Use seeds for reproducible test data. Export results for use in your
                        applications, testing, or databases.
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
            <h2 class="text-3xl font-bold mb-6 text-gray-800">Complete Guide to Pattern-Based Data Generation</h2>

            <div class="prose prose-lg max-w-none">
                <h3 class="text-2xl font-semibold mb-4 text-gray-800 mt-8">What is Pattern-Based Data Generation?</h3>
                <p class="text-gray-700 mb-4">
                    Pattern-based data generation is a technique for creating structured, formatted data by defining
                    templates
                    or patterns that specify the format and characteristics of the output. This is invaluable for
                    testing,
                    populating databases, creating mock data, and generating realistic sample datasets without manual
                    entry.
                </p>

                <h3 class="text-2xl font-semibold mb-4 text-gray-800 mt-8">Mask Generator: Simple and Intuitive</h3>
                <p class="text-gray-700 mb-4">
                    The Mask Generator uses intuitive symbols to represent different types of characters. Each symbol in
                    your
                    pattern is replaced with a random character from its category. This makes it extremely easy to
                    create
                    formatted data like phone numbers, IDs, license plates, and serial numbers without needing to
                    understand
                    regular expressions.
                </p>

                <h4 class="text-xl font-semibold mb-3 text-gray-800 mt-6">Mask Symbol Reference</h4>
                <div class="overflow-x-auto mb-6">
                    <table class="min-w-full border-collapse border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2 text-left">Symbol</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Generates</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Example Pattern</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Sample Output</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 font-mono">#</td>
                                <td class="border border-gray-300 px-4 py-2">Digit (0-9)</td>
                                <td class="border border-gray-300 px-4 py-2 font-mono">###-####</td>
                                <td class="border border-gray-300 px-4 py-2">123-4567</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 font-mono">@</td>
                                <td class="border border-gray-300 px-4 py-2">Uppercase Letter (A-Z)</td>
                                <td class="border border-gray-300 px-4 py-2 font-mono">@@@-###
                                </td>
                                <td class="border border-gray-300 px-4 py-2">ABC-123</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 font-mono">?</td>
                                <td class="border border-gray-300 px-4 py-2">Lowercase Letter (a-z)</td>
                                <td class="border border-gray-300 px-4 py-2 font-mono">???###</td>
                                <td class="border border-gray-300 px-4 py-2">abc123</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 font-mono">!</td>
                                <td class="border border-gray-300 px-4 py-2">Any Letter (A-Z, a-z)</td>
                                <td class="border border-gray-300 px-4 py-2 font-mono">!!!-###</td>
                                <td class="border border-gray-300 px-4 py-2">aBc-123</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 font-mono">$</td>
                                <td class="border border-gray-300 px-4 py-2">Alphanumeric (A-Z, a-z, 0-9)</td>
                                <td class="border border-gray-300 px-4 py-2 font-mono">$$$</td>
                                <td class="border border-gray-300 px-4 py-2">aB3x9Z</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 font-mono">%</td>
                                <td class="border border-gray-300 px-4 py-2">Special Character</td>
                                <td class="border border-gray-300 px-4 py-2 font-mono">Pass%%##</td>
                                <td class="border border-gray-300 px-4 py-2">Pass!@12</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h4 class="text-xl font-semibold mb-3 text-gray-800 mt-6">Using Quantifiers in Masks</h4>
                <p class="text-gray-700 mb-4">
                    Quantifiers allow you to repeat a mask symbol multiple times without typing it repeatedly. Place the
                    quantifier immediately after the symbol you want to repeat. This makes patterns more concise and
                    easier
                    to read.
                </p>
                <ul class="text-gray-700 mb-4 space-y-2 list-disc list-inside">
                    <li><code class="bg-gray-100 px-2 py-1 rounded">#{5}</code> - Exactly 5 digits (equivalent to
                        #####)</li>
                    <li><code class="bg-gray-100 px-2 py-1 rounded">@{3,6}</code> - Between 3 and 6 uppercase letters
                    </li>
                    <li><code class="bg-gray-100 px-2 py-1 rounded">?{8}</code> - Exactly 8 lowercase letters</li>
                    <li><code class="bg-gray-100 px-2 py-1 rounded">${10,15}</code> - Between 10 and 15 alphanumeric
                        characters</li>
                </ul>

                <h3 class="text-2xl font-semibold mb-4 text-gray-800 mt-8">Regex Generator: Advanced Pattern Matching
                </h3>
                <p class="text-gray-700 mb-4">
                    The Regex Generator interprets regular expression patterns and generates strings that match them.
                    This
                    provides far more flexibility and power than masks, allowing complex patterns with alternation,
                    negation,
                    and sophisticated character matching. It's perfect for generating email addresses, URLs, complex
                    IDs, and
                    data that follows intricate rules.
                </p>

                <h4 class="text-xl font-semibold mb-3 text-gray-800 mt-6">Character Classes</h4>
                <p class="text-gray-700 mb-4">
                    Character classes define a set of characters, and the generator picks one randomly from that set.
                </p>
                <div class="space-y-3 mb-6">
                    <div class="bg-gray-50 p-4 rounded">
                        <code class="text-blue-600 font-semibold">[A-Z]</code>
                        <p class="text-gray-700 text-sm mt-2">Matches any uppercase letter from A to Z</p>
                        <p class="text-gray-500 text-xs">Example: A, M, Z</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded">
                        <code class="text-blue-600 font-semibold">[a-z0-9]</code>
                        <p class="text-gray-700 text-sm mt-2">Matches any lowercase letter or digit</p>
                        <p class="text-gray-500 text-xs">Example: a, m, 5</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded">
                        <code class="text-blue-600 font-semibold">[^0-9]</code>
                        <p class="text-gray-700 text-sm mt-2">Negated class - matches anything except digits</p>
                        <p class="text-gray-500 text-xs">Example: a, X, !</p>
                    </div>
                </div>

                <h4 class="text-xl font-semibold mb-3 text-gray-800 mt-6">Escape Sequences</h4>
                <p class="text-gray-700 mb-4">
                    Shorthand escape sequences provide quick access to common character sets.
                </p>
                <ul class="text-gray-700 mb-4 space-y-2 list-disc list-inside">
                    <li><code class="bg-gray-100 px-2 py-1 rounded">\d</code> - Any digit (0-9)</li>
                    <li><code class="bg-gray-100 px-2 py-1 rounded">\w</code> - Word character (A-Z, a-z, 0-9, _)</li>
                    <li><code class="bg-gray-100 px-2 py-1 rounded">\s</code> - Whitespace (space, tab)</li>
                    <li><code class="bg-gray-100 px-2 py-1 rounded">\D</code> - Non-digit</li>
                    <li><code class="bg-gray-100 px-2 py-1 rounded">\W</code> - Non-word character</li>
                    <li><code class="bg-gray-100 px-2 py-1 rounded">\S</code> - Non-whitespace</li>
                </ul>

                <h4 class="text-xl font-semibold mb-3 text-gray-800 mt-6">Quantifiers in Regex</h4>
                <p class="text-gray-700 mb-4">
                    Quantifiers specify how many times the preceding element should appear.
                </p>
                <div class="overflow-x-auto mb-6">
                    <table class="min-w-full border-collapse border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2 text-left">Quantifier</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Meaning</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Example</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Generates</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 font-mono">*</td>
                                <td class="border border-gray-300 px-4 py-2">0 or more</td>
                                <td class="border border-gray-300 px-4 py-2 font-mono">a*</td>
                                <td class="border border-gray-300 px-4 py-2">"", "a", "aa", "aaa"</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 font-mono">+</td>
                                <td class="border border-gray-300 px-4 py-2">1 or more</td>
                                <td class="border border-gray-300 px-4 py-2 font-mono">\d+</td>
                                <td class="border border-gray-300 px-4 py-2">"1", "23", "456"</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 font-mono">?</td>
                                <td class="border border-gray-300 px-4 py-2">0 or 1 (optional)</td>
                                <td class="border border-gray-300 px-4 py-2 font-mono">colou?r</td>
                                <td class="border border-gray-300 px-4 py-2">"color", "colour"</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 font-mono">{n}</td>
                                <td class="border border-gray-300 px-4 py-2">Exactly n times</td>
                                <td class="border border-gray-300 px-4 py-2 font-mono">\d{4}</td>
                                <td class="border border-gray-300 px-4 py-2">"1234", "5678"</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 font-mono">{n,m}</td>
                                <td class="border border-gray-300 px-4 py-2">Between n and m</td>
                                <td class="border border-gray-300 px-4 py-2 font-mono">[A-Z]{2,4}</td>
                                <td class="border border-gray-300 px-4 py-2">"AB", "XYZ", "ABCD"</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h4 class="text-xl font-semibold mb-3 text-gray-800 mt-6">Groups and Alternation</h4>
                <p class="text-gray-700 mb-4">
                    Groups allow you to apply quantifiers to multiple characters, while alternation lets you choose
                    between different options.
                </p>
                <div class="space-y-3 mb-6">
                    <div class="bg-gray-50 p-4 rounded">
                        <code class="text-blue-600 font-semibold">(abc)+</code>
                        <p class="text-gray-700 text-sm mt-2">Repeats the entire group "abc" one or more times</p>
                        <p class="text-gray-500 text-xs">Example: "abc", "abcabc", "abcabcabc"</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded">
                        <code class="text-blue-600 font-semibold">(com|net|org)</code>
                        <p class="text-gray-700 text-sm mt-2">Matches one of: "com", "net", or "org"</p>
                        <p class="text-gray-500 text-xs">Example: "com", "net", "org"</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded">
                        <code class="text-blue-600 font-semibold">user(1|2|3)@example\.(com|net)</code>
                        <p class="text-gray-700 text-sm mt-2">Complex pattern with multiple alternations</p>
                        <p class="text-gray-500 text-xs">Example: "user1@example.com", "user2@example.net"</p>
                    </div>
                </div>

                <h3 class="text-2xl font-semibold mb-4 text-gray-800 mt-8">Understanding Seeds for Reproducible Data
                </h3>
                <p class="text-gray-700 mb-4">
                    A seed is a starting value for a random number generator. When you provide the same seed, you'll get
                    the exact same sequence of "random" results. This is incredibly useful for testing, debugging, and
                    creating reproducible datasets that multiple team members can generate independently.
                </p>

                <h4 class="text-xl font-semibold mb-3 text-gray-800 mt-6">When to Use Seeds</h4>
                <ul class="text-gray-700 mb-4 space-y-2 list-disc list-inside">
                    <li><strong>Testing:</strong> Generate the same test data across different environments</li>
                    <li><strong>Debugging:</strong> Reproduce issues with identical data</li>
                    <li><strong>Team Collaboration:</strong> Share a seed so everyone generates the same dataset</li>
                    <li><strong>Version Control:</strong> Document seeds in your tests for consistency</li>
                    <li><strong>Auditing:</strong> Prove that data was generated with specific parameters</li>
                </ul>

                <p class="text-gray-700 mb-4">
                    Leave the seed empty if you want truly random results each time. Use the random seed button (🎲) to
                    generate a new seed value that you can save for later use.
                </p>

                <h3 class="text-2xl font-semibold mb-4 text-gray-800 mt-8">Real-World Use Cases</h3>

                <div class="space-y-4 mb-6">
                    <div class="border-l-4 border-green-500 pl-4">
                        <h4 class="font-semibold text-gray-800 mb-1">Software Testing</h4>
                        <p class="text-gray-600 text-sm">Generate test data for unit tests, integration tests, and UI
                            testing.
                            Create phone numbers, emails, usernames, and IDs that look realistic but are completely
                            fake.</p>
                        <code
                            class="text-xs bg-gray-100 px-2 py-1 rounded mt-2 inline-block">test_user_?{8}@example.com</code>
                    </div>

                    <div class="border-l-4 border-blue-500 pl-4">
                        <h4 class="font-semibold text-gray-800 mb-1">Database Population</h4>
                        <p class="text-gray-600 text-sm">Populate development and staging databases with
                            realistic-looking
                            data for demos, performance testing, and development. Generate thousands of records quickly.
                        </p>
                        <code class="text-xs bg-gray-100 px-2 py-1 rounded mt-2 inline-block">USER-\d{8}</code>
                    </div>

                    <div class="border-l-4 border-purple-500 pl-4">
                        <h4 class="font-semibold text-gray-800 mb-1">API Development</h4>
                        <p class="text-gray-600 text-sm">Create mock API responses, generate API keys, session tokens,
                            and test identifiers for API endpoint testing and documentation.</p>
                        <code class="text-xs bg-gray-100 px-2 py-1 rounded mt-2 inline-block">[A-Z0-9]{32}</code>
                    </div>

                    <div class="border-l-4 border-orange-500 pl-4">
                        <h4 class="font-semibold text-gray-800 mb-1">Form Testing</h4>
                        <p class="text-gray-600 text-sm">Generate valid-looking data for form validation testing,
                            ensuring
                            your forms handle various input formats correctly.</p>
                        <code class="text-xs bg-gray-100 px-2 py-1 rounded mt-2 inline-block">(###) ###-####</code>
                    </div>

                    <div class="border-l-4 border-red-500 pl-4">
                        <h4 class="font-semibold text-gray-800 mb-1">Load Testing</h4>
                        <p class="text-gray-600 text-sm">Create large volumes of unique test data for load testing and
                            stress testing applications, ensuring performance under realistic conditions.</p>
                        <code class="text-xs bg-gray-100 px-2 py-1 rounded mt-2 inline-block">TXN-[A-Z0-9]{12}</code>
                    </div>

                    <div class="border-l-4 border-yellow-500 pl-4">
                        <h4 class="font-semibold text-gray-800 mb-1">Documentation Examples</h4>
                        <p class="text-gray-600 text-sm">Generate consistent example data for documentation, tutorials,
                            and training materials using seeds to ensure examples remain stable.</p>
                        <code class="text-xs bg-gray-100 px-2 py-1 rounded mt-2 inline-block">example_\w{5,10}</code>
                    </div>
                </div>

                <h3 class="text-2xl font-semibold mb-4 text-gray-800 mt-8">Practical Examples Library</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-bold text-gray-800 mb-2">📱 Phone Numbers</h4>
                        <div class="space-y-2 text-sm">
                            <div><code class="bg-green-50 px-2 py-1 rounded">(###) ###-####</code></div>
                            <div><code class="bg-blue-50 px-2 py-1 rounded">\(\d{3}\) \d{3}-\d{4}</code></div>
                            <p class="text-gray-600 text-xs">US format: (555) 123-4567</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-bold text-gray-800 mb-2">✉️ Email Addresses</h4>
                        <div class="space-y-2 text-sm">
                            <div><code class="bg-green-50 px-2 py-1 rounded">????@????.com</code></div>
                            <div><code class="bg-blue-50 px-2 py-1 rounded">\w{5,10}@\w{5,8}\.(com|net)</code></div>
                            <p class="text-gray-600 text-xs">user@domain.com</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-bold text-gray-800 mb-2">💳 Credit Cards</h4>
                        <div class="space-y-2 text-sm">
                            <div><code class="bg-green-50 px-2 py-1 rounded">####-####-####-####</code></div>
                            <div><code class="bg-blue-50 px-2 py-1 rounded">\d{4}-\d{4}-\d{4}-\d{4}</code></div>
                            <p class="text-gray-600 text-xs">1234-5678-9012-3456</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-bold text-gray-800 mb-2">🔑 API Keys</h4>
                        <div class="space-y-2 text-sm">
                            <div><code class="bg-green-50 px-2 py-1 rounded">${32}</code></div>
                            <div><code class="bg-blue-50 px-2 py-1 rounded">[A-Za-z0-9]{32}</code></div>
                            <p class="text-gray-600 text-xs">aB3xY9zK4m...</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-bold text-gray-800 mb-2">🚗 License Plates</h4>
                        <div class="space-y-2 text-sm">
                            <div><code class="bg-green-50 px-2 py-1 rounded">@@@-####</code>
                            </div>
                            <div><code class="bg-blue-50 px-2 py-1 rounded">[A-Z]{3}-\d{4}</code></div>
                            <p class="text-gray-600 text-xs">ABC-1234</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-bold text-gray-800 mb-2">🌐 URLs</h4>
                        <div class="space-y-2 text-sm">
                            <div><code class="bg-green-50 px-2 py-1 rounded">https://????.com</code></div>
                            <div><code class="bg-blue-50 px-2 py-1 rounded">https?://\w{5,10}\.(com|org)</code></div>
                            <p class="text-gray-600 text-xs">https://example.com</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-bold text-gray-800 mb-2">🏦 IBAN Numbers</h4>
                        <div class="space-y-2 text-sm">
                            <div><code class="bg-green-50 px-2 py-1rounded">@@##${20}</code>
                            </div>
                            <div><code class="bg-blue-50 px-2 py-1 rounded">[A-Z]{2}\d{2}[A-Z0-9]{20}</code></div>
                            <p class="text-gray-600 text-xs">GB29NWBK60161331926819</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-bold text-gray-800 mb-2">🎨 Hex Colors</h4>
                        <div class="space-y-2 text-sm">
                            <div><code
                                    class="bg-green-50 px-2 py-1 rounded">#@@@@@@</code>
                            </div>
                            <div><code class="bg-blue-50 px-2 py-1 rounded">#[0-9A-F]{6}</code></div>
                            <p class="text-gray-600 text-xs">#FF5733</p>
                        </div>
                    </div>
                </div>

                <h3 class="text-2xl font-semibold mb-4 text-gray-800 mt-8">Advanced Techniques</h3>

                <h4 class="text-xl font-semibold mb-3 text-gray-800 mt-6">Combining Masks for Complex Patterns</h4>
                <p class="text-gray-700 mb-4">
                    You can mix different mask symbols and literal text to create sophisticated patterns. For example,
                    to generate product codes with a prefix, version, and serial:
                </p>
                <div class="bg-gray-50 p-4 rounded mb-4">
                    <code class="text-green-600">PROD-v#.#-${8}-###</code>
                    <p class="text-gray-600 text-sm mt-2">Generates: PROD-v2.1-aB3xY9zK-456</p>
                </div>

                <h4 class="text-xl font-semibold mb-3 text-gray-800 mt-6">Variable-Length Regex Patterns</h4>
                <p class="text-gray-700 mb-4">
                    Use ranges in quantifiers to generate variable-length data, useful for testing edge cases and
                    ensuring your application handles different lengths properly:
                </p>
                <div class="bg-gray-50 p-4 rounded mb-4">
                    <code class="text-blue-600">\w{5,15}@(gmail|yahoo|outlook)\.(com|net)</code>
                    <p class="text-gray-600 text-sm mt-2">Generates emails with usernames between 5-15 chars</p>
                </div>

                <h4 class="text-xl font-semibold mb-3 text-gray-800 mt-6">Escaping Special Characters</h4>
                <p class="text-gray-700 mb-4">
                    When you need to include a mask symbol or regex metacharacter as a literal character, use the
                    backslash escape:
                </p>
                <ul class="text-gray-700 mb-4 space-y-1 list-disc list-inside text-sm">
                    <li>Mask: <code class="bg-gray-100 px-2 py-1 rounded">\#TAG-###</code> → #TAG-123</li>
                    <li>Regex: <code class="bg-gray-100 px-2 py-1 rounded">Price: \$\d{1,4}\.\d{2}</code> → Price:
                        $99.99</li>
                </ul>

                <h3 class="text-2xl font-semibold mb-4 text-gray-800 mt-8">Export Formats Explained</h3>

                <div class="space-y-4 mb-6">
                    <div class="bg-gray-50 p-4 rounded">
                        <h4 class="font-semibold text-gray-800 mb-2">📄 CSV (Comma-Separated Values)</h4>
                        <p class="text-gray-600 text-sm">Best for importing into spreadsheets like Excel or Google
                            Sheets,
                            or for bulk imports into databases. Includes index, value, and timestamp columns.</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded">
                        <h4 class="font-semibold text-gray-800 mb-2">📝 TXT (Plain Text)</h4>
                        <p class="text-gray-600 text-sm">Simple line-by-line format perfect for scripts, command-line
                            tools,
                            or manual review. Includes header comments with generation metadata.</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded">
                        <h4 class="font-semibold text-gray-800 mb-2">🔧 JSON (JavaScript Object Notation)</h4>
                        <p class="text-gray-600 text-sm">Structured format ideal for APIs, web applications, and
                            automated
                            systems. Includes full metadata about pattern, seed, count, and timestamp.</p>
                    </div>
                </div>

                <h3 class="text-2xl font-semibold mb-4 text-gray-800 mt-8">Tips and Best Practices</h3>

                <div class="bg-blue-50 rounded-lg p-6 mb-6">
                    <ul class="text-gray-700 space-y-3 list-disc list-inside">
                        <li><strong>Start Simple:</strong> Begin with mask patterns if you're new to data generation.
                            They're easier to understand and perfect for most common formats.</li>
                        <li><strong>Use Presets:</strong> The preset buttons provide tested patterns for common formats.
                            Modify them to suit your specific needs.</li>
                        <li><strong>Test Incrementally:</strong> Generate a few results first to verify your pattern
                            works correctly before generating thousands.</li>
                        <li><strong>Document Seeds:</strong> If using seeds for reproducible data, document them in your
                            code comments or test documentation.</li>
                        <li><strong>Consider Length:</strong> For regex patterns, set an appropriate max length to
                            prevent
                            excessive output from patterns with * or + quantifiers.</li>
                        <li><strong>Export Smart:</strong> Use JSON for programmatic access, CSV for databases, and TXT
                            for quick manual use.</li>
                        <li><strong>Validate Output:</strong> After generation, validate a sample of results to ensure
                            they meet your requirements.</li>
                        <li><strong>Batch Generation:</strong> Generate larger batches rather than multiple small ones
                            for better performance.</li>
                    </ul>
                </div>

                <h3 class="text-2xl font-semibold mb-4 text-gray-800 mt-8">Frequently Asked Questions</h3>

                <div class="space-y-4">
                    <div class="border-b border-gray-200 pb-4">
                        <h4 class="font-semibold text-gray-800 mb-2">What's the difference between mask and regex
                            generation?</h4>
                        <p class="text-gray-600">Masks use simple symbols (like # for digits) and are easier to learn.
                            Regex provides more power with features like alternation, negation, and complex quantifiers.
                            Use masks for simple formats, regex for complex patterns.</p>
                    </div>

                    <div class="border-b border-gray-200 pb-4">
                        <h4 class="font-semibold text-gray-800 mb-2">Why would I use a seed?</h4>
                        <p class="text-gray-600">Seeds make your data generation reproducible. The same seed always
                            produces the same sequence of results. This is invaluable for testing, debugging, sharing
                            datasets with teammates, and version control.</p>
                    </div>

                    <div class="border-b border-gray-200 pb-4">
                        <h4 class="font-semibold text-gray-800 mb-2">Can I generate truly unique values?</h4>
                        <p class="text-gray-600">The generator uses random selection, so duplicates are possible,
                            especially with simple patterns or large quantities. For guaranteed uniqueness, use patterns
                            with high variability or add sequential numbers to your pattern.</p>
                    </div>

                    <div class="border-b border-gray-200 pb-4">
                        <h4 class="font-semibold text-gray-800 mb-2">What regex features aren't supported?</h4>
                        <p class="text-gray-600">Lookaheads, lookbehinds, backreferences, and some advanced features
                            aren't supported. Anchors (^ and $) are ignored. The generator focuses on practical pattern
                            matching for data generation rather than full regex validation.</p>
                    </div>

                    <div class="border-b border-gray-200 pb-4">
                        <h4 class="font-semibold text-gray-800 mb-2">How do I generate emails that look realistic?</h4>
                        <p class="text-gray-600">Use patterns like <code
                                class="bg-gray-100 px-1 rounded">\w{5,10}@(gmail|yahoo|outlook)\.(com|net)</code>
                            for varied but realistic email addresses. Combine lowercase letters and numbers for more
                            authentic-looking usernames.</p>
                    </div>

                    <div class="pb-4">
                        <h4 class="font-semibold text-gray-800 mb-2">Can I use this for production data?</h4>
                        <p class="text-gray-600">This tool generates random data suitable for testing, development,
                            and demos. Never use it for security-sensitive data like real passwords, encryption keys, or
                            anything requiring cryptographic strength. For production IDs, use proper UUID generators.
                        </p>
                    </div>
                </div>

                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 mt-8">
                    <p class="text-sm text-yellow-800">
                        <strong>⚠️ Privacy Notice:</strong> The data generated by this tool is completely random and
                        does not represent real people, places, or entities. Always use fake data for testing and
                        never use real personal information. Generated data should never be considered secure for
                        cryptographic purposes.
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
