<?php
$con = mysql_connect("数据库地址","数据库用户","密码");
if (!$con)
{
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("数据库", $con);



if (!isset($_POST["wxSure"])){
    $arrBack = array(
        "code" => '202',
        "msg" => '请输入wxSure（wxSure）',
        "data" => 'wxSure is not'
    );
    echo json_encode($arrBack);
    return;
}elseif ($_POST["wxSure"] == '1' || $_POST["wxSure"] == '2'|| $_POST["wxSure"] == '3'|| $_POST["wxSure"] == '4'|| $_POST["wxSure"] == '5'){


    $resultArray = mysql_query("SELECT * FROM 表名称 where 字段 like $_POST[wxSure]");


    $res = mysql_num_rows($resultArray);

    if($res < 1){

        $arrBack = array(
            "code" => '202',
            "msg" => '暂无数据',
            "data" => 'not goods'
        );
        echo json_encode($arrBack);
        return;

    }else{
        $arr;
        while ($row = mysql_fetch_array($resultArray)) {
            $arr[] = array(
                "id" => $row['id'],

            );
        }
        echo json_encode($arr);
    }





}else{
    $arrBack = array(
        "code" => '202',
        "msg" => 'wxSure请传入1-5（wxSure）',
        "data" => 'wxSure is not 1-5'
    );
    echo json_encode($arrBack);
    return;
}
mysql_close($con)
?>
