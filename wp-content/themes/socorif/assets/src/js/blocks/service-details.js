/**
 * Service Details Block Animationen & Interaktionen
 *
 * Features:
 * - Scroll-Animationen mit Intersection Observer
 * - Zähler-Animation für Statistiken
 * - Timeline progressive Enthüllung
 * - Vorher/Nachher Slider Vergleicher
 * - Galerie-Karussell
 *
 * @package Beka
 */

document.addEventListener("alpine:init", () => {
  // ========================================
  // GALERIE KARUSSELL KOMPONENTE
  // ========================================
  Alpine.data("galleryCarousel", (items) => ({
    currentSlide: 0,
    totalSlides: items,
    autoplayInterval: null,
    autoplayDelay: 5000,

    init() {
      this.startAutoplay();

      // Pause Autoplay bei Hover
      this.$el.addEventListener("mouseenter", () => this.stopAutoplay());
      this.$el.addEventListener("mouseleave", () => this.startAutoplay());
    },

    next() {
      this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
    },

    prev() {
      this.currentSlide =
        (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
    },

    goToSlide(index) {
      this.currentSlide = index;
    },

    startAutoplay() {
      this.autoplayInterval = setInterval(() => {
        this.next();
      }, this.autoplayDelay);
    },

    stopAutoplay() {
      if (this.autoplayInterval) {
        clearInterval(this.autoplayInterval);
        this.autoplayInterval = null;
      }
    },

    destroy() {
      this.stopAutoplay();
    },
  }));

  // ========================================
  // VORHER/NACHHER VERGLEICHER KOMPONENTE
  // ========================================
  Alpine.data("beforeAfterComparator", () => ({
    sliderPosition: 50,
    isDragging: false,

    init() {
      // Tastaturnavigation
      this.$el.addEventListener("keydown", (e) => {
        if (e.key === "ArrowLeft") {
          this.sliderPosition = Math.max(0, this.sliderPosition - 5);
        } else if (e.key === "ArrowRight") {
          this.sliderPosition = Math.min(100, this.sliderPosition + 5);
        }
      });
    },

    startDrag() {
      this.isDragging = true;
    },

    stopDrag() {
      this.isDragging = false;
    },

    handleMove(event) {
      if (!this.isDragging) return;

      const rect = this.$el.getBoundingClientRect();
      const x =
        (event.type.includes("touch")
          ? event.touches[0].clientX
          : event.clientX) - rect.left;
      this.sliderPosition = Math.max(0, Math.min(100, (x / rect.width) * 100));
    },
  }));

  // ========================================
  // ZÄHLER-ANIMATION KOMPONENTE
  // ========================================
  Alpine.data("counterAnimation", (endValue, duration = 2000, suffix = "") => ({
    displayValue: 0,
    hasAnimated: false,

    init() {
      const observer = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting && !this.hasAnimated) {
              this.animateCounter(endValue, duration, suffix);
              this.hasAnimated = true;
            }
          });
        },
        { threshold: 0.5 },
      );

      observer.observe(this.$el);
    },

    animateCounter(end, duration, suffix) {
      const start = 0;
      const startTime = performance.now();

      // Numerischen Wert parsen
      const numericEnd = parseFloat(
        String(end)
          .replace(/[^\d.,]/g, "")
          .replace(",", "."),
      );

      const animate = (currentTime) => {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);

        // Easing-Funktion (easeOutCubic)
        const easeOut = 1 - Math.pow(1 - progress, 3);

        this.displayValue = Math.floor(easeOut * numericEnd);

        if (progress < 1) {
          requestAnimationFrame(animate);
        } else {
          this.displayValue = end;
        }
      };

      requestAnimationFrame(animate);
    },
  }));

  // ========================================
  // TIMELINE PROGRESSIVE ENTHÜLLUNG
  // ========================================
  Alpine.data("timelineReveal", () => ({
    visibleSteps: new Set(),

    init() {
      const steps = this.$el.querySelectorAll("[data-timeline-step]");

      const observer = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              const stepIndex = parseInt(entry.target.dataset.timelineStep);
              this.visibleSteps.add(stepIndex);
              entry.target.classList.add("timeline-step-visible");
            }
          });
        },
        { threshold: 0.3, rootMargin: "-50px" },
      );

      steps.forEach((step) => observer.observe(step));
    },

    isStepVisible(index) {
      return this.visibleSteps.has(index);
    },
  }));
});

// ========================================
// SCROLL-ANIMATIONEN (Intersection Observer)
// ========================================
class ScrollAnimations {
  constructor() {
    this.observerOptions = {
      threshold: 0.1,
      rootMargin: "0px 0px -100px 0px",
    };

    this.init();
  }

  init() {
    this.setupObserver();
    this.observeElements();
  }

  setupObserver() {
    this.observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("animate-in");

          // Für gestaffelte Animationen
          if (entry.target.hasAttribute("data-stagger")) {
            this.handleStagger(entry.target);
          }
        }
      });
    }, this.observerOptions);
  }

  observeElements() {
    // Alle Elemente mit Animationsklassen beobachten
    const animatedElements = document.querySelectorAll(
      '[data-animate="fade-up"], ' +
        '[data-animate="fade-in"], ' +
        '[data-animate="slide-left"], ' +
        '[data-animate="slide-right"], ' +
        '[data-animate="scale"], ' +
        "[data-stagger-container]",
    );

    animatedElements.forEach((el) => this.observer.observe(el));
  }

  handleStagger(container) {
    const children = container.querySelectorAll("[data-stagger-item]");
    children.forEach((child, index) => {
      setTimeout(() => {
        child.classList.add("animate-in");
      }, index * 100); // 100ms Verzögerung zwischen jedem Element
    });
  }
}

// Scroll-Animationen initialisieren wenn DOM bereit ist
if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", () => {
    new ScrollAnimations();
  });
} else {
  new ScrollAnimations();
}

// ========================================
// SANFTES SCROLLEN FÜR ANKER-LINKS
// ========================================
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    const href = this.getAttribute("href");
    if (href !== "#" && href !== "#!") {
      e.preventDefault();
      const target = document.querySelector(href);
      if (target) {
        target.scrollIntoView({
          behavior: "smooth",
          block: "start",
        });
      }
    }
  });
});
