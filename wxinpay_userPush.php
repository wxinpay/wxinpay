<?php

header("Content-Type:text/html;charset=utf-8");
require_once("./phpmailer/functions.php");

$con = mysql_connect("数据库m地址","数据库用户名","数据库密码");
if (!$con)
{
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("表名称", $con);

if (!isset($_POST["orderID"])){
    $arrBack = array(
        "code" => '202',
        "msg" => '请输入订单号（orderID）',
        "data" => 'not orderID'
    );
    echo json_encode($arrBack);
    return;
}elseif (!isset($_POST["wxSure"])){
    $arrBack = array(
        "code" => '202',
        "msg" => '请输入确认信息 2确认支付了 或者 3取消支付了（wxSure）',
        "data" => 'not wxSure'
    );
    echo json_encode($arrBack);
    return;
}else{
    $resultOrders = mysql_query("SELECT * FROM 表名称 where id = $_POST[orderID]");

    $resID = mysql_num_rows($resultOrders);

    if ($_POST[wxSure] == '3'){
        if($resID < 1){

            $arrBack = array(
                "code" => '202',
                "msg" => '数据库查不到orderID='.$_POST[orderID],
                "data" => 'NO orderID = '.$_POST[orderID]
            );
            echo json_encode($arrBack);
            return;

        }else{


            $arrBack = array(
                "code" => '200',
                "msg" => '取消支付成功！订单为'.$_POST[orderID],
                "data" => 'YES'
            );
            echo json_encode($arrBack);
            return;
        }


    }elseif ($_POST[wxSure] == '2'){

        if($resID < 1){

            $arrBack = array(
                "code" => '202',
                "msg" => '数据库查不到orderID='.$_POST[orderID],
                "data" => 'NO orderID = '.$_POST[orderID]
            );
            echo json_encode($arrBack);
            return;

        }else{
            $orders = mysql_fetch_array($resultOrders);
            $wxID = $orders['wxID'];

            $resultWXArray = mysql_query("SELECT * FROM 表名称 where id like $wxID");

            $resultWX = mysql_fetch_array($resultWXArray);

            $wxRemark = $resultWX['wxRemark'];
            $wxMoney = $resultWX['wxMoney'];


           

        }


    }else{
        $arrBack = array(
            "code" => '202',
            "msg" => 'wxSure状态不正确 2提交支付成功审核，3取消支付 (wxSure)',
            "data" => 'wxSure isNot 2/3'
        );
        echo json_encode($arrBack);
        return;
    }

}

mysql_close($con)
?>
