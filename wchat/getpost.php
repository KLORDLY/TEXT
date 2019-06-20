<?php  
/** 
  * wechat php test 
  */  
  
//define your token  
define("TOKEN", "ThreeZ");  
$wechatObj = new wechatCallbackapiTest();  
//验证token
// $wechatObj->valid();  
  
  //调用消息处理函数
$wechatObj ->responseMsg();

class wechatCallbackapiTest  
{  
    public function valid()  
    {  
        $echoStr = $_GET["echostr"];  
  
        //valid signature , option  
        if($this->checkSignature()){  
            echo $echoStr;  
            exit;  
        }  
    }  
  
  //响应消息处理函数
    public function responseMsg()  
    {  
        //get post data, May be due to the different environments 
        //获取全局的消息 
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];  
  
        //extract post data  
        //判断消息是否为空
        if (!empty($postStr)){  
                  //进行解析
        		libxml_disable_entity_loader(true);
                $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA); 

                //获取openid
                $openid=trim($postObj->FromUserName);
                //发送的内容
                 $content=trim($postObj->Content);
                //获取addid（小程序开发者文档获取）
				$appid="wx4f7011956fa7834a";
				//获取secret（小程序开发者文档获取）
				$secret="9b31bfe0cb03e567f322de942b660784";

				 //获取ACCESS_TOKEN接口，（微信开发者文档查找）
				$getTokenApi="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$secret}";

				//调用httpGet请求，通过get获取ACCESS_TOKEN
				$resultStr=$this->httpGet($getTokenApi);
				//进行解析（得到的access_token是json数据包的格式，我们把他转化为数组）
				$arr=json_decode($resultStr,true);
				//获取最后的access_token
				$token=$arr["access_token"];

				//发送客户消息(小程序开发文档查找)
				$postMsgApi="https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$token}";

				//进行关键字判断
				if($content=="你好"){
					//进行解析，因为发送的数据为json数据包的格式，我们把他转化为数组。
					$data=array("touser"=>$openid, "msgtype"=> "text","text"=>array("content"=>"好的"));
				}elseif ($content=="再见") {
					$data=array("touser"=>$openid, "msgtype"=> "text","text"=>array("content"=>"嗯"));
				}elseif ($content=="我我我") {
					$data=array("touser"=>$openid, "msgtype"=> "text","text"=>array("content"=>"哦"));
				}else{
					$data=array("touser"=>$openid, "msgtype"=> "text","text"=>array("content"=>"搜索不到"));
				}

				//对content进行编码转换
				foreach ($data as $key => $value) {
					$data["text"]["content"]=urlencode($value["content"]);
				}

				//对数组转化为json数据包的格式
				$json=urldecode(json_encode($data));

				//通过post请求发送
				$str=$this->httpPost($json,$postMsgApi);

				echo str;
        }
        else
        {  
            echo "";  
            exit;  
        }  
    }  
         
        //获取POST请求
     public function httpPost($data,$url){
         $ch = curl_init();
         curl_setopt($ch,CURLOPT_URL,$url);
         curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"POST");
         curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
         curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (compatible;MSIE 5.01;windows NT 5.0)');
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_AUTOREFERER,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $tmpInfo=curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return $tmpInfo;

    }
    //获取Get请求
   public function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
    curl_setopt($curl, CURLOPT_URL, $url);
    $res = curl_exec($curl);
    curl_close($curl);
    return $res;
    } 

    private function checkSignature()  
    {  
        $signature = $_GET["signature"];  
        $timestamp = $_GET["timestamp"];  
        $nonce = $_GET["nonce"];      
                  
        $token = TOKEN;  
        $tmpArr = array($token, $timestamp, $nonce);  
        sort($tmpArr);  
        $tmpStr = implode( $tmpArr );  
        $tmpStr = sha1( $tmpStr );  
          
        if( $tmpStr == $signature ){  
            return true;  
        }else{  
            return false;  
        }  
    }  
}  
  
?>  