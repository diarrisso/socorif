/**
 * Sticky Header with Scroll Detection
 * Adds elegant shadow effect when scrolling on mobile
 */

document.addEventListener("DOMContentLoaded", function () {
  "use strict";

  const header = document.querySelector("header");

  if (!header) {
    console.error("Header element not found");
    return;
  }

  let lastScrollTop = 0;
  let ticking = false;

  function updateHeader() {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    // Add "scrolled" class when user scrolls down more than 10px
    if (scrollTop > 10) {
      header.classList.add("scrolled");
    } else {
      header.classList.remove("scrolled");
    }

    lastScrollTop = scrollTop;
    ticking = false;
  }

  // Use requestAnimationFrame for better performance
  function requestTick() {
    if (!ticking) {
      window.requestAnimationFrame(updateHeader);
      ticking = true;
    }
  }

  // Listen to scroll events
  window.addEventListener("scroll", requestTick, { passive: true });

  // Check initial state
  updateHeader();

  console.log("Sticky header script loaded");
});
