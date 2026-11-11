
<?php
$hostname_forumtest = "localhost";
$database_forumtest = "databasga";
$username_forumtest = "forum";
$password_forumtest = "forum";

try {
    $forum = new PDO(
        "mysql:host=$hostname_forumtest;dbname=$database_forumtest;charset=utf8mb4",
        $username_forumtest,
        $password_forumtest
    );

    $forum->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $forum->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log($e->getMessage());
    die("Kunde inte ansluta till databasen.");
}
