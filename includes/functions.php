<?PHP

function open_template( $f = "main.html", $arr = array() )
{
    $retval=false;
    $theData="";
    $myFile = "template/" . $f;
    if (file_exists($myFile))
    {
        $fh = fopen($myFile, 'r');
        $theData = fread($fh, filesize($myFile));
        fclose($fh);
        //
        //		Optional
        //
        if (empty($arr['TITLE']))
        {
            $theData = str_ireplace("{TITLE}", "", $theData);
        }

        foreach ($arr as $key => $value)
        {
            if (is_array($value))
            {
                $theData = str_ireplace("{" . $key . "}", implode(",", $value) , $theData);
            }
            else
            {
                $theData = str_ireplace("{" . $key . "}", $value , $theData);
            }
        }

        echo $theData;
        $retval=true;
    }
    return $retval;
}

function read_template( $f = "main.html", $arr = array() )
{

    $theData="";
    $myFile = "template/" . $f;
    if (file_exists($myFile))
    {
        $fh = fopen($myFile, 'r');
        $theData = fread($fh, filesize($myFile));
        fclose($fh);

        //
        //		Optional
        //
        if (empty($arr['TITLE']))
        {
            $theData = str_ireplace("{TITLE}", "", $theData);
        }

        foreach ($arr as $key => $value)
        { $theData = str_ireplace("{" . $key . "}", $value , $theData); }
    }
    return $theData;
}

function format_phone($phone)
{
    $retval=$phone;
    $phone = preg_replace("/[^0-9]/", "", clean_phone($phone));
    $i = strlen($phone);
    switch ($i)
    {
        case 7:
            $retval=preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
            break;

        case 8:
            $retval=preg_replace("/([0-9]{4})([0-9]{4})/", "$1-$2", $phone);
            break;

        case 9:
            $retval=preg_replace("/([0-9]{2})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
            break;

        case 10:
            if (substr($phone,0,2)=='04')
            {
                $retval=preg_replace("/([0-9]{4})([0-9]{3})([0-9]{3})/", "($1) $2-$3", $phone);
            }
            else
            {
                if (substr($phone,0,4)=='1800' || substr($phone,0,4)=='1300')
                {
                    $retval=preg_replace("/([0-9]{4})([0-9]{3})([0-9]{3})/", "($1) $2-$3", $phone);
                }
                else
                {
                    $retval=preg_replace("/([0-9]{2})([0-9]{4})([0-9]{4})/", "($1) $2-$3", $phone);
                }
            }
            break;

        case 11:
            $retval=preg_replace("/([0-9]{3})([0-9]{4})([0-9]{4})/", "$1 $2-$3", $phone);
            break;

        default:
            $retval=$phone;
            break;
    }
    return $retval;
}

function clean_phone( $i )
{
    $retval = str_replace("+","",$i);
    $retval = str_replace(" ","",$i);
    $retval = str_replace("-","",$retval);
    $retval = str_replace("(","",$retval);
    $retval = str_replace(")","",$retval);
    $retval = str_replace("-","",$retval);
    return $retval;
}

function cleanjavascript( $msg )
{
    $result = str_replace('"','\"', $msg);
    $result = str_replace("\r\n","", $result);
    $result = str_replace("\n","", $result);
    $result = str_replace("\t","", $result);
    $result = str_replace("&#x0D;","", $result);
    $result = str_replace('  ',' ', $result);
    return $result;
}

function smart_trim( $str, $s=200 )
{
    $retval=$str;
    if (strlen($str)>$s)
    {
        if ($pos = strpos($str, " ", $s))
        {
            $retval=substr($str,0, $pos);
        }
    }
    return $retval;
}

function subval_sort($a, $subkey, $order='ASC') {

    if ($order=='ASC')
    {
        foreach($a as $k=>$v) {
            $b[$k] = strtolower($v[$subkey]);
        }
        asort($b);
        foreach($b as $key=>$val) {
            $c[] = $a[$key];
        }
    }
    else
    {
        foreach($a as $k=>$v) {
            $b[$k] = strtolower($v[$subkey]);
        }
        arsort($b);
        foreach($b as $key=>$val) {
            $c[] = $a[$key];
        }
    }
    return $c;
}

function fixnumber( $amt)
{
    $amt=str_replace(",","",$amt);
    $amt=str_replace("%","",$amt);
    $amt=str_replace("$","",$amt);
    $amt=str_replace("#DIV/0!","0",$amt);
    return $amt;
}

function in_array_r($item , $array){
    return preg_match('/"'.$item.'"/i' , json_encode($array));
}

function field_mapping_title($item , $array){
    $retval='';
    foreach($array as $row)
    {
        if ($row['name']==$item)
        {
            $retval=$row['title'];
            break;
        }

    }
    return $retval;
}
function field_mapping_lookup($item , $array){
    $retval='';
    foreach($array as $row)
    {
        if ($row['name']==$item)
        {
            $retval=$row['lookup'];
            break;
        }

    }
    return $retval;
}

function fnord ( $n )
{
    $retval='';
    $i=substr($n,-1);
    switch ($i)
    {
        case 1:
            $retval=$n.'st';
            break;
        case 2:
            $retval=$n.'nd';
            break;
        case 3:
            $retval=$n.'rd';
            break;
        default:
            $retval=$n.'th';
            break;

    }
    return $retval;

}
?>