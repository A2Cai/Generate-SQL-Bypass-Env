<?php
include "injectionPoint.php";
include "sqlRule.php";

class GenerateModel {
    public $injectionPoint;
    public $sqlRule;
    public $sqlRuleList;
    public $injectionPointList;

    public function __construct($injectionPointListByUser = null, $sqlRuleListByUser = null) {
        if ($injectionPointListByUser != null && $sqlRuleListByUser != null) {
            $this->sqlRule = $sqlRuleListByUser;
            $this->injectionPoint = $injectionPointListByUser;
            // 初始化 InjectionPoint 清单和 sqlFilter 清单
            $injectPoint = new InjectPoint();
            $sqlRule = new SqlRule();
            $this->injectionPointList = $this->cleanup($injectPoint->injectionPointList);
            $this->sqlRuleList = $this->cleanup($sqlRule->sqlRuleList);
            // 检查传入的要求是否合法
            $this->setInjectionPoint();
            $this->setFilter();
        }
    }

    private function cleanup($list) {
        $tmp = array();
        foreach ($list as $key => $value) {
            $tmp = array_merge($tmp, array(explode("|", $key)[0] => $value) );
        }
        return $tmp;
    }

    private function setInjectionPoint(){
        foreach ($this->injectionPointList as $injectionPoint=>$value) {
            foreach ($this->injectionPoint as $injectionPointByUser=>$valueByUser) {
                if ($injectionPoint != $valueByUser){
                    continue;
                }else{
                    $this->injectionPoint = $this->injectionPointList[$valueByUser];
                    break;
                }
            }
        }
    }

    private function setFilter(){
        $tmp = array();
        foreach ($this->sqlRuleList as $sqlRule=>$value) {
            foreach ($this->sqlRule as $sqlRuleByUser => $valueByUser) {
                if ($sqlRule != $valueByUser){
                    continue;
                }else{
                    $tmp = array_merge($tmp, $this->sqlRuleList[$valueByUser]);
                }
            }
        }
        $this->sqlRule = $tmp;
    }

    public function render(){
        $sql = $this->injectionPoint;
        $blackList = $this->sqlRule;
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