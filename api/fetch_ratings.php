<?php
header('Content-Type: application/json');
$ratings = [
    ["movie_id" => 1, "rating" => 8.8, "votes" => 2000],
    ["movie_id" => 2, "rating" => 7.7, "votes" => 1500],
    ["movie_id" => 3, "rating" => 9.3, "votes" => 3000],
];
echo json_encode($ratings);
?>