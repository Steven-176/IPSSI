const API_KEY = 'keylGy9dvvUc5clRX';
const URL = `https://api.airtable.com/v0/appljQzgZO6yDwebG/Joueur?api_key=${API_KEY}`;

const formulaire = document.querySelector('#ajout')
formulaire.addEventListener('submit', (e)=>{
    e.preventDefault()
    addPlayer()
})
function addPlayer() {

    var prenomJoueur = document.getElementById("prenomJoueur").value;
    var nomJoueur = document.getElementById("nomJoueur").value;
    var imageJoueur = document.getElementById("imageJoueur").value;
    var nationaliteJoueur = document.getElementById("nationaliteJoueur").value;
    var posteJoueur = document.getElementById("posteJoueur").value;
    var clubJoueur = document.getElementById("clubJoueur").value;
    var maillotJoueur = parseInt(document.getElementById("maillotJoueur").value);
    var matchsJouesJoueur = parseInt(document.getElementById("matchsJouesJoueur").value);
    var butsMarquesJoueur = parseInt(document.getElementById("butsMarquesJoueur").value);
    var passesDecisivesJoueur = parseInt(document.getElementById("passesDecisivesJoueur").value);

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

