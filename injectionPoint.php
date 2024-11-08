<?php
class InjectPoint {
    public $injectionPointList =  array(
        // Format: name|show_name => SQL Condition; [use @ for injection point]
        // sql condition 必须外面双引号，里面单引号(如果有的话)
    "injectInNum_s|数字型注入 (select)" => "select * from users where id=@",
    "injectInString_s|字符型注入 (select)" => "select * from users where name='@'",
    "injectInOrderBy_s|order by 注入 (select) " => "select * from users order by '@'"
    );
}
