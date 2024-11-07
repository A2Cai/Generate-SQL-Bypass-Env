<?php
include "GenerateModel.php";

$filterList = $_POST["Filter"];
$injectionPointList = $_POST["injectionPoint"];

$model = new GenerateModel($injectionPointList, $filterList);
$data =  $model->getBlackListAndSql($model);
$model->getGetReq($_GET);
$model->render($data);
