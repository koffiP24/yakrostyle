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

  // (Optionnel) Mise à jour dynamique du compteur panier (si vous utilisez AJAX plus tard)
});
