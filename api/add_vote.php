<?php
include_once "../db.php";

$sql_chk_subject="select count(*) from `topics` where subject='{$_POST['subject']}'";
$chk=$pdo->query($sql_chk_subject)->fetchColumn();

$image='';
if(!empty($_FILES['img']['tmp_name'])){
    if(in_array($_FILES['img']['type'],['image/jpeg','image/png','image/gif'])){
        move_uploaded_file($_FILES['img']['tmp_name'],'../upload/'.$_FILES['img']['name']);
        $image=$_FILES['img']['name'];
    }else{
        header("location:../backend.php?do=add_vote&error=非圖片格式");
        exit();
    }
}

if($chk>0){
    echo "此主題已被使用過,請修改主題內容";
    echo "<a href='../back/add_vote.php'>返回新增主題</a>";
}else{
 
    $Topic->save('topics',['subject'=>$_POST['subject'],
                   'open_time'=>$_POST['open_time'],
                   'close_time'=>$_POST['close_time'],
                   'type'=>$_POST['type'],
                   'image'=>$image,
                   'login'=>$_POST['login']]);

    $Option->find('topics',['subject'=>$_POST['subject']])['id'];
    
    //echo $subject_id;

    foreach($_POST['description'] as $desc){
        if($desc!=''){
        
            $Option->save('options',['description'=>$desc,'subject_id'=>$subject_id]);
        }
    }
}
header("location:../backend.php");