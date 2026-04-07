<?php 
require_once 'includes/config.php';

if (!$mysqli || $mysqli->connect_error) {
    die("❌ Нет соединения с БД");
}

$filters = [];
$result = $mysqli->query("SELECT * FROM `filter` ORDER BY `id`");
while ($row = $result->fetch_assoc()) {
    $filters[] = $row;
}

$subfilters = [];
$result = $mysqli->query("
    SELECT fr.*, f.name as filter_name, f.slug as filter_slug, 
           sf.name as subfilter_name, sf.slug as subfilter_slug 
    FROM `filter_Relationships` fr 
    JOIN `filter` f ON fr.filter_id = f.id 
    JOIN `subfilter` sf ON fr.subfilter_id = sf.id 
    ORDER BY f.id, sf.id
");
while ($row = $result->fetch_assoc()) {
    $subfilters[] = $row;
}

$products = [];
$result = $mysqli->query("
    SELECT m.*,
           sf.slug AS subfilter_slug,
           sf.name AS subfilter_name,
           f.slug AS filter_slug,
           (SELECT path_img FROM medicator_img WHERE medicator_id = m.id AND is_Main = 1 LIMIT 1) as main_img
    FROM `medicator` m
    LEFT JOIN `subfilter` sf
        ON LOWER(TRIM(sf.slug)) = LOWER(TRIM(m.filtr))
        OR LOWER(TRIM(sf.name)) = LOWER(TRIM(m.filtr))
    LEFT JOIN `filter_Relationships` fr ON fr.subfilter_id = sf.id
    LEFT JOIN `filter` f ON f.id = fr.filter_id
    ORDER BY m.id
");
while ($row = $result->fetch_assoc()) {
    $images = [];
    $imgResult = $mysqli->query("SELECT * FROM medicator_img WHERE medicator_id = {$row['id']} ORDER BY sort ASC");
    while ($imgRow = $imgResult->fetch_assoc()) {
        $images[] = $imgRow;
    }
    $row['images'] = $images;
    $products[] = $row;
}

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>7company - Каталог</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/catalog.css">
    <script src="js/catalog.js" defer></script>
</head>
<body>
    <?php require_once __DIR__ . '/includes/header.php'; ?>

    <main class="main">
        <section class="catalog-hero">
            <div class="container">
                <div class="catalog-hero__content">
                    <h1 class="catalog-hero__title"><span class='gradient-text'>КАТАЛОГ</span></h1>
                    <p class="catalog-hero__subtitle">Каталог медикаторов-дозаторов для сельского хозяйства</p>
                </div>
            </div>
        </section>

        <section class="catalog-categories">
            <div class="container">
                <div class="catalog-categories__list">
                    <button class="category-btn active" data-category="all">Все</button>
                    <?php foreach ($filters as $filter): ?>
                    <button class="category-btn" data-category="<?= htmlspecialchars($filter['slug']) ?>">
                        <?= htmlspecialchars($filter['name']) ?>
                    </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="catalog-main">
            <div class="container">
                <div class="catalog-grid">
                    <aside class="catalog-filters">
                        <?php if (!empty($subfilters)): ?>
                            <?php 
                            $current_filter = null;
                            foreach ($subfilters as $subfilter):
                                if ($current_filter !== $subfilter['filter_name']):
                                    if ($current_filter !== null): ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <div class="filter-group">
                                        <button class="filter-dropdown" data-filter="<?= htmlspecialchars($subfilter['filter_slug']) ?>">
                                            <?= htmlspecialchars($subfilter['filter_name']) ?>
                                            <span class="filter-arrow">▼</span>
                                        </button>
                                        <div class="filter-submenu" data-submenu="<?= htmlspecialchars($subfilter['filter_slug']) ?>">
                                <?php 
                                $current_filter = $subfilter['filter_name'];
                                endif; 
                                ?>
                                <label>
                                    <input type="checkbox" value="<?= htmlspecialchars($subfilter['subfilter_slug']) ?>" 
                                           data-category="<?= htmlspecialchars($subfilter['filter_slug']) ?>">
                                    <?= htmlspecialchars($subfilter['subfilter_name']) ?>
                                </label>
                            <?php endforeach; ?>
                                        </div>
                                    </div>
                        <?php else: ?>
                            <p>Фильтры не найдены</p>
                        <?php endif; ?>
                        
                        <button class="filter-reset" id="reset-filters">Сбросить фильтры</button>
                    </aside>

                    <div class="catalog-products">
                        <div class="products-header">
                            <span class="products-count" id="products-count">Найдено: <?= count($products) ?> товаров</span>
                        </div>

                        <div class="products-grid" id="products-grid">
                            <?php if (!empty($products)): ?>
                                <?php foreach ($products as $product): ?>
                                <div class="product-card" data-category="<?= htmlspecialchars($product['filter_slug'] ?? '') ?>" 
                                     data-subcategory="<?= htmlspecialchars($product['subfilter_slug'] ?? $product['filtr']) ?>">
                                    <div class="product-card__content">
                                        <?php if (!empty($product['main_img'])): ?>
                                        <div class="product-image">
                                            <img src="<?= htmlspecialchars($product['main_img']) ?>" 
                                                 alt="<?= htmlspecialchars($product['name']) ?>">
                                        </div>
                                        <?php endif; ?>
                                        <h3 class="product-title"><?= htmlspecialchars($product['name']) ?></h3>
                                        <p class="product-desc"><?= htmlspecialchars($product['filtr']) ?></p>
                                        
                                        <!-- Характеристики товара -->
                                        <div class="product-specs">
                                            <?php if (!empty($product['d_dosing'])): ?>
                                            <span class="spec">Дозирование: <?= htmlspecialchars($product['d_dosing']) ?></span>
                                            <?php endif; ?>
                                            <?php if (!empty($product['performance'])): ?>
                                            <span class="spec">Производительность: <?= htmlspecialchars($product['performance']) ?></span>
                                            <?php endif; ?>
                                            <?php if (!empty($product['pressure'])): ?>
                                            <span class="spec">Давление: <?= htmlspecialchars($product['pressure']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <a href="product.php?slug=<?= urlencode($product['slug']) ?>" class="product-btn">Подробнее →</a>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Товары не найдены</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php require_once __DIR__ . '/includes/footer.php'; ?>
    
</body>
</html>