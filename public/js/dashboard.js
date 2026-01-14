/**
 * SIKANDIS Dashboard - Operator JavaScript
 * Dinas Kominfo Kota Bengkulu
 */

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize dashboard
    initDashboard();
    
    // Initialize mobile menu
    initMobileMenu();
    
    // Initialize active menu highlighting
    initActiveMenu();

    initModals();
    
});

/**
 * Initialize Dashboard
 */
function initDashboard() {
    console.log('SIKANDIS Dashboard initialized');
    
    // Add smooth scroll behavior
    document.documentElement.style.scrollBehavior = 'smooth';
}

function initModals() {
    const openers = document.querySelectorAll('[data-modal-open]');
    const closers = document.querySelectorAll('[data-modal-close]');

    openers.forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-modal-open');
            const overlay = document.getElementById(id);
            if (overlay) overlay.classList.add('active');
        });
    });

    closers.forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-modal-close');
            const overlay = document.getElementById(id);
            if (overlay) overlay.classList.remove('active');
        });
    });

    document.addEventListener('click', (e) => {
        const target = e.target;
        if (target && target.classList && target.classList.contains('modal-overlay')) {
            target.classList.remove('active');
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.active').forEach(overlay => {
                overlay.classList.remove('active');
            });
        }
    });
}

/**
 * Initialize Mobile Menu Toggle
 */
function initMobileMenu() {
    const mobileToggle = document.getElementById('mobile-toggle');
    const sidebar = document.querySelector('.sidebar');
    
    if (mobileToggle && sidebar) {
        mobileToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnToggle = mobileToggle.contains(event.target);
            
            if (!isClickInsideSidebar && !isClickOnToggle && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });
    }
}

/**
 * Initialize Active Menu Highlighting
 */
function initActiveMenu() {
    const navLinks = document.querySelectorAll('.nav-link');
    const currentPath = window.location.pathname;
    
    navLinks.forEach(link => {
        // Remove active class from all links
        link.classList.remove('active');
        
        // Add active class to current page link
        if (link.getAttribute('href') === currentPath || 
            (currentPath === '/' && link.getAttribute('href') === '#dashboard')) {
            link.classList.add('active');
        }
    });
}

/**
 * Format number with thousand separator
 */
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

/**
 * Update summary card value with animation
 */
function updateSummaryCard(cardId, newValue) {
    const card = document.getElementById(cardId);
    if (card) {
        const valueElement = card.querySelector('.summary-value');
        if (valueElement) {
            // Animate number change
            const currentValue = parseInt(valueElement.textContent);
            const increment = newValue > currentValue ? 1 : -1;
            const duration = 500; // ms
            const steps = Math.abs(newValue - currentValue);
            const stepDuration = duration / steps;
            
            let current = currentValue;
            const timer = setInterval(() => {
                current += increment;
                valueElement.textContent = current;
                
                if (current === newValue) {
                    clearInterval(timer);
                }
            }, stepDuration);
        }
    }
}

/**
 * Show notification (can be used for future features)
 */
function showNotification(message, type = 'info') {
    // This is a placeholder for future notification system
    console.log(`[${type.toUpperCase()}] ${message}`);
}

/**
 * Handle table row click (for future detail view)
 */
function handleTableRowClick(vehicleId) {
    console.log('Vehicle clicked:', vehicleId);
    // Future: Navigate to detail page or show modal
}

// Export functions for global use if needed
window.SIKANDIS = {
    formatNumber,
    updateSummaryCard,
    showNotification,
    handleTableRowClick
};
