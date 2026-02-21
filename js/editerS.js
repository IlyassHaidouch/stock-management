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