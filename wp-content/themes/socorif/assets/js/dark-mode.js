/**
 * Dark Mode Selector
 * Gestion des 3 modes: Light, Dark, Auto
 *
 * Comportement :
 * - Light: Force le mode clair
 * - Dark: Force le mode sombre
 * - Auto: Suit les préférences système
 */

document.addEventListener("DOMContentLoaded", function () {
  "use strict";

  // Get all mode selectors and toggle buttons
  const selectors = document.querySelectorAll(".dark-mode-selector-wrapper");
  const toggleButton = document.getElementById("dark-mode-toggle");
  const toggleButtonMobile = document.getElementById("dark-mode-toggle-mobile");
  const toggleButtonOverlay = document.getElementById(
    "dark-mode-toggle-overlay",
  );

  // Function to get current mode from localStorage (defaults to 'dark')
  function getCurrentMode() {
    return localStorage.getItem("theme") || "dark";
  }

  // Function to apply dark mode based on current theme
  function applyDarkMode() {
    const theme = getCurrentMode();
    const prefersDark = window.matchMedia(
      "(prefers-color-scheme: dark)",
    ).matches;

    if (theme === "auto") {
      // Follow system preference
      if (prefersDark) {
        document.documentElement.classList.add("dark");
      } else {
        document.documentElement.classList.remove("dark");
      }
    } else if (theme === "dark") {
      document.documentElement.classList.add("dark");
    } else {
      document.documentElement.classList.remove("dark");
    }
  }

  // Function to update UI for all selectors
  function updateSelectorUI() {
    const currentMode = getCurrentMode();

    selectors.forEach((selector) => {
      const modeText = selector.querySelector("[data-mode-text]");
      const options = selector.querySelectorAll(".dark-mode-option");

      // Update button text
      if (modeText) {
        modeText.textContent =
          currentMode.charAt(0).toUpperCase() + currentMode.slice(1);
      }

      // Update checkmarks
      options.forEach((option) => {
        const mode = option.getAttribute("data-mode");
        const checkmark = option.querySelector(".checkmark");

        if (checkmark) {
          if (mode === currentMode) {
            checkmark.classList.remove("opacity-0");
            checkmark.classList.add("opacity-100");
          } else {
            checkmark.classList.remove("opacity-100");
            checkmark.classList.add("opacity-0");
          }
        }
      });
    });
  }

  // Function to set mode
  function setMode(mode) {
    if (mode === "auto") {
      localStorage.removeItem("theme");
    } else {
      localStorage.setItem("theme", mode);
    }

    applyDarkMode();
    updateSelectorUI();

    console.log("Theme changed to:", mode);
  }

  // Add event listeners to all mode options
  selectors.forEach((selector) => {
    const options = selector.querySelectorAll(".dark-mode-option");

    options.forEach((option) => {
      option.addEventListener("click", function (e) {
        e.preventDefault();
        const mode = this.getAttribute("data-mode");
        setMode(mode);
      });
    });
  });

  // Legacy: Simple toggle between light and dark (for old toggle buttons if they still exist)
  function toggleDarkMode() {
    const isDark = document.documentElement.classList.contains("dark");
    const newTheme = isDark ? "light" : "dark";
    setMode(newTheme);
  }

  // Add event listener to legacy desktop button if exists
  if (toggleButton) {
    toggleButton.addEventListener("click", toggleDarkMode);
  }

  // Add event listener to legacy mobile button if exists
  if (toggleButtonMobile) {
    toggleButtonMobile.addEventListener("click", toggleDarkMode);
  }

  // Add event listener to legacy overlay button if exists
  if (toggleButtonOverlay) {
    toggleButtonOverlay.addEventListener("click", toggleDarkMode);
  }

  // Listen to system preference changes (only in auto mode)
  window
    .matchMedia("(prefers-color-scheme: dark)")
    .addEventListener("change", function (e) {
      const theme = getCurrentMode();
      if (theme === "auto") {
        applyDarkMode();
      }
    });

  // Apply initial theme and update UI
  applyDarkMode();
  updateSelectorUI();

  console.log("Dark mode script loaded. Current theme:", getCurrentMode());
});
