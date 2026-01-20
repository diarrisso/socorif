// Delegated handler: ONLY intercept clicks on elements with [data-open-overlay="true"]
// Let all other navigation happen normally
(function () {
  if (typeof window === "undefined" || typeof document === "undefined") return;

  document.addEventListener(
    "click",
    function (e) {
      // Only check for explicit data-open-overlay="true" attribute
      var el =
        e.target.closest && e.target.closest('[data-open-overlay="true"]');

      // If no element with data-open-overlay="true", let navigation happen normally
      if (!el) return;

      // Debug log to help during local testing
      try {
        console.debug(
          "[overlay-delegate] matched element with data-open-overlay:",
          el,
        );
      } catch (err) {}

      // Get menu ID and title for Alpine
      var menuId = el.getAttribute("data-menu-id");
      var menuTitle = el.textContent.trim();

      // Prevent navigation and dispatch custom event for Alpine to handle
      e.preventDefault();
      var ev = new CustomEvent("open-menu", {
        bubbles: true,
        detail: { menuId: menuId, menuTitle: menuTitle },
      });
      window.dispatchEvent(ev);

      try {
        console.debug(
          "[overlay-delegate] dispatched open-menu for:",
          menuTitle,
        );
      } catch (err) {}
    },
    false,
  );
})();
