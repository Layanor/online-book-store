<?php
session_start();

# If the admin is logged in
if (
    isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])
) {

    # Database Connection File
    include "../db_conn.php";


    /**
	  check if the book
	  id set
     **/
    if (isset($_GET['id'])) {
        /**
		Get data from GET request
		and store it in var
         **/
        $id = $_GET['id'];
        $book_id = $_GET['book_id'];

        #simple form Validation
        if (empty($id)) {
            $em = "Error Occurred!";
            header("Location: ../book.php?id=" . $book_id . "&error=$em");
            exit;
        } else {
            # GET book from Database
            $sql2  = "SELECT * FROM reviews
			          WHERE id=?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->execute([$id]);
            $the_book = $stmt2->fetch();

            if ($stmt2->rowCount() > 0) {
                # DELETE the book from Database
                $sql  = "DELETE FROM reviews
				         WHERE id=?";
                $stmt = $conn->prepare($sql);
                $res  = $stmt->execute([$id]);

                /**
			      If there is no error while
			      Deleting the data
                 **/
                if ($res) {
                    # success message
                    $sm = "Successfully removed!";
                    header("Location: ../book.php?id=" . $book_id . "&success=$sm");
                    exit;
                } else {
                    # Error message
                    $em = "Unknown Error Occurred!";
                    header("Location: ../book.php?id=" . $book_id . "&error=$em");
                    exit;
                }
            } else {
                $em = "Error Occurred!";
                header("Location: ../book.php?id=" . $book_id . "&error=$em");
                exit;
            }
        }
    } else {
        header("Location: ../admin.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
