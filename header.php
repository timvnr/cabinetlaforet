        <?php 

            //si on appuie sur le bouton pour voir les patients
            if(isset($_POST['patient'])) {
                header('Location: Affichage_Usagers.php');
            }

            //si on appuie sur le bouton pour voir les médecins
            if(isset($_POST['medecin'])) {
                header('Location: Affichage_Medecin.php');
            }

            //si on appuie sur le bouton pour voir les consultations
            if(isset($_POST['consult'])) {
                header('Location: Affichage_consultation.php');
            }

            //si on appuie sur le bouton pour voir les stats
            if(isset($_POST['stat'])) {
                header('Location: Affichage_Statistiques.php');
            }

            //si on appuie sur le bouton pour se déconnecter
            if(isset($_POST['menu'])) {
                header('Location: bienvenue.php');
            }
        ?>

        <header>
            
            <!--Formulaire pour stocker tous les boutons du header et pour pouvoir faire des traitements différents en fonction du bouton utilisé-->
            <form action="header.php" method="post">
                    <p>
                        <input class="survolBleu" type="submit" value="Patients" name="patient" />      <!--Bouton pour accéder à la page des patients-->
                        <input class="survolBleu" type="submit" value="Médecins" name="medecin"/>       <!--Bouton pour accéder à la page des médecins-->
                        <input class="survolBleu" type="submit" value="Consultations" name="consult"/>  <!--Bouton pour accéder à la page des consultations (rendez-vous)-->
                        <input class="survolBleu" type="submit" value="Statistiques" name="stat"/>      <!--Bouton pour accéder à la page des statistiques-->
                        <input class="survolBleu" type="submit" value="Retour au menu" name="menu"/>    <!--Bouton pour revenir au menu du site-->
                    </p>
            </form>

        </header>

