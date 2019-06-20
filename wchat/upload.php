<?php
    //初始化sae方法
    $s=new SaeStorage();
    //转换为二进制
    ob_start();
    //读文件
    readfile($_FILES['upfile']['tmp_name']);
    //选择文件
    $img=ob_get_contents();
    //清除图片
    ob_end_clean();
    //获取文件大小
    file_put_contents(SAE_TMP_PATH."/bg.png",$img);
    //判断,first 是对应的Storage里面储存的东西的
    if($s->upload('first','second.png',SAE_TMP_PATH."/bg.png")){
        echo '上传成功';
    }else{
        echo '上传失败';
    }
?>