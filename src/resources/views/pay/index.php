<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>测试页面</title>
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">

<?php
if($type == 'submit'){
    if($trade_type == 'NATIVE'){
        echo "<img alt='模式一扫码支付' src='http://paysdk.weixin.qq.com/example/qrcode.php?data=".urlencode($url)."' style='width:300px;height:300px;'/>";
        echo "<br/><br/>";
        echo "<div>".$url."</div>";
    }
}else{
?>
<div style="margin-top:40px;">
    <form class="form-horizontal" role="form" action="http://etingcase.xing.aparcar.cn/pay" method="get">
        <div class="form-group">
            <label class="col-sm-2 control-label">code</label>
            <div class="col-sm-10">
                <input type="text" name="code" class="form-control" value="agua" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">openid:(js支付时必填)</label>
            <div class="col-sm-10">
                <div class="input-group">
                    <input type="text" name="openid" class="form-control" value="<?php echo isset($_COOKIE['test_xing_openid']) ? $_COOKIE['test_xing_openid'] : ''; ?>" placeholder="js支付时必填" />
                    <span class="input-group-btn"><button id="getopenid" class="btn btn-default" type="button">getOpenid</button></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">商品名称</label>
            <div class="col-sm-10">
                <input type="text" name="body" class="form-control" placeholder="商品名称 必填" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">金额</label>
            <div class="col-sm-10">
                <input type="text" name="total_fee" class="form-control" placeholder="金额（单位:分） 必填" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">设备号</label>
            <div class="col-sm-10">
                <input type="text" name="device_info" class="form-control" placeholder="设备号" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">商品详情</label>
            <div class="col-sm-10">
                <input type="text" name="detail" class="form-control" placeholder="商品详情" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">附加数据</label>
            <div class="col-sm-10">
                <input type="text" name="attach" class="form-control" placeholder="附加数据" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">商品标记</label>
            <div class="col-sm-10">
                <input type="text" name="goods_tag" class="form-control" placeholder="商品标记" />
            </div>
        </div>
        <input type="button" id="qrcode" name="qrcode" value="扫码支付" class="btn btn-primary"  />
        <input type="button" id="jspay" name="jspay" value="js支付" class="btn btn-primary"  />
    </form>
</div>


<script type="text/javascript">

    $("#qrcode").click(function(){
        var str = "http://etingcase.xing.aparcar.cn/pay?type=submit&trade_type=NATIVE";
        str += "&code="+$(":input[name='code']").val();
        str += "&openid="+$(":input[name='openid']").val();
        str += "&body="+$(":input[name='body']").val();
        str += "&total_fee="+$(":input[name='total_fee']").val();
        str += "&device_info="+$(":input[name='device_info']").val();
        str += "&detail="+$(":input[name='detail']").val();
        str += "&attach="+$(":input[name='attach']").val();
        str += "&goods_tag="+$(":input[name='goods_tag']").val();
        window.location.href = str;
    });

    $("#jspay").click(function(){
        var str = "http://etingcase.xing.aparcar.cn/pay?type=submit&trade_type=JSAPI";
        str += "&code="+$(":input[name='code']").val();
        str += "&openid="+$(":input[name='openid']").val();
        str += "&body="+$(":input[name='body']").val();
        str += "&total_fee="+$(":input[name='total_fee']").val();
        str += "&device_info="+$(":input[name='device_info']").val();
        str += "&detail="+$(":input[name='detail']").val();
        str += "&attach="+$(":input[name='attach']").val();
        str += "&goods_tag="+$(":input[name='goods_tag']").val();
        window.location.href = str;
    });

    $("#getopenid").click(function(){
        window.location.href = "http://etingcase.xing.aparcar.cn/pay/weixin/openid";
    });

</script>

<?php

}
?>

</div>
</body>
</html>
