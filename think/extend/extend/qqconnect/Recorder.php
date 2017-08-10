<?php
/* PHP SDK
 * @version 2.0.0
 * @author connect@qq.com
 * @copyright © 2013, Tencent Corporation. All rights reserved.
 */

namespace qqconnect;

use qqconnect\ErrorCase;
class Recorder
{
    private static $data;
    private $inc;
    private $error;

    public function __construct()
    {
        $this->error = new ErrorCase();

        //-------读取配置
   
        $incFileContents = '{"appid":"101416730","appkey":"8635368d39385923eaaf26b420bf1327","callback":"http://sjw.xiaoyanyanlh.cn/index/user/qqcallback","scope":"get_user_info","errorReport":true,"storageType":"file","host":"localhost","user":"root","password":"root","database":"test"}';
        $this->inc = json_decode($incFileContents);
        if(empty($this->inc)){
            $this->error->showError("20001");
        }

        if(empty($_SESSION['QC_userData'])){
            self::$data = array();
        }else{
            self::$data = $_SESSION['QC_userData'];
        }
    }

    public function write($name,$value)
    {
        self::$data[$name] = $value;
    }

    public function read($name)
    {
        if(empty(self::$data[$name])){
            return null;
        }else{
            return self::$data[$name];
        }
    }

    public function readInc($name)
    {
        if(empty($this->inc->$name)){
            return null;
        }else{
            return $this->inc->$name;
        }
    }

    public function delete($name)
    {
        unset(self::$data[$name]);
    }

    function __destruct()
    {
        $_SESSION['QC_userData'] = self::$data;
    }
}
