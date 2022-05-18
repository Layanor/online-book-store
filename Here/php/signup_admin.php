<?php
session_start();

if (
    isset($_POST['email']) &&
    isset($_POST['first_name']) &&
    isset($_POST['last_name']) &&
    isset($_POST['password'])
) {

    # Database Connection File
    include "../db_conn.php";

    # Validation helper function
    include "func-validation.php";

    /**
	   Get data from POST request
	   and store them in var
     **/

    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $password = $_POST['password'];

    # making URL data format
    $user_input = 'email=' . $email . '&first_name=' . $first_name . '&last_name=' . $last_name;

    # simple form validation

    $text = "Email";
    $location = "../SignUp_admin.php";
    $ms = "error";
    is_empty($email, $text, $location, $ms, $user_input);

    $text = "First Name";
    $location = "../SignUp_admin.php";
    $ms = "error";
    is_empty($first_name, $text, $location, $ms, $user_input);

    $text = "Last Name";
    $location = "../SignUp_admin.php";
    $ms = "error";
    is_empty($last_name, $text, $location, $ms, $user_input);

    $text = "Password";
    $location = "../SignUp_admin.php";
    $ms = "error";
    is_empty($password, $text, $location, $ms, $user_input);

    # search for the email
    $sql = "SELECT * FROM admin
            WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);

    # if the email is exist
    if ($stmt->rowCount() === 1) {

        # Error message
        $em = "Email already exists";
        header("Location: ../SignUp_admin.php?error=$em&" . $user_input);
    } else {

        # Insert the data into database
        $sql  = "INSERT INTO admin (full_name,
                                            email,
                                            password)
                         VALUES (?,?,?)";
        $stmt = $conn->prepare($sql);
        $res  = $stmt->execute([$first_name . ' ' . $last_name, $email, password_hash($password, PASSWORD_DEFAULT)]);

        /**
		      If there is no error while
		      inserting the data
         **/
        if ($res) {
            # success message
            $sm = "The admin successfully created. Plase login!";
            header("Location: ../login.php?success=$sm");
            exit;
        } else {
            # Error message
            $em = "Unknown Error Occurred!";
            header("Location: ../SignUp_admin.php?error=$em");
            exit;
        }
    }
} else {
    # Redirect to "../SignUp_admin.php"
    header("Location: ../SignUp_admin.php");
}
