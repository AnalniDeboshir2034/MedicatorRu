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
            'd_dosing' => $row['d_dosing'] ?? '',
            'performance' => $row['performance'] ?? '',
            'pressure' => $row['pressure'] ?? '',
            'temperature' => $row['temperature'] ?? '',
            'connections' => $row['connections'] ?? '',
            'm_seal' => $row['m_seal'] ?? '',
            'm_case' => $row['m_case'] ?? '',
            'dop' => $row['dop'] ?? '',
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <base href="/" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/products/favico.png">
    <title>Medikator.ru - Медикаторы-дозаторы для сельского хозяйства</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/compare.css">
</head>
<body>
    <?php require_once __DIR__ . '/includes/header.php'; ?>

    <main class="main compare-page">
        <section class="compare-section">
            <div class="container">
                <div class="compare-head">
                    <h1 class="compare-title">Сравнение медикаторов</h1>
                    <p class="compare-subtitle">Добавьте товары из каталога, главной или карточки товара</p>
                </div>

                <div id="compare-empty" class="compare-empty">
                    <p>Вы пока не добавили товары в сравнение.</p>
                    <a href="/catalog" class="btn btn-primary">Перейти в каталог</a>
                </div>

                <div id="compare-table-wrap" class="compare-table-wrap" style="display:none;">
                   

                    <div class="compare-table-scroll">
                        <table class="compare-table" id="compare-table"></table>
                    </div>
                     <div class="compare-actions">
                        <button type="button" class="btn btn-secondary" id="compare-clear">Очистить сравнение</button>
                        <a href="/catalog" class="btn btn-primary">Добавить еще товары</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php require_once __DIR__ . '/includes/footer.php'; ?>
    <?php $mysqli->close(); ?>

    <script>
        window.ALL_PRODUCTS_FOR_COMPARE = <?= json_encode($products, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
    </script>
    <script src="js/compare-page.js" defer></script>
</body>
</html>
