const coutAInput = document.getElementById('coutA');
const quantiteInput = document.getElementById('quantite');
const totalInput = document.getElementById('total');

// Ajout d'un écouteur d'événement sur les deux inputs
coutAInput.addEventListener('input', updateTotal);
quantiteInput.addEventListener('input', updateTotal);

// Fonction qui calcule le montant total
function updateTotal() {
    const coutA = parseFloat(coutAInput.value);
    const quantite = parseFloat(quantiteInput.value);
    if (!isNaN(coutA) && !isNaN(quantite)) {
        totalInput.value = (coutA * quantite).toFixed(2);
        console.log(totalInput.value);
    } else {
        totalInput.value = '';
    }
}