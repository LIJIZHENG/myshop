<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>用户注册</title>
    <link rel="stylesheet" href="/style/base.css" type="text/css">
    <link rel="stylesheet" href="/style/global.css" type="text/css">
    <link rel="stylesheet" href="/style/header.css" type="text/css">
    <link rel="stylesheet" href="/style/login.css" type="text/css">
    <link rel="stylesheet" href="/style/footer.css" type="text/css">
    <style>
        span.error {
            padding-left: 16px;

            padding-bottom: 2px;

            font-weight: bold;

            color: red;
        }
    </style>
</head>
<body>
<script src="/jQueryValidate/jquery.js"></script>
<script src="/jQueryValidate/jquery-1.11.1.js"></script>
<script src="/jQueryValidate/jquery.validate.min.js"></script>
<!-- 顶部导航 start -->
<div class="topnav">
    <div class="topnav_bd w990 bc">
        <div class="topnav_left">

        </div>
        <div class="topnav_right fr">
            <ul>
                <li>您好，欢迎来到京西！[<a href="<?=\yii\helpers\Url::to(['login/login'])?>">登录</a>] [<a href="<?=\yii\helpers\Url::to(['member/register'])?>">免费注册</a>] </li>
                <li class="line">|</li>
                <li>我的订单</li>
                <li class="line">|</li>
                <li>客户服务</li>

            </ul>
        </div>
    </div>
</div>
<!-- 顶部导航 end -->

<div style="clear:both;"></div>

<!-- 页面头部 start -->
<div class="header w990 bc mt15">
    <div class="logo w990">
        <h2 class="fl"><a href="index.html"><img src="/images/logo.png" alt="京西商城"></a></h2>
    </div>
</div>
<!-- 页面头部 end -->

<!-- 登录主体部分start -->
<div class="login w990 bc mt10 regist">
    <div class="login_hd">
        <h2>用户注册</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
            <form action="" method="post" id="registForm">
                <ul>
                    <li>
                        <label for="">用户名：</label>
                        <input type="text" class="txt" name="username" />
                        <p>3-20位字符，可由中文、字母、数字和下划线组成</p>
                    </li>
                    <li>
                        <label for="">密码：</label>
                        <input type="password" class="txt" name="password_hash" id="password"/>
                        <p>6-20位字符，可使用字母、数字和符号的组合，不建议使用纯数字、纯字母、纯符号</p>
                    </li>
                    <li>
                        <label for="">确认密码：</label>
                        <input type="password" class="txt" name="repassword" id="repassword" />
                        <p> <span>请再次输入密码</p>
                    </li>
                    <li>
                        <label for="">邮箱：</label>
                        <input type="text" class="txt" name="email" />
                        <p>邮箱必须合法</p>
                    </li>
                    <li>
                        <label for="">手机号码：</label>
                        <input type="text" class="txt" value="" name="tel" id="tel" placeholder=""/>
                    </li>
                    <li>
                        <label for="">验证码：</label>
                        <input type="text" class="txt" value="" placeholder="请输入短信验证码" name="captcha" disabled="disabled" id="captcha"/> <input type="button" id="get_captcha" value="获取验证码" style="height: 25px;padding:3px 8px"/>

                    </li>
                    <li class="checkcode">
                        <label for="">验证码：</label>
                        <input type="text"  name="checkcode" />
                        <img id="imgCaptcha" alt="" />
                        <span>看不清？<a href="javascript:;" id="change">换一张</a></span>
                    </li>

                    <li>
                        <label for="">&nbsp;</label>
                        <input type="checkbox" class="chb" checked="checked" name="agree" /> 我已阅读并同意《用户注册协议》
                    </li>
                    <li>
                        <label for="">&nbsp;</label>
                        <input type="submit" value="" class="login_btn" />
                    </li>
                </ul>
            </form>


        </div>

        <div class="mobile fl">
            <h3>手机快速注册</h3>
            <p>中国大陆手机用户，编辑短信 “<strong>XX</strong>”发送到：</p>
            <p><strong>1069099988</strong></p>
        </div>

    </div>
</div>
<!-- 登录主体部分end -->

<div style="clear:both;"></div>
<!-- 底部版权 start -->
<div class="footer w1210 bc mt15">
    <p class="links">
        <a href="">关于我们</a> |
        <a href="">联系我们</a> |
        <a href="">人才招聘</a> |
        <a href="">商家入驻</a> |
        <a href="">千寻网</a> |
        <a href="">奢侈品网</a> |
        <a href="">广告服务</a> |
        <a href="">移动终端</a> |
        <a href="">友情链接</a> |
        <a href="">销售联盟</a> |
        <a href="">京西论坛</a>
    </p>
    <p class="copyright">
        © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号
    </p>
    <p class="auth">
        <a href=""><img src="/images/xin.png" alt="" /></a>
        <a href=""><img src="/images/kexin.jpg" alt="" /></a>
        <a href=""><img src="/images/police.jpg" alt="" /></a>
        <a href=""><img src="/images/beian.gif" alt="" /></a>
    </p>
</div>
<!-- 底部版权 end -->

<script type="text/javascript">
    $().ready(function() {
        $('#get_captcha').click(function () {
            $('#captcha').prop('disabled',false);

            var time=30;
            var interval = setInterval(function(){
                time--;
                if(time<=0){
                    clearInterval(interval);
                    var html = '获取验证码';
                    $('#get_captcha').prop('disabled',false);
                } else{
                    var html = time + ' 秒后再次获取';
                    $('#get_captcha').prop('disabled',true);
                }

                $('#get_captcha').val(html);
            },1000);
            //发送短信的ajax请求
            var phone = $('#tel').val();
            var reg = /^1[34578]\d{9}$/;
            if (reg.test(phone)){
                $.post('<?=\yii\helpers\Url::to(['send-sms'])?>',{'phone':phone},function (data) {
                    if (data==-1){
                        alert('发送失败');
                    }else if(data == 0){
                        alert('一分钟内只能发送一次短信');
                    }
                })
            }else{
                alert('请输入正确的手机号码');
            }

        });
        $("#registForm").validate({
            rules: {
                username: {
                    required: true,
                    rangelength:[3,20],
                    remote:{
                        url:"<?=\yii\helpers\Url::to(['member/check-name'])?>"
                    }
                },
                password_hash: {
                    required: true,
                    rangelength:[6,20]
                },
                repassword:{
                    required:true,
                    checkPassword:true
                },
                email:{
                    required:true,
                    email:true
                },
                tel:{
                    required:true,
                    checkTel:true
                },
                checkcode:{
                    checkCaptcha:true
                },
                agree:{
                    required:true
                },
                captcha:{
                    remote:{
                        url:"<?=\yii\helpers\Url::to(['member/check-captcha'])?>",
                        type:"post",
                        dataType:"json",
                        data:{
                            captcha:function () {
                                return $('#captcha').val();
                            },
                            tel:function () {
                                return $('#tel').val();
                            }
                        }
                    }
                }
            },
            messages: {
                username: {
                    required: "请输入用户名",
                    rangelength: "用户名长度为3-20个字符",
                    remote:"用户名已存在"
                },
                password_hash: {
                    required: "请输入密码",
                    rangelength:"密码的长度为6-20个字符"
                },
                repassword:{
                    required:"再次输入密码"
                },
                email:{
                    required:"请输入邮箱",
                    email:"请输入正确的邮箱"
                },
                tel:{
                    required:"请输入手机号码"
                },
                agree:{
                    required:""
                },
                captcha:{
                    remote:"请输入正确的手机号或验证码"
                }
            },
            errorElement:'span'
        });
        $('#change').click(function () {
            flushCaptcha();
        });
        //获取验证码
        var flushCaptcha = function () {
            $.getJSON('<?=\yii\helpers\Url::to(['site/captcha',\yii\captcha\CaptchaAction::REFRESH_GET_VAR=>1])?>',
                function (data) {
                    $('#imgCaptcha').attr('src',data.url);
                    $('#imgCaptcha').attr('captchaHash',data.hash1);
                })
        };
        flushCaptcha();
        //验证验证码
        jQuery.validator.addMethod("checkCaptcha", function(value, element) {
            var hash = $('#imgCaptcha').attr('captchaHash');
            var v = value.toLowerCase();
            var h = 0;
            for (var i = v.length-1;i >= 0;i--){
                h += v.charCodeAt(i);
            }
            return h == hash;
        }, "验证码输入不正确");
        //验证密码是否一致
        jQuery.validator.addMethod("checkPassword", function(value, element) {
           var password = $('#password').val();
           return password == value;
        }, "两次输入的密码不一致");
        //验证手机号
        jQuery.validator.addMethod("checkTel", function(value, element) {
          var reg = /^1[34578]\d{9}$/;
          return reg.test(value);
        }, "请输入正确手机号码");
    });
</script>
</body>
</html>