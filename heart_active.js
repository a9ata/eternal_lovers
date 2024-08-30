document.addEventListener('DOMContentLoaded', function() {
    const favoriteButtons = document.querySelectorAll('.catalog__item-favorite');

    favoriteButtons.forEach(button => {
        const form = button.closest('form');
        const productId = form.querySelector('input[name="product_id"]').value;

        button.addEventListener('click', function(event) {
            event.preventDefault(); // Останавливаем стандартное поведение кнопки

            // Определяем действие: добавление или удаление
            const action = button.classList.contains('active') ? 'remove_from_favorite' : 'add_to_favorite';

            // Отправляем AJAX запрос
            fetch('handle_action.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `product_id=${productId}&action=${action}&ajax=true`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    button.classList.toggle('active');
                } else {
                    console.error('Ошибка при обработке запроса');
                }
            })
            .catch(error => console.error('Ошибка:', error));
        });
    });
});
