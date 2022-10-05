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
                'IDJoueur' => $table['records'][$ligne]['id'],
                'Prénom' => $table['records'][$ligne]['fields']['prenom'],
                'NomJoueur' => $table['records'][$ligne]['fields']['nom'],
                'Photo' => $table['records'][$ligne]['fields']['Photo'],
                'Nationalité' => $table['records'][$ligne]['fields']['nationalite'],
                'Poste' => $table['records'][$ligne]['fields']['poste'],
                'Club' => $table['records'][$ligne]['fields']['nom (from club)'][0],
                'Maillot' => $table['records'][$ligne]['fields']['numero_maillot'],
                'Matchs' => $table['records'][$ligne]['fields']['match_joues'],
                'Buts' => $tab[7] = $table['records'][$ligne]['fields']['buts_marques'],
                'PassesD' => $table['records'][$ligne]['fields']['passes_decisives'],
                'IDClubJoueur' => $table['records'][$ligne]['fields']['club'][0],
            );
            return $tab;
        }


        /**************************************
         *  Réorganisation du tableau "Club"  *
         **************************************/
        function getTableClub($table, $ligne) {
            $tab = array(
                'IDClub' => $table['records'][$ligne]['id'],
                'NomClub' => $table['records'][$ligne]['fields']['nom'],
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

        $keyinfos = array_keys($tableau_joueur[0]);

        for ($i = 0 ; $i < count($tableau_joueur) ; $i++) {

            echo '<div class="Carte"><table>
            <span id="'.$keyinfos[0].'_'.$i.'" class="joueurID">'.$tableau_joueur[$i]['IDJoueur'].'</span>
            <span id="'.$keyinfos[3].'_'.$i.'" class="joueurID">'.$tableau_joueur[$i]['Photo'][0]['url'].'</span>
            <span id="'.$keyinfos[11].'_'.$i.'" class="joueurID">'.$tableau_joueur[$i]['IDClubJoueur'].'</span>
            <thead>
                <tr>
                    <th class="buttonModif"><button class="realButtonModif" onclick="modifPlayer('.$i.')"><img class="imgIcone" src="https://cdn-icons-png.flaticon.com/512/84/84380.png"></button></th>
                </tr>
                <tr>
                    <th><span id="'.$keyinfos[1].'_'.$i.'">'.$tableau_joueur[$i]['Prénom'].'</span><br /><span id="'.$keyinfos[2].'_'.$i.'">'.$tableau_joueur[$i]['NomJoueur'].'</span></th>
                    <th><img class="imgJoueur" src="'.$tableau_joueur[$i]['Photo'][0]['url'].'"></img></th>
                </tr>
            </thead>
            <tbody><span class="bodyinfos">';
            foreach($tableau_joueur[$i] as $infos => $value){
                if($infos != 'Prénom' && $infos != 'NomJoueur' && $infos != 'Photo' && $infos != 'IDJoueur' && $infos != 'IDClubJoueur'){
                    echo '<tr><td class="infos">'.$infos.' :</td><td id="'.$infos.'_'.$i.'"class="value">'.$value.'</td></tr>';
                }
            }
            echo '</span></tbody></table></div>';
        }


        /********************************
         *  Formulaire ajout de joueur  *
         ********************************/

        echo '<div class="Carte"><form id="ajout">
        <table>
            <thead>
                <tr>
                    <th>    
                        <input type="text" id="'.$keyinfos[1].'_modif" placeholder="Prénom" maxlength="16" required><span class="validity"></span><br />
                        <input type="text" id="'.$keyinfos[2].'_modif" placeholder="Nom" maxlength="16" required><span class="validity"></span>    
                    </th>
                    <th>    <input class="ImageFoot" id="'.$keyinfos[3].'_modif" type="text" placeholder="URL image du joueur" required><span class="validity"></span></th>
                </tr>
            </thead>
            <tbody><span class="bodyinfos">';
            foreach($tableau_joueur[0] as $infos => $value){
                switch ($infos) {
                    case 'Nationalité' :
                        echo '<tr><td class="infos">'.$infos.' :</td><td class="value"><input type="text" maxlength="16" id="'.$keyinfos[4].'_modif" required><span class="validity"></span></td></tr>';
                        break;
                    case 'Poste' :
                        echo '<tr><td class="infos">'.$infos.' :</td>
                        <td class="value"><select id="'.$keyinfos[5].'_modif" required >
                        <option value="" selected disabled hidden>Sélectionner poste</option>
                        <option value="Gardien">Gardien</option>
                        <option value="Défenseur">Défenseur</option>
                        <option value="Milieu">Milieu</option>
                        <option value="Attaquant">Attaquant</option>
                        </select><span class="validity"></span></td></tr>';
                        break;                    
                    case 'Club' :
                        echo '<tr><td class="infos">'.$infos.' :</td>
                        <td class="value"><select id="'.$keyinfos[6].'_modif" required >
                        <option value="" selected disabled hidden>Sélectionner club existant</option>';    
                            foreach($tableau_club as $clubid){
                                echo '<option value="'.$clubid['IDClub'].'">'.$clubid['NomClub'].'</option>';
                            }
                        echo '</select><span class="validity"></span></td></tr>';
                        break;
                    case 'Maillot' :
                        echo '<tr><td class="infos">'.$infos.' :</td><td class="value"><input type="number" min="1" max="99" placeholder="1 - 99" id="'.$keyinfos[7].'_modif" required><span class="validity"></span></td></tr>';
                        break;
                    case 'Matchs' :
                        echo '<tr><td class="infos">'.$infos.' :</td><td class="value"><input type="number" min="0" max="1000" placeholder="0 - 1000" id="'.$keyinfos[8].'_modif" required><span class="validity"></span></td></tr>';
                        break;
                    case 'Buts' :
                        echo '<tr><td class="infos">'.$infos.' :</td><td class="value"><input type="number" min="0" max="1000" placeholder="0 - 1000" id="'.$keyinfos[9].'_modif" required><span class="validity"></span></td></tr>';
                        break;
                    case 'PassesD' :
                        echo '<tr><td class="infos">'.$infos.' :</td><td class="value"><input type="number" min="0" max="1000" placeholder="0 - 1000" id="'.$keyinfos[10].'_modif" required><span class="validity"></span></td></tr>';
                        break;
                }
            }
        echo '<tr><td colspan="2"><input type="submit" value="Ajouter le joueur"></td></tr></span>';
        
        echo '</tbody></table></form></div>';

        echo '</div>';


        /*************************** 
         *  Affichage des Joueurs  *
         ***************************/

        echo '<div class="Clubs"><h2 class="title">Clubs</h2>';

        $keyinfos = array_keys($tableau_club[0]);

            echo '<div class="Equipe"><table>
            <tr>
            <theader>
                <th rowspan="2" class="nomClub">'.$tableau_club[$i]['NomClub'].'<br /><input class="ImageFoot" id="'.$keyinfos[3].'_modif" type="text" placeholder="URL image du joueur" required><span class="validity"></span></th>
            </theader>';

            foreach($tableau_club[$i] as $infos => $value){
                if($infos != 'NomClub' && $infos != 'Logo' && $infos != 'IDClub'){
                    echo '<td class="infos">'.$infos.' :</td>';
                }
            }            
            echo '</tr><tr>';

            foreach($tableau_club[$i] as $infos => $value){
                if($infos != 'NomClub' && $infos != 'Logo' && $infos != 'IDClub'){
                    echo '<td class="value">'.$value.'</td>';
                }
            }
            echo '</tr></table></div>';


        // /******************************
        //  *  Formulaire ajout de club  *
        //  ******************************/

        // echo '<div class="Clubs"><h2 class="title">Clubs</h2>';

        // $keyinfos = array_keys($tableau_joueur[0]);

        // for ($i = 0 ; $i < count($tableau_club) ; $i++) {
        //     echo '<div class="Equipe"><table>
        //     <tr>
        //     <theader>
        //         <th rowspan="2" class="nomClub"><input type="text" id="'.$keyinfos[2].'_modif" placeholder="Nom" maxlength="16" required><span class="validity"></span><br /><img class="imgClub" src="'.$tableau_club[$i]['Logo'][0]['url'].'"></th>
        //     </theader>';

        //     foreach($keyinfos as $infos){
        //         if($infos != 'NomClub' && $infos != 'Logo' && $infos != 'IDClub'){
        //             echo '<td class="infos">'.$infos.' :</td>';
        //         }
        //     }            
        //     echo '</tr><tr>';

        //     foreach($keyinfos){
        //         if($infos != 'NomClub' && $infos != 'Logo' && $infos != 'IDClub'){
        //             echo '<td class="value">'.$value.'</td>';
        //         }
        //     }
        //     echo '</tr></table></div>';
        // }

        // echo '</div>'
    ?>
</body>
</html>
