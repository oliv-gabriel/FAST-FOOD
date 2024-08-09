document.querySelectorAll('.aumentar').forEach(button => {
    button.addEventListener('mousedown', () => {
        const id = button.getAttribute('data-id');
        intervalId = setInterval(() => {
            const quantidadeElements = document.querySelectorAll(`.quantidade[data-id="${id}"]`);
            quantidadeElements.forEach(element => {
                let count = parseInt(element.innerHTML);
                count += 1;
                element.innerHTML = count;
                updateResumoItem(id, count);
                updateTotals();
            });
        }, 100);
    });
});

document.querySelectorAll('.diminuir').forEach(button => {
    button.addEventListener('mousedown', () => {
        const id = button.getAttribute('data-id');
        intervalId = setInterval(() => {
            const quantidadeElements = document.querySelectorAll(`.quantidade[data-id="${id}"]`);
            quantidadeElements.forEach(element => {
                let count = parseInt(element.innerHTML);
                if (count > 0) {
                    count -= 1;
                    element.innerHTML = count;
                    updateResumoItem(id, count);
                    updateTotals();
                }
            });
        }, 100);
    });
});

document.addEventListener('mouseup', () => clearInterval(intervalId));

const updateResumoItem = (id, quantity) => {
    const itemPriceElement = document.querySelector(`.item-price[data-id="${id}"]`);
    const itemPrice = parseFloat(itemPriceElement.getAttribute('data-price'));
    const totalPrice = quantity * itemPrice;
    itemPriceElement.innerHTML = 'R$ ' + totalPrice.toFixed(2).replace('.', ',');
};

const updateTotals = () => {
    let subtotal = 0;
    document.querySelectorAll('.item-price').forEach(itemPriceElement => {
        subtotal += parseFloat(itemPriceElement.innerHTML.replace('R$ ', '').replace(',', '.'));
    });
    
    document.getElementById('sub-total').innerHTML = 'R$ ' + subtotal.toFixed(2).replace('.', ',');
    document.getElementById('total').innerHTML = 'R$ ' + subtotal.toFixed(2).replace('.', ',');
};


function showPaymentDetails() {
    var paymentMethod = document.getElementById('payment_method').value;
    var cardDetails = document.getElementById('card-details');
    var pixDetails = document.getElementById('pix-details');
    cardDetails.style.display = paymentMethod === 'credit' || paymentMethod === 'debit' ? 'block' : 'none';
    pixDetails.style.display = paymentMethod === 'pix' ? 'block' : 'none';
}

