<?php
$con = mysql_connect("数据库","用户名","密码");
if (!$con)
{
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("数据库名称", $con);

$result = mysql_query("SELECT * FROM 表名称");

$res = mysql_num_rows($result);

if($res < 1){

    $arrBack = array(
        "code" => '202',
        "msg" => '数据库暂时没有商品了',
        "data" => 'not goods'
    );
    echo json_encode($arrBack);
    return;

}else{
    $arr = array();

    while($row = mysql_fetch_array($result))
    {
        $arr[] = array(
            "goodsid" => $row['id'],
            "goodsName" => $row['goodsName'],
            "goodsPrice" => $row['goodsPrice']
        );
    }

    $arrBack = array(
        "code" => '200',
        "msg" => '获取商品列表成功',
        "data" => array("title" => '标题',"content" => '内容', "goodsList" => $arr)
    );


    echo json_encode($arrBack);
}


mysql_close($con)
?>
