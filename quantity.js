const pricePerItem = 120000;

    function changeQuantity(change) {
        const quantityInput = document.querySelector('.quantity-input');
        let currentQuantity = parseInt(quantityInput.value);
        currentQuantity += change;
        if (currentQuantity < 1) {
            currentQuantity = 1;
        }
        quantityInput.value = currentQuantity;
        updateTotal();
    }

    function updateTotal() {
        const quantity = parseInt(document.querySelector('.quantity-input').value);
        const totalPrice = pricePerItem * quantity;
        document.getElementById('total-price').textContent = totalPrice.toLocaleString() + ' руб.';
        document.getElementById('overall-total').textContent = totalPrice.toLocaleString() + ' руб.';
    }