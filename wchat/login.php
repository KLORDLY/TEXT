<?php

//����code������ǰ̨��������code��code���û��ĵ�¼ƾ֤����Ч������ӣ�����������Ҫ�ڿ����߷�������̨���� auth.code2Session��ʹ�� code ��ȡ openid ���û�Ψһ��ʶ���� session_key ���Ự��Կ������Ϣ
$code=$_GET["code"];
//��ȡaddid��С���򿪷����ĵ���ȡ��
$appid="wx4f7011956fa7834a";
//��ȡsecret��С���򿪷����ĵ���ȡ��
$secret="9b31bfe0cb03e567f322de942b660784";
//api,���õĵ��� auth.code2Session�ӿڵ�ַ,Ȼ��Ѷ�Ӧ�ĵط�����{...}
$api="https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$secret}&js_code={$code}&grant_type=authorization_code";

//��ȡGet����
   function httpGet($url) {
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

//���͵Ĵ���,��api���͵�������
$str=httpGet($api);

//���������str
echo $str;

?>