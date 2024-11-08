<?php include "db.php";?><?php
        $blackList = "YTo1OntpOjA7czoxOiIsIjtpOjE7czozOiJhbmQiO2k6MjtzOjI6Im9yIjtpOjM7czozOiJub3QiO2k6NDtzOjM6InhvciI7fQ==";
        $blackList = unserialize(base64_decode($blackList));
        function filter($str, $blackList){
            $str = strtolower($str);
            foreach($blackList as $black){
                if(strpos($str, $black) !== false){
                exit("<h1 style=\"color: red;\">Hacker!!!</h1>");
                }
            }
        }
        empty($_GET) ? $get = 1 : $get = $_GET;
        if ($get != 1){
            foreach($_GET as $key => $value){
                $get = $value;
                break;
            }
        }
        filter($get, $blackList);
        $sql = "select * from users order by '". $get ."'";
        $db = new DB();
        $db->connect();
        $res = $db->query($sql);
        $res = $db->fetch_all($res);
        $db->close();
        ?>
<div style="
    display: flex; 
    flex-direction: column; 
    justify-content: center; 
    align-items: center; 
    height: 100vh; /* 使容器填满全屏高度 */
    margin: 0; /* 去掉默认边距 */
    font-family: Arial, sans-serif; /* 设置字体 */
">
    <div style="margin: 10px; font-size: 24px; background-color: darkorange"><b>blackList:  </b>,, and, or, not, xor</div><div style="margin: 10px; font-size: 24px; background-color: yellow">
        <?= $sql ?>
      </div>
      <div style="margin: 10px; font-size: 24px; text-align: center">
            <?php if(!empty($res)):?>
                <?php foreach($res[0] as $key => $value):?>
                    <div>
                    <?php echo $key . ": " . $value;?>
                    </div>
                <?php endforeach?>
            <?php endif?>
       </div>
     </div>
            