@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
    <style>
        /* EasyMDE Base Overrides */
        .EasyMDEContainer {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 2px;
        }

        .editor-toolbar {
            background: rgba(0, 0, 0, 0.3) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
        }

        .editor-toolbar button {
            color: #888 !important;
        }

        .editor-toolbar button:hover,
        .editor-toolbar button.active {
            background: rgba(0, 255, 136, 0.1) !important;
            border-color: #00ff88 !important;
            color: #00ff88 !important;
        }

        /* CodeMirror (The Text Area) */
        .CodeMirror {
            background: #0a0a0f !important;
            color: #e0e0e0 !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            font-family: 'Courier New', monospace !important;
            font-size: 16px;
        }

        .CodeMirror-cursor {
            border-left: 2px solid #00ff88 !important;
        }

        /* Preview Mode */
        .editor-preview {
            background: #0a0a0f !important;
            color: #a0a0a0 !important;
            padding: 2rem;
        }

        .editor-preview h1,
        .editor-preview h2 {
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .editor-preview code {
            background: rgba(255, 255, 255, 0.1);
            color: #00ff88;
            padding: 2px 5px;
            border-radius: 3px;
        }

        .editor-statusbar {
            color: #666 !important;
            border-top: 1px solid rgba(255, 255, 255, 0.05) !important;
        }

        /* === CRITICAL FIX FOR FULLSCREEN === */
        .EasyMDEContainer.fullscreen {
            z-index: 9999 !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
        }
    </style>
@endpush

<div>
    <main class="max-w-7xl mx-auto px-6 mt-10 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            {{-- LEFT COLUMN: Content --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Title --}}
                <div class="group">
                    <input wire:model.live.debounce.500ms="title" type="text" placeholder="Article Title..."
                        class="w-full bg-transparent text-3xl md:text-4xl text-white font-light placeholder-[#333] outline-none border-b border-transparent focus:border-accent/50 transition-all pb-4">
                    @error('title')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Excerpt --}}
                <div>
                    <label class="block text-xs text-[#666] mb-2 uppercase">Excerpt</label>
                    <textarea wire:model.blur="excerpt" rows="3"
                        class="w-full bg-black/40 border border-white/10 rounded-sm p-4 focus:border-accent outline-none text-white transition-all"
                        placeholder="Brief abstract..."></textarea>
                </div>

                {{-- Markdown Editor (Alpine.js Wrapper) --}}
                <div wire:ignore>
                    <label class="block text-xs text-[#666] mb-2 uppercase">Main Content</label>
                    <textarea id="markdown-editor"></textarea>
                </div>
                @error('content')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            {{-- RIGHT COLUMN: Settings --}}
            <div class="space-y-6">

                {{-- 1. Thumbnail Upload --}}
                <div class="bg-white/5 border border-white/10 p-6 rounded-sm">
                    <h3 class="text-xs text-accent uppercase tracking-widest mb-4 border-b border-white/10 pb-2">Visual
                        Data</h3>

                    <div class="space-y-4">
                        {{-- Preview Area --}}
                        <div
                            class="relative w-full aspect-video bg-black/40 border border-dashed border-white/20 flex items-center justify-center overflow-hidden">
                            @if ($thumbnail)
                                <img src="{{ $thumbnail->temporaryUrl() }}" class="w-full h-full object-cover">
                            @elseif($existingThumbnail)
                                <img src="{{ $existingThumbnail }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="text-center text-[#444]">
                                    <svg class="mx-auto h-8 w-8 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span class="text-[10px] uppercase">No Signal</span>
                                </div>
                            @endif

                            {{-- Loading Spinner --}}
                            <div wire:loading wire:target="thumbnail"
                                class="absolute inset-0 bg-black/80 flex items-center justify-center">
                                <span class="text-accent text-xs animate-pulse">UPLOADING...</span>
                            </div>
                        </div>

                        {{-- File Input --}}
                        <input type="file" wire:model="thumbnail" id="thumbnail" class="hidden">
                        <label for="thumbnail"
                            class="block w-full text-center border border-white/10 py-2 text-[10px] uppercase cursor-pointer hover:bg-white/5 hover:border-accent hover:text-accent transition-all">
                            Select Source File
                        </label>
                        <p class="text-[12px] text-accent">Auto-compression to WebP active.</p>
                        @error('thumbnail')
                            <span class="text-red-500 text-[10px]">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- 2. SEO Meta Data --}}
                <div class="bg-white/5 border border-white/10 p-6 rounded-sm">
                    <h3 class="text-xs text-accent uppercase tracking-widest mb-4 border-b border-white/10 pb-2">SEO
                        Protocols</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="text-[10px] uppercase text-[#666] block mb-1">Meta Title</label>
                            <input wire:model="meta_title" type="text"
                                class="w-full bg-black/40 border border-white/10 p-2 text-white text-xs focus:border-accent outline-none">
                            <p class="text-[9px] text-[#444] mt-1 text-right">{{ strlen($meta_title) }}/60</p>
                        </div>
                        <div>
                            <label class="text-[10px] uppercase text-[#666] block mb-1">Meta Description</label>
                            <textarea wire:model="meta_description" rows="3"
                                class="w-full bg-black/40 border border-white/10 p-2 text-white text-xs focus:border-accent outline-none"></textarea>
                            <p class="text-[9px] text-[#444] mt-1 text-right">{{ strlen($meta_description) }}/160</p>
                        </div>
                    </div>
                </div>

                {{-- 3. Grid Position --}}
                <div class="bg-white/5 border border-white/10 p-6 rounded-sm">
                    <h3 class="text-xs text-accent uppercase tracking-widest mb-4 border-b border-white/10 pb-2">Grid
                        Position</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] uppercase text-[#666] block mb-1">X Axis</label>
                            <input wire:model="x" type="number"
                                class="w-full bg-black/40 border border-white/10 p-2 text-white text-xs focus:border-accent outline-none">
                        </div>
                        <div>
                            <label class="text-[10px] uppercase text-[#666] block mb-1">Y Axis</label>
                            <input wire:model="y" type="number"
                                class="w-full bg-black/40 border border-white/10 p-2 text-white text-xs focus:border-accent outline-none">
                        </div>
                    </div>
                </div>

                {{-- 4. Taxonomy --}}
                <div class="bg-white/5 border border-white/10 p-6 rounded-sm space-y-4">
                    <h3 class="text-xs text-accent uppercase tracking-widest mb-4 border-b border-white/10 pb-2">
                        Taxonomy</h3>

                    {{-- Category Datalist --}}
                    <div>
                        <label class="text-[10px] uppercase text-[#666] block mb-2">Category</label>
                        <input wire:model="category_name" list="category_list" type="text"
                            class="w-full bg-black/40 border border-white/10 p-2 text-white text-xs focus:border-accent outline-none uppercase"
                            placeholder="SEARCH OR CREATE...">
                        <datalist id="category_list">
                            @foreach ($categories as $category)
                                <option value="{{ $category->name }}">
                            @endforeach
                        </datalist>
                        @error('category_name')
                            <span class="text-red-500 text-[10px]">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Tags --}}
                    <div>
                        <label class="text-[10px] uppercase text-[#666] block mb-2">Tags</label>
                        <input wire:model="tags" type="text" placeholder="LARAVEL, UI, DEVLOG"
                            class="w-full bg-black/40 border border-white/10 p-2 text-white text-xs focus:border-accent outline-none">
                        <p class="text-[9px] text-[#444] mt-1">> Separate with commas</p>
                    </div>

                    {{-- Date --}}
                    <div>
                        <label class="text-[10px] uppercase text-[#666] block mb-2">Date</label>
                        <input wire:model="date" type="date"
                            class="w-full bg-black/40 border border-white/10 p-2 text-white text-xs focus:border-accent outline-none invert-calendar">
                    </div>

                    {{-- Slug (Auto) --}}
                    <div>
                        <label class="text-[10px] uppercase text-[#666] block mb-2">Slug</label>
                        <input wire:model="slug" type="text" readonly
                            class="w-full bg-black/40 border border-white/10 p-2 text-[#666] text-xs focus:border-accent outline-none cursor-not-allowed">
                    </div>
                </div>

            </div>
        </div>
    </main>

    <header
        class="fixed bottom-0 left-0 w-full bg-[#0a0a0f]/95 border-b border-white/10 h-16 flex items-center justify-between px-6 md:px-8 backdrop-blur-md z-40">
        <a href="{{ route('article.index') }}"
            class="group flex items-center gap-3 text-[#666] hover:text-white transition-colors">
            <div
                class="w-8 h-8 rounded-full border border-white/10 flex items-center justify-center group-hover:border-accent group-hover:bg-accent/10 transition-all">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="m15 18-6-6 6-6" />
                </svg>
            </div>
            <span class="text-xs uppercase tracking-widest group-hover:text-accent transition-colors">Abort Entry</span>
        </a>

        <div class="hidden md:flex items-center gap-2">
            <span class="w-1.5 h-1.5 bg-accent rounded-full animate-pulse"></span>
            <span class="text-[10px] text-accent uppercase tracking-[0.2em]">Live Editor Mode</span>
        </div>

        {{-- Publish Button triggers Livewire `store` --}}
        <button wire:click="store" wire:loading.attr="disabled"
            class="group bg-accent text-sm hover:bg-[#00cc6a] text-black px-6 py-2 flex items-center gap-2 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
            <span wire:loading.remove class="text-xs font-bold uppercase tracking-wider">Publish Grid</span>
            <span wire:loading class="text-xs font-bold uppercase tracking-wider">Optimizing...</span>
            <svg wire:loading.remove width="14" height="14" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2">
                <path d="M5 12h14" />
                <path d="m12 5 7 7-7 7" />
            </svg>
        </button>
    </header>
</div>

@push('scripts')
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Initialize EasyMDE
            const easyMDE = new EasyMDE({
                element: document.getElementById('markdown-editor'),
                spellChecker: false,
                autosave: {
                    enabled: false
                },
                toolbar: ["bold", "italic", "heading", "quote", "code", "table", "link", "image", "preview",
                    "side-by-side", "fullscreen"
                ],
                status: false,
            });

            // Sync EasyMDE -> Livewire
            easyMDE.codemirror.on('change', () => {
                @this.set('content', easyMDE.value());
            });

            // (Optional) Sync Livewire -> EasyMDE if content changes externally
            Livewire.hook('morph.updated', ({
                component,
                el
            }) => {
                if (component.name === 'article-manager' && easyMDE.value() !== @this.get('content')) {
                    easyMDE.value(@this.get('content'));
                }
            });

            // Load initial content
            easyMDE.value(@this.get('content'));
        });
    </script>
@endpush

@script
    <script>
        Livewire.on('show-toast', (event) => {
            if (window.showToast) {
                // Accessing index 0 of the event array, as required by the backend fix
                window.showToast(event[0].type, event[0].title, event[0].message);
            } else {
                console.log(event[0].message);
            }
        });
    </script>
@endscript
