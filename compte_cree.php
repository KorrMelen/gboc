<?php
    try{
        $bdd = new PDO('pgsql:host=localhost;port=5432;dbname=gboc;user=super_admin;password=super_admin');
    }catch (Exception $e){
        die('Erreur : ' . $e->getMessage());
    }
    function uuid(){
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>GBoC - compte creé</title>
    </head>
    <body>
    <?php
        if($_POST['mail1'] != $_POST['mail2'] || $_POST['password1'] != $_POST['password2']){
            if (isset($_POST['tel'])) {
                header('location: creer_compte.php?nom='.str_replace(' ','+',$_POST['nom']).'&prenom='.$_POST['prenom'].'&mail1='.$_POST['mail1'].'&tel='.str_replace(' ','+',$_POST['tel']).'&ndate='.$_POST['ndate'].'&error=notsame');
            }else{
                header('location: creer_compte.php?nom='.str_replace(' ','+',$_POST['nom']).'&prenom='.$_POST['prenom'].'&mail1='.$_POST['mail1'].'&ndate='.$_POST['ndate'].'&error=notsame');
            }            
        }else{
            $benevoles = $bdd->prepare('SELECT * FROM benevoles WHERE mail=:mail');
            $benevoles->execute(array('mail'=>$_POST['mail1']));
            if($benevoles->rowCount() > 0){
                if (isset($_POST['tel'])) {
                    header('location: creer_compte.php?nom='.str_replace(' ','+',$_POST['nom']).'&prenom='.$_POST['prenom'].'&tel='.str_replace(' ','+',$_POST['tel']).'&ndate='.$_POST['ndate'].'&error=mailexist');
                }else{
                    header('location: creer_compte.php?nom='.str_replace(' ','+',$_POST['nom']).'&prenom='.$_POST['prenom'].'&ndate='.$_POST['ndate'].'&error=mailexsit');
                }
            }else{
                $_POST['password1'] = password_hash($_POST['password1'], PASSWORD_BCRYPT);
                $uuid = uuid();
                $addbenevoles = $bdd->prepare('INSERT INTO "benevoles" VALUES(:id,:nom,:prenom,:dateNaissance,:numeroTel,:mail,:password,\'BENEVOLE\')');
                $addbenevoles->execute(array(
                    'id' => $uuid,
                    'nom' => strtoupper($_POST['nom']),
                    'prenom' =>ucwords ($_POST['prenom']," -'_/"),
                    'dateNaissance' => $_POST['ndate'],
                    'numeroTel' => $_POST['tel'],
                    'mail' => $_POST['mail1'],
                    'password' => $_POST['password1']
                ));
                $commissions = $bdd->query('SELECT * FROM commissions');
                $addcom = $bdd->prepare('UPDATE commissions SET benevolesattente = array_append(benevolesattente, :uuid) WHERE id=:id');
                while($donnees_comms = $commissions->fetch()){
                    if(isset($_POST[$donnees_comms['nom']])){
                        $addcom->execute(array(
                            'uuid' =>$uuid,
                            'id' => $donnees_comms['id']
                        ));
                    }
                }
            }
            $benevoles->closeCursor();
        }
    ?>
    <div id="corps">
    <h1>Inscription au module de Gestion des Bénévoles Ou des Commissions</h1>
    <p>
        Félicitaion votre compte à été creé, pour vous connecter vous aurez besoin de l'adresse mail enregistré (<?php echo $_POST['mail1']; ?>) et de votre mot de passe<br />
    </p>
    <a href="accueil.php">Retourner à la page de connexion</a><br>


    </div>
    
    <!-- Le pied de page -->
    
    <footer id="pied_de_page">
    </footer>
    
    </body>
</html>