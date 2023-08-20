<?php
$dsn = 'mysql:host=localhost;dbname=new_products';
$user_name = 'root';
$pass = '';
$pdo = new PDO($dsn, $user_name, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stat = $pdo->prepare('SELECT title, description, image, price, id, date FROM products');
$stat->execute();
$products = $stat->fetchAll(PDO::FETCH_ASSOC);



print_r($products);
?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">
    <title>Products</title>

</head>

<body>
    <h1>Products CRUD</h1><br>

    <p>
        <a href="create_product.php" class="btn btn-primary">Create Product</a>
    </p>

    <?php require_once '../header/header.php' ?>
    <table class="table">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Product Image</th>
                <th scope="col">Product Name</th>
                <th scope="col">Product Price</th>
                <th scope="col">Product Date Created</th>
                <th scope="col">Action</th>


            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $index => $product) : ?>
                <tr>
                    <th scope="row"><?php echo $index + 1 ?></th>
                    <td><img class="table-img" src="<?php echo '../' . $product['image'] ?>"></img></td>
                    <td><?php echo $product['title'] ?></td>
                    <td><?php echo $product['price'] ?></td>
                    <td><?php echo $product['date'] ?></td>
                    <td>
                        <a style="width: 70px;" href="update.php?id=<?php echo $product['id'] ?>" class=" btn btn-outline-primary btn-sm">Edit</a>
                        <form style="display: inline-block;" action="delete.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                            <button style="width: 70px;" type="submit" class=" btn btn-outline-danger btn-sm">Delete</button>
                        </form>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>