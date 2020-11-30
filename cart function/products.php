<?php
$con = mysqli_connect("localhost", "root", "", "productDb");
if (!$con) {
    die("Cannot connect to DB server");
}

if (isset($_POST['product_image'])) {

    $pname = $_POST["pname"];
    $pcode = $_POST["pcode"];
    $pprice = $_POST["pprice"];
    $name = $_FILES['file']['name'];

    $target_dir = "product-images/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);

    // Select file type
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Valid file extensions
    $extensions_arr = array("jpg", "jpeg", "png", "gif");

    // Check extension
    if (in_array($imageFileType, $extensions_arr)) {


        // Convert to base64 
        $image_base64 = base64_encode(file_get_contents($_FILES['file']['tmp_name']));
        $image = 'product-images/' . $name;

        // Insert record
        $sql = "INSERT INTO `products` (`name`, `code`, `image`, `price`) 
        VALUES ('" . $pname . "', '" . $pcode . "', '" . $image . "', '" . $pprice . "');";

        $data = mysqli_query($con, $sql);

        // Upload file
        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $name);

        if ($data != null) {
            echo "<script>
            alert('Product Added Successfully');
            window.location.href='products.php';
            </script>";
        }

        mysqli_close($con);
    }
}
?>
<HTML>

<HEAD>
    <TITLE>Shopping Cart</TITLE>
    <link href="product.css" type="text/css" rel="stylesheet" />
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
</HEAD>

<BODY>
    <div class="container register">
        <div class="row">
            <div class="col-md-3 register-left">
                <img src="images/cart.png" alt="" />
                <h3>Welcome</h3>
                <p>Product Cart</p>
            </div>
            <div class="col-md-9 register-right">
                <ul class="nav nav-tabs nav-justified">
                    <li class="nav-item">
                        <a class="nav-link active" href="products.php" aria-controls="home" aria-selected="true">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php" target="_blank" aria-controls="profile" aria-selected="false">Cart</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <h3 class="register-heading">Add Product</h3>
                        <div class="row register-form">
                            <div class="col-md-12">
                                <form method="post" action="" enctype='multipart/form-data'>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Product Name" name="pname" value="" />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Product Code" name="pcode" value="" />
                                    </div>
                                    <div class="form-group">
                                        <input type='file' name='file' />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Product Price" name="pprice" value="" />
                                    </div>
                                    <div class="form-group">
                                        <input type='submit' value='Save Product' name='product_image'>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</BODY>

</HTML>