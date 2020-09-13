<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p><?php
print_r(array_values(hash_algos()));
echo hash("sha3-384", "ihjkfdsbukjfew")
?></p>
</body>
</html>
