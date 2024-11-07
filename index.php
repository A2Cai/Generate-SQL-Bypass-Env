<?php
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
    <label>
        <input type="radio" name="injectionPoint[]" value="injectInNum_s"> 数字型注入 (select)
    </label>
    <label>
        <input type="radio" name="injectionPoint[]" value="injectInString_s"> 字符型注入 (select)
    </label>
    <label>
        <input type="radio" name="injectionPoint[]" value="injectInOrderBy_s"> order by 注入 (select)
    </label>
<!--    <label>-->
<!--        <input type="radio" name="injectionPoint[]" value="injectInNum_u" disabled> 数字型注入 (update)-->
<!--    </label>-->
<!--    <label>-->
<!--        <input type="radio" name="injectionPoint[]" value="injectInString_u" disabled> 字符型注入 (update)-->
<!--    </label>-->
<!--    <label>-->
<!--        <input type="radio" name="injectionPoint[]" value="injectInOrderBy_u" disabled> order by 注入 (update)-->
<!--    </label>-->
    </div>
    <br />
    <div class="checkbox-group">
        <label>
            <input type="checkbox" name="Filter[]" value="commaFilter"> 逗号过滤绕过
        </label>
        <label>
            <input type="checkbox" name="Filter[]" value="spaceFilter"> 空格过滤绕过
        </label>
        <label>
            <input type="checkbox" name="Filter[]" value="equalSignFilter"> 等号过滤绕过
        </label>
        <label>
            <input type="checkbox" name="Filter[]" value="quotationMarkFilter"> 引号过滤绕过
        </label>
        <label>
            <input type="checkbox" name="Filter[]" value="logicalOperatorFilter"> 逻辑运算符过滤绕过
        </label>
        <label>
            <input type="checkbox" name="Filter[]" value="keywordFilter"> 关键词过滤绕过
        </label>
        <label>
            <input type="checkbox" name="Filter[]" value="comparisonOperatorFilter"> 比较运算符过滤绕过
        </label>
        <label>
            <input type="checkbox" name="Filter[]" value="functionFilter"> 函数过滤绕过
        </label>
    </div>
        <br />
        <br />
    <input type="submit" value="Generate" style="width: 200px; height: 50px; font-size: 25px">
    </form>
</div>

</body>

</html>

