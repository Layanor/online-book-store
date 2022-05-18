<?php
session_start();

# If the admin is logged in
//if (
//    isset($_SESSION['user_id']) &&
//    isset($_SESSION['user_email'])
//) {

    # Database Connection File
    include "../db_conn.php";

    # Validation helper function
    include "./func-validation.php";

    /**
	  If all Input field
	  are filled
     **/
    if (
        isset($_POST['id']) &&
        isset($_POST['reviewer_name'])       &&
        isset($_POST['completion_status']) &&
        isset($_POST['review'])
    ) {
        /**
		Get data from POST request
		and store it in var
         **/

        $book_id = $_POST['id'];
        $reviewer_name = $_POST['reviewer_name'];
        $completion_status = $_POST['completion_status'];
        $review = $_POST['review'];

        # making URL data format
        $user_input = 'id=' . $book_id . '&reviewer_name=' . $reviewer_name . '&completion_status=' . $completion_status . '&review=' . $review;

        #simple form Validation

        $text = "Book id";
        $location = "../book.php";
        $ms = "error";
        is_empty($book_id, $text, $location, $ms, $user_input);

        $text = "Reviwer name";
        $location = "../book.php";
        $ms = "error";
        is_empty($reviewer_name, $text, $location, $ms, $user_input);

        $text = "Completion status";
        $location = "../book.php";
        $ms = "error";
        is_empty($completion_status, $text, $location, $ms, $user_input);

        $text = "Review";
        $location = "../book.php";
        $ms = "error";
        is_empty($review, $text, $location, $ms, $user_input);

        #simple form Validation
        # Insert Into Database
        $sql  = "INSERT INTO reviews (book_id, reviewer_name, completion_status, review, created_at)
			         VALUES (?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $res  = $stmt->execute([$book_id, $reviewer_name, $completion_status, $review, date('Y-m-d H:i:s')]);

        /**
		      If there is no error while
		      inserting the data
         **/
        if ($res) {
            # success message
            $sm = "Successfully created!";
            header("Location: ../book.php?id=" . $book_id . "&success=$sm");
            exit;
        } else {
            # Error message
            $em = "Unknown Error Occurred!";
            header("Location: ../book.php?id=" . $book_id . "&error=$em");
            exit;
        }
    } else {
        header("Location: ../admin.php");
        exit;
    }
//} else {
//    header("Location: ../login.php");
//    exit;
//}
