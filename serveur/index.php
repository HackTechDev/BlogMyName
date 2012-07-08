<html>
    <head>
        <title>
            BlogMyName
        </title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />    
    <link href="style.css" rel="stylesheet" media="all" type="text/css"> 
    </head>
<body>
<?php
require("IXR_Library.php");


function listerArticle($blog, $utilisateur, $motdepasse){

	$client = new IXR_Client('http://'.$blog.'/xmlrpc.php');
		$articleTitres = "";
        if (!$client->query('metaWeblog.getRecentPosts','', $utilisateur, $motdepasse, 15)){  
            echo('Error occured during category request.' . $client->getErrorCode().":".$client->getErrorMessage());  
        }
        $posts = $client->getResponse();
		$i=0;
        if(!empty($posts)){
            foreach($posts as $_post){
				$articleTitres .= "<a href=".$_post['postid']."> ". $_post['title'] . "</a><br>";
			}
        }
	return $articleTitres;
}

/*
    Lit un article 

 */

function lireArticle(){
}

/*
 Affiche toutes les catégories disponible
 */

function afficherCategories($blog, $utilisateur, $motdepasse){

	$client = new IXR_Client('http://'.$blog.'/xmlrpc.php');
		$options = "";
        if (!$client->query('wp.getCategories','', $utilisateur, $motdepasse)){  
            echo('Error occured during category request.' . $client->getErrorCode().":".$client->getErrorMessage());  
        }
        $cats = $client->getResponse();
       
        if(!empty($cats)){
            foreach($cats as $_cat){
				$options .= "<option value='".$_cat['categoryName']."'>". $_cat['categoryName'] . "</option>";
			}
        }
	return $options;
}

/*
    Ecrire un article
    $titre : titre de l'article
    $texte : texte de l'article
    $apublie : true = publié de suite, false = brouillon
*/

function ecrireArticle($blog, $utilisateur, $motdepasse, $titre, $texte, $apublie){
    
    $client = new IXR_Client('http://'.$blog.'/xmlrpc.php');
    $content['title'] = $titre;
    $content['description'] = $texte;

    if (!$client->query('metaWeblog.newPost','', $utilisateur, $motdepasse, $content, $apublie)) {
        die('Erreur creation article' . $client->getErrorCode() ." : ". $client->getErrorMessage());  
    }
    $idArticle =  $client->getResponse();
    return $idArticle;  
}

function recupererTitreArticle($fichier){
    static $fp, $ligne, $regs;
    $fp = @fopen($fichier, "r");
    if (!$fp) return FALSE;
    $ligne = fgets($fp, 1024);
    while (!eregi("<TITLE>(.*)</TITLE>", $ligne) and !feof($fp)) $ligne = fgets($fp, 1024);
    if (eregi("<TITLE>(.*)</TITLE>", $ligne, $regs)) return $regs[1];
    else return FALSE;
}

if(isset($_GET["blog"]) && isset($_GET["utilisateur"]) && isset($_GET['motdepasse']) && isset($_GET['site'])){
       $blog = $_GET["blog"];
       $utilisateur = $_GET["utilisateur"];
       $motdepasse = $_GET["motdepasse"];

       $texte = $_GET['site'];
       $titre = recupererTitreArticle($texte); 
}

if( isset($_POST["blog"]) && isset($_POST["utilisateur"]) && isset($_POST['motdepasse']) &&
    isset($_POST["action"]) && isset($_POST["titre"]) && isset($_POST['texte'])){

            $blog = $_POST['blog'];
            $utilisateur = $_POST['utilisateur'];
            $motdepasse = $_POST['motdepasse'];

            $titre = $_POST['titre'];
            $texte = $_POST['texte'];

            $etat = $_POST['etat'];

            if($etat == "brouillon"){            
                echo "Article #" . ecrireArticle($blog, $utilisateur, $motdepasse, $titre, $texte, false) . " a &eacute;t&eacute; cr&eacute;er et en brouillon<br/><br/>";
            }else{
                echo "Article #" . ecrireArticle($blog, $utilisateur, $motdepasse, $titre, $texte, true) . " a &eacute;t&eacute; cr&eacute;er et publié<br/><br/>";
            }    
 }
?>
Blog : <a href="http://<?php echo $blog; ?>"><?php echo $blog; ?></a><br/><br/>
<table>
	<tr>
		<td>

			<form name="form" action="index.php" method="post">

            <input type="hidden" value="<?php echo $blog; ?>" id="blog" name="blog">
            <input type="hidden" value="<?php echo $utilisateur; ?>" id="utilisateur" name="utilisateur">
            <input type="hidden" value="<?php echo $motdepasse; ?>" id="motdepasse" name="motdepasse">

			<table>

				<tr>
					<td>
						Titre : 
					</td>
					<td>    
						<input type="text" value="<?php echo $titre; ?>" id="titre" name="titre" size="40"><br/>
					</td>
				</tr>
				<tr>
					<td>
						Cat&eacute;gorie : 
					</td>
					<td>
						<select id="categories" name="categories" >
							<?php echo afficherCategories($blog, $utilisateur, $motdepasse); ?><br/>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Mots-clefs : 
					</td>
					<td>
						<input type="text" value="" id="motcles" name="motcles" size="40"><br/>
					</td>
				</tr>
				<tr>
					<td>
						Texte : 
					</td>
					<td>
						<textarea  id="texte" name="texte" rows="10" cols="40"><?php echo $texte; ?></textarea><br/>
					</td>
				</tr>
				<tr>
					<td>
						Etat :
					</td>
					 <td>
						<input type="checkbox" id="etat" name="etat" value="brouillon"> Brouillon
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						<input type="submit" value="Poster l'article" name="action">
					</td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table>
<?php

?>
</body>
</html>
