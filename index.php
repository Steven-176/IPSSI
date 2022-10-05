<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee+Spice&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400&display=swap" rel="stylesheet">

    <script src="script.js" defer></script>

    <title>Document</title>
</head>
<body>
    <?php

        /***************************************
         *  Acquisition de la base de données  *
         ***************************************/
        function acquisitionTableau ($tableauURL, $key) {
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $tableauURL);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json', $key));

            //
            $certificate = "C:\wamp64\cacert.pem";
            curl_setopt($curl, CURLOPT_CAINFO, $certificate);
            curl_setopt($curl, CURLOPT_CAPATH, $certificate);

            //Acquisition du tableau "Joueur" de Airtable
            $resultat = curl_exec($curl);

            curl_close($curl);

            return $resultat;
        }

        
         /***************************************
         *  Réorganisation du tableau "Joueur  *
         ***************************************/
        function getTableJoueur($table, $ligne) {
            $tab = array(
                'Prénom Nom' => $table['records'][$ligne]['fields']['prenom']."<br />".$table['records'][$ligne]['fields']['nom'],
                'Photo' => $table['records'][$ligne]['fields']['Photo'],
                'Nationalité' => $table['records'][$ligne]['fields']['nationalite'],
                'Poste' => $table['records'][$ligne]['fields']['poste'],
                'Club' => $table['records'][$ligne]['fields']['nom (from club)'][0],
                'N° Maillot' => $table['records'][$ligne]['fields']['numero_maillot'],
                'Match Joués' => $table['records'][$ligne]['fields']['match_joues'],
                'But Marqués' => $tab[7] = $table['records'][$ligne]['fields']['buts_marques'],
                'Passes Décisives' => $table['records'][$ligne]['fields']['passes_decisives'],
                'Club' => $table['records'][$ligne]['fields']['passes_decisives'],
            );
            return $tab;
        }


        /**************************************
         *  Réorganisation du tableau "Club"  *
         **************************************/
        function getTableClub($table, $ligne) {
            $tab = array(
                'ID' => $table['records'][$ligne]['id'],
                'Nom' => $table['records'][$ligne]['fields']['nom'],
                'Logo' => $table['records'][$ligne]['fields']['Logo'],
                'Classement' => $table['records'][$ligne]['fields']['classement'],
                'Ville' => $table['records'][$ligne]['fields']['ville'],
                'Année de création' => $table['records'][$ligne]['fields']['annee_de_creation'],
                'Entraîneur' => $table['records'][$ligne]['fields']['entraineur'],
            );
            foreach ($table['records'][$ligne]['fields']['nom (from joueur)'] as $joueur) {
                $tab['Joueur'][] = $joueur;
            }
            return $tab;
        }

        //Clé d'accés
        $authorization =  "Authorization: Bearer keylGy9dvvUc5clRX";

        /************************************/

        //Acquisition de la base de données "Joueur"
        $resultatJoueur = acquisitionTableau("https://api.airtable.com/v0/appljQzgZO6yDwebG/Joueur?view=Grid%20view", $authorization);
    
        //Acquisition de la base de données "Club"
        $resultatClub = acquisitionTableau("https://api.airtable.com/v0/appljQzgZO6yDwebG/Club?view=Grid%20view", $authorization);

        /************************************/

        // Converti en PHP le JSON
        $resultatJoueur = json_decode($resultatJoueur, true);
        $resultatClub = json_decode($resultatClub, true);

        /************************************/
       
        //Réorganisation tableau "Joueur"
        $tableau_joueur = [];
        for ($i = 0 ; $i < count($resultatJoueur['records']) ; $i++){
            $tableau_joueur[$i] = getTableJoueur($resultatJoueur, $i);
        }

        //Réorganisation tableau "CLub"
        $tableau_club = [];
        for ($i = 0 ; $i < count($resultatClub['records']) ; $i++){
            $tableau_club[$i] = getTableClub($resultatClub, $i);

            $tableau_club[$i]['Joueur'] = join(',<br />', $tableau_club[$i]['Joueur']);
        }
        
        /************************************/

        /*************************
        *  Affichage de la page  *
        **************************/

        echo '<h1>Premier League</h1>';

        /*************************** 
         *  Affichage des Joueurs  *
         ***************************/
        echo '<div class="Joueurs"><h2 class="title">Joueurs</h2>';

        for ($i = 0 ; $i < count($tableau_joueur) ; $i++) {
            echo '<div class="Carte"><table>
            <thead>
                <tr>
                    <th>'.$tableau_joueur[$i]['Prénom Nom'].'</th>
                    <th><img src="'.$tableau_joueur[$i]['Photo'][0]['url'].'"></th>
                </tr>
            </thead>
            <tbody><span class="bodyinfos">';
            foreach($tableau_joueur[$i] as $infos => $value){
                if($infos != 'Prénom Nom' && $infos != 'Photo'){
                    echo '<tr><td class="infos">'.$infos.' :</td><td class="value">'.$value.'</td></tr>';
                }
            }
            echo '</span></tbody></table></div>';
        }

        /*******************************
         *  Formulaire ajout de joueur *
         *******************************/

        echo '<div class="Carte"><form id="ajout">
        <table>
            <thead>
                <tr>
                    <th>    
                        <input type="text" id="prenomJoueur" placeholder="Prénom" maxlength="16" required><span class="validity"></span><br />
                        <input type="text" id="nomJoueur" placeholder="Nom" maxlength="16" required><span class="validity"></span>    
                    </th>
                    <th>    <input class="ImageFoot" id="imageJoueur" type="text" placeholder="URL image du joueur" required><span class="validity"></span></th>
                </tr>
            </thead>
            <tbody><span class="bodyinfos">';
            foreach($tableau_joueur[0] as $infos => $value){
                switch ($infos) {
                    case 'Nationalité' :
                        echo '<tr><td class="infos">'.$infos.' :</td><td class="value"><input type="text" maxlength="16" id="nationaliteJoueur" required><span class="validity"></span></td></tr>';
                        break;
                    case 'Poste' :
                        echo '<tr><td class="infos">'.$infos.' :</td>
                        <td class="value"><select id="posteJoueur" required >
                        <option value="" selected disabled hidden>Sélectionner poste</option>
                        <option value="Gardien">Gardien</option>
                        <option value="Défenseur">Défenseur</option>
                        <option value="Milieu">Milieu</option>
                        <option value="Attaquant">Attaquant</option>
                        </select><span class="validity"></span></td></tr>';
                        break;                    
                    case 'Club' :
                        echo '<tr><td class="infos">'.$infos.' :</td>
                        <td class="value"><select id="clubJoueur" required >
                        <option value="" selected disabled hidden>Sélectionner club existant</option>';    
                            foreach($tableau_club as $clubid){
                                echo '<option value="'.$clubid['ID'].'">'.$clubid['Nom'].'</option>';
                            }
                        echo '</select><span class="validity"></span></td></tr>';
                        break;
                    case 'N° Maillot' :
                        echo '<tr><td class="infos">'.$infos.' :</td><td class="value"><input type="number" min="1" max="99" placeholder="1 - 99" id="maillotJoueur" required><span class="validity"></span></td></tr>';
                        break;
                    case 'Match Joués' :
                        echo '<tr><td class="infos">'.$infos.' :</td><td class="value"><input type="number" min="0" max="1000" placeholder="0 - 1000" id="matchsJouesJoueur" required><span class="validity"></span></td></tr>';
                        break;
                    case 'But Marqués' :
                        echo '<tr><td class="infos">'.$infos.' :</td><td class="value"><input type="number" min="0" max="1000" placeholder="0 - 1000" id="butsMarquesJoueur" required><span class="validity"></span></td></tr>';
                        break;
                    case 'Passes Décisives' :
                        echo '<tr><td class="infos">'.$infos.' :</td><td class="value"><input type="number" min="0" max="1000" placeholder="0 - 1000" id="passesDecisivesJoueur" required><span class="validity"></span></td></tr>';
                        break;
                }
            }
        echo '<tr><td colspan="2"><input type="submit" value="Ajouter le joueur"></td></tr></span>';
        
        echo '</tbody></table></form></div>';


        echo '</div>';

        echo '<div class="Clubs"><h2 class="title">Clubs</h2>';

        for ($i = 0 ; $i < count($tableau_club) ; $i++) {
            echo '<div class="Equipe"><table>
            <tr>
            <theader>
                <th rowspan="2" class="nomClub">'.$tableau_club[$i]['Nom'].'<br /><img src="'.$tableau_club[$i]['Logo'][0]['url'].'"></th>
            </theader>';

            foreach($tableau_club[$i] as $infos => $value){
                if($infos != 'Nom' && $infos != 'Logo' && $infos != 'ID'){
                    echo '<td class="infos">'.$infos.' :</td>';
                }
            }            
            echo '</tr><tr>';

            foreach($tableau_club[$i] as $infos => $value){
                if($infos != 'Nom' && $infos != 'Logo' && $infos != 'ID'){
                    echo '<td class="value">'.$value.'</td>';
                }
            }
            echo '</tr></table></div>';
        }
        echo '</div>'
    ?>
</body>
</html>
