<?php  
/** 
  * wechat php test 
  */  
  
//define your token  
define("TOKEN", "ThreeZ");  
$wechatObj = new wechatCallbackapiTest();  
//��֤token
// $wechatObj->valid();  
  
  //������Ϣ������
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
  
  //��Ӧ��Ϣ������
    public function responseMsg()  
    {  
        //get post data, May be due to the different environments 
        //��ȡȫ�ֵ���Ϣ 
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];  
  
        //extract post data  
        //�ж���Ϣ�Ƿ�Ϊ��
        if (!empty($postStr)){  
                  //���н���
        		libxml_disable_entity_loader(true);
                $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA); 

                //��ȡopenid
                $openid=trim($postObj->FromUserName);
                //���͵�����
                 $content=trim($postObj->Content);
                //��ȡaddid��С���򿪷����ĵ���ȡ��
				$appid="wx4f7011956fa7834a";
				//��ȡsecret��С���򿪷����ĵ���ȡ��
				$secret="9b31bfe0cb03e567f322de942b660784";

				 //��ȡACCESS_TOKEN�ӿڣ���΢�ſ������ĵ����ң�
				$getTokenApi="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$secret}";

				//����httpGet����ͨ��get��ȡACCESS_TOKEN
				$resultStr=$this->httpGet($getTokenApi);
				//���н������õ���access_token��json���ݰ��ĸ�ʽ�����ǰ���ת��Ϊ���飩
				$arr=json_decode($resultStr,true);
				//��ȡ����access_token
				$token=$arr["access_token"];

				//���Ϳͻ���Ϣ(С���򿪷��ĵ�����)
				$postMsgApi="https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$token}";

				//���йؼ����ж�
				if($content=="���"){
					//���н�������Ϊ���͵�����Ϊjson���ݰ��ĸ�ʽ�����ǰ���ת��Ϊ���顣
					$data=array("touser"=>$openid, "msgtype"=> "text","text"=>array("content"=>"�õ�"));
				}elseif ($content=="�ټ�") {
					$data=array("touser"=>$openid, "msgtype"=> "text","text"=>array("content"=>"��"));
				}elseif ($content=="������") {
					$data=array("touser"=>$openid, "msgtype"=> "text","text"=>array("content"=>"Ŷ"));
				}else{
					$data=array("touser"=>$openid, "msgtype"=> "text","text"=>array("content"=>"��������"));
				}

				//��content���б���ת��
				foreach ($data as $key => $value) {
					$data["text"]["content"]=urlencode($value["content"]);
				}

				//������ת��Ϊjson���ݰ��ĸ�ʽ
				$json=urldecode(json_encode($data));

				//ͨ��post������
				$str=$this->httpPost($json,$postMsgApi);

				echo str;
        }
        else
        {  
            echo "";  
            exit;  
        }  
    }  
         
        //��ȡPOST����
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
    //��ȡGet����
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