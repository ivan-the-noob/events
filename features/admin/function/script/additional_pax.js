const additionalPaxInput = document.getElementById('additional-pax');
const totalPaxInput = document.getElementById('total-pax');
const corkageFeeCheckbox = document.getElementById('corkage-fee');
const totalCostInput = document.getElementById('total-cost');
const amountInput = document.getElementById('amount');
const totalAmountInput = document.getElementById('total-amount');
const initialCostInput = document.getElementById('initial-cost'); // Hidden input to store initial cost

const costPerPax = 400; // Price per additional pax
const corkageFee = 500; // Corkage fee

// Update total pax cost when additional pax changes
additionalPaxInput.addEventListener('input', () => {
    const additionalPax = parseInt(additionalPaxInput.value) || 0;
    const paxCost = additionalPax * costPerPax;
    totalPaxInput.value = `₱${paxCost.toLocaleString('en-US', { minimumFractionDigits: 2 })}`;
    updateAmount(); // Update amount after calculating Pax cost
});

// Update total corkage fee when checkbox is toggled
corkageFeeCheckbox.addEventListener('change', () => {
    if (corkageFeeCheckbox.checked) {
        totalCostInput.value = `₱${corkageFee.toLocaleString('en-US', { minimumFractionDigits: 2 })}`;
    } else {
        totalCostInput.value = "₱0.00";
    }
    updateAmount(); // Update amount after changing corkage fee
});

// Function to update the amount and total amount
function updateAmount() {
    // Get the initial cost from the hidden input
    const initialCost = parseFloat(initialCostInput.value.replace('₱', '').replace(',', '') || 0);

    // Get the cost of additional pax and corkage fee
    const paxCost = parseFloat(totalPaxInput.value.replace('₱', '').replace(',', '') || 0);
    const corkageCost = parseFloat(totalCostInput.value.replace('₱', '').replace(',', '') || 0);

    // Calculate the total amount for Amount (Pax Cost + Corkage Fee)
    const amount = paxCost + corkageCost;
    amountInput.value = `₱${amount.toLocaleString('en-US', { minimumFractionDigits: 2 })}`;

    // Calculate the total amount (initial cost + Amount)
    const totalAmount = initialCost + amount;
    totalAmountInput.value = `₱${totalAmount.toLocaleString('en-US', { minimumFractionDigits: 2 })}`;
}
