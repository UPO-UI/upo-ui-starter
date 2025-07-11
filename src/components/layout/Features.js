import App from '@/core/App.js';
import '@/components/ui/Box.js';

/**
 * Features Section Component
 * 
 * Displays the core features of the UPO UI framework in a card-based layout.
 */
class Features extends App {
    render() {
        return `
            <ui-box class="bg-gray-50 py-20 sm:py-24">
                <ui-box class="max-w-7xl mx-auto px-6 lg:px-8">
                    <ui-box class="text-center max-w-2xl mx-auto">
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Everything You Need, Nothing You Don't</h2>
                        <p class="mt-4 text-lg text-gray-600">
                            A simple, fast, and powerful web components framework.
                        </p>
                    </ui-box>
                    
                    <ui-box class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Feature 1: No Build Step -->
                        <ui-box class="bg-white rounded-2xl p-8 shadow-lg transition-transform transform hover:-translate-y-2 text-center">
                            <ui-box class="flex items-center justify-center h-16 w-16 mx-auto bg-yellow-100 rounded-full">
                                <i class="fas fa-bolt text-3xl text-yellow-600"></i>
                            </ui-box>
                            <h3 class="mt-6 text-xl font-semibold text-gray-900">No Build Step</h3>
                            <p class="mt-4 text-base text-gray-600">Clone and start immediately. No npm, no webpack, no complexity.</p>
                        </ui-box>
                        
                        <!-- Feature 2: CSS Framework Agnostic -->
                        <ui-box class="bg-white rounded-2xl p-8 shadow-lg transition-transform transform hover:-translate-y-2 text-center">
                            <ui-box class="flex items-center justify-center h-16 w-16 mx-auto bg-blue-100 rounded-full">
                                <i class="fas fa-palette text-3xl text-blue-600"></i>
                            </ui-box>
                            <h3 class="mt-6 text-xl font-semibold text-gray-900">CSS Framework Agnostic</h3>
                            <p class="mt-4 text-base text-gray-600">Works with Tailwind, Bootstrap, or your own custom CSS.</p>
                        </ui-box>
                        
                        <!-- Feature 3: Modern & Simple -->
                        <ui-box class="bg-white rounded-2xl p-8 shadow-lg transition-transform transform hover:-translate-y-2 text-center">
                            <ui-box class="flex items-center justify-center h-16 w-16 mx-auto bg-purple-100 rounded-full">
                                <i class="fas fa-rocket text-3xl text-purple-600"></i>
                            </ui-box>
                            <h3 class="mt-6 text-xl font-semibold text-gray-900">Modern & Simple</h3>
                            <p class="mt-4 text-base text-gray-600">Uses standard Web Components with a reactive state system.</p>
                        </ui-box>
                    </ui-box>
                </ui-box>
            </ui-box>
        `;
    }
}

customElements.define('app-features', Features);
export default Features; 