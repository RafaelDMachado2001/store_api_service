const LoadingManager = {
    activeRequests: 0,
    initialized: false,
    
    init() {
        if (this.initialized || typeof NProgress === 'undefined') {
            return;
        }
        
        NProgress.configure({
            showSpinner: true,
            trickleSpeed: 200,
            minimum: 0.08
        });
        
        this.initialized = true;
    },
    
    start() {
        this.init();
        this.activeRequests++;
        if (this.activeRequests === 1) {
            if (typeof NProgress !== 'undefined') {
                NProgress.start();
            }
        }
    },
    
    done() {
        this.activeRequests = Math.max(0, this.activeRequests - 1);
        if (this.activeRequests === 0) {
            if (typeof NProgress !== 'undefined') {
                NProgress.done();
            }
        }
    },
    
    set(progress) {
        if (typeof NProgress !== 'undefined') {
            NProgress.set(progress);
        }
    },
    
    configure(options) {
        if (typeof NProgress !== 'undefined') {
            NProgress.configure(options);
        }
    }
};

function showSkeletonLoader(containerId, skeletonHTML) {
    const container = document.getElementById(containerId);
    if (container) {
        container.innerHTML = skeletonHTML;
        container.style.display = 'block';
    }
}

function hideSkeletonLoader(containerId) {
    const container = document.getElementById(containerId);
    if (container) {
        const skeleton = container.querySelector('.skeleton-loader');
        if (skeleton) {
            skeleton.remove();
        }
    }
}

function createProductSkeleton(count = 3) {
    return Array.from({ length: count }, () => `
        <div class="skeleton-product-card">
            <div class="skeleton-line skeleton-title"></div>
            <div class="skeleton-line skeleton-subtitle"></div>
            <div class="skeleton-line skeleton-text"></div>
            <div class="skeleton-line skeleton-text short"></div>
        </div>
    `).join('');
}

async function fetchWithLoading(url, options = {}) {
    LoadingManager.start();
    try {
        const response = await fetch(url, options);
        const data = await response.json();
        return { response, data };
    } finally {
        LoadingManager.done();
    }
}
