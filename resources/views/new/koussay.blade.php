<div>
    <div class="max-w-7xl mx-auto mt-8 p-6">
        <h1 class="text-4xl font-bold mb-2 text-gray-800">{{ self::$title }}</h1>
        <p class="text-lg text-gray-600 mb-8">{{ self::$description }}</p>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content - Left 2 columns -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Converter Card -->
                <div class="bg-gradient-to-br from-teal-500 to-cyan-600 rounded-lg shadow-lg p-6 text-white">
                    <h2 class="text-2xl font-bold mb-6 flex items-center">
                        <span class="mr-2">🔢</span> Number to Words Converter
                    </h2>

                    <div class="bg-white rounded-lg p-6 text-gray-800">
                        <!-- Input -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Enter Number
                            </label>
                            <input type="text" wire:model.live="numberInput"
                                class="w-full p-4 text-2xl font-bold border-2 border-gray-300 rounded-lg focus:outline-none focus:border-teal-500 text-center"
                                placeholder="Enter number (e.g., 1234)">
                            <p class="text-xs text-gray-500 mt-2 text-center">
                                Supports whole numbers, decimals, and negative numbers
                            </p>
                        </div>

                        <!-- Currency Selection -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Currency (for currency format)
                            </label>
                            <select wire:model.live="currency"
                                class="w-full p-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-teal-500 font-semibold">
                                <option value="USD">🇺🇸 US Dollar (USD)</option>
                                <option value="EUR">🇪🇺 Euro (EUR)</option>
                                <option value="GBP">🇬🇧 British Pound (GBP)</option>
                                <option value="JPY">🇯🇵 Japanese Yen (JPY)</option>
                                <option value="CAD">🇨🇦 Canadian Dollar (CAD)</option>
                                <option value="AUD">🇦🇺 Australian Dollar (AUD)</option>
                            </select>
                        </div>

                        <!-- Error Message -->
                        @if (!empty($error))
                            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                                <p class="text-red-700 font-semibold">{{ $error }}</p>
                            </div>
                        @endif

                        <!-- Clear Button -->
                        @if (!empty($wordsOutput))
                            <div class="flex justify-center mb-6">
                                <button wire:click="clear"
                                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-semibold transition">
                                    🗑️ Clear
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Results Section -->
                @if (!empty($wordsOutput))
                    <div class="space-y-4">
                        <!-- Standard Words -->
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                                <span class="mr-2">📝</span> Standard Format
                            </h3>
                            <div
                                class="bg-gradient-to-r from-teal-50 to-cyan-50 border-l-4 border-teal-500 p-6 rounded-lg">
                                <p class="text-2xl font-semibold text-teal-800 capitalize">
                                    {{ $wordsOutput }}
                                </p>
                            </div>
                        </div>

                        <!-- Ordinal -->
                        @if (!empty($ordinalOutput))
                            <div class="bg-white rounded-lg shadow-lg p-6">
                                <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                                    <span class="mr-2">🥇</span> Ordinal Format
                                </h3>
                                <div
                                    class="bg-gradient-to-r from-purple-50 to-pink-50 border-l-4 border-purple-500 p-6 rounded-lg">
                                    <p class="text-2xl font-semibold text-purple-800 capitalize">
                                        {{ $ordinalOutput }}
                                    </p>
                                    <p class="text-sm text-gray-600 mt-2">
                                        Used for rankings, positions, dates (1st, 2nd, 3rd, etc.)
                                    </p>
                                </div>
                            </div>
                        @endif

                        <!-- Currency -->
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                                <span class="mr-2">💰</span> Currency Format
                            </h3>
                            <div
                                class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-6 rounded-lg">
                                <p class="text-2xl font-semibold text-green-800 capitalize">
                                    {{ $currencyOutput }}
                                </p>
                                <p class="text-sm text-gray-600 mt-2">
                                    Perfect for writing checks and formal documents
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Examples Grid -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-bold mb-4 text-gray-800 flex items-center">
                        <span class="mr-2">💡</span> Quick Examples
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                        @foreach ($examples as $example)
                            <div class="bg-gradient-to-br from-teal-50 to-cyan-50 p-4 rounded-lg border border-teal-200 hover:shadow-md transition cursor-pointer"
                                wire:click="useExample('{{ $example['number'] }}')">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-teal-700">{{ $example['number'] }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $example['description'] }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Use Cases -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-bold mb-4 text-gray-800 flex items-center">
                        <span class="mr-2">📋</span> Common Use Cases
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div
                            class="bg-gradient-to-br from-blue-50 to-cyan-50 p-4 rounded-lg border-l-4 border-blue-500">
                            <h3 class="font-bold text-blue-800 mb-2">✍️ Check Writing</h3>
                            <p class="text-sm text-gray-700">Write out dollar amounts in words to prevent fraud and
                                alteration</p>
                            <p class="text-xs text-blue-600 mt-2 italic">Example: $1,234.56 → "One thousand two hundred
                                thirty-four dollars and fifty-six cents"</p>
                        </div>
                        <div
                            class="bg-gradient-to-br from-purple-50 to-pink-50 p-4 rounded-lg border-l-4 border-purple-500">
                            <h3 class="font-bold text-purple-800 mb-2">📄 Legal Documents</h3>
                            <p class="text-sm text-gray-700">Contracts and agreements require numbers spelled out to
                                avoid ambiguity</p>
                            <p class="text-xs text-purple-600 mt-2 italic">Example: Payment of "Five Thousand Dollars
                                ($5,000)"</p>
                        </div>
                        <div
                            class="bg-gradient-to-br from-green-50 to-teal-50 p-4 rounded-lg border-l-4 border-green-500">
                            <h3 class="font-bold text-green-800 mb-2">🎓 Academic Writing</h3>
                            <p class="text-sm text-gray-700">Style guides often require small numbers to be written out
                            </p>
                            <p class="text-xs text-green-600 mt-2 italic">Example: "There were twenty-three students in
                                the class"</p>
                        </div>
                        <div
                            class="bg-gradient-to-br from-orange-50 to-red-50 p-4 rounded-lg border-l-4 border-orange-500">
                            <h3 class="font-bold text-orange-800 mb-2">🏆 Rankings & Positions</h3>
                            <p class="text-sm text-gray-700">Use ordinal numbers for competition results and rankings
                            </p>
                            <p class="text-xs text-orange-600 mt-2 italic">Example: "She finished in twenty-first place"
                            </p>
                        </div>
                        <div
                            class="bg-gradient-to-br from-yellow-50 to-amber-50 p-4 rounded-lg border-l-4 border-yellow-500">
                            <h3 class="font-bold text-yellow-800 mb-2">🎂 Dates & Ages</h3>
                            <p class="text-sm text-gray-700">Formal invitations and announcements use written numbers
                            </p>
                            <p class="text-xs text-yellow-600 mt-2 italic">Example: "Twenty-first birthday celebration"
                            </p>
                        </div>
                        <div
                            class="bg-gradient-to-br from-indigo-50 to-blue-50 p-4 rounded-lg border-l-4 border-indigo-500">
                            <h3 class="font-bold text-indigo-800 mb-2">📚 Publishing</h3>
                            <p class="text-sm text-gray-700">Books and articles follow style guidelines for number
                                formatting</p>
                            <p class="text-xs text-indigo-600 mt-2 italic">Example: Chapter titles, figure references
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Number Writing Rules -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-bold mb-4 text-gray-800 flex items-center">
                        <span class="mr-2">📐</span> Style Guide Rules
                    </h2>

                    <div class="space-y-4">
                        <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-500">
                            <h3 class="font-bold text-blue-800 mb-2">General Writing</h3>
                            <ul class="text-sm text-gray-700 space-y-1 ml-4">
                                <li>• Spell out numbers one through nine</li>
                                <li>• Use numerals for 10 and above</li>
                                <li>• Spell out numbers at the beginning of sentences</li>
                                <li>• Be consistent within the same document</li>
                            </ul>
                        </div>

                        <div class="bg-green-50 p-4 rounded-lg border-l-4 border-green-500">
                            <h3 class="font-bold text-green-800 mb-2">Financial Writing</h3>
                            <ul class="text-sm text-gray-700 space-y-1 ml-4">
                                <li>• Always spell out amounts on checks</li>
                                <li>• Write both numerals and words in contracts</li>
                                <li>• Use "and" only for decimal points</li>
                                <li>• Example: "One thousand five hundred dollars and fifty cents"</li>
                            </ul>
                        </div>

                        <div class="bg-purple-50 p-4 rounded-lg border-l-4 border-purple-500">
                            <h3 class="font-bold text-purple-800 mb-2">Ordinal Numbers</h3>
                            <ul class="text-sm text-gray-700 space-y-1 ml-4">
                                <li>• Use for rankings: first, second, third</li>
                                <li>• Use for dates: twenty-first century</li>
                                <li>• Use for sequences: the fifth chapter</li>
                                <li>• Hyphenate compound ordinals: twenty-first</li>
                            </ul>
                        </div>

                        <div class="bg-yellow-50 p-4 rounded-lg border-l-4 border-yellow-500">
                            <h3 class="font-bold text-yellow-800 mb-2">Hyphenation</h3>
                            <ul class="text-sm text-gray-700 space-y-1 ml-4">
                                <li>• Hyphenate compound numbers: twenty-one to ninety-nine</li>
                                <li>• Don't hyphenate at hundred/thousand/million</li>
                                <li>• Correct: "forty-five thousand"</li>
                                <li>• Incorrect: "forty five-thousand"</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Interesting Facts -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-bold mb-4 text-gray-800 flex items-center">
                        <span class="mr-2">🎯</span> Interesting Number Facts
                    </h2>
                    <div class="space-y-3">
                        <div
                            class="bg-gradient-to-r from-pink-50 to-rose-50 p-4 rounded-lg border-l-4 border-pink-500">
                            <h3 class="font-bold text-pink-800 mb-1">Longest Single-Word Number</h3>
                            <p class="text-sm text-gray-700">"Eight hundred seventy-seven" (877) has the most letters
                                when written without hyphens!</p>
                        </div>
                        <div
                            class="bg-gradient-to-r from-indigo-50 to-purple-50 p-4 rounded-lg border-l-4 border-indigo-500">
                            <h3 class="font-bold text-indigo-800 mb-1">Googol</h3>
                            <p class="text-sm text-gray-700">A googol (10^100) is "one" followed by one hundred zeros.
                                The tech company Google is named after it!</p>
                        </div>
                        <div
                            class="bg-gradient-to-r from-teal-50 to-cyan-50 p-4 rounded-lg border-l-4 border-teal-500">
                            <h3 class="font-bold text-teal-800 mb-1">Four is Special</h3>
                            <p class="text-sm text-gray-700">Four is the only number in English that has the same
                                number of letters as its value!</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-8">
                    <h2 class="text-2xl font-bold mb-4 text-gray-800">About Number to Words</h2>
                    <p class="text-gray-700 mb-4">
                        Convert any number to its written word form. Essential for checks, legal documents, and formal
                        writing.
                    </p>

                    <h3 class="text-xl font-semibold mb-3 text-gray-800">How to Use</h3>
                    <ol class="list-decimal list-inside text-gray-700 mb-4 space-y-2">
                        <li>Enter any number</li>
                        <li>Select currency (if needed)</li>
                        <li>Get three formats instantly</li>
                        <li>Copy and use in your documents</li>
                    </ol>

                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Output Formats</h3>
                    <div class="bg-gray-50 rounded-lg p-4 mb-4 space-y-3 text-sm">
                        <div>
                            <div class="font-semibold text-gray-800 mb-1">📝 Standard</div>
                            <p class="text-gray-600">General written format</p>
                            <p class="text-xs text-teal-600 italic mt-1">1234 → "one thousand two hundred thirty-four"
                            </p>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-800 mb-1">🥇 Ordinal</div>
                            <p class="text-gray-600">For rankings and positions</p>
                            <p class="text-xs text-purple-600 italic mt-1">21 → "twenty-first"</p>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-800 mb-1">💰 Currency</div>
                            <p class="text-gray-600">For checks and financial docs</p>
                            <p class="text-xs text-green-600 italic mt-1">99.50 → "ninety-nine dollars and fifty cents"
                            </p>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Supported Features</h3>
                    <div class="bg-teal-50 border-l-4 border-teal-500 p-4 rounded-lg text-sm text-teal-800 mb-6">
                        <ul class="space-y-1">
                            <li>✓ Whole numbers</li>
                            <li>✓ Decimal numbers</li>
                            <li>✓ Negative numbers</li>
                            <li>✓ Large numbers (up to trillions)</li>
                            <li>✓ Multiple currencies</li>
                            <li>✓ Ordinal numbers (1st, 2nd, etc.)</li>
                        </ul>
                    </div>

                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Currency Support</h3>
                    <div class="bg-gray-50 rounded-lg p-4 mb-6 text-sm space-y-2">
                        <div class="flex items-center justify-between">
                            <span>🇺🇸 USD</span>
                            <span class="text-gray-600">Dollar/Cent</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>🇪🇺 EUR</span>
                            <span class="text-gray-600">Euro/Cent</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>🇬🇧 GBP</span>
                            <span class="text-gray-600">Pound/Penny</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>🇯🇵 JPY</span>
                            <span class="text-gray-600">Yen/Sen</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>🇨🇦 CAD</span>
                            <span class="text-gray-600">Dollar/Cent</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>🇦🇺 AUD</span>
                            <span class="text-gray-600">Dollar/Cent</span>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Quick Tips</h3>
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg text-sm text-blue-800 mb-6">
                        <ul class="space-y-2">
                            <li>• Use commas for readability: 1,234</li>
                            <li>• Capitalize the first word in formal docs</li>
                            <li>• Include "and" only before cents</li>
                            <li>• Draw a line after amount on checks</li>
                        </ul>
                    </div>

                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Did You Know?</h3>
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg text-sm text-yellow-800 mb-6">
                        <p class="mb-2">The word "hundred" comes from the Old Norse word "hundrath" meaning 120, not
                            100!</p>
                        <p>Writing numbers as words on checks dates back centuries as a security measure against fraud.
                        </p>
                    </div>

                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Related Tools</h3>
                    <ul class="space-y-2">
                        @foreach (self::$relatedTools as $related)
                            <li>
                                <a href="/tools/{{ $related }}"
                                    class="text-teal-600 hover:text-teal-800 font-medium transition">
                                    → {{ ucwords(str_replace('-', ' ', $related)) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
