<div id="confirmModal" class="fixed inset-0 z-[100] hidden">
    {{-- Backdrop with Blur --}}
    <div class="absolute inset-0 bg-black/90 backdrop-blur-sm transition-opacity opacity-0" id="confirmBackdrop"></div>

    {{-- Modal Content --}}
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md p-1 pointer-events-none opacity-0 transition-all duration-300 scale-95"
        id="confirmContent">

        {{-- Inner Card --}}
        <div class="bg-[#0a0a0f] border border-red-500/30 p-8 pointer-events-auto relative overflow-hidden">

            {{-- Technical Decor Lines --}}
            <div class="absolute top-0 left-0 w-2 h-2 border-l border-t border-red-500"></div>
            <div class="absolute bottom-0 right-0 w-2 h-2 border-r border-b border-red-500"></div>
            <div class="absolute top-0 right-0 w-full h-[1px] bg-gradient-to-l from-red-500/20 to-transparent"></div>

            <div class="text-center">
                {{-- Warning Icon --}}
                <div
                    class="mx-auto w-16 h-16 border border-red-500/20 rounded-full flex items-center justify-center mb-6 bg-red-500/5 relative">
                    <div class="absolute inset-0 rounded-full border border-red-500/20 animate-ping opacity-20"></div>
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" class="text-red-500">
                        <path
                            d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                        <line x1="12" y1="9" x2="12" y2="13" />
                        <line x1="12" y1="17" x2="12.01" y2="17" />
                    </svg>
                </div>

                <h3 class="text-xl text-white font-light mb-2 tracking-tight">Confirm Deletion</h3>
                <p class="text-[10px] text-red-400 font-display uppercase tracking-widest mb-6">Action Cannot Be Undone
                </p>

                <p class="text-sm text-[#888] mb-8 leading-relaxed font-light">
                    You are about to permanently remove this entry from the grid.
                </p>

                <div class="flex gap-4">
                    <button type="button" onclick="closeConfirmModal()"
                        class="flex-1 py-3 border border-white/10 text-[#666] text-xs font-display uppercase tracking-widest hover:bg-white/5 hover:text-white transition-colors">
                        Cancel
                    </button>

                    <button type="button" onclick="confirmAction()"
                        class="flex-1 py-3 bg-red-500/10 border border-red-500/50 text-red-400 text-xs font-display uppercase tracking-widest hover:bg-red-500 hover:text-white transition-all ">
                        Proceed
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let formToSubmit = null;

    // Open Modal and store the form reference
    function openConfirmModal(formElement) {
        formToSubmit = formElement;
        const modal = document.getElementById('confirmModal');
        const backdrop = document.getElementById('confirmBackdrop');
        const content = document.getElementById('confirmContent');

        modal.classList.remove('hidden');

        // Small delay for transition
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            content.classList.remove('opacity-0', 'scale-95');
        }, 10);
    }

    // Close Modal
    function closeConfirmModal() {
        const modal = document.getElementById('confirmModal');
        const backdrop = document.getElementById('confirmBackdrop');
        const content = document.getElementById('confirmContent');

        backdrop.classList.add('opacity-0');
        content.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
            formToSubmit = null;
        }, 300);
    }

    // Submit the stored form
    function confirmAction() {
        if (formToSubmit) {
            // Optional: Change button text to indicate processing
            const btn = document.querySelector('#confirmContent button:last-child');
            btn.innerText = 'DELETING...';

            formToSubmit.submit();
        }
    }
</script>
