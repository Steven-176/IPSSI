const API_KEY = 'keyz2SSXdjK0IVq2I';
const URL = `https://api.airtable.com/v0/appljQzgZO6yDwebG/Joueur?api_key=${API_KEY}`;

let data = {
    'records': [{
        'fields': {
            'nom' : 'Becker',
            'prenom' : 'Alisson',
            'poste' : 'Gardien',
            'nationalite' : 'Brésil',
            'club' : [
                "rec3j5wRiqvJzVhS7"
            ],
            'numero_maillot' : 1,
            'match_joues' : 7,
            'buts_marques' : 0,
            'passes_decisives' : 0,
            'Photo' : [
                {
                    "url": "https://i.pinimg.com/474x/61/35/24/613524c97ca8941b1bccfc2f50ae0021.jpg"
                }
            ]
        }
    }]
}
fetch(URL, {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify(data)
}).then((response) => {
    //console.log(response);
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
