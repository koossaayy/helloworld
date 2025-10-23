<div>
    <div class="max-w-7xl mx-auto mt-8 p-6">
        <h1 class="text-4xl font-bold mb-2 text-gray-800">{{ self::$title }}</h1>
        <p class="text-lg text-gray-600 mb-8">{{ self::$description }}</p>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Dice Area (Left - 2 columns) -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Dice Display Area -->
                <div
                    class="bg-gradient-to-br from-purple-600 to-blue-700 rounded-lg shadow-xl p-8 relative overflow-hidden min-h-[400px]">
                    <!-- Animated background pattern -->
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute top-0 left-0 w-full h-full"
                            style="background-image: repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.1) 35px, rgba(255,255,255,.1) 70px);">
                        </div>
                    </div>

                    <div class="relative z-10">
                        <!-- Result Display -->
                        @if (count($results) > 0)
                            <div class="text-center mb-8">
                                <!-- Critical Success/Failure Banner -->
                                @if ($criticalSuccess)
                                    <div class="mb-4 animate-bounce">
                                        <div
                                            class="inline-block bg-yellow-400 text-yellow-900 px-6 py-3 rounded-full font-bold text-lg shadow-lg">
                                            ⭐ CRITICAL SUCCESS! ⭐
                                        </div>
                                    </div>
                                @elseif($criticalFailure)
                                    <div class="mb-4 animate-bounce">
                                        <div
                                            class="inline-block bg-red-500 text-white px-6 py-3 rounded-full font-bold text-lg shadow-lg">
                                            💀 CRITICAL FAILURE! 💀
                                        </div>
                                    </div>
                                @endif

                                <!-- Dice Container -->
                                <div id="dice-container" class="flex flex-wrap justify-center gap-4 mb-6">
                                    @foreach ($results as $index => $result)
                                        <div class="dice-result" data-value="{{ $result['value'] }}"
                                            data-index="{{ $index }}">
                                            <div class="dice-3d {{ isset($result['dropped']) && $result['dropped'] ? 'opacity-40' : '' }}
                                                    {{ isset($result['winner']) && $result['winner'] ? 'ring-4 ring-yellow-400' : '' }}
                                                    {{ isset($result['exploded']) && $result['exploded'] ? 'ring-4 ring-red-400' : '' }}"
                                                style="animation: rollDice 0.6s ease-out {{ $index * 0.1 }}s;">
                                                <div
                                                    class="dice-face bg-white rounded-xl shadow-2xl w-20 h-20 flex items-center justify-center border-4 border-gray-200">
                                                    <span
                                                        class="text-4xl font-bold {{ $result['value'] == $diceType ? 'text-green-600' : ($result['value'] == 1 ? 'text-red-600' : 'text-gray-800') }}">
                                                        {{ $result['value'] }}
                                                    </span>
                                                </div>

                                                @if (isset($result['dropped']) && $result['dropped'])
                                                    <div class="absolute inset-0 flex items-center justify-center">
                                                        <div
                                                            class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded rotate-12 shadow-lg">
                                                            DROPPED
                                                        </div>
                                                    </div>
                                                @endif

                                                @if (isset($result['exploded']) && $result['exploded'])
                                                    <div class="absolute -top-2 -right-2">
                                                        <div
                                                            class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg animate-pulse">
                                                            💥
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Total Display -->
                                <div class="space-y-2">
                                    <div class="text-white text-lg">
                                        <span class="opacity-75">Base Total:</span>
                                        <span class="font-bold ml-2">{{ $total }}</span>
                                    </div>

                                    @if ($modifier != 0)
                                        <div class="text-white text-lg">
                                            <span class="opacity-75">Modifier:</span>
                                            <span
                                                class="font-bold ml-2 {{ $modifier > 0 ? 'text-green-300' : 'text-red-300' }}">
                                                {{ $modifier > 0 ? '+' : '' }}{{ $modifier }}
                                            </span>
                                        </div>
                                    @endif

                                    <div class="text-white text-6xl font-bold mt-4 animate-pulse">
                                        {{ $finalTotal }}
                                    </div>
                                    <div class="text-blue-200 text-sm">Final Total</div>
                                </div>
                            </div>
                        @else
                            <div class="text-center text-white py-20">
                                <div class="text-8xl mb-4 animate-bounce">🎲</div>
                                <p class="text-2xl font-semibold">Click "Roll Dice" to start!</p>
                            </div>
                        @endif

                        <!-- Roll Button -->
                        <button wire:click="roll"
                            class="w-full bg-white text-purple-600 hover:bg-gray-100 font-bold py-4 px-6 rounded-lg transition duration-200 shadow-lg text-xl transform hover:scale-105 active:scale-95">
                            🎲 Roll {{ $numberOfDice }}d{{ $diceType }}
                        </button>
                    </div>
                </div>

                <!-- Quick Presets -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">⚡ Quick Presets</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach ($presets as $key => $preset)
                            <button wire:click="applyPreset('{{ $key }}')"
                                class="p-4 rounded-lg border-2 border-gray-300 hover:border-purple-500 hover:bg-purple-50 transition-all duration-200 text-left">
                                <div class="font-bold text-gray-800 text-sm">{{ $preset['name'] }}</div>
                                <div class="text-xs text-gray-500 mt-1">{{ $preset['dice'] }}d{{ $preset['type'] }}
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Dice Settings -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">⚙️ Dice Settings</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Number of Dice -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Number of Dice: <span class="text-purple-600 font-bold">{{ $numberOfDice }}</span>
                            </label>
                            <input type="range" wire:model.live="numberOfDice" min="1" max="10"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-purple-600">
                            <div class="flex justify-between text-xs text-gray-500 mt-1">
                                <span>1</span>
                                <span>10</span>
                            </div>
                        </div>

                        <!-- Dice Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dice Type</label>
                            <select wire:model.live="diceType"
                                class="w-full p-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
                                <option value="4">d4 (1-4)</option>
                                <option value="6">d6 (1-6)</option>
                                <option value="8">d8 (1-8)</option>
                                <option value="10">d10 (1-10)</option>
                                <option value="12">d12 (1-12)</option>
                                <option value="20">d20 (1-20)</option>
                                <option value="100">d100 (1-100)</option>
                            </select>
                        </div>

                        <!-- Modifier -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Modifier: <span
                                    class="text-purple-600 font-bold">{{ $modifier > 0 ? '+' : '' }}{{ $modifier }}</span>
                            </label>
                            <input type="range" wire:model.live="modifier" min="-10" max="10"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-purple-600">
                            <div class="flex justify-between text-xs text-gray-500 mt-1">
                                <span>-10</span>
                                <span>0</span>
                                <span>+10</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Advanced Options -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">🎯 Advanced Options</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- D&D Mechanics -->
                        <div class="space-y-2">
                            <p class="text-sm font-semibold text-gray-700 mb-2">D&D Mechanics (d20)</p>
                            <label class="flex items-center cursor-pointer p-2 hover:bg-gray-50 rounded">
                                <input type="checkbox" wire:model.live="advantage"
                                    class="w-4 h-4 text-purple-600 rounded focus:ring-2 focus:ring-purple-500">
                                <span class="ml-2 text-sm text-gray-700">Advantage (roll 2, keep highest)</span>
                            </label>

                            <label class="flex items-center cursor-pointer p-2 hover:bg-gray-50 rounded">
                                <input type="checkbox" wire:model.live="disadvantage"
                                    class="w-4 h-4 text-purple-600 rounded focus:ring-2 focus:ring-purple-500">
                                <span class="ml-2 text-sm text-gray-700">Disadvantage (roll 2, keep lowest)</span>
                            </label>
                        </div>

                        <!-- Dice Manipulation -->
                        <div class="space-y-2">
                            <p class="text-sm font-semibold text-gray-700 mb-2">Dice Manipulation</p>
                            <label class="flex items-center cursor-pointer p-2 hover:bg-gray-50 rounded">
                                <input type="checkbox" wire:model.live="explodingDice"
                                    class="w-4 h-4 text-purple-600 rounded focus:ring-2 focus:ring-purple-500">
                                <span class="ml-2 text-sm text-gray-700">Exploding Dice (re-roll max)</span>
                            </label>

                            <label class="flex items-center cursor-pointer p-2 hover:bg-gray-50 rounded">
                                <input type="checkbox" wire:model.live="dropLowest"
                                    class="w-4 h-4 text-purple-600 rounded focus:ring-2 focus:ring-purple-500">
                                <span class="ml-2 text-sm text-gray-700">Drop Lowest Die</span>
                            </label>

                            <label class="flex items-center cursor-pointer p-2 hover:bg-gray-50 rounded">
                                <input type="checkbox" wire:model.live="dropHighest"
                                    class="w-4 h-4 text-purple-600 rounded focus:ring-2 focus:ring-purple-500">
                                <span class="ml-2 text-sm text-gray-700">Drop Highest Die</span>
                            </label>
                        </div>

                        <!-- Keep Options -->
                        <div class="space-y-2 md:col-span-2">
                            <p class="text-sm font-semibold text-gray-700 mb-2">Keep Options</p>
                            <div class="grid grid-cols-2 gap-2">
                                <label class="flex items-center cursor-pointer p-2 hover:bg-gray-50 rounded">
                                    <input type="checkbox" wire:model.live="keepHighest"
                                        class="w-4 h-4 text-purple-600 rounded focus:ring-2 focus:ring-purple-500">
                                    <span class="ml-2 text-sm text-gray-700">Keep Only Highest</span>
                                </label>

                                <label class="flex items-center cursor-pointer p-2 hover:bg-gray-50 rounded">
                                    <input type="checkbox" wire:model.live="keepLowest"
                                        class="w-4 h-4 text-purple-600 rounded focus:ring-2 focus:ring-purple-500">
                                    <span class="ml-2 text-sm text-gray-700">Keep Only Lowest</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                @if ($totalRolls > 0)
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold text-gray-800">📊 Session Statistics</h3>
                            <button wire:click="clearHistory"
                                class="text-sm text-red-600 hover:text-red-700 font-semibold">
                                Clear History
                            </button>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-500">
                                <p class="text-sm text-gray-600 mb-1">Total Rolls</p>
                                <p class="text-2xl font-bold text-blue-600">{{ $totalRolls }}</p>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg border-l-4 border-green-500">
                                <p class="text-sm text-gray-600 mb-1">Highest Roll</p>
                                <p class="text-2xl font-bold text-green-600">{{ $highestRoll }}</p>
                            </div>
                            <div class="bg-red-50 p-4 rounded-lg border-l-4 border-red-500">
                                <p class="text-sm text-gray-600 mb-1">Lowest Roll</p>
                                <p class="text-2xl font-bold text-red-600">{{ $lowestRoll }}</p>
                            </div>
                            <div class="bg-purple-50 p-4 rounded-lg border-l-4 border-purple-500">
                                <p class="text-sm text-gray-600 mb-1">Average</p>
                                <p class="text-2xl font-bold text-purple-600">{{ number_format($averageRoll, 1) }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if (count($rollHistory) > 0)
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-xl font-bold mb-4 text-gray-800">📜 Roll History</h3>
                        <div class="space-y-2 max-h-96 overflow-y-auto">
                            @foreach ($rollHistory as $roll)
                                <div
                                    class="p-3 bg-gray-50 rounded-lg border-l-4 {{ $roll['critical'] ? ($roll['criticalType'] === 'success' ? 'border-yellow-500 bg-yellow-50' : 'border-red-500 bg-red-50') : 'border-gray-300' }}">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="font-semibold text-gray-800">
                                                {{ $roll['dice'] }}
                                                @if ($roll['modifier'] != 0)
                                                    <span
                                                        class="text-sm {{ $roll['modifier'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                        {{ $roll['modifier'] > 0 ? '+' : '' }}{{ $roll['modifier'] }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="text-xs text-gray-500">{{ $roll['timestamp'] }}</div>

                                            @if ($roll['critical'])
                                                <div
                                                    class="text-xs font-bold mt-1 {{ $roll['criticalType'] === 'success' ? 'text-yellow-600' : 'text-red-600' }}">
                                                    {{ $roll['criticalType'] === 'success' ? '⭐ CRITICAL!' : '💀 FUMBLE!' }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <div class="text-2xl font-bold text-purple-600">
                                                {{ $roll['finalTotal'] }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                ({{ $roll['total'] }})
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar (Right - 1 column) -->
            <div class="lg:col-span-1 space-y-6">
                <!-- About Section -->
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-8">
                    <h2 class="text-2xl font-bold mb-4 text-gray-800">About Dice Roller</h2>

                    <p class="text-gray-700 mb-4">
                        Roll dice with smooth animations and advanced features. Perfect for D&D, board games, and any
                        tabletop RPG.
                    </p>

                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Features</h3>
                    <ul class="space-y-2 text-gray-700 mb-6 text-sm">
                        <li class="flex items-start gap-2">
                            <span class="text-green-500 mt-1">✓</span>
                            <span>Smooth 3D dice animations</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-500 mt-1">✓</span>
                            <span>Multiple dice types (d4, d6, d8, d10, d12, d20, d100)</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-500 mt-1">✓</span>
                            <span>D&D advantage/disadvantage mechanics</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-500 mt-1">✓</span>
                            <span>Exploding dice (re-roll max values)</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-500 mt-1">✓</span>
                            <span>Drop lowest/highest dice</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-500 mt-1">✓</span>
                            <span>Custom modifiers (+/-)</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-500 mt-1">✓</span>
                            <span>Critical success/failure detection</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-500 mt-1">✓</span>
                            <span>Roll history and statistics</span>
                        </li>
                    </ul>

                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Dice Types</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between p-2 bg-gray-50 rounded">
                            <span class="font-semibold">d4</span>
                            <span class="text-gray-600">Tetrahedron (1-4)</span>
                        </div>
                        <div class="flex justify-between p-2 bg-gray-50 rounded">
                            <span class="font-semibold">d6</span>
                            <span class="text-gray-600">Cube (1-6)</span>
                        </div>
                        <div class="flex justify-between p-2 bg-gray-50 rounded">
                            <span class="font-semibold">d8</span>
                            <span class="text-gray-600">Octahedron (1-8)</span>
                        </div>
                        <div class="flex justify-between p-2 bg-gray-50 rounded">
                            <span class="font-semibold">d10</span>
                            <span class="text-gray-600">Pentagonal (1-10)</span>
                        </div>
                        <div class="flex justify-between p-2 bg-gray-50 rounded">
                            <span class="font-semibold">d12</span>
                            <span class="text-gray-600">Dodecahedron (1-12)</span>
                        </div>
                        <div class="flex justify-between p-2 bg-gray-50 rounded">
                            <span class="font-semibold">d20</span>
                            <span class="text-gray-600">Icosahedron (1-20)</span>
                        </div>
                        <div class="flex justify-between p-2 bg-gray-50 rounded">
                            <span class="font-semibold">d100</span>
                            <span class="text-gray-600">Percentile (1-100)</span>
                        </div>
                    </div>
                </div>

                <!-- Roll History -->

            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-6">
        <livewire:related-tools :current-slug="self::$slug" :related-slugs="self::$relatedTools ?? []" />
    </div>

    <style>
        @keyframes rollDice {
            0% {
                transform: translateY(-100px) rotate(0deg) scale(0.5);
                opacity: 0;
            }

            50% {
                transform: translateY(-20px) rotate(180deg) scale(1.1);
            }

            100% {
                transform: translateY(0) rotate(360deg) scale(1);
                opacity: 1;
            }
        }

        .dice-result {
            position: relative;
            animation: fadeIn 0.5s ease-out;
        }

        .dice-3d {
            transform-style: preserve-3d;
            transition: all 0.3s ease;
        }

        .dice-3d:hover {
            transform: rotateX(20deg) rotateY(20deg) scale(1.1);
        }

        .dice-face {
            transition: all 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        /* Smooth scrollbar for history */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #9333ea;
            border-radius: 10px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #7c3aed;
        }
    </style>

    <script>
        // Listen for dice rolled event
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('diceRolled', (event) => {
                // Play sound effect (optional)
                playDiceSound();

                // Add shake animation to container
                const container = document.getElementById('dice-container');
                if (container) {
                    container.style.animation = 'none';
                    setTimeout(() => {
                        container.style.animation = 'shake 0.5s ease-in-out';
                    }, 10);
                }

                // Confetti effect for critical success
                const results = event.results;
                const diceType = event.diceType;

                if (results.length === 1 && results[0].value === 20 && diceType === 20) {
                    createConfetti();
                }
            });
        });

        function playDiceSound() {
            // Create a simple beep sound using Web Audio API
            const audioContext = new(window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);

            oscillator.frequency.value = 400;
            oscillator.type = 'sine';

            gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.1);

            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.1);
        }

        function createConfetti() {
            const duration = 3 * 1000;
            const animationEnd = Date.now() + duration;
            const defaults = {
                startVelocity: 30,
                spread: 360,
                ticks: 60,
                zIndex: 9999
            };

            function randomInRange(min, max) {
                return Math.random() * (max - min) + min;
            }

            const interval = setInterval(function() {
                const timeLeft = animationEnd - Date.now();

                if (timeLeft <= 0) {
                    return clearInterval(interval);
                }

                const particleCount = 50 * (timeLeft / duration);

                // Create confetti particles using emojis
                for (let i = 0; i < particleCount; i++) {
                    createConfettiParticle();
                }
            }, 250);
        }

        function createConfettiParticle() {
            const particle = document.createElement('div');
            const emojis = ['⭐', '✨', '🎉', '🎊', '💫'];
            particle.textContent = emojis[Math.floor(Math.random() * emojis.length)];
            particle.style.position = 'fixed';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = '-50px';
            particle.style.fontSize = (Math.random() * 20 + 20) + 'px';
            particle.style.zIndex = '9999';
            particle.style.pointerEvents = 'none';
            particle.style.animation = `fall ${Math.random() * 3 + 2}s linear`;

            document.body.appendChild(particle);

            setTimeout(() => {
                particle.remove();
            }, 5000);
        }

        // Add CSS for fall animation
        const style = document.createElement('style');
        style.textContent = `
        @keyframes fall {
            to {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
    `;
        document.head.appendChild(style);
    </script>
</div>
