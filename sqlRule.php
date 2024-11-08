<?php
class SqlRule {
    public $sqlRuleList = array(
    /* Format: name|show_name => array(blacklist for input);
    [Every string will transform to lowercase automatically]
    */
    "commaFilter|逗号过滤绕过" => array(','),
    "spaceFilter|空格过滤绕过" => array(' ', '\n', '\t', '\r'),
    "equalSignFilter|等号过滤绕过" => array('='),
    "quotationMarkFilter|引号过滤绕过" => array('"', "'"),
    "logicalOperatorFilter|逻辑运算符过滤绕过" => array('and', 'or', 'not', 'xor'),
    "keywordFilter|关键词过滤绕过 " => array('users'),
    "comparisonOperatorFilter|比较运算符过滤绕过" => array('>', '<'),
    "functionFilter|函数过滤绕过" => array('sleep', 'ascii', 'group_concat', 'substr', 'union')
    );
}
