<?php
    //��ʼ��sae����
    $s=new SaeStorage();
    //ת��Ϊ������
    ob_start();
    //���ļ�
    readfile($_FILES['upfile']['tmp_name']);
    //ѡ���ļ�
    $img=ob_get_contents();
    //���ͼƬ
    ob_end_clean();
    //��ȡ�ļ���С
    file_put_contents(SAE_TMP_PATH."/bg.png",$img);
    //�ж�,first �Ƕ�Ӧ��Storage���洢��Ķ�����
    if($s->upload('first','second.png',SAE_TMP_PATH."/bg.png")){
        echo '�ϴ��ɹ�';
    }else{
        echo '�ϴ�ʧ��';
    }
?>