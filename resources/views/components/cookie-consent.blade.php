<div>
    <button id="cookie-reopen-btn" onclick="toggleCookieBanner(true)" 
        class="hidden fixed bottom-16 left-6 z-40 bg-white/5 border border-white/10 p-3 rounded-full text-white hover:border-[#00ff88] hover:text-[#00ff88] transition-all duration-300 backdrop-blur-md group">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="group-hover:rotate-12 transition-transform">
            <path d="M12 2a10 10 0 1 0 10 10 4 4 0 0 1-5-5 4 4 0 0 1-5-5zm0 0a6 6 0 0 1 6 6"></path>
            <path d="M8.5 8.5h.01"></path>
            <path d="M16 15h.01"></path>
            <path d="M9 16h.01"></path>
        </svg>
    </button>

    <div id="cookie-banner" class="hidden fixed bottom-6 left-6 max-w-md w-[calc(100%-3rem)] bg-[#0a0a0f]/95 border border-white/10 backdrop-blur-xl shadow-2xl z-50 p-8 rounded-sm">
        
    
        <div class="absolute top-0 left-0 w-3 h-3 border-l-2 border-t-2 border-[#00ff88]"></div>
        <div class="absolute bottom-0 right-0 w-3 h-3 border-r-2 border-b-2 border-[#00ff88]"></div>

        <div id="cookie-view-main" class="flex flex-col gap-6">
            <div class="flex items-start gap-5">
                <div class="text-[#00ff88] mt-1 shrink-0">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M12 2a10 10 0 1 0 10 10 4 4 0 0 1-5-5 4 4 0 0 1-5-5"></path>
                        <path d="M8.5 8.5h.01"></path>
                        <path d="M16 15h.01"></path>
                        <path d="M9 16h.01"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-white font-bold text-base tracking-widest uppercase mb-3">Data Protocols</h3>
                    <p class="text-[#ccc] text-sm leading-relaxed">
                        System requires permission to initialize tracking trackers for analytics and optimization purposes.
                        <a href="/privacy-policy" class="text-white underline hover:text-[#00ff88] decoration-[#00ff88]/30 underline-offset-4">View Policy</a>.
                    </p>
                </div>
            </div>

            <div class="flex flex-col gap-3">
                {{-- Row 1: Accept / Reject --}}
                <div class="flex gap-3">
                    <button onclick="acceptAllCookies()" 
                        class="flex-1 bg-[#00ff88]/10 border border-[#00ff88]/50 text-[#00ff88] hover:bg-[#00ff88] hover:text-black px-6 py-3 text-xs font-bold uppercase tracking-wider transition-all">
                        Accept All
                    </button>
                    <button onclick="rejectAllCookies()" 
                        class="flex-1 bg-red-500/10 border border-red-500/50 text-red-500 hover:bg-red-500 hover:text-white px-6 py-3 text-xs font-bold uppercase tracking-wider transition-all">
                        Reject All
                    </button>
                </div>
                
                {{-- Row 2: Customize --}}
                <button onclick="showPreferences()" 
                    class="w-full border border-white/10 text-[#888] hover:text-white hover:border-white/30 px-6 py-3 text-xs font-bold uppercase tracking-wider transition-all">
                    Configure Parameters
                </button>
            </div>
        </div>

        <div id="cookie-view-pref" class="hidden flex-col gap-6">
            <h3 class="text-white font-display text-base tracking-widest uppercase mb-1 border-b border-white/10 pb-4">Configuration</h3>
            
            <div class="space-y-6">
                {{-- Essential --}}
                <div class="flex items-start justify-between gap-4">
                    <div class="flex flex-col gap-1">
                        <span class="text-sm text-white uppercase font-bold tracking-wider">Essential Core</span>
                        <p class="text-xs text-[#888] leading-relaxed">Mandatory scripts required for basic system integrity and navigation functions. Cannot be disabled.</p>
                    </div>
                    <input type="checkbox" checked disabled class="accent-[#00ff88] w-5 h-5 opacity-50 cursor-not-allowed mt-1">
                </div>

                {{-- Analytics --}}
                <div class="flex items-start justify-between gap-4">
                    <div class="flex flex-col gap-1">
                        <span class="text-sm text-white uppercase font-bold tracking-wider">Analytics Stream</span>
                        <p class="text-xs text-[#888] leading-relaxed">Aggregates anonymous usage data to help us optimize performance and fix bugs.</p>
                    </div>
                    <input type="checkbox" id="consent-analytics" class="accent-[#00ff88] w-5 h-5 bg-transparent border-white/20 mt-1 cursor-pointer">
                </div>

                {{-- Marketing --}}
                <div class="flex items-start justify-between gap-4">
                    <div class="flex flex-col gap-1">
                        <span class="text-sm text-white uppercase font-bold tracking-wider">Targeting Arrays</span>
                        <p class="text-xs text-[#888] leading-relaxed">Used to deliver tailored content and advertising based on your interaction history.</p>
                    </div>
                    <input type="checkbox" id="consent-marketing" class="accent-[#00ff88] w-5 h-5 bg-transparent border-white/20 mt-1 cursor-pointer">
                </div>
            </div>

            <div class="flex gap-3 pt-4 border-t border-white/10">
                <button onclick="savePreferences()" 
                    class="flex-1 bg-white text-black hover:bg-[#00ff88] border border-transparent hover:border-[#00ff88] px-4 py-3 text-xs font-bold uppercase tracking-wider transition-all">
                    Save
                </button>
                <button onclick="showMainView()" 
                    class="flex-1 bg-red-500/10 border border-red-500/30 text-red-500 hover:bg-red-500 hover:text-white px-4 py-3 text-xs font-bold uppercase tracking-wider transition-all">
                    Back
                </button>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            checkCookieConsent();
        });

        const banner = document.getElementById('cookie-banner');
        const viewMain = document.getElementById('cookie-view-main');
        const viewPref = document.getElementById('cookie-view-pref');
        const reopenBtn = document.getElementById('cookie-reopen-btn');

        function checkCookieConsent() {
            const consent = localStorage.getItem('cookie_consent_config');
            if (!consent) {
                toggleCookieBanner(true);
            } else {
                const config = JSON.parse(consent);
                if (config.analytics) activateAnalytics();
                if (config.marketing) activateMarketing();
                toggleCookieBanner(false);
            }
        }

        function toggleCookieBanner(show) {
            if (show) {
                banner.classList.remove('hidden');
                reopenBtn.classList.add('hidden');
            } else {
                banner.classList.add('hidden');
                reopenBtn.classList.remove('hidden');
            }
        }

        function showPreferences() {
            viewMain.classList.add('hidden');
            viewPref.classList.remove('hidden');
            viewPref.classList.add('flex');
        }

        function showMainView() {
            viewPref.classList.add('hidden');
            viewPref.classList.remove('flex');
            viewMain.classList.remove('hidden');
        }

        function acceptAllCookies() {
            saveConfig({ essential: true, analytics: true, marketing: true });
        }

        function rejectAllCookies() {
            saveConfig({ essential: true, analytics: false, marketing: false });
        }

        function savePreferences() {
            saveConfig({
                essential: true,
                analytics: document.getElementById('consent-analytics').checked,
                marketing: document.getElementById('consent-marketing').checked
            });
        }

        function saveConfig(config) {
            localStorage.setItem('cookie_consent_config', JSON.stringify(config));
            if (config.analytics) activateAnalytics();
            if (config.marketing) activateMarketing();
            toggleCookieBanner(false);
            setTimeout(() => showMainView(), 500);
        }

        // --- SCRIPTS ---
        function activateAnalytics() {
            if (window.analyticsLoaded) return;
            console.log('>> Analytics Loaded');
            window.analyticsLoaded = true;
        }

        function activateMarketing() {
            if (window.marketingLoaded) return;
            console.log('>> Marketing Loaded');
            window.marketingLoaded = true;
        }
    </script>
</div>