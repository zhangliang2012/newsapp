<?php
namespace app\admin\controller;

use app\admin\lib\Auth;

class Admin extends Base
{
    public function add()
    {
        if(request()->isPost()){//2、处理post表单
            //4、过滤数据、验证数据
            $data = input('post.');
            if(model('AdminUser')->get(array('username'=>$data['username']))){
                return json(array('status'=>5,'mes'=>'用户已存在'));
            }

            $res = $this->validate($data,'AdminUser');//验证数据
            if(true !== $res){
               return json(array('status'=>5,'mes'=>$res));//验证不通过返回不通过的信息
            }

            $data['password'] = Auth::setPassword($data['password']);
            $data['status'] = 1;
            try{
                $id = model('AdminUser')->add($data);
            }catch (\Exception $e){
                return json(array('status'=>5,'mes'=>$e->getMessage()));
            }
            if($id){
                return json(array('status'=>6,'mes'=>'id='.$id.'的用户新增成功'));
            }else{
                return json(array('status'=>5,'mes'=>'id='.$id.'的用户新增失败'));
            }
        }
        return $this->fetch();//1、显示添加管理员模板
    }

    public function lst()
    {
        return $this->fetch();
    }

    public function edit()
    {
        return $this->fetch();
    }

    public function generatorSign()//签名
    {
        /**
         * 使用下面三条命令生成公钥和密钥对
         *  openssl genrsa -out rsa_private_key.pem 1024
            openssl pkcs8 -topk8 -inform PEM -in rsa_private_key.pem -outform PEM -nocrypt -out private_key.pem
            openssl rsa -in rsa_private_key.pem -pubout -out rsa_public_key.pem
         */
        $data = "大好人";//测试数据

        $privaliteKeyFile = 'zhangliang';//私钥路径
        $privalitePassword = "";//私钥密码

        $digestAlgo = 'md5';//摘要的算法
        $algo = OPENSSL_ALGO_SHA1;//签名的算法

        $privaliteKey = openssl_pkey_get_private(file_get_contents($privaliteKeyFile),$privalitePassword);//加载私钥

        $digest = openssl_digest($data,$digestAlgo);//生成摘要

        //签名
        $sign = '';
        openssl_sign($digest, $sign, $privaliteKey, $algo);
        $sign = base64_encode($sign);
        dump($sign);

    }

    public function checkSign()//验签
    {
        $data = "大好人";//测试数据

        $publicKeyFile = "zhangliang.pub";//公钥路径



        //摘要及签名算法需要和签名时算法保持一致
        $digestAlgo = 'md5';//摘要的算法
        $algo = OPENSSL_ALGO_SHA1;//签名的算法

        $publicKey = openssl_pkey_get_public(file_get_contents($publicKeyFile));//加载公钥

        $digest = openssl_digest($data,$digestAlgo);//生成摘要

        //签名生成的base64加密的数据
        $sign = base64_decode("DE1DZI9WKofYKZiCJVXAo4Q8M23ab+6nCfO/cjiyI5s9g/p+S9eHENX9JTfTxXJgIW0Vshxb1zeQYqwABhC63J29FXVWql1ykzIr/G4ZkxOq8tjIhR1iVmLfKqOMYVvDPhZ0+094lcbiaAvkPeVjMGO7Sb4BLJLn1GxHIHn9NMQ=");

        //验签
        $verify = openssl_verify($digest, $sign, $publicKey, $algo);

        dump($verify);//$verify    int(1)   表示验证成功
    }

    public function encryptData()//非对称加密
    {
        $data = "好人";//测试数据

        $publicKeyFile = "zhangliang.pub";//公钥路径

        $publicKey = openssl_pkey_get_public(file_get_contents($publicKeyFile));//加载公钥

        //使用公钥进行加密
        $encryptData = '';
        openssl_public_encrypt($data, $encryptData, $publicKey);

        var_dump(base64_encode($encryptData));//加密数据
    }

    public function decryptData()//解密
    {
        $encryptData = base64_decode('JDbC1INzzSIQjwSlYFMdw/mbdLs+SjVNzPGN8xmQJ6IWN9R2Vc/zD519uSJCPvaVfQ1OMS9kq1MQdt6KLz4oa6Ponor1OsYiJbNyQBkcIqSUz9h2xr6v7DDL+Z3QcKyrQGz4fcxj8iLuPUU02qKkdcURlg+Iq3Nixkctys4pMBE=');

        $privaliteKeyFile = 'zhangliang';//私钥路径
        $privalitePassword = "";//私钥密码

        $privaliteKey = openssl_pkey_get_private(file_get_contents($privaliteKeyFile),$privalitePassword);//加载私钥

        //使用私钥进行解密
        $data = '';
        openssl_private_decrypt($encryptData, $data, $privaliteKey);
        dump($data);//解密后的数据
    }

}
