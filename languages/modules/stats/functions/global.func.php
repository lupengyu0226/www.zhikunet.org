<?php
function aweek($gdate = "", $first = 0){
 if(!$gdate) $gdate = date("Y-m-d");
 $w = date("w", strtotime($gdate));//取得一周的第几天,星期天开始0-6
 $dn = $w ? $w - $first : 6;//要减去的天数
 //本周开始日期
 $st = date("Y-m-d", strtotime("$gdate -".$dn." days"));
 //本周结束日期
 $en = date("Y-m-d", strtotime("$st +6 days"));
 //上周开始日期
 $last_st = date('Y-m-d',strtotime("$st - 7 days"));
 //上周结束日期
 $last_en = date('Y-m-d',strtotime("$st - 1 days"));
 return array($st, $en,$last_st,$last_en);//返回开始和结束日期
}