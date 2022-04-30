<?php  
session_start();

# If the admin is logged in
if (!isset($_SESSION['user_id']) &&
    !isset($_SESSION['user_email'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>LOGIN</title>

    <!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="My-colors.css">
</head>
<header>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container-fluid">
			<a class="navbar-brand" href="index.php"><img src="img/bibliophilia (3).png" alt="logo" width="150" height="150"></a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link active" aria-current="page" href="index.php">Books</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="SignUp_admin.php">Login</a>
					</li>



				</ul>
			</div>
		</div>
	</nav>
</header>
<body>
    
	 <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <form class="p-5 rounded shadow" style="max-width: 30rem; width: 100%" method="post" action="index.html" onsubmit="validation(event);">

            <h1 class="text-center display-4 pb-5">Sign Up</h1>
            <!------------------------------------------------------------------------->
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" name="email" id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Admin@hotmail.com"
                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
            </div>
            <!------------------------------------------------------------------------->
            <div class="mb-3">
                <label for="exampleInputname1" class="form-label">First Name</label>
                <input type="name" class="form-control" name="First name" id="exampleInputname1"
                   placeholder="for example : Noura "
                    pattern="[a-zA-Z]+">
            </div>
             <!------------------------------------------------------------------------->
             <div class="mb-3">
                <label for="exampleInputname2" class="form-label">Last Name</label>
                <input type="name" class="form-control" name="Last name" id="exampleInputname2"
                   placeholder="for example : Ahmad "
                    pattern="[a-zA-Z]+">
            </div>
            <!-------------------------------------------------------------------------->
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="letters or numbers or both">
            </div>

            <p><em>Note: All feilds must have (at least) 2 digits</em></p>
            <br>
        
                <button type="submit" id="login_btn" class="btn disabled" value="Login" disabled="true">Sgin
                    Up</button>
            </div>

        </form>
    </div>
    	<footer style="text-align: center;">

		<!--Copy Rights-->
		<p>Copyright &copy; 2022 Bibliophilia . All Rights Reserved</p>

	</footer>
	<script src="login.js"></script>
</body>
</html>

<?php }else{
  header("Location: admin.php");
  exit;
} ?>