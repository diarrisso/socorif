/**
 * Active Menu Indicator - Disabled
 * Now using simple CSS border-bottom on menu items
 */

document.addEventListener("DOMContentLoaded", function () {
  "use strict";

  // Simple border-bottom animation is now handled purely with CSS
  // No JavaScript needed for the new simplified menu indicator
  console.log("Menu indicator: Using CSS-only border-bottom animation");
  return;

  // Function to position and animate the indicator under a menu element
  function positionIndicator(element) {
    const nav = element.closest("nav");
    const navRect = nav.getBoundingClientRect();
    const elementRect = element.getBoundingClientRect();

    // Calculate position relative to navigation
    const leftPosition = elementRect.left - navRect.left;
    const width = elementRect.width;

    // Apply smooth animation with transform and width
    indicator.style.left = `${leftPosition}px`;
    indicator.style.width = `${width}px`;

    // Make indicator visible with fade-in
    indicator.classList.remove("opacity-0");
    indicator.classList.add("opacity-100");
  }

  // Trouver et positionner l'indicateur sur le menu actif au chargement
  function findAndPositionActiveMenu() {
    const currentUrl = window.location.pathname;
    let activeItem = null;

    // Parcourir les items pour trouver le premier menu actif
    for (const item of navItems) {
      const linkUrl = new URL(item.href).pathname;

      // Vérification stricte: exact match de l'URL actuelle
      if (currentUrl === linkUrl) {
        activeItem = item;
        break;
      }

      // Si pas de match exact, vérifier si c'est la classe active ou text-red-600
      if (
        !activeItem &&
        (item.classList.contains("active") ||
          item.classList.contains("text-red-600"))
      ) {
        activeItem = item;
      }
    }

    // Positionner l'indicateur uniquement si un menu actif est trouvé
    if (activeItem) {
      console.log(
        "Menu actif trouvé:",
        activeItem.textContent.trim(),
        "- URL:",
        activeItem.href,
      );
      positionIndicator(activeItem);
    } else {
      console.log("Aucun menu actif trouvé - indicateur caché");
      // Cacher l'indicateur si aucun menu n'est actif
      indicator.classList.add("opacity-0");
      indicator.classList.remove("opacity-100");
    }
  }

  findAndPositionActiveMenu();

  // Add hover animation to menu items
  navItems.forEach((item) => {
    item.addEventListener("mouseenter", function () {
      positionIndicator(this);
    });
  });

  // Return to active menu when mouse leaves navigation
  const nav = document.querySelector("header nav");
  if (nav) {
    nav.addEventListener("mouseleave", function () {
      const activeItem = document.querySelector(
        "header nav ul > li > a.text-red-600, header nav ul > li > a.active",
      );
      if (activeItem) {
        positionIndicator(activeItem);
      } else {
        // Hide indicator if no active menu
        indicator.classList.add("opacity-0");
        indicator.classList.remove("opacity-100");
      }
    });
  }

  // Reposition on window resize
  let resizeTimeout;
  window.addEventListener("resize", function () {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(function () {
      const activeItem = document.querySelector(
        "header nav ul > li > a.text-red-600, header nav ul > li > a.active",
      );
      if (activeItem) {
        positionIndicator(activeItem);
      }
    }, 250);
  });

  console.log(
    "Modern animated menu indicator loaded - Current URL:",
    window.location.pathname,
  );
});
