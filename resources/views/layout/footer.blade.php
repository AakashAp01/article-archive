<footer class="relative border-t border-white/10 bg-bg pt-20 pb-8 overflow-hidden">

    <div
        class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-accent/5 rounded-full blur-[100px] pointer-events-none">
    </div>

    <div class="max-w-7xl mx-auto px-6 relative">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center border-b border-white/10 pb-16 mb-16">
            <div>
                <div class="flex items-center gap-2 text-accent mb-4">
                    <span class="font-display text-md uppercase tracking-widest font-semibold">
                        Weekly Insights
                    </span>
                </div>

                <h2 class="text-3xl md:text-4xl text-white font-bold tracking-tight mb-4">
                    Join the Newsletter
                </h2>

                <p class="text-text-muted max-w-md text-sm leading-relaxed">
                    Get clear, practical insights on modern web development, Laravel, APIs, and frontend architecture.
                    Actionable tech and digital marketing updates straight to your inbox.
                </p>

            </div>

            <form action="{{ route('newsletter.subscribe') }}" method="POST" class="relative group">
                @csrf
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <label for="email_sub" class="sr-only">Email Address</label>
                        <input type="email" name="email" id="email_sub" placeholder="Enter email address..."
                            class="w-full h-14 bg-white/5 border border-white/10 px-6 text-white font-display text-sm outline-none focus:border-accent focus:bg-white/10 transition-all placeholder-[#555]">
                        <div
                            class="absolute top-0 right-0 w-2 h-2 border-t border-r border-accent opacity-0 group-focus-within:opacity-100 transition-opacity">
                        </div>
                    </div>

                    <button type="submit"
                        class="h-14 px-8 bg-accent text-black font-bold font-display uppercase text-sm hover:bg-[#00cc6a] transition-colors flex items-center justify-center gap-2">
                        <span>Subscribe</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14" />
                            <path d="m12 5 7 7-7 7" />
                        </svg>
                    </button>
                </div>
                <p class="mt-3 text-[13px] text-[#555] font-display">* No spam. Unsubscribe command always available.
                </p>
            </form>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-12 mb-20">
            <div class="col-span-2 md:col-span-1">
                <a href="{{ route('welcome') }}" class="block text-2xl text-white font-bold tracking-tighter mb-6">
                    AkashAp<span class="text-accent">.dev</span>
                </a>
                <p class="text-sm text-text-muted leading-relaxed mb-6">
                    Full-Stack Developer specialized in immersive web experiences and scalable architectures.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="text-text-muted hover:text-accent transition-colors"><svg width="20"
                            height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z" />
                            <rect width="4" height="12" x="2" y="9" />
                            <circle cx="4" cy="4" r="2" />
                        </svg></a>
                    <a href="#" class="text-text-muted hover:text-accent transition-colors"><svg width="20"
                            height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path
                                d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4" />
                            <path d="M9 18c-4.51 2-5-2-7-2" />
                        </svg></a>
                    <a href="#" class="text-text-muted hover:text-accent transition-colors"><svg width="20"
                            height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path
                                d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z" />
                        </svg></a>
                </div>
            </div>

            <div>
                <h4 class="font-display text-sm font-semibold text-white uppercase tracking-widest mb-6">Directory</h4>
                <ul class="space-y-3 text-sm font-display">
                    <li><a href="/"
                            class="text-text-muted hover:text-accent transition-all duration-300  block">Home</a></li>
                    <li><a href="/about"
                            class="text-text-muted hover:text-accent transition-all duration-300  block">About Me</a>
                    </li>
                    <li><a href="/projects"
                            class="text-text-muted hover:text-accent transition-all duration-300  block">Projects</a>
                    </li>
                    <li><a href="/contact"
                            class="text-text-muted hover:text-accent transition-all duration-300  block">Contact</a>
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="font-display text-sm font-semibold text-white uppercase tracking-widest mb-6">System Core
                </h4>
                <ul class="space-y-3 text-sm font-display">

                    <li class="text-[#666] flex justify-between">
                        <a href="https://laravel.com" target="_blank" class="hover:text-accent transition-colors">
                            Laravel
                        </a>
                    </li>

                    <li class="text-[#666] flex justify-between">
                        <a href="https://react.dev" target="_blank" class="hover:text-accent transition-colors">
                            React
                        </a>
                    </li>

                    <li class="text-[#666] flex justify-between">
                        <a href="https://threejs.org" target="_blank" class="hover:text-accent transition-colors">
                            Three.js
                        </a>
                    </li>

                    <li class="text-[#666] flex justify-between">
                        <a href="https://tailwindcss.com" target="_blank" class="hover:text-accent transition-colors">
                            Tailwind
                        </a>
                    </li>

                </ul>
            </div>


            <div>
                <h4 class="font-display text-sm font-semibold text-white uppercase tracking-widest mb-6">Protocols</h4>
                <ul class="space-y-3 text-sm font-display">
                    <li><a href="{{ route('privacy') }}"
                            class="text-text-muted hover:text-accent transition-colors">Privacy Policy</a></li>
                    <li><a href="{{ route('terms') }}"
                            class="text-text-muted hover:text-accent transition-colors">Terms of Service</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="text-[10px] text-[#555] font-display uppercase tracking-wider">
                &copy; {{ date('Y') }} AkashAp Systems. All Rights Reserved.
            </div>
            <div class="flex items-center gap-3 bg-white/5 border border-white/10 px-3 py-1.5 rounded-full">
                <div class="relative flex h-2 w-2">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-accent opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-accent"></span>
                </div>
                <span class="text-[10px] font-bold text-[#a0a0a0] font-display uppercase">System Operational</span>
            </div>
        </div>
    </div>
</footer>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('form[action="{{ route('newsletter.subscribe') }}"]');

        if (!form) return;

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const btn = form.querySelector('button[type="submit"]');
            const emailInput = form.querySelector('input[name="email"]');
            const originalHTML = btn.innerHTML;

            btn.innerText = 'Processing...';
            btn.disabled = true;
            btn.classList.add('opacity-70');

            try {
                const response = await fetch("{{ route('newsletter.subscribe') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: new FormData(form),
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error(data.message || 'Subscription failed');
                }

                // Success
                btn.innerText = 'Subscribed';
                emailInput.value = '';
                window.showToast?.('success', 'Subscribed', data.message);

            } catch (err) {
                btn.innerHTML = originalHTML;
                window.showToast?.('error', 'Error', err.message);
            }

            setTimeout(() => {
                btn.innerHTML = originalHTML;
                btn.disabled = false;
                btn.classList.remove('opacity-70');
            }, 2500);
        });
    });
</script>
