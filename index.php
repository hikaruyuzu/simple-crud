<?php
require_once("connection.php");

$title = "";
$genre = "";
$studio = "";
$release = "";
$error = "";
$success = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = "DELETE FROM anime WHERE id = '$id'";
    $q1 = mysqli_query($conn, $sql1);

    if ($q1) {
        $success = "Success Delete Data";
    } else {
        $error = "Failed to Delete Data";
    }
}
if ($op == 'edit') {
    $id = $_GET['id'];
    $sql1 = "SELECT * FROM anime WHERE id = '$id'";
    $q1 = mysqli_query($conn, $sql1);
    $r1 = mysqli_fetch_array($q1);
    $title = $r1['title'];
    $genre = $r1['genre'];
    $studio = $r1['studio'];
    $release = $r1['realese'];
    if ($title == "") {
        $error = "Data not found";
    }
}

if (isset($_POST['save'])) {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $studio = $_POST['studio'];
    $release = $_POST['release'];

    if ($title && $genre && $studio && $release) {
        if ($op == 'edit') {
            $sql1 = "UPDATE anime set title='$title', genre= '$genre', studio='$studio', realese='$release' WHERE id='$id'";
            $q1 = mysqli_query($conn, $sql1);

            if ($q1) {
                $success = "Data updated Successfuly";
            } else {
                $error = "Failed to update Data";
            }
        } else {
            $sql1 = "INSERT INTO anime (title, genre, studio, realese) VALUES ('$title', '$genre', '$studio', '$release' )";
            $q1 = mysqli_query($conn, $sql1);

            if ($q1) {
                $success = "Successfull entry of new Data";
            } else {
                $error = "Failed to save Data";
            }
        }
    } else {
        $error = "Please enter all data";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anime List</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body>
    <div class="mx-auto">
        <!--insert data-->
        <div class="card text-center">
            <div class="card-header">
                Create / Edit data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:3;url=index.php");
                }

                if ($success) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $success ?>
                    </div>
                <?php
                    header("refresh:3;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Anime Title</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="title" name="title" value=<?php echo $title ?>>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Genre</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="title" name="genre" value=<?php echo $genre ?>>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Studio</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="studio" name="studio" value=<?php echo $studio ?>>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Realese Date</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="release" name="release" value=<?php echo $release ?>>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="save" value="Save Data" class="btn btn-dark ">
                    </div>
                </form>
            </div>
        </div>

        <!--show data-->
        <div class="card text-center">
            <div class="card-header text-white bg-dark">
                Anime List
            </div>
            <div class="card-body">
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Anime</th>
                            <th scope="col">Genre</th>
                            <th scope="col">Studio</th>
                            <th scope="col">Release Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    <tbody>
                        <?php
                        $sql2 = "SELECT * FROM anime ORDER BY id DESC";
                        $q2 = mysqli_query($conn, $sql2);
                        $count = 1;

                        while ($r2 = mysqli_fetch_array($q2)) {

                            $id = $r2['id'];
                            $title = $r2['title'];
                            $genre = $r2['genre'];
                            $studio = $r2['studio'];
                            $release = $r2['realese'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $count++ ?></th>
                                <td scope="row"><?php echo $title ?></td>
                                <td scope="row"><?php echo $genre ?></td>
                                <td scope="row"><?php echo $studio ?></td>
                                <td scope="row"><?php echo $release ?></td>
                                <td>
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Are you sure, want to delete Data?')"><button type=" button" class="btn btn-light">Delete</button></a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>

                    </tbody>
                    </thead>

                </table>
            </div>
        </div>
    </div>
</body>

</html>