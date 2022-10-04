<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <?php
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, "https://api.airtable.com/v0/appljQzgZO6yDwebG/Joueur?view=Grid%20view");

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $authorization =  "Authorization: Bearer keylGy9dvvUc5clRX";

        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json', $authorization));

        $certificate = "C:\wamp64\cacert.pem";
        curl_setopt($curl, CURLOPT_CAINFO, $certificate);
        curl_setopt($curl, CURLOPT_CAPATH, $certificate);

    //    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');

        $resultat = curl_exec($curl);

        curl_close($curl);

        function getTable($table, $ligne) {
        
            $tab = [];
            
            $tab[0] = $table['records'][$ligne]['fields']['prenom'];
            $tab[1] = $table['records'][$ligne]['fields']['nom'];
            $tab[2] = $table['records'][$ligne]['fields']['poste'];
            $tab[3] = $table['records'][$ligne]['fields']['nationalite'];
            $tab[4] = $table['records'][$ligne]['fields']['nom (from club)'][0];
            $tab[5] = $table['records'][$ligne]['fields']['numero_maillot'];
            $tab[6] = $table['records'][$ligne]['fields']['match_joues'];
            $tab[7] = $table['records'][$ligne]['fields']['buts_marques'];
            $tab[8] = $table['records'][$ligne]['fields']['passes_decisives'];

            return $tab;
        }

        

        // Converti en PHP le JSON
        $resultat = json_decode($resultat, true);

        $tableau_joueur = [];

        for ($i = 0 ; $i < count($resultat['records']) ; $i++){
            $nomJoueur = getTable($resultat, $i);

            $tableau_joueur[$i] = $nomJoueur;
        }

//        var_dump($tableau_joueur);

        echo '<h1>Premier League</h1>'.
        '<div><h2>Joueur</h2></div>';

        for ($i = 0 ; $i < count($tableau_joueur) ; $i++) {
            echo '<div class="Joueur">';
            for($j = 0 ; $j < count($tableau_joueur[$i]) ; $j++){
               echo '<p class=l'.$j.'>'. $tableau_joueur[$i][$j] .'</p>';
            }            
            echo '</div>';
        }

    ?>
</body>
</html>
