import Alpine from "alpinejs";
import "@tailwindplus/elements";
import "./slider";

// Initialize Alpine.js
window.Alpine = Alpine;

// Register Alpine components
Alpine.data("slider", () => ({
  currentSlide: 0,
  totalSlides: 0,
  autoplay: null,

  init() {
    this.totalSlides = this.$refs.slides?.children.length || 0;
    if (this.$el.dataset.autoplay === "true") {
      this.startAutoplay();
    }
  },

  next() {
    this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
  },

  prev() {
    this.currentSlide =
      (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
  },

  goTo(index) {
    this.currentSlide = index;
  },

  startAutoplay() {
    this.autoplay = setInterval(() => this.next(), 5000);
  },

  stopAutoplay() {
    if (this.autoplay) clearInterval(this.autoplay);
  },
}));

Alpine.data("mobileMenu", () => ({
  open: false,

  toggle() {
    this.open = !this.open;
  },

  close() {
    this.open = false;
  },
}));

Alpine.data("accordion", () => ({
  active: null,

  toggle(index) {
    this.active = this.active === index ? null : index;
  },

  isOpen(index) {
    return this.active === index;
  },
}));

// Start Alpine
Alpine.start();
