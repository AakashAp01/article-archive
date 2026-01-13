@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
    <style>
        /* EasyMDE Base Overrides */
        .EasyMDEContainer { background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 2px; }
        .editor-toolbar { background: rgba(0, 0, 0, 0.3) !important; border-color: rgba(255, 255, 255, 0.1) !important; color: #fff !important; }
        .editor-toolbar button { color: #888 !important; }
        .editor-toolbar button:hover, .editor-toolbar button.active {
            background: rgba(255, 255, 255, 0.05) !important;
            border-color: #00ff88 !important;
            color: #00ff88 !important;
        }
        .CodeMirror { background: #0a0a0f !important; color: #e0e0e0 !important; border-color: rgba(255, 255, 255, 0.1) !important; font-family: 'Courier New', monospace !important; font-size: 16px; }
        .CodeMirror-cursor { border-left: 2px solid #00ff88 !important; }
        .editor-preview { background: #0a0a0f !important; color: #a0a0a0 !important; padding: 2rem; }
        .editor-preview h1, .editor-preview h2 { color: white; border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        .editor-statusbar { color: #666 !important; border-top: 1px solid rgba(255, 255, 255, 0.05) !important; }
        .EasyMDEContainer.fullscreen { z-index: 9999 !important; position: fixed !important; top: 0 !important; left: 0 !important; }
    </style>
@endpush

{{-- Load Script --}}
@push('scripts')
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            // RELOAD HANDLER FOR EDITOR FIX
            Livewire.on('reload-page', () => {
                setTimeout(() => { window.location.reload(); }, 1500);
            });

            // EDITOR INIT
            let easyMDE = null;
            const initEditor = (initialContent = '') => {
                const element = document.getElementById('email-markdown-editor');
                if (!element) return;
                if (easyMDE) { easyMDE.toTextArea(); easyMDE = null; }
                easyMDE = new EasyMDE({
                    element: element,
                    initialValue: initialContent,
                    spellChecker: false,
                    autosave: { enabled: false },
                    toolbar: ["bold", "italic", "heading", "quote", "code", "link", "preview", "side-by-side", "fullscreen"],
                    status: false,
                });
                easyMDE.codemirror.on('change', () => { @this.set('content', easyMDE.value()); });
            };
            Livewire.on('update-editor-content', ({ content }) => {
                setTimeout(() => { initEditor(content); }, 50);
            });
        });
    </script>
@endpush

{{-- Removed root style variable to fix global color bleeding --}}
<div class="min-h-screen w-full">
    
    <main class="max-w-7xl mx-auto mt-32 px-6 pb-20 relative">

        {{-- ================= LIST VIEW ================= --}}
        @if(!$showForm)
            
            {{-- Header Section --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12 border-b border-white/10 pb-6">
                <div>
                    <h1 class="text-2xl text-white font-semibold mb-2">Email Protocols
                        <p class="text-xs text-[#666] uppercase tracking-widest">System Transmission Grid</p>
                    </h1>
                </div>

                <div class="flex flex-col xl:flex-row items-center gap-4 w-full md:w-auto">
                    
                    {{-- Search Bar --}}
                    <div class="relative w-full md:w-64 group">
                        <input wire:model.live.debounce.300ms="search" type="text"
                            class="w-full bg-black/20 border border-white/10 px-10 py-3 text-xs text-white focus:outline-none focus:border-accent transition-all placeholder-white/20 font-display uppercase tracking-wider"
                            placeholder="SEARCH PROTOCOLS...">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-white/30 group-focus-within:text-accent transition-colors">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </div>
                    </div>

                    {{-- Create Button --}}
                    <button wire:click="create"
                        class="w-full md:w-auto group flex items-center justify-center gap-3 bg-white/5 border border-white/20 hover:border-accent px-6 py-3 transition-all hover:bg-accent/10 cursor-pointer">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-white group-hover:text-accent transition-colors">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                        <span class="text-xs text-white uppercase tracking-widest group-hover:text-accent font-display">
                            Initialize New
                        </span>
                    </button>
                </div>
            </div>

            {{-- Table Grid --}}
            <div class="space-y-4">
                {{-- Headers --}}
                <div class="hidden md:grid grid-cols-12 gap-4 text-[10px] uppercase tracking-widest text-[#666] px-6 pb-2 font-display">
                    <div class="col-span-4">Template Name</div>
                    <div class="col-span-3">System Key</div>
                    <div class="col-span-3">Theme Color</div>
                    <div class="col-span-2 text-right">Controls</div>
                </div>

                @forelse($templates as $tpl)
                    <div class="group relative bg-white/[0.02] border border-white/5 hover:border-accent/50 transition-all duration-300 p-6 md:p-4 rounded-sm">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">

                            {{-- 1. Name & Subject --}}
                            <div class="col-span-1 md:col-span-4">
                                <div class="flex items-center gap-4">
                                    {{-- Icon Box --}}
                                    <div class="w-10 h-10 bg-black/50 border border-white/10 flex items-center justify-center shrink-0">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="text-[#666] group-hover:text-white transition-colors">
                                            <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="text-sm font-medium text-white truncate group-hover:text-accent transition-colors">
                                            {{ $tpl->name }}
                                        </h3>
                                        <div class="mt-1 text-[9px] text-[#666] font-mono truncate">
                                            {{ Str::limit($tpl->subject, 40) }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- 2. System Key --}}
                            <div class="col-span-1 md:col-span-3">
                                <span class="px-2 py-1 text-[9px] uppercase tracking-wider border border-white/10 bg-white/5 text-[#888] font-mono rounded-sm">
                                    {{ $tpl->key }}
                                </span>
                            </div>

                            {{-- 3. Theme Color Preview --}}
                            <div class="col-span-1 md:col-span-3 flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full bg-[{{ $tpl->theme_color ?? '#00ff88' }}]" ></div>
                                <span class="text-[9px] text-[{{ $tpl->theme_color ?? '#00ff88' }}] font-mono uppercase">{{ $tpl->theme_color ?? '#DEFAULT' }}</span>
                            </div>

                            {{-- 4. Actions --}}
                            <div class="col-span-1 md:col-span-2 flex items-center justify-start md:justify-end gap-2 mt-4 md:mt-0 pt-4 md:pt-0 border-t md:border-t-0 border-white/5">
                                
                                {{-- Test Signal --}}
                                <button wire:click="openTestModal({{ $tpl->id }})" 
                                    class="w-8 h-8 flex items-center justify-center border border-blue-500/20 bg-blue-500/5 text-blue-400 hover:border-blue-500 hover:bg-blue-500 hover:text-white transition-all"
                                    title="Test Signal">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13"></path><path d="M22 2L15 22L11 13L2 9L22 2Z"></path></svg>
                                </button>

                                {{-- Edit --}}
                                <button wire:click="edit({{ $tpl->id }})" 
                                    class="w-8 h-8 flex items-center justify-center border border-white/10 bg-black/20 text-[#888] hover:border-white hover:text-white hover:bg-white/5 transition-all"
                                    title="Edit Protocol">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" /></svg>
                                </button>

                                {{-- Delete --}}
                                <button wire:click="confirmDelete({{ $tpl->id }})" 
                                    class="w-8 h-8 flex items-center justify-center border border-red-500/20 bg-red-500/5 text-red-400 hover:border-red-500 hover:bg-red-500 hover:text-white transition-all"
                                    title="Purge Protocol">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18" /><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" /><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" /></svg>
                                </button>
                            </div>
                        </div>

                        {{-- Hover Decor --}}
                        <div class="absolute top-0 left-0 w-2 h-2 border-l border-t border-white/20 group-hover:border-accent"></div>
                        <div class="absolute bottom-0 right-0 w-2 h-2 border-r border-b border-white/20 group-hover:border-accent"></div>
                    </div>
                @empty
                    <div class="py-20 text-center border border-dashed border-white/10 rounded-sm">
                        <p class="text-[#666] mb-4 font-display">No protocols found in the grid.</p>
                        <button wire:click="create" class="text-accent hover:underline text-sm uppercase font-display">Initialize First Entry</button>
                    </div>
                @endforelse

                <div class="pt-6">
                    {{ $templates->links() }}
                </div>
            </div>

        @else 
            {{-- ================= EDITOR VIEW ================= --}}
            <div class="flex items-center justify-between mb-8 border-b border-white/10 pb-6">
                <div>
                    <h1 class="text-2xl text-white font-light">
                        {{ $isEditMode ? 'Edit Template' : 'New Template' }}
                    </h1>
                   
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                {{-- LEFT COLUMN: Content --}}
                <div class="lg:col-span-2 space-y-8">
                    <div class="group">
                        <label class="block text-xs text-[#666] mb-2 uppercase tracking-widest font-display">Internal Name</label>
                        <input wire:model="name" type="text" placeholder="e.g. Welcome Email"
                            class="w-full bg-transparent text-3xl text-white font-light placeholder-[#333] outline-none border-b border-transparent focus:border-accent transition-all pb-2"
                            style="border-color: {{ $theme_color }};">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs text-[#666] mb-2 uppercase tracking-widest font-display">Subject Line</label>
                        <input wire:model="subject" type="text"
                            class="w-full bg-black/40 border border-white/10 px-4 py-3 text-sm text-white focus:outline-none transition-all placeholder-[#444]"
                            style="focus:border-color: {{ $theme_color }};"
                            placeholder="Welcome to the Grid, {{ $name }}">
                        @error('subject') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div wire:ignore>
                        <label class="block text-xs text-[#666] mb-2 uppercase tracking-widest font-display">Content Payload</label>
                        <textarea id="email-markdown-editor"></textarea>
                    </div>
                    @error('content') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- RIGHT COLUMN: Settings --}}
                <div class="space-y-6">
                    {{-- Theme Color --}}
                    <div class="bg-white/5 border border-white/10 p-6 rounded-sm">
                        <h3 class="text-xs text-accent uppercase tracking-widest mb-4 border-b border-white/10 pb-2 font-display">Visual ID</h3>
                        <label class="text-[10px] uppercase text-[#666] block mb-2">Theme Color</label>
                        <div class="flex items-center gap-3">
                            <input wire:model.live="theme_color" type="color" class="w-10 h-10 bg-transparent border-0 cursor-pointer p-0">
                            <input wire:model.live="theme_color" type="text" class="bg-black/40 border border-white/10 p-2 text-white text-xs font-mono w-24 outline-none" style="focus:border-color: {{ $theme_color }};">
                        </div>
                    </div>

                    {{-- System Key --}}
                    <div class="bg-white/5 border border-white/10 p-6 rounded-sm">
                        <h3 class="text-xs text-accent uppercase tracking-widest mb-4 border-b border-white/10 pb-2 font-display">System Identification</h3>
                        <label class="text-[10px] uppercase text-[#666] block mb-1">Unique Key</label>
                        <input wire:model="key" type="text"
                            class="w-full bg-black/40 border border-white/10 p-2 text-white text-xs outline-none font-mono"
                            style="focus:border-color: {{ $theme_color }};"
                            placeholder="welcome_user">
                        @error('key') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>

                    {{-- Variables --}}
                    <div class="bg-white/5 border border-white/10 p-6 rounded-sm">
                        <h3 class="text-xs text-accent uppercase tracking-widest mb-4 border-b border-white/10 pb-2 font-display">Variables</h3>
                        <code class="block bg-black/30 p-2 border border-white/5 font-mono text-xs" style="color: {{ $theme_color }};">Hello @{{ name }}</code>
                    </div>
                </div>
            </div>

            {{-- Editor Footer --}}
            <header class="fixed bottom-0 left-0 w-full bg-[#0a0a0f]/95 border-b border-white/10 h-16 flex items-center justify-between px-6 md:px-8 backdrop-blur-md z-40">
                <button wire:click="cancel" class="group flex items-center gap-3 text-[#666] hover:text-white transition-colors">
                    <div class="w-8 h-8 rounded-full border border-white/10 flex items-center justify-center group-hover:border-accent group-hover:bg-accent/10 transition-all">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                    </div>
                    <span class="text-xs uppercase tracking-widest group-hover:text-accent transition-colors">Abort Entry</span>
                </button>

                <div class="hidden md:flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full animate-pulse" style="background-color: {{ $theme_color }}"></span>
                    <span class="text-[10px] uppercase tracking-[0.2em]" style="color: {{ $theme_color }}">Live Editor Mode</span>
                </div>

                <button wire:click="store" wire:loading.attr="disabled"
                    class="group bg-accent text-sm hover:bg-[#00cc6a] text-black px-6 py-2 flex items-center gap-2 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove class="text-xs font-bold uppercase tracking-wider">Publish Grid</span>
                    <span wire:loading class="text-xs font-bold uppercase tracking-wider">Optimizing...</span>
                    <svg wire:loading.remove width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14" />
                        <path d="m12 5 7 7-7 7" />
                    </svg>
                </button>
            </header>
        @endif

        {{-- ================= DELETE MODAL ================= --}}
        @if ($isDeleteModalOpen)
            <div class="fixed inset-0 z-50 flex items-center justify-center">
                <div class="absolute inset-0 bg-black/90 backdrop-blur-sm" wire:click="$set('isDeleteModalOpen', false)"></div>
                <div class="relative w-full max-w-sm p-6 bg-[#0a0a0a] border border-red-500/30 shadow-[0_0_30px_rgba(255,0,0,0.1)] z-10 text-center animate-fade-in-down">
                    <svg class="mx-auto w-12 h-12 text-red-500 mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                        <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h3 class="text-lg text-white font-light mb-2">Confirm Purge</h3>
                    <p class="text-xs text-[#888] font-mono mb-6">Permanently delete this entry?</p>
                    <div class="flex gap-3">
                        <button wire:click="$set('isDeleteModalOpen', false)"
                            class="flex-1 bg-white/5 border border-white/10 text-white py-3 text-[10px] font-bold uppercase tracking-widest hover:bg-white/10">Cancel</button>
                        <button wire:click="delete"
                            class="flex-1 bg-red-600/20 border border-red-500/50 text-red-500 py-3 text-[10px] font-bold uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all">Confirm</button>
                    </div>
                </div>
            </div>
        @endif

        {{-- ================= TEST EMAIL MODAL ================= --}}
        @if($showTestModal)
            <div class="fixed inset-0 z-50 flex items-center justify-center">
                <div class="absolute inset-0 bg-black/90 backdrop-blur-sm" wire:click="closeTestModal"></div>
                <div class="relative w-full max-w-md p-6 bg-[#0a0a0a] border border-blue-500/30 shadow-[0_0_30px_rgba(0,100,255,0.1)] z-10 animate-fade-in-down">
                    
                    {{-- Header --}}
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-500">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13"></path><path d="M22 2L15 22L11 13L2 9L22 2Z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg text-white font-light">Test Transmission</h3>
                            <p class="text-xs text-[#666] font-mono">Verify signal integrity.</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-[10px] uppercase tracking-widest text-[#666] mb-2 font-display">Target Frequency (Email)</label>
                        <input wire:model="testEmail" type="email" 
                            class="w-full bg-black/40 border border-white/10 px-4 py-3 text-sm text-white focus:border-blue-500 outline-none transition-all placeholder-[#444]"
                            placeholder="user@example.com">
                        @error('testEmail') <span class="text-red-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex gap-3">
                        <button wire:click="closeTestModal" 
                            class="flex-1 bg-white/5 border border-white/10 text-white py-3 text-[10px] font-bold uppercase tracking-widest hover:bg-white/10 font-display">
                            Abort
                        </button>
                        <button wire:click="sendTestMail" wire:loading.attr="disabled"
                            class="flex-1 bg-blue-600/20 border border-blue-500/50 text-blue-400 py-3 text-[10px] font-bold uppercase tracking-widest hover:bg-blue-600 hover:text-white transition-all font-display">
                            <span wire:loading.remove>Transmit</span>
                            <span wire:loading>Sending...</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif

    </main>
</div>

@script
    <script>
        Livewire.on('show-toast', (event) => {
            if (window.showToast) {
                window.showToast(event[0].type, event[0].title, event[0].message);
            }
        });
    </script>
@endscript