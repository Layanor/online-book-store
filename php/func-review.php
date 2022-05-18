<?php

# Get all Reviews function
function get_all_book_reviews($con, $book_id)
{
    $sql  = "SELECT * FROM reviews WHERE book_id  = ? ORDER BY created_at DESC";
    $stmt = $con->prepare($sql);
    $stmt->execute([$book_id]);

    if ($stmt->rowCount() > 0) {
        $reviews = $stmt->fetchAll();
    } else {
        $reviews = 0;
    }

    return $reviews;
}

# Get all Reviews function
function get_all_reviews($con)
{
    $sql  = "SELECT * FROM reviews";
    $stmt = $con->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $reviews = $stmt->fetchAll();
    } else {
        $reviews = 0;
    }

    return $reviews;
}


# Get review by ID
function get_review($con, $id)
{
    $sql  = "SELECT * FROM reviews WHERE id=?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        $review = $stmt->fetch();
    } else {
        $review = 0;
    }

    return $review;
}

# Get review completion status
function get_review_completion_status($value)
{
    $statusValue = '';
    if ($value == 1) {
        $statusValue = 'Will-read';
    } else if ($value == 2) {
        $statusValue = 'Currently reading';
    } else if ($value == 3) {
        $statusValue = 'Finished reading';
    }

    return $statusValue;
}
