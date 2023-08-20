<?php
require_once '../header/header.php';
include '../functions dir/get_dir_name.php';

$dsn = 'mysql:host=localhost;dbname=new_products';
$user_name = 'root';
$pass = '';
$pdo = new PDO($dsn, $user_name, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



$errors = [];
$image_path = '';
$title = '';
$description = '';
$price = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $date = date('Y-m-d H:i:s');

    if (!$title) {
        $errors[] = 'Product Title Is Not exist';
    }
    if (!$price) {
        $errors[] = 'Product Price Is Not exist';
    }
    if (!is_dir(dirname(__FILE__, 2) . '/images')) {
        mkdir(dirname(__FILE__, 2) . '/images');
    }

    if (empty($errors)) {
        $image = $_FILES['image'] ?? null;
        if ($image && $image['tmp_name']) {
            $image_path = 'images/' . randomName(7) . '/' . $image['name'];
            mkdir(dirname(dirname(__FILE__, 2) . '/' . $image_path));
            move_uploaded_file($image['tmp_name'], dirname(__FILE__, 2) . '/' . $image_path);
        }

        $stat = $pdo->prepare("INSERT INTO products (title, description, image, price, date)
        VALUES(:title, :description, :image, :price, :date)");

        $stat->bindValue(':title', $title);
        $stat->bindValue(':description', $description);
        $stat->bindValue(':price', $price);
        $stat->bindValue(':date', $date);
        $stat->bindValue(':image', $image_path);
        $stat->execute();
        header('Location: index.php');
    }
}

?>


<p>
    <a href="index.php" style="width: 150px;" class="btn btn-secondary" type="submit">Go Back</a>
</p>

<h1>Create New Product</h1>
<?php if ($errors) : ?>
    <div class="alert alert-danger" role="alert">
        <?php foreach ($errors as $error) : ?>
            <?php echo $error ?><br>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form action="" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-group">Product Image</label><br>
        <input name="image" type="file">
    </div>
    <div class="mb-3">
        <label class="form-group">Product title</label>
        <input value="<?php echo $title ?>" name="title" class="form-control" id="formFileMultiple">
    </div>
    <div class="mb-3">
        <label class="form-group">Product Description</label>
        <textarea name="description" class="form-control" id="formFileDisabled"><?php echo $description ?></textarea>
    </div>
    <div class="mb-3">
        <label class="form-group">Product Price</label>
        <input value="<?php echo $price ?>" name="price" type="number" class="form-control" step="0.01">
    </div>
    <button href class="btn btn-primary" type="submit">Creat Product</button>
</form>