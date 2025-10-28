// Theme Toggle Functionality
document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('themeToggle');
    
    if (themeToggle) {
        const themeIcon = themeToggle.querySelector('.theme-icon');
        
        // Check for saved theme preference or use default
        const currentTheme = localStorage.getItem('theme') || 'dark';
        document.documentElement.setAttribute('data-theme', currentTheme);
        
        // Update Bootstrap theme attribute as well
        document.documentElement.setAttribute('data-bs-theme', currentTheme);
        
        // Update icon based on current theme
        updateThemeIcon(currentTheme);
        
        // Toggle theme when button is clicked
        themeToggle.addEventListener('click', function() {
            let theme = document.documentElement.getAttribute('data-theme');
            let newTheme = theme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            document.documentElement.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            
            updateThemeIcon(newTheme);
            
            // Add visual feedback
            themeToggle.style.transform = 'scale(0.9)';
            setTimeout(() => {
                themeToggle.style.transform = 'scale(1)';
            }, 150);
        });
        
        function updateThemeIcon(theme) {
            if (themeIcon) {
                themeIcon.textContent = theme === 'dark' ? '🌙' : '☀️';
            }
        }
    }
});

// Initialize movie ratings
document.addEventListener('DOMContentLoaded', function() {
    const ratingContainers = document.querySelectorAll('.rating-stars');
    
    ratingContainers.forEach(container => {
        const ratingValue = parseFloat(container.dataset.rating) || 0;
        const maxRating = 5;
        
        for (let i = 1; i <= maxRating; i++) {
            const star = document.createElement('span');
            star.classList.add('star');
            star.innerHTML = i <= ratingValue ? '★' : '☆';
            container.appendChild(star);
        }
    });
});

// Smooth scrolling for anchor links
document.addEventListener('DOMContentLoaded', function() {
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// Loading animation for forms
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
            if (submitBtn) {
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Bezig...';
                submitBtn.disabled = true;
                
                // Re-enable after 5 seconds as fallback
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 5000);
            }
        });
    });
});

// Enhanced card hover effects
document.addEventListener('DOMContentLoaded', function() {
    const movieCards = document.querySelectorAll('.card');
    
    movieCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});

// Navbar scroll effect
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector('.navbar');
    let lastScrollTop = 0;
    
    if (navbar) {
        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                // Scrolling down - hide navbar
                navbar.style.transform = 'translateY(-100%)';
            } else {
                // Scrolling up - show navbar
                navbar.style.transform = 'translateY(0)';
            }
            
            lastScrollTop = scrollTop;
        }, false);
    }
});

// Search form enhancements
document.addEventListener('DOMContentLoaded', function() {
    const searchForms = document.querySelectorAll('form[action*="search.php"]');
    
    searchForms.forEach(form => {
        const searchInput = form.querySelector('input[type="search"]');
        
        if (searchInput) {
            // Add search suggestions (placeholder functionality)
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                if (query.length > 2) {
                    // Here you could add AJAX search suggestions
                    console.log('Searching for:', query);
                }
            });
            
            // Clear search on escape key
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    this.value = '';
                    this.blur();
                }
            });
        }
    });
});

// Image lazy loading fallback
document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('img');
    
    images.forEach(img => {
        img.addEventListener('error', function() {
            // If image fails to load, use placeholder
            if (this.src.includes('placeholder.jpg')) return; // Prevent infinite loop
            
            const basePath = this.src.includes('../assets') ? '../assets/img/placeholder.jpg' : 'assets/img/placeholder.jpg';
            this.src = basePath;
            this.alt = 'Afbeelding niet beschikbaar';
        });
    });
});