function verificationForm() {

    const email = document.getElementById("formMail").value;
    const password = document.getElementById("formPassword").value;
    let error = false;
  
    if (!email) {
      document.getElementById("formMail").classList.add("errorInput");
      document.getElementById("ErreurMail").innerHTML = "Le champ e-mail est requis";
      error = true;
    } else {
      document.getElementById("formMail").classList.remove("errorInput");
      document.getElementById("ErreurMail").innerHTML = "";
    }
  
    if (!password) {
      document.getElementById("formPassword").classList.add("errorInput");
      document.getElementById("ErreurPassword").innerHTML = "Le champ mot de passe est requis";
      error = true;
    } else {
      document.getElementById("formPassword").classList.remove("errorInput");
      document.getElementById("ErreurPassword").innerHTML = "";
    }
  
    if (error) {
      return false;
    }
  
    return true;

}

function verification() {

    const orga = document.getElementById("formOrga").checked;
    const util = document.getElementById("formUtil").checked;
    const raisonSociale = document.getElementById("raison sociale").value;
    const nom = document.getElementById("nom").value;
    const prenom = document.getElementById("prenom").value;
    const email = document.getElementById("formMail").value;
    const adresse = document.getElementById("adresse").value;
    const lieu = document.getElementById("formLieu").value;
    const cp = document.getElementById("formCP").value;
    const telephone = document.getElementById("formTelephone").value;
    const password = document.getElementById("formPassword").value;
    let error = false;

    if ((orga !==true)&&(util !==true)){
      document.getElementById("ErreurOrga").innerHTML = "Veuillez cocher";
      document.getElementById("formOrga").classList.add("errorInput");
      error=true;
    }else{
      document.getElementById("ErreurOrga").innerHTML = "";
  }
  
    if (!raisonSociale) {
      document.getElementById("raison sociale").classList.add("errorInput");
      document.getElementById("ErreurRS").innerHTML = "Le champ est requis";
      error = true;
    } else {
      document.getElementById("raison sociale").classList.remove("errorInput");
      document.getElementById("ErreurRS").innerHTML = "";
    }
  
    if (!nom) {
      document.getElementById("nom").classList.add("errorInput");
      document.getElementById("ErreurNom").innerHTML = "Le champ nom est requis";
      error = true;
    } else {
      document.getElementById("nom").classList.remove("errorInput");
      document.getElementById("ErreurNom").innerHTML = "";
    }
  
    if (!prenom) {
      document.getElementById("prenom").classList.add("errorInput");
      document.getElementById("ErreurPrenom").innerHTML = "Le champ prénom est requis";
      error = true;
    } else {
      document.getElementById("prenom").classList.remove("errorInput");
      document.getElementById("ErreurPrenom").innerHTML = "";
    }
  
    if (!email) {
      document.getElementById("formMail").classList.add("errorInput");
      document.getElementById("ErreurMail").innerHTML = "Le champ e-mail est requis";
      error = true;
    } else {
      document.getElementById("formMail").classList.remove("errorInput");
      document.getElementById("ErreurMail").innerHTML = "";
    }

    if (!password) {
      document.getElementById("formPassword").classList.add("errorInput");
      document.getElementById("ErreurPassword").innerHTML = "Le champ mot de passe est requis";
      error = true;
    } else {
      document.getElementById("formPassword").classList.remove("errorInput");
      document.getElementById("ErreurPassword").innerHTML = "";
    }
  
    if (!adresse) {
      document.getElementById("adresse").classList.add("errorInput");
      document.getElementById("ErreurAdresse").innerHTML = "Le champ adresse est requis";
      error = true;
    } else {
      document.getElementById("adresse").classList.remove("errorInput");
      document.getElementById("ErreurAdresse").innerHTML = "";
    }

    if (!cp) {
      document.getElementById("formCP").classList.add("errorInput");
      document.getElementById("ErreurCP").innerHTML = "Le champ code postal est requis";
      error = true;
    } else {
      document.getElementById("formCP").classList.remove("errorInput");
      document.getElementById("ErreurLieu").innerHTML = "";
    }
  
    if (!lieu) {
      document.getElementById("formLieu").classList.add("errorInput");
      document.getElementById("ErreurLieu").innerHTML = "Le champ ville est requis";
      error = true;
    } else {
      document.getElementById("formLieu").classList.remove("errorInput");
      document.getElementById("ErreurLieu").innerHTML = "";
    }
  
    if (!telephone) {
      document.getElementById("formTelephone").classList.add("errorInput");
      document.getElementById("ErreurTelephone").innerHTML = "Le champ téléphone est requis";
      error = true;
    } else {
      document.getElementById("formTelephone").classList.remove("errorInput");
      document.getElementById("ErreurTelephone").innerHTML = "";
    }
  
    if (error) {
        return false;
      }
    
      return true;
  }

  function verificationEvent() {

    const titre = document.getElementById("formOrga").checked;
    const util = document.getElementById("formUtil").checked;
    const raisonSociale = document.getElementById("raison sociale").value;
    const nom = document.getElementById("nom").value;
    const prenom = document.getElementById("prenom").value;
    const email = document.getElementById("formMail").value;
    const adresse = document.getElementById("adresse").value;
    const lieu = document.getElementById("formLieu").value;
    const cp = document.getElementById("formCP").value;
    const telephone = document.getElementById("formTelephone").value;
    const password = document.getElementById("formPassword").value;
    let error = false;

    if ((orga !==true)&&(util !==true)){
      document.getElementById("ErreurOrga").innerHTML = "Veuillez cocher";
      document.getElementById("formOrga").classList.add("errorInput");
      error=true;
    }else{
      document.getElementById("ErreurOrga").innerHTML = "";
  }
  
    if (!raisonSociale) {
      document.getElementById("raison sociale").classList.add("errorInput");
      document.getElementById("ErreurRS").innerHTML = "Le champ est requis";
      error = true;
    } else {
      document.getElementById("raison sociale").classList.remove("errorInput");
      document.getElementById("ErreurRS").innerHTML = "";
    }
  
    if (!nom) {
      document.getElementById("nom").classList.add("errorInput");
      document.getElementById("ErreurNom").innerHTML = "Le champ nom est requis";
      error = true;
    } else {
      document.getElementById("nom").classList.remove("errorInput");
      document.getElementById("ErreurNom").innerHTML = "";
    }
  
    if (!prenom) {
      document.getElementById("prenom").classList.add("errorInput");
      document.getElementById("ErreurPrenom").innerHTML = "Le champ prénom est requis";
      error = true;
    } else {
      document.getElementById("prenom").classList.remove("errorInput");
      document.getElementById("ErreurPrenom").innerHTML = "";
    }
  
    if (!email) {
      document.getElementById("formMail").classList.add("errorInput");
      document.getElementById("ErreurMail").innerHTML = "Le champ e-mail est requis";
      error = true;
    } else {
      document.getElementById("formMail").classList.remove("errorInput");
      document.getElementById("ErreurMail").innerHTML = "";
    }

    if (!password) {
      document.getElementById("formPassword").classList.add("errorInput");
      document.getElementById("ErreurPassword").innerHTML = "Le champ mot de passe est requis";
      error = true;
    } else {
      document.getElementById("formPassword").classList.remove("errorInput");
      document.getElementById("ErreurPassword").innerHTML = "";
    }
  
    if (!adresse) {
      document.getElementById("adresse").classList.add("errorInput");
      document.getElementById("ErreurAdresse").innerHTML = "Le champ adresse est requis";
      error = true;
    } else {
      document.getElementById("adresse").classList.remove("errorInput");
      document.getElementById("ErreurAdresse").innerHTML = "";
    }

    if (!cp) {
      document.getElementById("formCP").classList.add("errorInput");
      document.getElementById("ErreurCP").innerHTML = "Le champ code postal est requis";
      error = true;
    } else {
      document.getElementById("formCP").classList.remove("errorInput");
      document.getElementById("ErreurLieu").innerHTML = "";
    }
  
    if (!lieu) {
      document.getElementById("formLieu").classList.add("errorInput");
      document.getElementById("ErreurLieu").innerHTML = "Le champ ville est requis";
      error = true;
    } else {
      document.getElementById("formLieu").classList.remove("errorInput");
      document.getElementById("ErreurLieu").innerHTML = "";
    }
  
    if (!telephone) {
      document.getElementById("formTelephone").classList.add("errorInput");
      document.getElementById("ErreurTelephone").innerHTML = "Le champ téléphone est requis";
      error = true;
    } else {
      document.getElementById("formTelephone").classList.remove("errorInput");
      document.getElementById("ErreurTelephone").innerHTML = "";
    }
  
    if (error) {
        return false;
      }
    
      return true;
  }

  function backOrToPage() {
    if (document.referrer === "") {
        // Si la page précédente n'existe pas, rediriger vers une autre page
        window.location.href = "?controller=pages&action=home"; // Remplacez "/" par l'URL de votre choix
    } else {
        history.back(); // Retourner à la page précédente
    }
}