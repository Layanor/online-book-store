<?php
session_start();

# Database Connection File
include "db_conn.php";

# If the admin is logged in
$user_id = '';
$user_email = '';
if (
    isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])
) {
    $user_id = $_SESSION['user_id'];
    $user_email = $_SESSION['user_email'];
}

# Book helper function
include "php/func-book.php";
$book = get_book($conn, $_GET['id']);

# author helper function
include "php/func-author.php";
$author = get_author($conn, $book['author_id']);

# category helper function
include "php/func-category.php";
$category = get_category($conn, $book['category_id']);

# review helper function
include "php/func-review.php";
$reviews = get_all_book_reviews($conn, $book['id']);

# time format helper function
include "php/func-time-format.php";

if (isset($_GET['reviewer_name'])) {
    $reviewer_name = $_GET['reviewer_name'];
} else $reviewer_name = '';

if (isset($_GET['completion_status'])) {
    $completion_status = $_GET['completion_status'];
} else $completion_status = '';

if (isset($_GET['review'])) {
    $review = $_GET['review'];
} else $review = '';

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store</title>

    <!-- bootstrap 5 CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="My-colors.css">
    <style>
        .bdge {
            height: 21px;
            background-color: orange;
            color: #fff;
            font-size: 11px;
            padding: 8px;
            border-radius: 4px;
            line-height: 3px
        }

        .comments {
            text-decoration: underline;
            text-underline-position: under;
            cursor: pointer
        }

        .dot {
            height: 7px;
            width: 7px;
            margin-top: 3px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block
        }

        .hit-voting:hover {
            color: blue
        }

        .hit-voting {
            cursor: pointer
        }
    </style>

</head>

<body data-new-gr-c-s-check-loaded="14.1056.0" data-gr-ext-installed="">
    <div class="container-fluid">
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.html"><img src="img/bibliophilia (3).png" alt="logo" width="150" height="150"></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="index.php">Books</a>
                            </li>

                            <!-- <li class="nav-item">
                                <a class="nav-link" href="login_admin.html">Login</a>
                            </li> -->



                        </ul>
                    </div>
                </div>
            </nav>
        </header>
    </div>
    <div class="container">
        <main>
            <!-------------- Display books and book info goes here------------------>
            <div class="card mb-1" style="max-width: 100%;">
                <div class="row g-0">
                    <div class="col-md-1"></div>
                    <div class="col-md-4 ">
                        <!-- book's img -->
                        <img src="<?= $book['cover'] ?>" class="my-3 img-fluid rounded-start" alt="<?= $book['title'] ?>">
                    </div>
                    <div class="col-md-6">
                        <div class="card-body">
                            <!-- book's info -->
                            <h5 class="card-title"><?= $book['title'] ?></h5>
                            <p class="card-text">
                                <i><b>By: <?= $author['name'] ?>.<br></b><br><br></i>
                                <?= $book['description'] ?>
                                <br><br><br><i><b>Category:
                                        <?= $category['name'] ?><br></b></i>
                            </p>
                            <?php if ($reviews != 0) : ?>
                                <p class="card-text"><small class="text-muted">Last review <?= time_elapsed_string($reviews[0]['created_at']) ?></small></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!---------Post Reviews goes here---------------------->
            <h2 class="text-Gold" style="margin-left: 8.5%; margin-top: 2%;">Write a reveiw:</h2>

            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($_GET['error']); ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?= htmlspecialchars($_GET['success']); ?>
                </div>
            <?php } ?>
            <div class="card mb-1" style="max-width: 100%;">
                <form action="./php/add-review.php" method="POST">
                    <div class="row g-0 mt-4">
                        <!-- blank space for design -->
                        <div class="col-md-1 "></div>
                        <!-- reviewer name -->
                        <div class="col-md-4 ">
                            <label for="reviewer_name" class="form-label text-Gold">Name:</label>
                            <input type="text" class="form-control" id="reviewer_name" name="reviewer_name" placeholder=" ex: Abo Khalid" value="<?= $reviewer_name ?>">
                        </div>
                        <!-- blank space for design -->
                        <div class="col-md-1 "></div>
                        <!-- completaion status Select -->
                        <div class="col-md-4">
                            <label for="completion_status" class="form-label text-Gold">Completion status:</label>
                            <select class="form-select" aria-label="Choose completaion status" id="completion_status" name="completion_status">
                                <option selected value="">Choose completaion status</option>
                                <option value="1" <?= $completion_status == 1 ? 'selected' : '' ?>>Will-read</option>
                                <option value="2" <?= $completion_status == 2 ? 'selected' : '' ?>>currently reading</option>
                                <option value="3" <?= $completion_status == 3 ? 'selected' : '' ?>>Finished reading</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-0 my-2">
                        <!-- blank space for design -->
                        <div class="col-md-1"></div>
                        <!-- Review -->
                        <div class="form-floating col-md-9">
                            <textarea class="form-control" id="review" name="review" style=" height: 100px"><?= $review ?></textarea>
                            <label for="review">Your review</label>
                        </div>
                    </div>
                    <div class="row g-0 my-2">
                        <input type="hidden" name="id" value="<?= $book['id'] ?>">
                        <!-- blank space for design -->
                        <div class="col-md-1"></div>
                        <!-- Send review button -->
                        <div class="form-floating col-md-9">
                            <input class="btn btn-blue" type="submit" value="Post">
                        </div>
                    </div>
                </form>
            </div>

            <!--------------- Display peoples reviews goes here ---------------->
            <h2 class="text-Gold" style="margin-left: 8.5%; margin-top: 2%;">Reviews:</h2>
            <div class="card mb-1" style="max-width: 100%;">
                <div class="row g-0 pb-3">

                    <?php if ($reviews == 0) : ?>
                        <div class="text-center">No review!</div>
                    <?php else : ?>
                        <?php foreach ($reviews as $review) : ?>
                            <!-- blank space for design -->
                            <div class="col-md-1 "></div>
                            <div class="col-md-9">
                                <div class="card bg-blue text-white  mt-2">
                                    <div class="p-3 ">
                                        <div class="d-flex flex-row align-items-center commented-user">
                                            <h5 class="mr-2"><?= $review['reviewer_name'] ?></h5><span class="dot mb-1 mx-2"></span><span class="mb-1 ml-2"><?= get_review_completion_status($review['completion_status']) ?></span><span class="dot mb-1 mx-2"></span><span class="mb-1 ml-2"><?= time_elapsed_string($review['created_at']) ?></span>
                                        </div>
                                        <div class="comment-text-sm"><span><?= $review['review'] ?></span></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Admin buttons to control review 1 -->
                            <div class="col-md-1 mx-2 mt-2">
                                <?php if ($user_id && $user_email) : ?>
                                    <button style="width: 100%;" class="btn btn-Success mt-2 ">Update</button>
                                    <a href="./php/delete-review.php?id=<?= $review['id'] ?>&book_id=<?= $book['id'] ?>" style="width: 100%;" class="btn btn-danger mt-3 ">Delete </a>
                                <?php endif;  ?>
                            </div>

                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            </div>
    </div>

    </main>
    <footer style="text-align: center;">

        <!--Copy Rights-->
        <p>Copyright &copy; 2022 Bibliophilia . All Rights Reserved</p>

    </footer>
    </div>
</body>
<script>
    function Activity() {

        document.getElementById("Fairy").hidden = false;
        document.getElementById("Cookbook").hidden = true;
        document.getElementById("Hungry").hidden = true;
        document.getElementById("Workbook").hidden = true;
        document.getElementById("Stars").hidden = true;
        document.getElementById("Games").hidden = true;

    }

    function Fiction() {

        document.getElementById("Fairy").hidden = true;
        document.getElementById("Cookbook").hidden = false;
        document.getElementById("Hungry").hidden = true;
        document.getElementById("Workbook").hidden = true;
        document.getElementById("Stars").hidden = true;
        document.getElementById("Games").hidden = true;

    }

    function Education() {

        document.getElementById("Fairy").hidden = true;
        document.getElementById("Cookbook").hidden = true;
        document.getElementById("Hungry").hidden = false;
        document.getElementById("Workbook").hidden = true;
        document.getElementById("Stars").hidden = true;
        document.getElementById("Games").hidden = true;

    }

    function Animals() {

        document.getElementById("Fairy").hidden = true;
        document.getElementById("Cookbook").hidden = true;
        document.getElementById("Hungry").hidden = true;
        document.getElementById("Workbook").hidden = false;
        document.getElementById("Stars").hidden = true;
        document.getElementById("Games").hidden = true;

    }

    function Arts() {

        document.getElementById("Fairy").hidden = true;
        document.getElementById("Cookbook").hidden = true;
        document.getElementById("Hungry").hidden = true;
        document.getElementById("Workbook").hidden = true;
        document.getElementById("Stars").hidden = false;
        document.getElementById("Games").hidden = true;

    }

    function Fairy() {

        document.getElementById("Fairy").hidden = true;
        document.getElementById("Cookbook").hidden = true;
        document.getElementById("Hungry").hidden = true;
        document.getElementById("Workbook").hidden = true;
        document.getElementById("Stars").hidden = true;
        document.getElementById("Games").hidden = false;

    }
</script>


</html>