<?php 
    session_start();
    include("functions.php");
    if(!user_verified()){
        header('location: reception.php');
    }
    $db = connecting_db();
    if($_SESSION['role'] != 'ADMIN'){
        echo 'Vous n\'avez pas les droits pour accéder à cette page';
    }else{
?>
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8" />
                <title>GBoC - Liste des commissions</title>
            </head>
            <body>
                <?php include("menus.php"); ?>
                <div id="corps">

                    <h1>Liste des commissions</h1>

                    <?php $commissions = $db->query('SELECT id_commission, name_commission, active FROM commissions');
                    while($data_commission = $commissions->fetch()){
                        echo '<a href="data_commission.php?id_commission='.$data_commission['id_commission'].'">'.$data_commission['name_commission'].'</a> Cette commission ';
                        if($data_commission['active']) echo "est active.<br>"; else echo "n'est pas active <br>";
                    } ?>

                    <h2>Créer une nouvelle commission</h2>

                    <?php $volunteers = $db->query('SELECT id_volunteer, name_volunteer, surname_volunteer, mail FROM volunteers');?>
                    <form method="post" action="post_crud_commission.php">
                        Nom de la commission<br>
                        <input type="text" name="name" required=""><br>
                        Un moderateur<br>
                        <input type="text" list="volunteers" name="moderator" required="" size="40"><br>
                        <datalist id="volunteers">
                            <?php while($data_volunteer=$volunteers->fetch()){
                                echo '<option value="'.$data_volunteer['name_volunteer'].' '.$data_volunteer['surname_volunteer'].' ('.$data_volunteer['mail'].')"></option>';
                            }?>
                        </datalist>
                        <input type="submit" name="add_commission" value="Ajouter une commission">
                    </form>
                </div>
                <footer id="pied_de_page"></footer>
            </body>
        </html>
        <?php
    }
?>