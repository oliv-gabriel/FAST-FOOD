function showPaymentDetails() {
    const paymentMethod = document.getElementById('payment_method').value;
    const cardDetails = document.getElementById('card-details');
    const pixDetails = document.getElementById('pix-details');

    if (paymentMethod === 'credit' || paymentMethod === 'debit') {
        cardDetails.style.display = 'block';
        pixDetails.style.display = 'none';
    } else if (paymentMethod === 'pix') {
        cardDetails.style.display = 'none';
        pixDetails.style.display = 'block';
    } else {
        cardDetails.style.display = 'none';
        pixDetails.style.display = 'none';
    }
}