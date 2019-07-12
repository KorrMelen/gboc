<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>GBoC - Accueil</title>
    </head>
 
    <body>
 
    <!-- L'en-tête -->
    
    <header>
       
    </header>
    
    <!-- Le menu -->
    <!-- Le corps -->
    
    <div id="corps">
        <h1>Accueil du module de Gestion des Bénévoles Ou des Commissions</h1>
        
        <p>
            Bienvenue sur le module de Gestion des bénévoles Ou des Commissions !<br />
            Ce module est là pour permettre aux chargés de commissions de la mission bretonne de faire appel aux bénévoles afin d'aider lors d'événement et pouvoir communniquer avec eux directement.<br />
        </p>

        <form method="post" action="post_accueil.php">
            Adresse E-mail :<br>
            <input type="email" name="mail" required="" <?php if(isset($_COOKIE['mail'])) echo 'value='.$_COOKIE['mail']; ?>><br>
            Mot de passe :<br>
            <input type="password" name="password" required="" <?php if(isset($_COOKIE['password'])) echo 'value='.$_COOKIE['password']; ?> ><br>
            <input type="checkbox" name="save" <?php if(isset($_COOKIE['save'])) echo 'checked'; ?>> Se souvenir de mon identifiant et de mon mot de passe<br>
            <input type="submit" value="Connexion">
        </form>
        <a href="creer_compte.php">Créer un compte</a>
        <?php 
            if(isset($_GET['error'])){
                if ($_GET['error'] == "mailnotexist") {
                    echo "Cette adresse mail n'est déjà enregistrée. Une erreur dans l'adresse? Compte pas créé?";
                }else{
                    echo "Mot de passe incorrecte";
                }
            }
        ?>
    </div>
    
    <!-- Le pied de page -->
    
    <footer id="pied_de_page">
    </footer>
    
    </body>
</html>