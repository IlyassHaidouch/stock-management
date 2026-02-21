// Récupération des éléments HTML
//ce code ci-dessous permet de calculer le total et qu'il soit affiché 
//dynamiquement le temps ou l'utilisateur saisie la quantite et le prix de vente
const prixVInput = document.getElementById('prixV');
const quantiteInput = document.getElementById('quantite');
const totalInput = document.getElementById('total');

// Ajout d'un écouteur d'événement sur les deux inputs
prixVInput.addEventListener('input', updateTotal);
quantiteInput.addEventListener('input', updateTotal);

// Fonction qui calcule le montant total
function updateTotal() {
    const prixV = parseFloat(prixVInput.value);
    const quantite = parseFloat(quantiteInput.value);
    if (!isNaN(prixV) && !isNaN(quantite)) {
        totalInput.value = (prixV * quantite).toFixed(2);
        console.log(totalInput.value);
    } else {
        totalInput.value = '';
    }
}


function fetchData() {
    var reference = document.getElementById("reference").value;

    // Send a GET request to the PHP script
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // Parse the JSON data
            var data = JSON.parse(this.responseText);

            // Populate the input fields with the retrieved data
            document.getElementById("designation").value = data.designation;
            document.getElementById("categorie").value = data.categorie;
            console.log(document.getElementById("categorie").value);
            document.getElementById("prixV").value = data.prixV;
        }
    };
    xhttp.open("GET", "affDynamiqueS.php?reference=" + reference, true);
    xhttp.send();
}