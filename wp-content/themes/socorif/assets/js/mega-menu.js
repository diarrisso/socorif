/**
 * Mega Menu Overlay Script
 * Handles click-to-open overlay with mega menu dropdown
 */

document.addEventListener("DOMContentLoaded", function () {
  // Mobile menu toggle
  const mobileMenuButton = document.getElementById("mobile-menu-button");
  const mobileMenu = document.getElementById("mobile-menu");

  if (mobileMenuButton && mobileMenu) {
    mobileMenuButton.addEventListener("click", function () {
      mobileMenu.classList.toggle("hidden");
    });
  }

  // Desktop navigation triangle indicator
  const menuItems = document.querySelectorAll(".header-menu-item");
  const menuTriangle = document.querySelector(".menu-triangle");

  if (menuTriangle) {
    // Position triangle under active menu item on load
    positionTriangleUnderActiveItem();

    // Add hover listeners for triangle positioning
    menuItems.forEach(function (item) {
      const link = item.querySelector("a[data-menu-item]");
      if (!link) return;

      item.addEventListener("mouseenter", function () {
        positionTriangleUnderItem(link);
      });

      item.addEventListener("mouseleave", function () {
        positionTriangleUnderActiveItem();
      });
    });

    // Reposition on window resize
    let resizeTimeout;
    window.addEventListener("resize", function () {
      clearTimeout(resizeTimeout);
      resizeTimeout = setTimeout(function () {
        positionTriangleUnderActiveItem();
      }, 100);
    });
  }

  /**
   * Mega Menu Overlay Functionality
   */
  const overlay = document.getElementById("mega-menu-overlay");
  const overlayPanel = overlay
    ? overlay.querySelector(".mega-menu-panel")
    : null;
  const closeButton = document.getElementById("close-mega-menu");

  // Get all menu items from the main navigation (find UL element in nav)
  const mainNav = document.querySelector("nav");
  const mainMenu = mainNav ? mainNav.querySelector("ul") : null;

  if (overlay && overlayPanel) {
    // Add click listeners to all menu links
    document.addEventListener("click", function (e) {
      const trigger = e.target.closest(".has-dropdown-trigger");
      if (trigger) {
        e.preventDefault();
        console.log("Overlay trigger clicked!", trigger);

        // Populate overlay navigation
        if (mainMenu) {
          populateOverlayNavigation(mainMenu);
        }

        // Load menu content dynamically
        loadMegaMenuContent(trigger);

        // Open overlay with animation
        openOverlay();
      }
    });

    // Close overlay on close button click
    if (closeButton) {
      closeButton.addEventListener("click", function () {
        closeOverlay();
      });
    }

    // Close overlay on background click
    overlay.addEventListener("click", function (e) {
      if (e.target === overlay) {
        closeOverlay();
      }
    });

    // Close overlay on ESC key
    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && !overlay.classList.contains("hidden")) {
        closeOverlay();
      }
    });
  }

  /**
   * Open overlay with animation
   */
  function openOverlay() {
    overlay.classList.remove("hidden");
    // Force reflow for animation
    overlay.offsetHeight;
    overlay.classList.remove("opacity-0");
    overlayPanel.classList.remove("translate-x-full");
    document.body.style.overflow = "hidden";
  }

  /**
   * Close overlay with animation
   */
  function closeOverlay() {
    overlay.classList.add("opacity-0");
    overlayPanel.classList.add("translate-x-full");
    setTimeout(function () {
      overlay.classList.add("hidden");
      document.body.style.overflow = "";
    }, 300);
  }

  /**
   * Populate overlay navigation (clone from main navigation)
   */
  function populateOverlayNavigation(mainMenu) {
    const overlayNav = document.getElementById("overlay-nav-menu");
    if (!overlayNav || !mainMenu) return;

    // Clear existing
    overlayNav.innerHTML = "";

    // Clone menu items
    const menuItems = mainMenu.querySelectorAll("li > a");
    menuItems.forEach(function (item) {
      const link = document.createElement("a");
      link.href = item.getAttribute("href");
      link.textContent = item.textContent;

      // Check if current/active
      if (
        item.closest("li").classList.contains("current-menu-item") ||
        item.closest("li").classList.contains("current-menu-parent") ||
        item.closest("li").classList.contains("current-menu-ancestor") ||
        item.classList.contains("active-menu-link")
      ) {
        link.className = "text-red-600 dark:text-red-500 font-medium";
      } else {
        link.className =
          "text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors";
      }

      overlayNav.appendChild(link);
    });
  }

  /**
   * Load mega menu content dynamically from WordPress menu structure
   */
  function loadMegaMenuContent(triggerElement) {
    const categoriesContainer = document.getElementById("mega-menu-categories");
    const servicesContainer = document.getElementById("mega-menu-services");

    if (!categoriesContainer || !servicesContainer) return;

    // Clear existing content
    categoriesContainer.innerHTML = "";
    servicesContainer.innerHTML = "";

    // Get parent LI element
    const parentLi = triggerElement.closest("li");
    if (!parentLi) {
      console.error("Parent LI not found");
      return;
    }

    console.log("Parent LI:", parentLi);

    // Get submenu - try both UL and DIV structure
    let submenu = parentLi.querySelector("ul");
    if (!submenu) {
      // Try the div structure from the walker
      submenu = parentLi.querySelector("div > div > div > div");
      console.log("Using DIV structure");
    }

    if (!submenu) {
      console.error("Submenu not found");
      return;
    }

    console.log("Submenu found:", submenu);

    // Get categories (try both LI and direct A elements)
    const categories = submenu.querySelectorAll("li");
    console.log("Found categories:", categories.length);

    categories.forEach(function (category, index) {
      const categoryLink = category.querySelector("a");
      if (!categoryLink) return;

      console.log("Category:", categoryLink.textContent);

      // Create category link (left column)
      const link = document.createElement("a");
      link.href = categoryLink.getAttribute("href") || "#";
      link.className =
        "flex items-center justify-between text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-500 transition-colors text-[15px] py-2";
      link.innerHTML =
        "<span>" +
        categoryLink.textContent +
        '</span><svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>';
      categoriesContainer.appendChild(link);

      // Get services (second level) - only from first category
      if (index === 0) {
        const servicesSubmenu =
          category.querySelector("ul") || category.querySelector("div");
        if (servicesSubmenu) {
          const services = servicesSubmenu.querySelectorAll("a");
          console.log("Found services:", services.length);
          services.forEach(function (serviceLink) {
            const sLink = document.createElement("a");
            sLink.href = serviceLink.getAttribute("href") || "#";
            sLink.className =
              "block text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors text-[14px] py-1.5";
            sLink.textContent = serviceLink.textContent;
            servicesContainer.appendChild(sLink);
          });
        }
      }
    });
  }

  /**
   * Triangle positioning functions
   */
  function positionTriangleUnderItem(link) {
    if (!menuTriangle) return;
    const linkRect = link.getBoundingClientRect();
    const containerRect = menuTriangle.parentElement.getBoundingClientRect();
    const centerPosition =
      linkRect.left + linkRect.width / 2 - containerRect.left;

    menuTriangle.style.left = centerPosition + "px";
    menuTriangle.classList.add("active");
  }

  function positionTriangleUnderActiveItem() {
    if (!menuTriangle) return;
    const activeLink = document.querySelector(
      ".active-menu-link[data-menu-item]",
    );

    if (activeLink) {
      positionTriangleUnderItem(activeLink);
    } else {
      menuTriangle.classList.remove("active");
    }
  }
});
