document.addEventListener('DOMContentLoaded', function() {
    const decreaseButtons = document.querySelectorAll('.quantity-decrease');
    const increaseButtons = document.querySelectorAll('.quantity-increase');

    decreaseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const cartId = this.getAttribute('data-cart-id');
            updateQuantity(cartId, -1);
        });
    });

    increaseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const cartId = this.getAttribute('data-cart-id');
            updateQuantity(cartId, 1);
        });
    });

    function updateQuantity(cartId, change) {
        const quantityElement = document.querySelector(`button[data-cart-id="${cartId}"]`).nextElementSibling;
        let currentQuantity = parseInt(quantityElement.textContent);

        // Не позволяем уменьшать количество ниже 1
        if (currentQuantity + change >= 1) {
            currentQuantity += change;

            // Отправляем данные на сервер через AJAX
            fetch('update_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    cart_id: cartId,
                    quantity: currentQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    quantityElement.textContent = currentQuantity;
                    document.getElementById('overall-total').textContent = data.new_total + ' руб.';
                }
            });
        }
    }
});
