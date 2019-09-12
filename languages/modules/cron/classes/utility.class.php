<?php
class utility {

	/**
	 * 取得下拉菜单
	 */
	public static function option($a, $v=null, $all=null, $valid='id', $valname='name') {
        $option = null;
        if ( $all ){
            $selected = ($v) ? null : 'selected';
            $option .= "<option value='0' $selected>".strip_tags($all)."</option>\n";
        }

        $v = explode(',', $v);
        settype($v, 'array');
        foreach( $a AS $key=>$value )
        {
            if (is_array($value)) { 
                $key = strval($value[$valid]);
                $value = strval($value[$valname]); 
            }
            $selected = in_array($key, $v) ? 'selected' : null;
            $option .= "<option value='{$key}' {$selected}>".strip_tags($value)."</option>\n";
        }

        return $option;
    }
	
	static public function OptionArray($a=array(), $c1, $c2) {
        if (empty($a)) return array();
        $s1 = self::GetColumn($a, $c1);
        $s2 = self::GetColumn($a, $c2);
        if ( $s1 && $s2 && count($s1)==count($s2) ) {
            return array_combine($s1, $s2);
        }
        return array();
    }
}
?>