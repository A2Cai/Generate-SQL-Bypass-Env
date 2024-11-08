<?php
include "sqlRule.php";
include "injectionPoint.php";

$a = new SqlRule();
$b = new InjectPoint();
$sqlRuleList = array_keys($a->sqlRuleList);
$injectionPointList = array_keys($b->injectionPointList);
$title_text = "Generate SQL Bypass Env";
$title = "SQL bypass";
?>

<!DOCTYPE html>
<html lang="zh">
<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            font-size: 20px;
            text-align: center;
            width: 80%;
        }

        .radio-group {
            display: flex;
            flex-wrap: wrap; /* 让单选框换行 */
            justify-content: center; /* 居中对齐单选框 */
            margin-top: 5px;
        }

        .radio-group label {
            margin: 10px; /* 每个单选框之间添加间隔 */
        }

        .checkbox-group {
            display: flex;
            flex-wrap: wrap; /* 让单选框换行 */
            justify-content: center; /* 居中对齐单选框 */
            margin-top: 10px;
        }

        .checkbox-group label {
            margin: 10px; /* 每个单选框之间添加间隔 */
        }

    </style>
    <script>
        window.onload=refreshRadio();
        function refreshRadio() {
            var radios = document.getElementsByName('injectionPoint');
            for (var i = 0; i < radios.length; i++) {
                radios[i].checked = false;
            }
        }
    </script>
</head>

<body>
<div class="container">
    <form enctype="application/x-www-form-urlencoded" action="handle.php" method="post">
    <h1><?= $title_text ?></h1>
    <br />
    <div class="radio-group">
        <?php for ($i = 0; $i < count($injectionPointList); $i++):?>
        <?php
        $names = explode("|", $injectionPointList[$i]);
        echo "<label>";
        echo '<input type="radio" name="injectionPoint[]" value="' . $names[0] . '">'. $names[1];
        echo "</label>";
        ?>
        <?php endfor;?>
    </div>
    <br />
    <div class="checkbox-group">
        <?php for ($i = 0; $i < count($sqlRuleList); $i++):?>
            <?php
            $names = explode("|", $sqlRuleList[$i]);
            echo "<label>";
            echo '<input type="checkbox" name="Filter[]" value="' . $names[0] . '">'. $names[1];
            echo "</label>";
            ?>
        <?php endfor;?>
    </div>
        <br />
        <br />
    <input type="submit" value="Generate" style="width: 200px; height: 50px; font-size: 25px">
    </form>
</div>

</body>

</html>

