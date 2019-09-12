<?php 
header("Content-type: text/html; charset=utf-8"); 
//此处为防盗用设置，请把url换成你自己的
//if(!(strpos($_SERVER['HTTP_REFERER'],'http://www.05273.cn')===0 || strpos($_SERVER['HTTP_REFERER'],'http://05273.cn')===0 || strpos($_SERVER['HTTP_REFERER'],'https://www.05273.cn')===0)){echo "Welcome to IP address library system for 05273.cn";exit;}
function getIP(){ 
    if (isset($_SERVER)) { 
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
            $realip = $_SERVER['HTTP_X_FORWARDED_FOR']; 
                } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) { 
                    $realip = $_SERVER['HTTP_CLIENT_IP']; 
                } else { 
                    $realip = $_SERVER['REMOTE_ADDR']; 
        } 
    } else { 
        if (getenv("HTTP_X_FORWARDED_FOR")) { 
            $realip = getenv( "HTTP_X_FORWARDED_FOR"); 
                } elseif (getenv("HTTP_CLIENT_IP")) { 
                   $realip = getenv("HTTP_CLIENT_IP"); 
                } else { 
                   $realip = getenv("REMOTE_ADDR"); 
        } 
    } 
        return $realip; 
    } 
    $ip = getIP(); 
    $url = 'http://iplocation.geo.qiyi.com/cityjson?ip='.$ip; 
    $ch = curl_init($url); 
    curl_setopt($ch,CURLOPT_ENCODING ,'utf-8'); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ;
    $location = curl_exec($ch); 
    //$location = json_decode($location); 
    $location = preg_match('/returnIpCity ={"code":"(.*)", "data": {"country":"(.*)", "province":"(.*)", "city":"(.*)", "country_id":(.*), "province_id":(.*), "city_id":(.*), "location_id":(.*), "isp_id":(.*), "isp":"(.*)", "ip":"(.*)"}}/', $location, $info);
    //$array=get_object_vars($location);
    //$info=get_object_vars($array[data]);
    curl_close($ch); 
?>var IPData = new Array("<?php echo $ip?>","<?php echo $info[2]?>","<?php echo $info[3]?>","<?php echo $info[4]?>");