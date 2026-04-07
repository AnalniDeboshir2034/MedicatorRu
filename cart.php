<?php
require_once __DIR__ . '/includes/config.php';

if (!$mysqli || $mysqli->connect_error) {
    die("Нет соединения с БД");
}

$products = [];
$sql = "
    SELECT m.*,
           (SELECT path_img FROM medicator_img WHERE medicator_id = m.id AND is_Main = 1 LIMIT 1) as main_img
    FROM medicator m
    ORDER BY m.id
";
$result = $mysqli->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = [
            'id' => (int)$row['id'],
            'slug' => $row['slug'] ?? '',
            'name' => $row['name'] ?? '',
            'image' => $row['main_img'] ?? '',
            'series' => $row['filtr'] ?? '',
        ];
    }
}
$mysqli->close();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина | 7company</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/cart.css">
</head>
<body>
    <?php require_once __DIR__ . '/includes/header.php'; ?>

    <main class="main cart-page">
        <section class="cart-section">
            <div class="container">
                <h1 class="cart-title">Корзина</h1>

                <div class="cart-grid">
                    <div>
                        <div id="cart-empty" class="cart-empty">
                            <p>Корзина пуста. Добавьте товары из каталога.</p>
                            <a href="catalog.php" class="btn btn-primary">Перейти в каталог</a>
                        </div>
                        <div id="cart-list" class="cart-list" style="display:none;"></div>
                    </div>

                    <aside id="cart-sidebar" class="cart-sidebar" style="display:none;">
                        <button type="button" class="btn btn-primary" id="cart-checkout-open">Оформить заказ</button>
                        <button type="button" class="btn btn-secondary" id="cart-print">Распечатать заказ</button>
                        <button type="button" class="cart-clear" id="cart-clear">Очистить корзину</button>
                    </aside>
                </div>
            </div>
        </section>
    </main>

    <div class="cart-modal" id="cartCheckoutModal" aria-hidden="true">
        <div class="cart-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="cartCheckoutTitle">
            <button type="button" class="cart-modal__close" id="cart-checkout-close" aria-label="Закрыть форму">&times;</button>
            <h3 id="cartCheckoutTitle">Оформление заказа</h3>
            <p>Оставьте контакты, отправим заявку в Bitrix.</p>

            <form id="cart-checkout-form" class="cart-checkout-form">
                <input type="text" name="name" placeholder="Ваше имя" required>
                <input type="tel" name="phone" placeholder="Ваш телефон" required>
                <textarea name="message" rows="4" placeholder="Комментарий к заказу"></textarea>
                <input type="hidden" name="form_type" value="Оформление заказа из корзины">
                <button type="submit" class="btn btn-primary">Отправить заказ</button>
            </form>
            <p id="cart-checkout-status" class="cart-checkout-status" aria-live="polite"></p>
        </div>
    </div>

    <?php require_once __DIR__ . '/includes/footer.php'; ?>

    <script>
        window.ALL_PRODUCTS_FOR_CART = <?= json_encode($products, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
    </script>
    <script src="js/cart-page.js" defer></script>
</body>
</html>
