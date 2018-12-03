<?php

date_default_timezone_set('Asia/Shanghai');



$con = mysql_connect("数据库地址","数据库名称","数据库密码");
if (!$con)
{
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("表名称", $con);



if (!isset($_POST["userName"])){
    $arrBack = array(
        "code" => '202',
        "msg" => '请输入昵称（userName）',
        "data" => 'not userName'
    );
    echo json_encode($arrBack);
    return;
}elseif (!isset($_POST["goodsID"])){
    $arrBack = array(
        "code" => '202',
        "msg" => '请选择类型（goodsID）',
        "data" => 'not goodsID'
    );
    echo json_encode($arrBack);
    return;
}elseif (!isset($_POST["userEmail"])){
    $arrBack = array(
        "code" => '202',
        "msg" => '请输入邮件（userEmail）',
        "data" => 'not userEmail'
    );
    echo json_encode($arrBack);
    return;
}elseif (!isset($_POST["userRemark"])){
    $arrBack = array(
        "code" => '202',
        "msg" => '请输入备注信息（userRemark）',
        "data" => 'not userRemark'
    );
    echo json_encode($arrBack);
    return;
}else{


    $goodsArray = mysql_query("SELECT * FROM 表名称 where id like $_POST[goodsID]");
    $rowGoods = mysql_fetch_array($goodsArray);
    $goodsPrice = $rowGoods['goodsPrice'];
    $goodsName = $rowGoods['goodsName'];
    $result = mysql_query("SELECT * FROM 表名称 where 字段1 like 0 and 字段2 like $goodsPrice");

    $res = mysql_num_rows($result);

    if($res < 1){

        $arrBack = array(
            "code" => '202',
            "msg" => '数据库暂时没有此价格收款码了 价格为 = '.$goodsPrice,
            "data" => 'not have '.$goodsPrice.'qrCode'
        );
        echo json_encode($arrBack);
        return;

    }else {
        $arr = array();

        while ($row = mysql_fetch_array($result)) {
            $arr = array(
                "wxID" => $row['id'],
            );
            break;
        }
        $currentDate = date("Y-m-d H:i:s");=
        $sql = "INSERT INTO 表名称 (userName, goodsID, userEmail, userRemark, wxID, wxSure, wxRemark, orderTime, wxQRCodeStr, wxQRCodePng, wxMoney, goodsPrice, goodsName)
              VALUES
              ('$_POST[userName]','$_POST[goodsID]','$_POST[userEmail]','$_POST[userRemark]','$arr[wxID]','1','$arr[wxRemark]','$currentDate','$arr[wxQRCodeStr]','$arr[wxQRCodePng]','$arr[wxMoney]','$goodsPrice','$goodsName')";

        if (!mysql_query($sql, $con)) {
            die('Error: ' . mysql_error());

        } else {


=
            $insterID = mysql_insert_id();

            $arrBack = array (
                "code" => '200',
                "msg" => '订单生成成功',
                "data" => array("orderID" => $insterID, "wxQRCodePng" => $row['wxQRCodePng'])
            );

            mysql_query("UPDATE 表名称 SET wxSure = '1' WHERE 字段名称 = $arr[wxID]");
            echo json_encode($arrBack);
        }

    }








}
mysql_close($con)
?>
