<div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex flex-col items-center justify-center p-4 selection:bg-indigo-500 selection:text-white">
    <div class="max-w-2xl w-full bg-white dark:bg-gray-800 shadow-2xl rounded-3xl overflow-hidden transition-all duration-300 hover:shadow-indigo-500/20">
        
        <!-- Header -->
        <div class="bg-linear-to-r from-gray-500 via-gray-400 to-gray-300 p-8 text-center relative overflow-hidden">
            <div class="absolute inset-0 bg-white/10 backdrop-blur-3xl"></div>
            <div class="relative z-10">
                <h1 class="text-3xl font-bold text-white mb-2 tracking-tight">IP Information</h1>
                <p class="text-gray-100 opacity-90 font-light">Your Digital Footprint Analysis</p>
            </div>
        </div>

        <div class="p-8 space-y-8">
            
            <!-- Connection IP Display -->
            <div class="text-center space-y-4">
                <p class="text-sm font-semibold text-gray-400 uppercase tracking-widest">Current Connection</p>
                <div class="relative group inline-block">
                    <h2 class="text-4xl md:text-5xl font-black text-gray-800 dark:text-white tracking-tight font-mono break-all selection:bg-indigo-200 dark:selection:bg-indigo-900">
                        {{ $ip }}
                    </h2>
                    
                    <button 
                        x-data="{ copied: false }"
                        @click="navigator.clipboard.writeText('{{ $ip }}'); copied = true; setTimeout(() => copied = false, 2000)"
                        class="absolute -right-10 top-1/2 -translate-y-1/2 p-2 text-gray-400 hover:text-indigo-500 transition-colors opacity-0 group-hover:opacity-100 focus:opacity-100"
                        title="Copy IP"
                    >
                        <svg x-show="!copied" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        <svg x-show="copied" class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                </div>
                
                <div class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider {{ filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300' : 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' }}">
                    <span class="w-2 h-2 rounded-full mr-2 {{ filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ? 'bg-purple-500' : 'bg-blue-500' }}"></span>
                    {{ filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ? 'IPv6' : 'IPv4' }}
                </div>
            </div>

            <!-- Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Location Info -->
                <div class="bg-gray-50 dark:bg-gray-700/30 p-6 rounded-2xl border border-gray-100 dark:border-gray-700/50 hover:border-indigo-200 dark:hover:border-indigo-900 transition-colors">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Location
                    </h3>
                    @if(isset($data['success']) && $data['success'])
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500 dark:text-gray-400 text-sm">Region</span>
                                <span class="font-medium text-gray-900 dark:text-white text-right">{{ $data['city'] ?? 'Unknown' }}, {{ $data['region_code'] ?? '' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500 dark:text-gray-400 text-sm">Country</span>
                                <span class="font-medium text-gray-900 dark:text-white text-right flex items-center">
                                    <span class="mr-2 text-lg">{{ $data['flag']['emoji'] ?? '' }}</span>
                                    {{ $data['country'] ?? '' }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500 dark:text-gray-400 text-sm">Continent</span>
                                <span class="font-medium text-gray-900 dark:text-white text-right">{{ $data['continent'] ?? '' }}</span>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center h-24 text-gray-400">
                            <svg class="w-8 h-8 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <span class="text-sm">Location Unavailable</span>
                        </div>
                    @endif
                </div>

                <!-- Network Info -->
                <div class="bg-gray-50 dark:bg-gray-700/30 p-6 rounded-2xl border border-gray-100 dark:border-gray-700/50 hover:border-indigo-200 dark:hover:border-indigo-900 transition-colors">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Network
                    </h3>
                    @if(isset($data['success']) && $data['success'])
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500 dark:text-gray-400 text-sm">ISP</span>
                                <span class="font-medium text-gray-900 dark:text-white text-right truncate ml-4" title="{{ $data['connection']['isp'] ?? '' }}">{{ $data['connection']['isp'] ?? 'Unknown' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500 dark:text-gray-400 text-sm">ASN</span>
                                <span class="font-mono text-sm text-indigo-500 bg-indigo-50 dark:bg-indigo-900/30 px-2 py-0.5 rounded">{{ $data['connection']['asn'] ?? 'N/A' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500 dark:text-gray-400 text-sm">Timezone</span>
                                <span class="font-medium text-gray-900 dark:text-white text-right">{{ $data['timezone']['id'] ?? '' }}</span>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center h-24 text-gray-400">
                            <span class="text-sm">Network Data Unavailable</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Client Side Checks for v4/v6 -->
            <div x-data="ipChecker()" x-init="checkIps()" class="border-t border-dashed border-gray-200 dark:border-gray-700 pt-8">
                 <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6 text-center">Protocol Connectivity Check</h3>
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- IPv4 -->
                    <div class="relative group p-4 rounded-xl transition-all duration-300" :class="ipv4 ? 'bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/50' : 'bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700'">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-semibold text-sm" :class="ipv4 ? 'text-blue-800 dark:text-blue-300' : 'text-gray-500'">IPv4</span>
                            <template x-if="ipv4">
                                <span class="text-[10px] bg-blue-200 text-blue-800 px-2 py-0.5 rounded-full dark:bg-blue-800 dark:text-blue-200 font-bold uppercase tracking-wider">Active</span>
                            </template>
                            <template x-if="!ipv4 && !loadingV4">
                                <span class="text-[10px] bg-gray-200 text-gray-600 px-2 py-0.5 rounded-full dark:bg-gray-700 dark:text-gray-400 font-bold uppercase tracking-wider">Inactive</span>
                            </template>
                            <template x-if="loadingV4">
                                <svg class="animate-spin h-4 w-4 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </template>
                        </div>
                        <div class="font-mono text-sm break-all" :class="ipv4 ? 'text-gray-700 dark:text-gray-300' : 'text-gray-400 italic'" x-text="ipv4 || (loadingV4 ? 'Checking connectivity...' : 'Not detected')"></div>
                         
                        <button 
                            x-show="ipv4"
                            @click="navigator.clipboard.writeText(ipv4); copiedV4 = true; setTimeout(() => copiedV4 = false, 2000)"
                            class="absolute right-3 bottom-3 p-1.5 rounded-md hover:bg-blue-100 dark:hover:bg-blue-800/50 text-blue-600 dark:text-blue-400 transition-colors"
                            :title="copiedV4 ? 'Copied!' : 'Copy Address'"
                        >
                            <svg x-show="!copiedV4" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            <svg x-show="copiedV4" class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </div>

                    <!-- IPv6 -->
                    <div class="relative group p-4 rounded-xl transition-all duration-300" :class="ipv6 ? 'bg-purple-50 dark:bg-purple-900/20 border border-purple-100 dark:border-purple-800/50' : 'bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700'">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-semibold text-sm" :class="ipv6 ? 'text-purple-800 dark:text-purple-300' : 'text-gray-500'">IPv6</span>
                            <template x-if="ipv6">
                                <span class="text-[10px] bg-purple-200 text-purple-800 px-2 py-0.5 rounded-full dark:bg-purple-800 dark:text-purple-200 font-bold uppercase tracking-wider">Active</span>
                            </template>
                            <template x-if="!ipv6 && !loadingV6">
                                <span class="text-[10px] bg-gray-200 text-gray-600 px-2 py-0.5 rounded-full dark:bg-gray-700 dark:text-gray-400 font-bold uppercase tracking-wider">Inactive</span>
                            </template>
                            <template x-if="loadingV6">
                                <svg class="animate-spin h-4 w-4 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </template>
                        </div>
                        <div class="font-mono text-sm break-all" :class="ipv6 ? 'text-gray-700 dark:text-gray-300' : 'text-gray-400 italic'" x-text="ipv6 || (loadingV6 ? 'Checking connectivity...' : 'Not detected')"></div>
                        
                        <button 
                            x-show="ipv6"
                            @click="navigator.clipboard.writeText(ipv6); copiedV6 = true; setTimeout(() => copiedV6 = false, 2000)"
                            class="absolute right-3 bottom-3 p-1.5 rounded-md hover:bg-purple-100 dark:hover:bg-purple-800/50 text-purple-600 dark:text-purple-400 transition-colors"
                            :title="copiedV6 ? 'Copied!' : 'Copy Address'"
                        >
                            <svg x-show="!copiedV6" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            <svg x-show="copiedV6" class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </div>
                 </div>
            </div>

        </div>
        
        <!-- Footer Actions -->
        <div class="bg-gray-50 dark:bg-gray-800/50 p-6 flex justify-center border-t border-gray-100 dark:border-gray-700">
            <button wire:click="refresh" class="group flex items-center px-6 py-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl shadow-sm hover:shadow-md transition-all text-gray-700 dark:text-gray-200 font-medium hover:border-indigo-300 dark:hover:border-indigo-500">
                <svg wire:loading.animate="spin" class="w-5 h-5 mr-2 text-indigo-500 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                <span wire:loading.remove>Refresh Data</span>
                <span wire:loading>Refreshing...</span>
            </button>
        </div>
    </div>

    <script>
        function ipChecker() {
            return {
                ipv4: null,
                ipv6: null,
                loadingV4: true,
                loadingV6: true,
                copiedV4: false,
                copiedV6: false,
                async checkIps() {
                    this.loadingV4 = true;
                    this.loadingV6 = true;

                    // Check IPv4
                    fetch('https://api.ipify.org?format=json')
                        .then(res => res.json())
                        .then(data => {
                            this.ipv4 = data.ip;
                        })
                        .catch(e => {
                            this.ipv4 = null;
                        })
                        .finally(() => {
                            this.loadingV4 = false;
                        });

                    // Check IPv6
                    fetch('https://api6.ipify.org?format=json')
                        .then(res => res.json())
                        .then(data => {
                            this.ipv6 = data.ip;
                        })
                        .catch(e => {
                            this.ipv6 = null;
                        })
                        .finally(() => {
                            this.loadingV6 = false;
                        });
                }
            }
        }
    </script>
</div>