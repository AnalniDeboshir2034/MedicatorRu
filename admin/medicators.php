<?php
require_once __DIR__ . '/bootstrap.php';
admin_require_auth();

$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'medicator_create') {
        $sql = "INSERT INTO medicator (name,d_dosing,performance,pressure,temperature,connections,m_seal,m_case,dop,passport,user_pass,opis,filtr,slug)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param(
            'ssssssssssssss',
            admin_req('name'),
            admin_req('d_dosing'),
            admin_req('performance'),
            admin_req('pressure'),
            admin_req('temperature'),
            admin_req('connections'),
            admin_req('m_seal'),
            admin_req('m_case'),
            admin_req('dop'),
            admin_req('passport'),
            admin_req('user_pass'),
            admin_req('opis'),
            admin_req('filtr'),
            admin_req('slug')
        );
        $stmt->execute();
        $success = 'Медикатор создан';
    }

    if ($action === 'medicator_update') {
        $sql = "UPDATE medicator SET name=?, slug=?, filtr=?, opis=? WHERE id=?";
        $stmt = $mysqli->prepare($sql);
        $id = (int)($_POST['id'] ?? 0);
        $stmt->bind_param('ssssi', admin_req('name'), admin_req('slug'), admin_req('filtr'), admin_req('opis'), $id);
        $stmt->execute();
        $success = 'Медикатор обновлён';
    }

    if ($action === 'medicator_delete') {
        $id = (int)($_POST['id'] ?? 0);
        $stmt = $mysqli->prepare("DELETE FROM medicator_img WHERE medicator_id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt = $mysqli->prepare("DELETE FROM medicator WHERE id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $success = 'Медикатор удалён';
    }
}

$medicators = $mysqli->query("SELECT * FROM medicator ORDER BY id DESC");
admin_page_start('Админка: Медикаторы');
if ($success) {
    echo '<div class="msg">' . htmlspecialchars($success) . '</div>';
}
?>
<div class="card">
    <h2>Создать медикатор</h2>
    <form method="post">
        <input type="hidden" name="action" value="medicator_create">
        <div class="grid">
            <input name="name" placeholder="name" required>
            <input name="slug" placeholder="slug" required>
            <input name="filtr" placeholder="filtr (slug subfilter)" required>
            <input name="d_dosing" placeholder="d_dosing">
            <input name="performance" placeholder="performance">
            <input name="pressure" placeholder="pressure">
            <input name="temperature" placeholder="temperature">
            <input name="connections" placeholder="connections">
            <input name="m_seal" placeholder="m_seal">
            <input name="m_case" placeholder="m_case">
            <input name="dop" placeholder="dop">
            <input name="passport" placeholder="passport">
            <input name="user_pass" placeholder="user_pass">
        </div>
        <textarea name="opis" placeholder="opis"></textarea>
        <button type="submit">Создать</button>
    </form>
</div>

<div class="card">
    <h2>Список медикаторов</h2>
    <table>
        <tr><th>ID</th><th>name</th><th>slug</th><th>filtr</th><th>opis</th><th>Обновить</th><th>Удалить</th></tr>
        <?php while ($m = $medicators->fetch_assoc()): ?>
            <tr>
                <td><?= (int)$m['id'] ?></td>
                <td><input form="m<?= (int)$m['id'] ?>" name="name" value="<?= htmlspecialchars($m['name']) ?>"></td>
                <td><input form="m<?= (int)$m['id'] ?>" name="slug" value="<?= htmlspecialchars($m['slug']) ?>"></td>
                <td><input form="m<?= (int)$m['id'] ?>" name="filtr" value="<?= htmlspecialchars($m['filtr']) ?>"></td>
                <td><textarea form="m<?= (int)$m['id'] ?>" name="opis"><?= htmlspecialchars($m['opis']) ?></textarea></td>
                <td>
                    <form id="m<?= (int)$m['id'] ?>" method="post">
                        <input type="hidden" name="action" value="medicator_update">
                        <input type="hidden" name="id" value="<?= (int)$m['id'] ?>">
                        <button>Сохранить</button>
                    </form>
                </td>
                <td>
                    <form method="post" onsubmit="return confirm('Удалить медикатор?')">
                        <input type="hidden" name="action" value="medicator_delete">
                        <input type="hidden" name="id" value="<?= (int)$m['id'] ?>">
                        <button class="danger">Удалить</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
<?php admin_page_end(); ?>

