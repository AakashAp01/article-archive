<div id="toast-container" class="fixed bottom-6 right-6 z-[60] space-y-3" aria-live="assertive" aria-atomic="true">

    {{-- Toast Message Template (Hidden by default) --}}
    <div id="toast-template"
        class="hidden w-80 max-w-full rounded-sm border p-4 shadow-xl transition-opacity duration-300 ease-in-out opacity-0"
        role="alert">

        <div class="flex items-start">
            <div id="toast-icon-wrapper" class="mr-3 flex-shrink-0">
                {{-- Icon will be injected here --}}
            </div>

            <div class="flex-grow">
                <p id="toast-title" class="text-sm font-semibold mb-1"></p>
                <p id="toast-message" class="text-xs"></p>
                <ul id="toast-errors" class="list-disc list-inside mt-2 space-y-1 pl-2 text-xs">
                    {{-- Validation errors will be listed here --}}
                </ul>
            </div>

            <button type="button" onclick="hideToast('toast-template')"
                class="ml-4 -mr-1.5 -mt-1.5 inline-flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-sm text-white/50 hover:text-white transition-colors"
                aria-label="Close">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</div>
<script>
    // Icon SVG definitions for the toast
    const ToastIcons = {
        'success': '<svg class="h-5 w-5 text-green-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-8.88"/><path d="M22 4L12 14.01l-3-3"/></svg>',
        'error': '<svg class="h-5 w-5 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
        'warning': '<svg class="h-5 w-5 text-yellow-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>'
    };

    /**
     * Hides a toast notification by ID.
     * Note: This is separate so closing buttons can call it.
     */
    window.hideToast = function(id) {
        const toast = document.getElementById(id);
        if (toast) {
            toast.classList.add('opacity-0');
            // Remove from DOM after transition
            setTimeout(() => toast.remove(), 300);
        }
    }

    /**
     * Shows a dynamic toast notification.
     * @param {string} type - 'success', 'error', or 'warning'
     * @param {string} title - The main heading of the toast.
     * @param {string} message - A secondary message.
     * @param {object|null} errors - Key-value object of validation errors {field: ['message', ...]}
     */
    window.showToast = function(type, title, message, errors = null) {
        const container = document.getElementById('toast-container');
        if (!container) return console.error('Toast container not found.');

        // Styles based on type
        const typeClasses = {
            'success': 'border-green-600',
            'error': 'border-red-600',
            'warning': 'border-yellow-600',
        };
        const textClasses = {
            'success': 'text-green-400',
            'error': 'text-red-400',
            'warning': 'text-yellow-400',
        };

        // Create new toast element
        const toast = document.createElement('div');
        const toastId = 'toast-' + Date.now();
        toast.id = toastId;
        toast.className =
            `w-80 max-w-full rounded-sm border p-4 shadow-xl transition-opacity duration-300 ease-in-out opacity-0 bg-[#0a0a0a] ${typeClasses[type]} pointer-events-auto`;
        toast.setAttribute('role', 'alert');

        // Construct Inner HTML
        let innerHTML = `
                <div class="flex items-start">
                    <div class="mr-3 flex-shrink-0">${ToastIcons[type]}</div>
                    <div class="flex-grow">
                        <p class="text-sm font-semibold mb-1 ${textClasses[type]}">${title}</p>
                        <p class="text-xs text-white/80">${message}</p>
            `;

        // Add detailed validation errors if provided
        if (errors && Object.keys(errors).length > 0) {
            innerHTML += `<ul class="list-disc list-inside mt-2 space-y-1 pl-2 text-xs text-white/80">`;
            for (const field in errors) {
                // Display the first error for each field, prefixed by the field name
                innerHTML += `<li>${errors[field][0]}</li>`;
            }
            innerHTML += `</ul>`;
        }

        // Add close button
        innerHTML += `
                    </div>
                    <button type="button" 
                        onclick="hideToast('${toastId}')"
                        class="ml-4 -mr-1.5 -mt-1.5 inline-flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-sm text-white/50 hover:text-white transition-colors" 
                        aria-label="Close">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                    </button>
                </div>
            `;

        toast.innerHTML = innerHTML;

        // Add to container and show with a slight delay for CSS transition
        container.appendChild(toast);
        setTimeout(() => {
            toast.classList.remove('opacity-0');
        }, 10);

        // Auto-hide after 5 seconds (set pointer-events-auto above so buttons can be clicked)
        setTimeout(() => hideToast(toastId), 5000);
    }
</script>
