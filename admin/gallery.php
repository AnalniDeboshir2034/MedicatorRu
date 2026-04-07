<?php
require_once __DIR__ . '/bootstrap.php';
admin_require_auth();

$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'gallery_create') {
        $stmt = $mysqli->prepare("INSERT INTO medicator_img (medicator_id, is_Main, path_img, sort) VALUES (?,?,?,?)");
        $medicatorId = (int)($_POST['medicator_id'] ?? 0);
        $isMain = (int)($_POST['is_Main'] ?? 0);
        $path = admin_req('path_img');
        $sort = (int)($_POST['sort'] ?? 0);
        $stmt->bind_param('iisi', $medicatorId, $isMain, $path, $sort);
        $stmt->execute();
        $success = 'Изображение добавлено';
    }
    if ($action === 'gallery_update') {
        $stmt = $mysqli->prepare("UPDATE medicator_img SET path_img=?, is_Main=?, sort=? WHERE id=?");
        $id = (int)($_POST['id'] ?? 0);
        $path = admin_req('path_img');
        $isMain = (int)($_POST['is_Main'] ?? 0);
        $sort = (int)($_POST['sort'] ?? 0);
        $stmt->bind_param('siii', $path, $isMain, $sort, $id);
        $stmt->execute();
        $success = 'Изображение обновлено';
    }
    if ($action === 'gallery_delete') {
        $stmt = $mysqli->prepare("DELETE FROM medicator_img WHERE id=?");
        $id = (int)($_POST['id'] ?? 0);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $success = 'Изображение удалено';
    }
}

$images = $mysqli->query("SELECT * FROM medicator_img ORDER BY id DESC");
admin_page_start('Админка: Галерея');
if ($success) {
    echo '<div class="msg">' . htmlspecialchars($success) . '</div>';
}
?>
<div class="card">
    <h2>Добавить изображение</h2>
    <form method="post" class="grid">
        <input type="hidden" name="action" value="gallery_create">
        <input name="medicator_id" type="number" placeholder="medicator_id" required>
        <input name="path_img" placeholder="products/example.jpg" required>
        <input name="is_Main" type="number" min="0" max="1" value="0">
        <input name="sort" type="number" value="0">
        <button>Добавить</button>
    </form>
</div>

<div class="card">
    <h2>Список изображений</h2>
    <table>
        <tr><th>ID</th><th>medicator_id</th><th>path</th><th>main</th><th>sort</th><th>Обновить</th><th>Удалить</th></tr>
        <?php while ($img = $images->fetch_assoc()): ?>
            <tr>
                <td><?= (int)$img['id'] ?></td>
                <td><?= (int)$img['medicator_id'] ?></td>
                <td><input form="g<?= (int)$img['id'] ?>" name="path_img" value="<?= htmlspecialchars($img['path_img']) ?>"></td>
                <td><input form="g<?= (int)$img['id'] ?>" name="is_Main" type="number" min="0" max="1" value="<?= (int)$img['is_Main'] ?>"></td>
                <td><input form="g<?= (int)$img['id'] ?>" name="sort" type="number" value="<?= (int)$img['sort'] ?>"></td>
                <td>
                    <form id="g<?= (int)$img['id'] ?>" method="post">
                        <input type="hidden" name="action" value="gallery_update">
                        <input type="hidden" name="id" value="<?= (int)$img['id'] ?>">
                        <button>Сохранить</button>
                    </form>
                </td>
                <td>
                    <form method="post">
                        <input type="hidden" name="action" value="gallery_delete">
                        <input type="hidden" name="id" value="<?= (int)$img['id'] ?>">
                        <button class="danger">Удалить</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
<?php admin_page_end(); ?>

