var IDJoueur;

const formulaire = document.querySelector('#ajout')
formulaire.addEventListener('submit', (e)=>{
    e.preventDefault()
    addPlayer()
})
function addPlayer() {

    const API_KEY = 'keylGy9dvvUc5clRX';
    const URL = `https://api.airtable.com/v0/appljQzgZO6yDwebG/Joueur?api_key=${API_KEY}`;  

    var prenomJoueur = document.querySelector("#Prénom_modif").value;
    var nomJoueur = document.querySelector("#NomJoueur_modif").value;
    var imageJoueur = document.querySelector("#Photo_modif").value;
    var nationaliteJoueur = document.querySelector("#Nationalité_modif").value;
    var posteJoueur = document.querySelector("#Poste_modif").value;
    var clubJoueur = document.querySelector("#Club_modif").value;
    var maillotJoueur = parseInt(document.querySelector("#Maillot_modif").value);
    var matchsJouesJoueur = parseInt(document.querySelector("#Matchs_modif").value);
    var butsMarquesJoueur = parseInt(document.querySelector("#Buts_modif").value);
    var passesDecisivesJoueur = parseInt(document.querySelector("#PassesD_modif").value);

    if (IDJoueur != null) {
        let data = {
            'records': [{
                'id' : IDJoueur,
                'fields': {
                    'nom' : nomJoueur,
                    'prenom' : prenomJoueur,
                    'poste' : posteJoueur,
                    'nationalite' : nationaliteJoueur,
                    'club' : [
                        clubJoueur
                    ],
                    'numero_maillot' : maillotJoueur,
                    'match_joues' : matchsJouesJoueur,
                    'buts_marques' : butsMarquesJoueur,
                    'passes_decisives' : passesDecisivesJoueur,
                    'Photo' : [
                        {
                            "url": imageJoueur
                        }
                    ]
                }
            }]
        };

        fetch(URL, {
            method: 'PATCH',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(data)
        }).then((response) => {
            if(response.ok){
                response.json().then((data) => {
                    console.log(data);
                })
            } else {
                console.log('Erreur status != 200')
            }
        }).catch((error) => {
            console.log(`Erreur : ${error.message}`);
        })
    }
    else
    {
        let data = {
            'records': [{
                'fields': {
                    'nom' : nomJoueur,
                    'prenom' : prenomJoueur,
                    'poste' : posteJoueur,
                    'nationalite' : nationaliteJoueur,
                    'club' : [
                        clubJoueur
                    ],
                    'numero_maillot' : maillotJoueur,
                    'match_joues' : matchsJouesJoueur,
                    'buts_marques' : butsMarquesJoueur,
                    'passes_decisives' : passesDecisivesJoueur,
                    'Photo' : [
                        {
                            "url": imageJoueur
                        }
                    ]
                }
            }]
        };

        fetch(URL, {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(data)
        }).then((response) => {
            if(response.ok){
                response.json().then((data) => {
                    console.log(data);
                })
            } else {
                console.log('Erreur status != 200')
            }
        }).catch((error) => {
            console.log(`Erreur : ${error.message}`);
        })
    }
}

function modifPlayer(i) {

    IDJoueur = document.querySelector("#IDJoueur_"+i).innerHTML;

    var prenomJoueur = document.querySelector("#Prénom_"+i).innerHTML;
    var nomJoueur = document.querySelector("#NomJoueur_"+i).innerHTML;
    var imageJoueur = document.querySelector("#Photo_"+i).innerHTML;
    var nationaliteJoueur = document.querySelector("#Nationalité_"+i).innerHTML;
    var posteJoueur = document.querySelector("#Poste_"+i).innerHTML;
    var clubJoueur = document.querySelector("#IDClubJoueur_"+i).innerHTML;
    var maillotJoueur = parseInt(document.querySelector("#Maillot_"+i).innerHTML);
    var matchsJouesJoueur = parseInt(document.querySelector("#Matchs_"+i).innerHTML);
    var butsMarquesJoueur = parseInt(document.querySelector("#Buts_"+i).innerHTML);
    var passesDecisivesJoueur = parseInt(document.querySelector("#PassesD_"+i).innerHTML);

    console.log(prenomJoueur+" ; type "+typeof(prenomJoueur));
    console.log(nomJoueur+" ; type "+typeof(nomJoueur));
    console.log(imageJoueur+" ; type "+typeof(imageJoueur));
    console.log(nationaliteJoueur+" ; type "+typeof(nationaliteJoueur));
    console.log(posteJoueur+" ; type "+typeof(posteJoueur));
    console.log(clubJoueur+" ; type "+typeof(clubJoueur));
    console.log(maillotJoueur+" ; type "+typeof(maillotJoueur));
    console.log(matchsJouesJoueur+" ; type "+typeof(matchsJouesJoueur));
    console.log(butsMarquesJoueur+" ; type "+typeof(butsMarquesJoueur));
    console.log(passesDecisivesJoueur+" ; type "+typeof(passesDecisivesJoueur));

    document.querySelector("#Prénom_modif").value = prenomJoueur;
    document.querySelector("#NomJoueur_modif").value = nomJoueur;
    document.querySelector("#Photo_modif").value = imageJoueur;
    document.querySelector("#Nationalité_modif").value = nationaliteJoueur;
    document.querySelector("#Poste_modif").value = posteJoueur;
    document.querySelector("#Club_modif").value = clubJoueur;
    document.querySelector("#Maillot_modif").value = maillotJoueur;
    document.querySelector("#Matchs_modif").value = matchsJouesJoueur;
    document.querySelector("#Buts_modif").value = butsMarquesJoueur;
    document.querySelector("#PassesD_modif").value = passesDecisivesJoueur;
}

