import App from '@/core/App.js';
import '@/components/ui/Button.js';
import '@/components/ui/Link.js';
import '@/components/ui/Box.js';

/**
 * Hero Section Component
 * 
 * A large, visually appealing hero section for welcoming users.
 * Features a gradient background, a main headline, a sub-headline,
 * and call-to-action buttons.
 */
class Hero extends App {
    handleGetStartedClick() {
        window.router.navigate('/docs');
    }

    render() {
        return `
            <ui-box class="bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 -mt-10">
                <ui-box class="py-24 sm:py-32">
                    <ui-box class="max-w-4xl mx-auto px-6 lg:px-8 text-center">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                            Build Modern Web Apps,
                            <span class="text-blue-600">No Build Step Required.</span>
                        </h1>
                        <p class="mt-6 text-lg leading-8 text-gray-600">
                            UPO UI is a dependency-free web components framework that runs directly in the browser. 
                            Focus on building, not configuring.
                        </p>
                        <ui-box class="mt-10 flex items-center justify-center gap-x-6">
                            <ui-button 
                                onclick="this.closest('app-hero').handleGetStartedClick()"
                                
                            >
                                Get Started
                            </ui-button>
                            <ui-link 
                                href="https://github.com/upovibe/upoUI" 
                                target="_blank"
                                class="rounded-lg bg-white px-5 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 no-underline transition-all transform hover:scale-105"
                            >
                                View on GitHub <span aria-hidden="true">→</span>
                            </ui-link>
                        </ui-box>
                    </ui-box>
                </ui-box>
            </ui-box>
        `;
    }
}

customElements.define('app-hero', Hero);
export default Hero; 