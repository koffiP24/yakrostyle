// public/js/app.js - YakroStyle

// Auto-masquage des messages flash après 4 secondes
document.addEventListener("DOMContentLoaded", function () {
  const alerts = document.querySelectorAll(".alert");
  alerts.forEach((el) => {
    setTimeout(() => {
      el.style.transition = "opacity 0.4s";
      el.style.opacity = "0";
      setTimeout(() => el.remove(), 400);
    }, 4000);
  });

  // Confirmation avant de vider le panier
  const clearCartLinks = document.querySelectorAll('a[href="/panier/vider"]');
  clearCartLinks.forEach((link) => {
    link.addEventListener("click", (e) => {
      if (!confirm("Vider tout le panier ?")) {
        e.preventDefault();
      }
    });
  });

  // Confirmation avant de supprimer un article du panier
  const deleteItemLinks = document.querySelectorAll(
    'a[href^="/panier/supprimer/"]',
  );
  deleteItemLinks.forEach((link) => {
    link.addEventListener("click", (e) => {
      if (!confirm("Retirer cet article du panier ?")) {
        e.preventDefault();
      }
    });
  });

  // Mode sombre / clair
  const themeToggle = document.getElementById("theme-toggle");
  const setTheme = (mode) => {
    const isDark = mode === "dark";
    document.body.classList.toggle("dark-mode", isDark);
    localStorage.setItem("yakro-theme", mode);
    if (themeToggle) {
      const icon = themeToggle.querySelector("i");
      const label = themeToggle.querySelector("span");
      icon.className = isDark ? "fa-solid fa-sun" : "fa-solid fa-moon";
      label.textContent = isDark ? "Mode clair" : "Mode sombre";
    }
  };

  const savedTheme = localStorage.getItem("yakro-theme") || "light";
  setTheme(savedTheme);

  if (themeToggle) {
    themeToggle.addEventListener("click", () => {
      setTheme(
        document.body.classList.contains("dark-mode") ? "light" : "dark",
      );
    });
  }

  document.querySelectorAll(".password-toggle").forEach((button) => {
    button.addEventListener("click", () => {
      const targetId = button.dataset.target;
      const input = document.getElementById(targetId);
      if (!input) return;

      const isPassword = input.type === "password";
      input.type = isPassword ? "text" : "password";
      button.querySelector("i").className = isPassword
        ? "fa-solid fa-eye-slash"
        : "fa-solid fa-eye";
    });
  });

  const adminSearch = document.getElementById("admin-search");
  if (adminSearch) {
    adminSearch.addEventListener("input", () => {
      const searchValue = adminSearch.value.trim().toLowerCase();
      const targetList = adminSearch.dataset.searchTarget || "admin-dashboard";
      const container = document.querySelector(
        `[data-search-list='${targetList}']`,
      );
      if (!container) return;

      container.querySelectorAll("[data-search-content]").forEach((item) => {
        const text = item.textContent.trim().toLowerCase();
        const matches = text.includes(searchValue);
        item.style.display = matches ? "grid" : "none";
      });

      container.querySelectorAll(".dashboard-panel").forEach((panel) => {
        const items = panel.querySelectorAll("[data-search-content]");
        const visibleItems = Array.from(items).filter(
          (item) => item.style.display !== "none",
        );
        const emptyResult = panel.querySelector(".empty-result");

        if (emptyResult) {
          emptyResult.style.display =
            visibleItems.length === 0 && searchValue ? "block" : "none";
        }
      });
    });
  }

  // (Optionnel) Mise à jour dynamique du compteur panier (si vous utilisez AJAX plus tard)
});
