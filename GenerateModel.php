<?php
class GenerateModel {
    private $injectInNum_s = array(0, array("select * from users where id=@"));
    private $injectInString_s = array(0, array("select * from users where name='@'"));
    private $injectInOrderBy_s = array(0, array('select * from users order by "@"'));
    private $commaFilter = array(0, array(','));
    private $spaceFilter = array(0, array(' ', '\n', '\t', '\r'));
    private $equalSignFilter = array(0, array('='));
    private $quotationMarkFilter = array(0, array('"', "'"));
    private $logicalOperatorFilter = array(0, array('and', 'or', 'not', 'xor'));
    private $keywordFilter = array(0, array('users'));
    private $comparisonOperatorFilter = array(0, array('>', '<'));
    private $functionFilter = array(0, array('sleep', 'ascii', 'group_concat', 'substr', 'union'));
    private $get;

    public function __construct($injectionPointList = null, $filterList = null) {
        if ($injectionPointList != null && $filterList != null) {
            $this->checkInjectionPoint($injectionPointList);
            $this->checkFilter($filterList);
        }
    }

    private function checkInjectionPoint($injectionPointList){
        $tmp = new GenerateModel();
        foreach($injectionPointList as $injectionPoint){
            if (property_exists($tmp, $injectionPoint)){
                $this->{$injectionPoint}[0] = 1;
            }
        }
    }

    private function checkFilter($filterList){
        $tmp = new GenerateModel();
        foreach($filterList as $filter){
            if (property_exists($tmp, $filter)){
                $this->{$filter}[0] = 1;
            }
        }
    }

    public function getBlackListAndSql($generate){
        $blackList = array();
        $objectVars = get_object_vars($generate);
        foreach($objectVars as $objectVar){
            if (!is_array($objectVar)){
                continue;
            }
            foreach($objectVar as $key => $value){
                if ($key === 0 and $value === 0){
                    break;
                }
                if($key === 1){
                    $blackList = array_merge($blackList, $value);
                }

            }
        }
        $sql = array_shift($blackList);
        return array($sql, $blackList);
    }

    public function getGetReq($arr){
        $this->get = empty($arr) ? 1 : $arr;
        if ( $this->get != 1){
            foreach ($_GET as $key => $value) {
                $this->get = $value;
                break;
            }
        }
    }

    public function render($data){

        $sql = $data[0];
        $blackList = $data[1];
        $sql = explode("@", $sql);
        $f = fopen("sqlBypass.php", "w");

        $inc = '<?php include "db.php";?>';
        $content = '
<div style="
    display: flex; 
    flex-direction: column; 
    justify-content: center; 
    align-items: center; 
    height: 100vh; /* 使容器填满全屏高度 */
    margin: 0; /* 去掉默认边距 */
    font-family: Arial, sans-serif; /* 设置字体 */
">
    <div style="margin: 10px; font-size: 24px; background-color: darkorange"><b>blackList:  </b>'. implode(', ', $blackList) .'</div>'.
     '<div style="margin: 10px; font-size: 24px; background-color: yellow">
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
            ';

        $php_code = '<?php
        $blackList = "'. base64_encode(serialize($blackList)) .'";
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
        $sql = "' . $sql[0] . '". $get ."' . $sql[1] . '";
        $db = new DB();
        $db->connect();
        $res = $db->query($sql);
        $res = $db->fetch_all($res);
        $db->close();
        ?>';

        fwrite($f, $inc . $php_code . $content);

        header('Location: sqlBypass.php');
    }

}
?>