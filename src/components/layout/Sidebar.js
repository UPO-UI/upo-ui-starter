import App from '@/core/App.js';
import '@/components/ui/Link.js';
import '@/components/ui/Button.js';

/**
 * 📚 Docs Sidebar Component
 *
 * Displays the navigation links for UPO UI documentation.
 * Organized by section (e.g., Getting Started, Components).
 * Responsive: slide-in overlay on mobile, fixed position on desktop.
 */
class Sidebar extends App {
    constructor() {
        super();
        this.isOpen = false;
    }

    connectedCallback() {
        super.connectedCallback();
        
        // Wait for the component to be fully rendered
        setTimeout(() => {
            // Add event listener for the toggle button
            const toggleButton = this.querySelector('#sidebar-toggle-button');
            if (toggleButton) {
                toggleButton.addEventListener('click', () => {
                    this.toggle();
                });
            }
        }, 100);
    }

    toggle() {
        this.isOpen = !this.isOpen;
        
        const sidebar = this.querySelector('aside');
        const backdrop = this.querySelector('.sidebar-backdrop');
        const toggleButton = this.querySelector('#sidebar-toggle-button');
        
        if (!sidebar || !backdrop || !toggleButton) {
            console.error('Sidebar, backdrop, or toggle button element not found');
            return;
        }
        
        if (this.isOpen) {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            backdrop.classList.remove('hidden');
            // Update button icon to left arrow (close)
            toggleButton.innerHTML = '<i class="fas fa-chevron-left text-gray-600"></i>';
        } else {
            sidebar.classList.remove('translate-x-0');
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
            // Update button icon to right arrow (open)
            toggleButton.innerHTML = '<i class="fas fa-chevron-right text-gray-600"></i>';
        }
    }

    close() {
        if (this.isOpen) {
            this.isOpen = false;
            const sidebar = this.querySelector('aside');
            const backdrop = this.querySelector('.sidebar-backdrop');
            const toggleButton = this.querySelector('#sidebar-toggle-button');
            
            if (sidebar && backdrop && toggleButton) {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
                // Update button icon to right arrow (open)
                toggleButton.innerHTML = '<i class="fas fa-chevron-right text-gray-600"></i>';
            }
        }
    }

    render() {
        const currentPath = window.location.pathname;
        
        const getLinkClass = (path) => {
            const baseClass = "text-sm font-medium transition-colors block px-3 py-1 rounded-md";
            if (currentPath === path) {
                return `${baseClass} bg-blue-100 text-blue-700`;
            }
            return `${baseClass} text-gray-700 hover:bg-gray-100 hover:text-gray-900`;
        };

        // Define component links in one place
        const componentLinks = [
            { href: '/docs/components', label: 'Overview' },
            { href: '/docs/components/accordion', label: 'Accordion' },
            { href: '/docs/components/alert', label: 'Alert' },
            { href: '/docs/components/avatar', label: 'Avatar' },
            { href: '/docs/components/badge', label: 'Badge' },
            { href: '/docs/components/breadcrumb', label: 'Breadcrumb' },
            { href: '/docs/components/button', label: 'Button' },
            { href: '/docs/components/calendar', label: 'Calendar' },
            { href: '/docs/components/card', label: 'Card' },
            { href: '/docs/components/carousel', label: 'Carousel' },
            { href: '/docs/components/checkbox', label: 'Checkbox' },
            { href: '/docs/components/dialog', label: 'Dialog' },
            { href: '/docs/components/dropdown', label: 'Dropdown' },
            { href: '/docs/components/fileupload', label: 'File Upload' },
            { href: '/docs/components/input', label: 'Input' },
            { href: '/docs/components/link', label: 'Link' },
            { href: '/docs/components/modal', label: 'Modal' },
            { href: '/docs/components/pagination', label: 'Pagination' },
            { href: '/docs/components/radiogroup', label: 'Radio Group' },
            { href: '/docs/components/skeleton', label: 'Skeleton Loader' },
            { href: '/docs/components/table', label: 'Table' },
            { href: '/docs/components/tabs', label: 'Tabs' },
            { href: '/docs/components/textarea', label: 'Textarea' },
            { href: '/docs/components/taginput', label: 'Tag Input' },
            { href: '/docs/components/tooltip', label: 'Tooltip' },
            { href: '/docs/components/toast', label: 'Toast' },
            { href: '/docs/components/switch', label: 'Switch' },
            // Add more as needed
        ];

        // Check if this is the mobile overlay version
        const isMobileOverlay = this.classList.contains('lg:hidden');

        if (isMobileOverlay) {
            // Mobile overlay version
            return `
                <!-- Mobile backdrop -->
                <div class="sidebar-backdrop fixed inset-0 bg-black bg-opacity-50 z-50 hidden" onclick="this.getRootNode().host.close()"></div>
                
                <!-- Mobile Sidebar Overlay -->
                <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white transform -translate-x-full transition-transform duration-300 ease-in-out flex flex-col">
                    
                    <!-- Toggle Button - positioned on the right edge of sidebar -->
                    <ui-button 
                        id="sidebar-toggle-button"
                        class="absolute -right-4 top-4 w-8 h-8 bg-white border border-gray-200 rounded-r-md hover:bg-gray-50 transition-colors flex items-center justify-center z-10 p-0"
                        aria-label="Toggle sidebar"
                    >
                        <i class="fas fa-chevron-right text-gray-600 text-sm"></i>
                    </ui-button>

                    <!-- Logo Section -->
                    <div class="h-16 border-b border-gray-200 flex items-center px-3 flex-shrink-0">
                        <div class="flex items-center gap-2">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg overflow-hidden bg-white">
                                <img 
                                    src="/src/assets/logo.png" 
                                    alt="UPO UI Logo" 
                                    class="w-full h-full object-contain size-5"
                                />
                            </div>
                            <div>
                                <h1 class="text-xl font-extrabold text-gray-800 tracking-tight">UPO UI</h1>
                                <p class="text-xs text-gray-500 font-semibold tracking-wide">Version 1.0.0</p>
                            </div>
                        </div>
                    </div>

                    <nav class="flex-1 p-4 space-y-6 overflow-y-auto overflow-x-hidden scrollbar-hide">
                        <style>
                            .scrollbar-hide {
                                -ms-overflow-style: none;  /* Internet Explorer 10+ */
                                scrollbar-width: none;  /* Firefox */
                            }
                            .scrollbar-hide::-webkit-scrollbar {
                                display: none;  /* Safari and Chrome */
                            }
                        </style>

                        <!-- Getting Started Section -->
                        <section class="space-y-2 border-l border-blue-500 pl-3">
                            <h3 class="text-xs uppercase tracking-wide font-semibold text-gray-500">
                                <i class="fas fa-rocket mr-2"></i>
                                <span class="truncate">Getting Started</span>
                            </h3>
                            <div class="flex flex-col space-y-1">
                                <ui-link href="/docs" class="${getLinkClass('/docs')}" onclick="this.getRootNode().host.close()">
                                    Introduction
                                </ui-link>
                                <ui-link href="/docs/installation" class="${getLinkClass('/docs/installation')}" onclick="this.getRootNode().host.close()">
                                    Installation
                                </ui-link>
                            </div>
                        </section>

                        <!-- Components Section -->
                        <section class="space-y-2 border-l border-blue-500 pl-3">
                            <h3 class="text-xs uppercase tracking-wide font-semibold text-gray-500">
                                <i class="fas fa-cubes mr-2"></i>
                                <span class="truncate">Components</span>
                            </h3>
                            <div class="flex flex-col space-y-1">
                                ${componentLinks.map(link => `
                                    <ui-link href="${link.href}" class="${getLinkClass(link.href)}" onclick="this.getRootNode().host.close()">${link.label}</ui-link>
                                `).join('')}
                            </div>
                        </section>

                    </nav>
                </aside>
            `;
        } else {
            // Desktop fixed version
            return `
                <nav class="p-4 space-y-6 h-full overflow-y-auto overflow-x-hidden scrollbar-hide">
                    <style>
                        .scrollbar-hide {
                            -ms-overflow-style: none;  /* Internet Explorer 10+ */
                            scrollbar-width: none;  /* Firefox */
                        }
                        .scrollbar-hide::-webkit-scrollbar {
                            display: none;  /* Safari and Chrome */
                        }
                    </style>

                    <!-- Getting Started Section -->
                    <section class="space-y-2 border-l border-blue-500 pl-3">
                        <h3 class="text-xs uppercase tracking-wide font-semibold text-gray-500">
                            <i class="fas fa-rocket mr-2"></i>
                            <span class="truncate">Getting Started</span>
                        </h3>
                        <div class="flex flex-col space-y-1">
                            <ui-link href="/docs" class="${getLinkClass('/docs')}">
                                Introduction
                            </ui-link>
                            <ui-link href="/docs/installation" class="${getLinkClass('/docs/installation')}">
                                Installation
                            </ui-link>
                        </div>
                    </section>

                    <!-- Components Section -->
                    <section class="space-y-2 border-l border-blue-500 pl-3">
                        <h3 class="text-xs uppercase tracking-wide font-semibold text-gray-500">
                            <i class="fas fa-cubes mr-2"></i>
                            <span class="truncate">Components</span>
                        </h3>
                        <div class="flex flex-col space-y-1">
                            ${componentLinks.map(link => `
                                <ui-link href="${link.href}" class="${getLinkClass(link.href)}">${link.label}</ui-link>
                            `).join('')}
                        </div>
                    </section>

                </nav>
            `;
        }
    }
}

customElements.define('app-sidebar', Sidebar);
export default Sidebar;
