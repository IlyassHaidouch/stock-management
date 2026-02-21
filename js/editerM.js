const prixUInput = document.getElementById('prixU');
const stockIInput = document.getElementById('stockI');
const totalInput = document.getElementById('total');

// Ajout d'un écouteur d'événement sur les deux inputs
prixUInput.addEventListener('input', updateTotal);
stockIInput.addEventListener('input', updateTotal);

// Fonction qui calcule le montant total
function updateTotal() {
    const prixU = parseFloat(prixUInput.value);
    const stockI = parseFloat(stockIInput.value);
    if (!isNaN(prixU) && !isNaN(stockI)) {
        totalInput.value = (prixU * stockI).toFixed(2);
        console.log(totalInput.value);
    } else {
        totalInput.value = '';
    }
}  