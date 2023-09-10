<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
</head>

<body>
    <h1>Runtime Error</h1>
    <?php
    echo "<h3>".$data["message"]."</h3><div><h3>STACK TRACE:</h3><ul>";
    foreach ($data["trace"] as $index=>$item) {
        echo '<li style="margin-bottom: 20px;font-size:20px;"> #'.$index.': At function "'.$item["function"].'(args=['.(!empty($item["args"])?'"'.implode('","', $item["args"]).'"':"").'])" in "'.$item["file"] .'", line '.$item["line"].'.</li>';
    }
    ?>
</body>

</html>