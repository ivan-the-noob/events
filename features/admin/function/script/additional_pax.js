const additionalPaxInput = document.getElementById('additional-pax');
const totalPaxInput = document.getElementById('total-pax');
const corkageFeeCheckbox = document.getElementById('corkage-fee');
const totalCostInput = document.getElementById('total-cost');
const amountInput = document.getElementById('amount');
const totalAmountInput = document.getElementById('total-amount');
const initialCostInput = document.getElementById('initial-cost'); 
const additionalExtendInput = document.getElementById('additional-extend');  
const totalExtendInput = document.getElementById('total-extend');  

const costPerPax = 400; 
const corkageFee = 500; 
const extendFee = 1000;  

additionalPaxInput.addEventListener('input', () => {
    const additionalPax = parseInt(additionalPaxInput.value) || 0;
    const paxCost = additionalPax * costPerPax;
    totalPaxInput.value = `₱${paxCost.toLocaleString('en-US', { minimumFractionDigits: 2 })}`;
    updateAmount(); 
});

corkageFeeCheckbox.addEventListener('change', () => {
    if (corkageFeeCheckbox.checked) {
        totalCostInput.value = `₱${corkageFee.toLocaleString('en-US', { minimumFractionDigits: 2 })}`;
    } else {
        totalCostInput.value = "₱0.00";
    }
    updateAmount(); 
});

additionalExtendInput.addEventListener('input', () => {
    const additionalExtend = parseInt(additionalExtendInput.value) || 0;
    const extendCost = additionalExtend * extendFee;
    totalExtendInput.value = `₱${extendCost.toLocaleString('en-US', { minimumFractionDigits: 2 })}`;
    updateAmount(); 
});

function updateAmount() {
    const initialCost = parseFloat(initialCostInput.value.replace('₱', '').replace(',', '') || 0);
    const paxCost = parseFloat(totalPaxInput.value.replace('₱', '').replace(',', '') || 0);
    const corkageCost = parseFloat(totalCostInput.value.replace('₱', '').replace(',', '') || 0);
    const extendCost = parseFloat(totalExtendInput.value.replace('₱', '').replace(',', '') || 0);

    const amount = paxCost + corkageCost + extendCost;
    amountInput.value = `₱${amount.toLocaleString('en-US', { minimumFractionDigits: 2 })}`;

    const totalAmount = initialCost + amount;
    totalAmountInput.value = `₱${totalAmount.toLocaleString('en-US', { minimumFractionDigits: 2 })}`;
}
