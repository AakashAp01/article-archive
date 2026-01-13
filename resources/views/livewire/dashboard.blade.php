<main class="max-w-7xl mx-auto mt-32 px-6 pb-20 relative ">

    {{-- HEADER --}}
    <div class="mb-10 border-b border-white/10 pb-6">
        <h1 class="text-2xl text-white font-semibold mb-2">Dashboard</h1>
        <p class="text-xs text-[#666] uppercase tracking-widest">Dashboard Data Visualization</p>
    </div>

    {{-- Clickable Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-10">

        <x-stat-card title="Personnel" :count="$stats['users']" :href="route('users.index')" color="blue" progress="70">
            <x-slot:icon>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card title="Articles" :count="$stats['articles']" :href="route('article.index')" color="emerald" progress="45">
            <x-slot:icon>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card title="Subscribers" :count="$stats['subscribers']" :href="route('newsletter.index')" color="purple" progress="60">
            <x-slot:icon>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card title="Interactions" :count="$stats['comments']" color="pink" progress="80">
            <x-slot:icon>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card title="Total Likes" :count="$stats['likes']" color="yellow" progress="55">
            <x-slot:icon>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path
                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                    </path>
                </svg>
            </x-slot:icon>
        </x-stat-card>

    </div>


    {{-- GRAPH SECTION --}}
    <div class="bg-white/5 border border-white/10 p-6 rounded-sm relative mb-12">
        <h3 class="text-xs text-white uppercase tracking-widest mb-6 border-b border-white/10 pb-4">
            Activity Log (Last 6 Months)
        </h3>
        <div class="relative h-[300px] w-full">
            <canvas id="dashboardChart"></canvas>
        </div>
        {{-- Decor --}}
        <div class="absolute top-0 left-0 w-2 h-2 border-l border-t border-accent"></div>
        <div class="absolute top-0 right-0 w-2 h-2 border-r border-t border-accent"></div>
        <div class="absolute bottom-0 left-0 w-2 h-2 border-l border-b border-accent"></div>
        <div class="absolute bottom-0 right-0 w-2 h-2 border-r border-b border-accent"></div>
    </div>

    {{-- TOP 10 ARTICLES --}}
    <div class="bg-white/5 border border-white/10 p-6 rounded-sm relative">
        <h3
            class="text-xs text-white uppercase tracking-widest mb-6 border-b border-white/10 pb-4 flex justify-between items-center">
            <span>Top 10 High-Engagement Articles</span>
            <a href="{{ route('article.index') }}" class="text-[10px] text-accent hover:underline">View Full
                Database</a>
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] uppercase text-[#666] font-mono tracking-widest border-b border-white/10">
                        <th class="pb-3 pl-2">#</th>
                        <th class="pb-3">Title</th>
                        <th class="pb-3 text-center">Category</th>
                        <th class="pb-3 text-center">Likes</th>
                        <th class="pb-3 text-right pr-2">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($topArticles as $index => $article)
                        <tr class="border-b border-white/5 hover:bg-white/5 transition-colors group">
                            <td class="py-3 pl-2 font-mono text-[#444] group-hover:text-white">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                            <td class="py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-20 h-10 bg-black/50 border border-white/10 overflow-hidden shrink-0">
                                        @if ($article->thumbnail)
                                            <img src="{{ $article->thumbnail }}" alt="Thumbnail"
                                                class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-[#333]">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2">
                                                    <rect x="3" y="3" width="18" height="18" rx="2"
                                                        ry="2"></rect>
                                                    <circle cx="8.5" cy="8.5" r="2"></circle>
                                                    <path d="M21 15l-5-5L5 21"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <span
                                        class="font-medium text-gray-300 group-hover:text-accent transition-colors line-clamp-1">{{ $article->title }}</span>
                                </div>
                            </td>
                            <td class="py-3 text-center">
                                @if ($article->category)
                                    <span class="text-[9px] uppercase tracking-wider px-2 py-1 border"
                                        style="color:{{ $article->category->color_code }}; border-color:{{ $article->category->color_code }}40;">
                                        {{ $article->category->name }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 text-center transition-colors">
                                <div class="col-span-1 md:col-span-2 flex md:justify-center items-center gap-4">

                                    {{-- Likes --}}
                                    <div class="flex items-center gap-1.5 text-[#666] group-hover:text-pink-500 transition-colors"
                                        title="Likes">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <path
                                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                            </path>
                                        </svg>
                                        <span class="text-xs font-mono">{{ $article->likes_count ?? 0 }}</span>
                                    </div>

                                    {{-- Comments --}}
                                    <div class="flex items-center gap-1.5 text-[#666] group-hover:text-blue-400 transition-colors"
                                        title="Comments">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <path
                                                d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                                            </path>
                                        </svg>
                                        <span class="text-xs font-mono">{{ $article->comments_count ?? 0 }}</span>
                                    </div>

                                    {{-- Reports --}}
                                    <div class="flex items-center gap-1.5 text-[#666] group-hover:text-red-500 transition-colors"
                                        title="Reports">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <path d="M12 9v2m0 4h.01M3 6h18M5 6v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6H5z">
                                            </path>
                                        </svg>
                                        <span class="text-xs font-mono">{{ $article->reports_count ?? 0 }}</span>
                                    </div>

                                </div>
                            </td>

                            <td class="py-3 text-right pr-2 flex items-center justify-start md:justify-end gap-2">
                                {{-- Edit --}}
                                <a href="{{ route('article.edit', $article->id) }}"
                                    class="w-8 h-8 flex items-center justify-center border border-white/10 bg-black/20 text-[#888] hover:border-white hover:text-white hover:bg-white/5 transition-all">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                    </svg>
                                </a>

                                {{-- View --}}
                                <a href="{{ route('article.show', $article->slug) }}"
                                    class="w-8 h-8 flex items-center justify-center border border-white/10 bg-black/20 text-[#888] hover:border-white hover:text-white hover:bg-white/5 transition-all"
                                    title="View Article">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center text-[#666] font-mono text-xs">No Data
                                Available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</main>

@script
    <script>
        document.addEventListener('livewire:initialized', () => {
            const ctx = document.getElementById('dashboardChart').getContext('2d');

            const labels = @json($chartLabels);
            const usersData = @json($chartUsers);
            const articlesData = @json($chartArticles);
            const subsData = @json($chartSubs);
            const reportsData = @json($chartReports); // New Report Data

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Articles',
                            data: articlesData,
                            borderColor: '#00ff88',
                            backgroundColor: 'rgba(0, 255, 136, 0.1)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Users',
                            data: usersData,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.05)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Reports', // Added Reports
                            data: reportsData,
                            borderColor: '#ef4444', // Red
                            borderWidth: 2,
                            borderDash: [2, 2],
                            tension: 0.4,
                            fill: false
                        },
                        {
                            label: 'Subscribers',
                            data: subsData,
                            borderColor: '#a855f7',
                            borderWidth: 2,
                            borderDash: [5, 5],
                            tension: 0.4,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#888',
                                font: {
                                    family: 'Courier New',
                                    size: 10
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.05)'
                            },
                            ticks: {
                                color: '#666',
                                font: {
                                    family: 'Courier New'
                                }
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.05)'
                            },
                            ticks: {
                                color: '#666',
                                font: {
                                    family: 'Courier New'
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                }
            });
        });
    </script>
@endscript
