 <?php
require 'db_mhs.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['title'])) {
    $title = $_POST['title'];
    $query = "INSERT INTO items_mhs (title) VALUES ('$title')";
    $mysqli->query($query);
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $mysqli->query("DELETE FROM items_mhs WHERE id = $delete_id");
}

$count_result = $mysqli->query("SELECT COUNT(*) AS c FROM items_mhs");
$count_row = $count_result->fetch_assoc();
$total_count = $count_row['c'];

$result = $mysqli->query("SELECT id, title, created_at FROM items_mhs ORDER BY created_at DESC LIMIT 10");
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>My List - mhs</title>
    <style>
        body { font-family: Tahoma; margin: 40px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; }
        .add-form { margin-bottom: 20px; }
        input[type="text"] { padding: 10px; width: 300px; border: 1px solid #ddd; border-radius: 5px; }
        button { padding: 10px 20px; background: #007cba; color: white; border: none; border-radius: 5px; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: right; }
        th { background: #f0f0f0; }
        .delete { color: red; text-decoration: none; }
        .count { font-weight: bold; margin-top: 20px; padding: 10px; background: #e0e0e0; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>My List - mhs</h1>
        
        <div class="add-form">
            <form method="POST">
                <input type="text" name="title" placeholder="یک عنوان بنویسید..." required>
                <button type="submit">➕ افزودن آیتم</button>
            </form>
        </div>

        <h2>📝 10 آیتم آخر:</h2>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>شماره</th>
                    <th>عنوان</th>
                    <th>تاریخ ایجاد</th>
                    <th>عملیات</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td><a href="?delete=<?= $row['id'] ?>" class="delete" onclick="return confirm('آیا مطمئن هستید؟')">❌ حذف</a></td>
                </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>📭 هیچ آیتمی وجود ندارد. اولین آیتم را اضافه کنید!</p>
        <?php endif; ?>

        <div class="count">
            🔢 تعداد کل آیتم‌ها: <?= $total_count ?>
        </div>
    </div>
</body>
</html>