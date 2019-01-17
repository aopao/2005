<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>index</title>
</head>
<body>
    <form action="/a.php" method="post">
        <input type="checkbox" name="college[]" value="1" id="">
        <input type="checkbox" name="college[]" value="2" id="">
        <input type="checkbox" name="college[]" value="3" id="">
        <input type="submit" value="sd">
    </form>
</body>
</html>

<?php
    if (isset($_POST)) {
        print_r($_POST);
    }

?>