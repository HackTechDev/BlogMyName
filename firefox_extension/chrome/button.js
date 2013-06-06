CustomButton = {

1: function () {

    const blog = "monsite.com";
    const site = window.content.location.href;
    
    // Serveur de production
    const serveur= "http://monsite.com/dev/blogmyname/";
    // Serveur de test
    //const serveur = "http://localhost/blog2blog/";

    const utilisateur = "nom_utilisateur";
    const motdepasse = "mot_passe";

    // Ouvre une fenêtre avec l'affichage du site internet
    var windowObjectReference;  
    var strWindowFeatures = "menubar=no,location=no,resizable=no,scrollbars=no,status=no,width=480,height=440,";  
      
    function openRequestedPopup() {  
      var lien = serveur + "index.php?blog=" + blog + "&utilisateur=" + utilisateur + "&motdepasse=" + motdepasse + "&site=" + site;    
      windowObjectReference = window.open(lien, "BlogMe_WindowName", strWindowFeatures);  
    }  

    openRequestedPopup();

  },

}
