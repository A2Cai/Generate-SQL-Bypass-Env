<?php
include "GenerateModel.php";

$model = new GenerateModel($_POST["injectionPoint"], $_POST["Filter"]);
$model->render();

//print_r($model->injectionPoint);
