<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ticket</title>
</head>
<body>

<?php
if (isset($_POST['code'])) {
    $code = (int) $_POST['code'];

    if ($code >= 1 && $code <= 999) {
        $mysqli = new mysqli("localhost", "root", "", "ticket");
        $mysqli->set_charset("utf8mb4");

        $stmt = $mysqli->prepare("SELECT article FROM articles WHERE code = ?");
        $stmt->bind_param("i", $code);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            echo "<p>Le code $code est correct. L'information correspondante est : " . $row['article'] . "</p>";
        }
    } elseif ($code == 0) {
        $mysqli = new mysqli("localhost", "root", "", "ticket");
        $mysqli->set_charset("utf8mb4");

        $result = $mysqli->query("SELECT code, article FROM articles");
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>" . $row['code'] . " : " . $row['article'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Le code est incorrect, trop grand !</p>";
    }
}
?>

<form method="post">
    <label>Code : <input type="number" name="code"></label>
    <button type="submit">Valider</button>
</form>

</body>
</html>