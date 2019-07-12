<?php session_start();
    try{
        $bdd = new PDO('pgsql:host=localhost;port=5432;dbname=gboc;user=super_admin;password=super_admin');
    }catch (Exception $e){
        die('Erreur : ' . $e->getMessage());
    }
    $reponse = $bdd->query('SELECT id, nom, prenom, datenaissance, numerotel, mail, role FROM benevoles WHERE id= \''.$_SESSION['uuid'].'\'');
    $donnees = $reponse->fetch()
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>GBoC - Mes informations</title>
    </head>
 
    <body>
 
    <!-- L'en-tête -->
    
    <header>
       
    </header>
    
    <!-- Le menu -->
    <?php include("menus.php"); ?>
    <!-- Le corps -->
    <div id="corps">
    <h1>Mes informations</h1>
    <form method="post" action="post_donnees_perso.php">
            Nom de famille :<br>
            <input type="text" name="nom" required=""value= <?php echo '"'.$donnees['nom'].'"'?>><br>
            Prénom :<br>
            <input type="text" name="prenom" required=""value= <?php echo '"'.$donnees['prenom'].'"'?>><br>
            Adresse E-mail :<br>
            <input type="mail" name="mail" required=""value= <?php echo '"'.$donnees['mail'].'"'?>><br>
            Numéro de telephone :<br>
           <input type="tel" name="tel" pattern="0[0-9]{9}|0[0-9]( [0-9]{2}){4}"value= <?php echo '"'.$donnees['numerotel'].'"'?>><br>
            Date de naissance :<br>
            <input type="date" name="ndate" required="" disabled="disabled" value= <?php echo '"'.$donnees['datenaissance'].'"'?> ><br>
            Participation aux commissions :<br>
            <?php $commissions = $bdd->query('SELECT * FROM commissions');
            while($com = $commissions->fetch()){
                echo '<input type="checkbox" name ="'.$com['nom'].'"'; if(in_array($_SESSION['uuid'], explode(",",substr($com['listbenevoles'],1,-1)), $strict = FALSE)) echo "checked=\"\""; echo '>'.$com['nom'].'<br>';
            }?>
            <input type="submit" value="Modifier mes informations">
        </form>
        <form method="post" action="post_donnees_perso.php">
            ancient mot de passe :<br>
            <input type="password" name="oldmp"><br>
            Nouveau mot de passe :<br>
            <input type="password" name="newmp"><br>
            Répétez le nouveau mot de passe :<br>
            <input type="password" name="newmp2"><br>
            <input type="submit" value="Modifier mon mot de passe"><br>
        </form>
        <?php 
            if(isset($_GET['error'])){
                if ($_GET['error'] == "mailexist") {
                    echo "Oups, cette adresse mail est déjà enregistrée. Une erreur dans l'adresse? Compte déjà créé?";
                }else if($_GET['error'] == "password"){
                    echo "Mot de passe incorrecte";
                }else{
                    echo "Oups, vous avez du faire une erreur en recopiant votre mot de passe. Veuillez recommencer s'il vous plait";
                }
            }
            if(isset($_GET['statut'])){
                echo "Vos nouvelles information on bien été enregistrées";
            }
        ?>
    </div>
    
    <!-- Le pied de page -->
    
    <footer id="pied_de_page">
    </footer>
    
    </body>
</html>