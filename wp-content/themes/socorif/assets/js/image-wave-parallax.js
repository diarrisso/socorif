/**
 * Image Wave Parallax Effect
 *
 * Smooth parallax scrolling effect for image-wave-section blocks
 * Uses Intersection Observer for performance optimization
 * GPU-accelerated with transform: translateY
 *
 * @package Ossenberg_Engels
 */

(function () {
  "use strict";

  /**
   * Parallax Effect Class
   */
  class ImageWaveParallax {
    constructor(element) {
      this.element = element;
      this.image = element.querySelector("[data-parallax-image]");
      this.speed = parseFloat(element.dataset.parallaxSpeed) || 0.5;
      this.isActive = false;
      this.ticking = false;
      this.lastScrollY = window.scrollY;

      // Check if device supports parallax (disable on mobile)
      this.isMobile = window.innerWidth < 768;

      if (!this.image || this.isMobile) {
        return;
      }

      this.init();
    }

    /**
     * Initialize parallax effect
     */
    init() {
      // Setup Intersection Observer
      this.setupObserver();

      // Bind scroll handler
      this.handleScroll = this.handleScroll.bind(this);

      // Listen to scroll events
      window.addEventListener("scroll", this.handleScroll, { passive: true });

      // Listen to resize events
      window.addEventListener("resize", this.handleResize.bind(this));
    }

    /**
     * Setup Intersection Observer
     * Only activate parallax when element is visible
     */
    setupObserver() {
      const options = {
        root: null,
        rootMargin: "200px 0px", // Start before element enters viewport
        threshold: 0,
      };

      this.observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          this.isActive = entry.isIntersecting;

          // Update parallax immediately when entering viewport
          if (this.isActive) {
            this.updateParallax();
          }
        });
      }, options);

      this.observer.observe(this.element);
    }

    /**
     * Handle scroll event with requestAnimationFrame
     */
    handleScroll() {
      this.lastScrollY = window.scrollY;

      if (!this.isActive || this.ticking) {
        return;
      }

      this.ticking = true;

      requestAnimationFrame(() => {
        this.updateParallax();
        this.ticking = false;
      });
    }

    /**
     * Update parallax transform
     */
    updateParallax() {
      if (!this.image || !this.isActive) {
        return;
      }

      // Get element position
      const rect = this.element.getBoundingClientRect();
      const elementTop = rect.top;
      const elementHeight = rect.height;
      const windowHeight = window.innerHeight;

      // Calculate parallax offset
      // When element enters from bottom: positive offset
      // When element exits from top: negative offset
      const scrollProgress =
        (windowHeight - elementTop) / (windowHeight + elementHeight);
      const parallaxOffset =
        (scrollProgress - 0.5) * elementHeight * this.speed;

      // Apply transform with GPU acceleration
      this.image.style.transform = `translateY(${parallaxOffset}px) translateZ(0)`;
    }

    /**
     * Handle window resize
     */
    handleResize() {
      // Check if we're now on mobile
      const wasMobile = this.isMobile;
      this.isMobile = window.innerWidth < 768;

      // If switching to mobile, reset transform
      if (!wasMobile && this.isMobile) {
        this.destroy();
      }

      // If switching to desktop, re-initialize
      if (wasMobile && !this.isMobile && this.image) {
        this.init();
      }
    }

    /**
     * Destroy parallax effect
     */
    destroy() {
      if (this.image) {
        this.image.style.transform = "";
      }

      if (this.observer) {
        this.observer.disconnect();
      }

      window.removeEventListener("scroll", this.handleScroll);
    }
  }

  /**
   * Initialize all parallax elements
   */
  function initParallax() {
    const parallaxElements = document.querySelectorAll(
      '[data-parallax="true"]',
    );

    if (parallaxElements.length === 0) {
      return;
    }

    // Initialize each parallax element
    parallaxElements.forEach((element) => {
      new ImageWaveParallax(element);
    });
  }

  /**
   * Initialize on DOM ready
   */
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initParallax);
  } else {
    initParallax();
  }

  /**
   * Re-initialize on AJAX/dynamic content load (if needed)
   */
  document.addEventListener("imageWaveParallaxInit", initParallax);
})();
