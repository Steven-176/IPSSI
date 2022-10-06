var IDJoueur;
var IDClub;

const formulaireJ = document.querySelector('#ajout_j');
const formulaireC = document.querySelector('#ajout_c');
const formulaireDJ =  document.querySelector('#delete_j');

formulaireJ.addEventListener('submit', (e)=>{
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

        airtableCom(URL, 'PATCH', data);
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

        airtableCom(URL, 'POST', data);
    }

    IDJoueur = null;
    IDClub = null;
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




formulaireC.addEventListener('submit', (e)=>{
    e.preventDefault()
    addClub()
})
function addClub() {

    const API_KEY = 'keylGy9dvvUc5clRX';
    const URL = `https://api.airtable.com/v0/appljQzgZO6yDwebG/Club?api_key=${API_KEY}`;  

    var nomClub = document.querySelector("#NomClub_modif").value;
    var logoClub = document.querySelector("#Logo_modif").value;
    var classementClub = parseInt(document.querySelector("#Classement_modif").value);
    var villeClub = document.querySelector("#Ville_modif").value;
    var creationClub = parseInt(document.querySelector("#Création_modif").value);
    var entraineurClub = document.querySelector("#Entraîneur_modif").value;

    if (IDClub != null) {
        let data = {
            'records': [{
                'id' : IDClub,
                'fields': {
                    'nom' : nomClub,
                    'classement' : classementClub,
                    'ville' : villeClub,
                    'annee_de_creation' : creationClub,
                    'entraineur' : entraineurClub,
                    'Logo' : [
                        {
                            "url": logoClub,
                        }
                    ]
                }
            }]
        };

        airtableCom(URL, 'PATCH', data);
    }
    else
    {
        let data = {
            'records': [{
                'fields': {
                    'nom' : nomClub,
                    'classement' : classementClub,
                    'ville' : villeClub,
                    'annee_de_creation' : creationClub,
                    'entraineur' : entraineurClub,
                    'Logo' : [
                        {
                            "url": logoClub,
                        }
                    ]
                }
            }]
        };

        airtableCom(URL, 'POST', data);
    }

    IDJoueur = null;
    IDClub = null;
}



function modifClub(i) {

    IDClub = document.querySelector("#IDClub_"+i).innerHTML;

    var nomClub = document.querySelector("#NomClub_"+i).innerHTML;
    var logoClub = document.querySelector("#Logo_"+i).innerHTML;
    var classementClub = parseInt(document.querySelector("#Classement_"+i).innerHTML);
    var villeClub = document.querySelector("#Ville_"+i).innerHTML;
    var creationClub = parseInt(document.querySelector("#Création_"+i).innerHTML);
    var entraineurClub = document.querySelector("#Entraîneur_"+i).innerHTML;

    document.querySelector("#NomClub_modif").value = nomClub;
    document.querySelector("#Logo_modif").value = logoClub;
    document.querySelector("#Classement_modif").value = classementClub;
    document.querySelector("#Ville_modif").value = villeClub;
    document.querySelector("#Création_modif").value = creationClub;
    document.querySelector("#Entraîneur_modif").value = entraineurClub;
}




/************
 *  DELETE  *
 ************/

formulaireDJ.addEventListener('click', (e)=>{
    e.preventDefault()
    deletePlayer()
})
function deletePlayer(i) {
    var ID = document.querySelector("#IDJoueur_"+i).innerHTML;

    const API_KEY = 'keylGy9dvvUc5clRX';
    const URL = `https://api.airtable.com/v0/appljQzgZO6yDwebG/Joueur/${ID}?api_key=${API_KEY}`; 

    fetch(URL, {
        method: 'DELETE',
        headers: {'Content-Type': 'application/json'}
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

    setTimeout(function() {
        window.location.reload();
    }, 1000);
}




/************************************
 *  Envoi de la requête à Airtable  *
 ************************************/

 function airtableCom(URL, method, data){
    fetch(URL, {
        method: method,
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

    setTimeout(function() {
        window.location.reload();
    }, 1000);
}