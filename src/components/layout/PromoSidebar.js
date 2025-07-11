import App from '@/core/App.js';
import '@/components/ui/Card.js';
import '@/components/ui/Link.js';

/**
 * 💖 Promotional Sidebar Component
 *
 * A call-to-action encouraging users to star the GitHub repo.
 * Now designed to work within a fixed container layout.
 */
class PromoSidebar extends App {
  render() {
    return `
      <div class="px-6 py-10">
        <ui-card class="bg-gradient-to-br from-blue-50 to-purple-100 border border-purple-200 rounded-xl shadow-lg text-center p-5">

          <h4 class="text-base font-bold text-gray-800 mb-2 tracking-tight">
            🚀 Enjoying UPO UI?
          </h4>
          
          <p class="text-sm text-gray-600 mb-4 leading-relaxed">
            Help the project grow by starring it on GitHub!
          </p>
          
          <ui-link 
            href="https://github.com/upovibe/upoUI"
            target="_blank"
            rel="noopener noreferrer"
            class="inline-flex items-center justify-center gap-2 bg-gray-900 text-white text-sm font-semibold py-2 px-4 rounded-md hover:bg-gray-800 transition-colors"
          >
            <i class="fab fa-github mr-2"></i>
            Star on GitHub
          </ui-link>

        </ui-card>
      </div>
    `;
  }
}

customElements.define('app-promo-sidebar', PromoSidebar);
export default PromoSidebar;
