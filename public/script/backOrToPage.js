function backOrToPage() {
    if (document.referrer) {  // Vérifie s'il y a une page précédente dans l'historique de navigation
      history.back();  // Si oui, retourne à cette page
    } else {
      window.location.href = "?controller=pages&action=home";  // Sinon, redirige vers une page spécifique
    }
  }