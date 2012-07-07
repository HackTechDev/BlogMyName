CustomButton = {

1: function () {

    const blog = "steamcyberpunk.net";
    const site = window.content.location.href;
    
    // Serveur de production
    const serveur= "http://steamcyberpunk.net/dev/blogmyname/";
    // Serveur de test
    //const serveur = "http://localhost/blog2blog/";

    const utilisateur = "xxxxxxxxxxxxxxxxxx";
    const motdepasse = "zzzzzzzzzzzzzzz";

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
