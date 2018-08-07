<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 18/7/18
 * Time: 5:34 PM
 */
$GLOBALS['session_instance'] = null;
const DEFAULT_SESSION_SEGMENT_NAME = 'session_segment';

if(!function_exists('gaga_indicator_init')){
    /**
     * @param $elementId
     * @param int $CONSUL
     * @param int $DIPLOMAT
     * @param int $AMBASSADOR
     * @param int $PREMIER
     * @param int $max
     * @return string
     */
    function gaga_indicator_init($elementId,$CONSUL=12000,$DIPLOMAT=22000,$AMBASSADOR=27000,$PREMIER=38000,$max=50000){
        $min=0;
        $gage_indicators = "";
        $gage_indicators .= "generateGageIndicator('$elementId', " . ($CONSUL / $max) * 100 . ", '#525357', 'Consul');";
        $gage_indicators .= "generateGageIndicator('$elementId', " . ($DIPLOMAT / $max) * 100 . ", '#BC2628', 'Diplomat');";
        $gage_indicators .= "generateGageIndicator('$elementId', " . ($AMBASSADOR / $max) * 100 . ", '#546E22', 'Ambassador');";
        $gage_indicators .= "generateGageIndicator('$elementId', " . ($PREMIER / $max) * 100 . ", '#B47C37', 'Premier');";
        return $gage_indicators;
    }
}

if(!function_exists('ordinal')){
    function ordinal($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }
}

if(!function_exists('get_month_array')){

    function get_months_array(){
        return [
            'APR','MAY','JUN','JUL',
            'AUG','SEP','OCT','NOV',
            'DEC','JAN','FEB','MAR'
        ];
    }
}

if(!function_exists('uploaded_file_path')){
    /**
     * 创建 uploads 目录中文件的快捷方法. 如果给定的参数为 null, 则仅返回到 uploads 目录的绝对路径
     * Easy way to build file's path in uploads folder
     * @param null $filePath
     * @return array|bool|false|string
     */
    function uploaded_file_path($filePath=null){
        return env('PUBLIC_UPLOADS_PATH_ROOT').$filePath;
    }
}

if(!function_exists('convert_array_to_js_2_dimension_array')){
    /**
     * 把一维度的数组, 转成 js 的二维数组
     * @param array $data 键值对的数组
     * @return string
     */
    function convert_array_to_js_2_dimension_array($data){
        array_walk(
            $data,
            function(&$value, $key){
                $value = "['$key',$value]";
            }
        );
        return '[' . implode(',', $data) . ']';
    }
}

if(!function_exists('env')){
    /**
     * @param $key
     * @param bool $default
     * @return array|bool|false|string
     */
    function env($key, $default=false){
        $dotenv = new \Dotenv\Dotenv(__DIR__);
        $dotenv->load();
        $result = getenv($key);
        if($result === 'false'){
            $result = false;
        }
        if($result === 'true'){
            $result = true;
        }
        return $result ? $result : $default;
    }
}

if(!function_exists('random_str')){
    /**
     * Generate a random string as uuid
     * @param null $salt
     * @return string
     */
    function random_str($salt=null){
        if(is_null($salt))
            $salt = env('SALT','L=kGL*y^Cv3YYs5Lq2k_wZQxtjS5_Y$LFaJJ%MdC+#NpbAZ#PaZtNJ2!HmffXTsc');
        return md5($salt.time());
    }
}

if(!function_exists('session_set')){
    /**
     * Set or get value from session by key
     * @param null $key
     * @param string|array|null $val
     * @return mixed
     */
    function session_set($key=null, $val = null){
        $session = get_session_instance();
        $segment = $session->getSegment(env('SESSION_SEGMENT',DEFAULT_SESSION_SEGMENT_NAME));
        if(is_array($val)){
            // Turn to json form string if array is given
            $val = json_encode($val);
        }
        $segment->set($key,$val);
        // commit to save at the end
        $session->commit();
        return $session;
    }
}

if(!function_exists('session_get')){
    /**
     * get value in session flash
     * @param null $key
     * @param bool $isJsonString
     * @return mixed
     */
    function session_get($key=null, $isJsonString=false){
        $session = get_session_instance();
        $segment = $session->getSegment(env('SESSION_SEGMENT',DEFAULT_SESSION_SEGMENT_NAME));
        $result = $segment->get($key);
        return $isJsonString ? json_decode($result, true) : $result;
    }
}

if(!function_exists('session_flash')){
    /**
     * Set or get value in session flash
     * @param null $key
     * @param null $val
     * @return mixed
     */
    function session_flash($key=null, $val = null){
        $session = get_session_instance();
        if(is_null($val)){
            return $session->getSegment(env('SESSION_SEGMENT',DEFAULT_SESSION_SEGMENT_NAME))
                ->getFlash($key,null);
        }else{
            $session->getSegment(env('SESSION_SEGMENT',DEFAULT_SESSION_SEGMENT_NAME))
                ->setFlashNow($key, $val);
            $session->commit();
        }
    }
}

if(!function_exists('get_session_instance')){
    /**
     * Get session instance
     * @param null $driver
     * @return \Aura\Session\Session
     */
    function get_session_instance($driver = null){
        if(is_null($GLOBALS['session_instance'])){
            $session_factory = new \Aura\Session\SessionFactory();
            $GLOBALS['session_instance'] = $session_factory->newInstance($_COOKIE);
        }
        return $GLOBALS['session_instance'];
    }
}

if(!function_exists('view_path')){
    /**
     * Build absolute file path for view files. If $filePath is null, return the root of view files folder
     * @param null $filePath
     * @return string
     */
    function view_path($filePath = null){
        $vPath = env('VIEW_PATH');
        if($filePath){
            if(strpos($filePath, '/') === 0){
                // if the give file path start with /, then remove it
                $filePath = substr($filePath, 1);
            }
            if(strpos($filePath,'.twig') === false){
                $filePath .= '.twig';
            }
        }
        return $filePath ? $vPath.$filePath : $vPath;
    }
}

if(!function_exists('cache_path')){
    /**
     * Build absolute path for twig cache
     * @return bool|string
     */
    function cache_path(){
        $appPath = env('APP_PATH',false);
        if($appPath){
            return $appPath.env('CACHE_PATH','cache');
        }else{
            return false;
        }
    }
}

if(!function_exists('asset')){
    /**
     * Build absolute url for js, css and images
     * @param $filePath
     * @return string
     */
    function asset($filePath){
        if(strpos($filePath,'/') === 0){
            $filePath = substr($filePath,1);
        }
        return env('SITE_URL').$filePath;
    }
}

if(!function_exists('url')){
    /**
     * Build url for js, css and images
     * @param string $uri
     * @param array $params
     * @return string
     */
    function url($uri=null, $params = []){
        if(strpos($uri,'/') === 0){
            $uri = substr($uri,1);
        }
        $paramsString = '';
        if(is_array($params)) {
            if (count($params) > 0) {
                $paramsString = '?' . http_build_query($params);
            }
        }
        return env('SITE_URL').$uri.$paramsString;
    }
}

if(!function_exists('dump')){
    function dump($str){
        echo '<pre>';
        var_dump($str);
        echo '</pre>';
    }
}

if(!function_exists('dd')){
    function dd($str){
        dump($str);
        die();
    }
}

if(!function_exists('_transformWhereCondition')){
    /**
     * To use Medoo ORM, need this function to transform the where conditions to Medoo convention.
     * For example:
     * ['name','John'] to ['name'=>'John']
     * ['name','<>','John'] to ['name[<>]'=>'John']
     * @param array $conditions
     * @return array
     */
    function _transformWhereCondition($conditions){
        $where = [];
        if(count($conditions) === 1){

        }
        foreach ($conditions as $key=>$param) {
            if(is_string($key)){
                $key = strtoupper($key);
                if($key === 'AND' || $key === 'OR'){

                }
            }else{
                if(is_array($param)){
                    if(count($param) === 2){
                        // Such as 'name'=>'John', means: name='John'. So keep as it is
                        $where[$param[0]] = $param[1];
                    }elseif (count($param) === 3){
                        $where[$param[0].'['.$param[1].']'] = $param[2];
                    }
                }
            }
        }
        return $where;
    }
}