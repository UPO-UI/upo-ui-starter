import App from '@/core/App.js';
import '@/components/layout/Hero.js';
import '@/components/layout/Features.js';
import '@/components/ui/Box.js';

/**
 * Root Page Component (/)
 * 
 * This is the home page of the application.
 * It now renders within the global RootLayout.
 */
class RootPage extends App {
    connectedCallback() {
        super.connectedCallback();
        document.title = 'Home | UPO UI';
    }

    render() {
        return `
            <div>
                <app-hero></app-hero>
                <app-features></app-features>

                <!-- App Architecture Info -->
                <ui-box class="bg-white py-20 sm:py-24">
                    <ui-box class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                            Clean & Logical Architecture
                        </h2>
                        <ui-box class="mt-16 bg-white rounded-lg shadow-xl p-8 max-w-4xl mx-auto">
                            <ui-box class="text-left">
                                <h3 class="text-lg font-semibold mb-4 text-gray-800">Organized Folder Structure:</h3>
                                <pre class="bg-gray-100 p-4 rounded-lg text-sm overflow-x-auto">
src/
├── app/                    # 📱 Main app directory
│   ├── layout.js          # Root layout (wraps all pages)
│   ├── page.js           # Home page (/)
│   ├── about/
│   │   └── page.js       # About page (/about)
│   ├── components/
│   │   └── page.js       # Components page (/components)
│   └── [dynamic]/        # Dynamic routes
│       └── page.js       # Dynamic page template
│
├── core/                  # 🧠 Framework core
│   ├── App.js            # Base component class
│   └── Router.js         # Router logic
│
├── components/           # 🎨 UI components
│   ├── ui/              # Basic UI elements
│   └── layout/          # Layout components
│
└── assets/              # 📁 Static assets
                                </pre>
                            </ui-box>
                            <ui-box class="mt-6 text-center">
                                <p class="text-gray-600">
                                    Inspired by the Next.js App Router, but with 100% vanilla JavaScript!
                                </p>
                            </ui-box>
                        </ui-box>
                    </ui-box>
                </ui-box>
            </div>
        `;
    }
}

customElements.define('app-root-page', RootPage);
export default RootPage; 