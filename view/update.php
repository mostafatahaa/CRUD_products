<?php
require_once '../header/header.php';
include '../functions dir/get_dir_name.php';


$dsn = 'mysql:host=localhost;dbname=new_products';
$user_name = 'root';
$pass = '';
$pdo = new PDO($dsn, $user_name, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('location: index.php');
    exit;
}

$stat = $pdo->prepare('SELECT * FROM products WHERE id=:id');
$stat->bindValue(':id', $id);
$stat->execute();
$products = $stat->fetch(PDO::FETCH_ASSOC);




$title = $products['title'];
$description = $products['description'];
$price = $products['price'];

$errors = [];
$image = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    if (!$title) {
        $errors[] = 'Product Title Is Not exist';
    }
    if (!$price) {
        $errors[] = 'Product Price Is Not exist';
    }

    if (!is_dir('images')) {
        mkdir('images');
    }

    if (empty($errors)) {
        $image = $_FILES['image'] ?? null;

        if ($image && $image['tmp_name']) {
            $image_path = 'images/' . randomName(7) . '/' . $image['name'];
            mkdir(dirname($image_path));
            move_uploaded_file($image['tmp_name'], __DIR__ . '/' . $image_path);
        }




        $stat = $pdo->prepare("UPDATE products SET title=:title, description=:description,
         image=:image, price = :price WHERE id=:id");

        $stat->bindValue(':title', $title);
        $stat->bindValue(':description', $description);
        $stat->bindValue(':price', $price);
        $stat->bindValue(':image', $image_path);
        $stat->bindValue(':id', $id);
        $stat->execute();
        header('location: index.php');
    }
}


?>







<p>
    <a href="index.php" style="width: 150px;" class="btn btn-secondary" type="submit">Go Back</a>
</p>

<h1>Update Product </h1>
<?php if ($errors) : ?>
    <div class="alert alert-danger" role="alert">
        <?php foreach ($errors as $error) : ?>
            <?php echo $error ?><br>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form action="" method="POST" enctype="multipart/form-data">
    <?php if ($products['image']) : ?>
        <img class="imag-update" src="<?php echo $products['image'] ?>">
    <?php endif; ?>
    <div class="mb-3">
        <label class="form-group">Product Image</label><br>
        <input name="image" type="file" <?php echo $products['image'] ?>>
    </div>
    <div class="mb-3">
        <label class="form-group">Product title</label>
        <input name="title" type="text" class="form-control" value="<?php echo $title ?>" id="formFileMultiple">
    </div>
    <div class="mb-3">
        <label class="form-group">Product Description</label>
        <textarea name="description" type="text" class="form-control" id="formFileDisabled"><?php echo $description ?></textarea>
    </div>
    <div class="mb-3">
        <label class="form-group">Product Price</label>
        <input name="price" type="number" class="form-control" value="<?php echo $price ?>" id="formFileMultiple">
    </div>
    <a href="index.php">
        <button class="btn btn-primary" type="submit">submit</button>
    </a>
</form>