<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<style>
    .clearfix:after{content:".";display:block;height:0;clear:both;visibility:hidden}
    .clearfix{*+height:1%;}
    .red {
        margin-left: 30px;
        font-size: 12px;
        color: #f00;
    }

    p {
        margin: 0;
        padding: 0
    }

    .w {
        display: inline-block;
        width: 40px;
    }

    .w2 {
        display: inline-block;
        width: 80px;
    }

    .cs {
        color: #50e3c2;
    }

    .cskey {
        color: #cbb956;
        margin-right: 5px;
    }

    .param {
        color: #89bf04;
    }
    .link { border-bottom: 1px solid #999;
        clear: both;
        float: none; padding-bottom: 30px;}
    .link, h1 {
        clear: both;
        float: none;
    }

    h1 {
        padding: 30px;
    }

    .link li {
        background: #1f648b;
        color: #fff;
        font-size: 14px;
        width: 150px;
        line-height: 30px;
        height: 30px;
        float: left;
        list-style: none;
        margin-right: 30px;
        text-align: center;
    }

    .link a {
        color: #fff;
        text-decoration: none;
    }

    .box {
        margin: 0;
        clear: both;
        float: none;
    }

    .fl {
        float: left
    }

    .return_code {
        width: 35%;
    }

    .doc_swagger {
        width: 65%
    }
</style>
<h1>API相关文档 [<?php echo $_SERVER['SERVER_ADDR'];?>]</h1>
<ul class="link clearfix">
    <?php
    foreach ($modules as $module) {
        echo '<li><a href="/docs/' . $module . '.html">' . ucwords($module) . ' API</a></li>';
    }
    ?>
</ul>

<div class="box clearfix">
    <div class="fl return_code">
        <h2>返回码总表</h2>
        <?php
        echo $returnCode;
        ?>
    </div>
    <div class="fl doc_swagger">
        <h2>PHP  Swagger 3注释的写法</h2>
        <div style="font-size: 16px; background: #101010; line-height: 1.4em; color: #ccc; padding: 15px;">
            <p>/*</p>
            <p> * Swagger文档中</p>

            <p> * <span class="cs">@OA\</span><i class="cskey">OpenApi(</i></p>
            <p> *<span class="w"></span>@OA\Info(</p>
            <p> *<span class="w"></span> version="1.0.0",</p>
            <p> *<span class="w"></span> title="超级管理后台——接口",</p>
            <p> *<span class="w"></span>),</p>

            <p> *<span class="w"></span>@OA\Server(</p>
            <p> *<span class="w"></span> description="OpenApi host",</p>
            <p> *<span class="w"></span> url="http://api.xxxx.cn/admin/v1"</p>
            <p> *<span class="w"></span>),</p>
            <p> *<span class="cs"> ),</span></p>
            <p> *</p>
            <p> * Controller中</p>
            <p> *</p>
            <p> * <span class="cs">@OA\</span><i class="cskey">Get(</i></p>
            <p> *<span class="w"></span> <b class="param">path=</b>"/login/index", <span class="red">请求完整路径</span></p>
            <p> *<span class="w"></span> <b class="param">tags=</b>{"用户"}, <span class="red">分组标题，相同类的接口请用同一个标题</span>
            </p>
            <p> *<span class="w"></span> <b class="param">summary=</b>"用户登录", <span class="red">本方法标题</span></p>
            <p> *<span class="w"></span> <b class="param">description=</b>"用户手机号登录", <span
                        class="red">本方法的补充描述,可省略</span></p>
            <p> *<span class="w"></span> <b class="param">operationId=</b>"loginUser", <span class="red">标记ID，此ID必须在API中描述的所有操作中是唯一的，看着好厉害的样子，但实测可省略</span>
            </p>
            <p><span class="w"></span><span class="red">接口用到的所有参数，每个参数一条</span></p>
            <p> *<span class="w"></span> <span class="cs">@OA\</span><i class="cskey">Parameter(</i></p>
            <p> *<span class="w2"></span> <b class="param">name=</b>"mobile", <span class="red">参数名</span></p>
            <p> *<span class="w2"></span> <b class="param">in=</b>"query", <span class="red">参数提交方式：  查询参数 query  | 头参数 header  | 路径参数 path  |   cookie</span>
            </p>
            <p> *<span class="w2"></span> <b class="param">required=</b>false, <span class="red">是否必填</span></p>
            <p> *<span class="w2"></span> <b class="param">description=</b>"用户的手机号", <span class="red">参数 描述</span></p>

            <p> *<span class="w2"></span> <span class="cs">@OA\</span><i class="cskey">Schema(</i></p>
            <p> *<span class="w2"></span><span class="w"></span> type="integer", <span class="red">数据类型: string, number, integer, boolean, array, file </span>
            </p>
            <p> *<span class="w2"></span><span class="w"></span> format="int64",</p>
            <p> *<span class="w2"></span><span class="w"></span> default="1", <span class="red">参数 默认值</span></p>
            <p> *<span class="w2"></span><span class="w"></span> minimum=1.0</p>
            <p> *<span class="w2"></span><span class="cskey"> )</span></p>
            <p> *<span class="w"></span><span class="cs"> ),</span></p>

            <p><span class="red">返回状态</span></p>


            <p> *<span class="w"></span><span class="cs">@OA\</span><i class="cskey">Response(</i>response=400,
                description="Invalid ID supplied"),</p>
            <p> *<span class="w"></span><span class="cs">@OA\</span><i class="cskey">Response(</i>response=404,
                description="Order not found"),</p>

            <p> *<span class="w"></span><span class="cs">@OA\</span><i class="cskey">Response(</i></p>
            <p> *<span class="w2"></span> <b class="param">response=</b>200,<span class="red">HTTP状态码</span></p>
            <p> *<span class="w2"></span> <b class="param">description=</b>"HTTP通讯成功",<span class="red">此状态码的描述</span>
            </p>

            <p> *<span class="w2"></span> <span class="cs">@OA\</span><i class="cskey">Header(</i>header="res_header",
                @OA\Schema(type="string"), description="response header"<i class="cskey">),</i></p>
            <p> *<span class="w2"></span> <span class="cs">@OA\</span><i class="cskey">JsonContent(</i></p>
            <p><span class="w2"></span><span class="w"></span><span class="red">通常API都会包括errorcode和msg两个字段</span></p>
            <p> *<span class="w2"></span><span class="w"></span> <span class="cs">@OA\</span><i
                        class="cskey">Property(</i></p>
            <p> *<span class="w2"></span><span class="w"></span><span class="w"></span> property="code",<span
                        class="red">key名</span></p>
            <p> *<span class="w2"></span><span class="w"></span><span class="w"></span> type="integer",<span
                        class="red">类型</span></p>
            <p> *<span class="w2"></span><span class="w"></span><span class="w"></span> example="0",<span class="red">默认值</span>
            </p>
            <p> *<span class="w2"></span><span class="w"></span><span class="w"></span> description="这是个说明",<span
                        class="red">这是个说明</span></p>
            <p> *<span class="w2"></span><span class="w"></span> ),</p>
            <p> *<span class="w2"></span><span class="w"></span> <span class="cs">@OA\</span><i
                        class="cskey">Property(</i>property="message",type="string",example="操作成功"),</p>

            <p><span class="w2"></span><span class="w"></span><span class="red">其它字段一个个写太过麻烦，建议写一个data然后大约说一下返回参数有哪些，有什么特别注意的就行了</span>
            </p>
            <p> *<span class="w2"></span><span class="w"></span> <span class="cs">@OA\</span><i
                        class="cskey">Property(</i>property="data",type="string",example="这里大约写一下其它返回参数。"),</p>

            <p><span class="w2"></span><span class="red">附：对象形式的返回参数</span></p>
            <p> *<span class="w2"></span><span class="w"></span> <span class="cs">@OA\</span><i
                        class="cskey">Property(</i></p>
            <p> *<span class="w2"></span><span class="w"></span><span class="w"></span> property="object_key",</p>
            <p> *<span class="w2"></span><span class="w"></span><span class="w"></span> type="object",</p>
            <p> *<span class="w2"></span><span class="w"></span><span class="w"></span> <span class="cs">@OA\</span><i
                        class="cskey">Property(</i>property="param1", type="string",example="参数一的值"),</p>
            <p> *<span class="w2"></span><span class="w"></span><span class="w"></span> <span class="cs">@OA\</span><i
                        class="cskey">Property(</i>property="param2", type="string",example="参数二的值"),</p>
            <p> *<span class="w2"></span><span class="w"></span> ),</p>
            <p><span class="w2"></span><span class="red">附：数组形式的返回参数</span></p>
            <p> *<span class="w2"></span><span class="w"></span> <span class="cs">@OA\</span><i
                        class="cskey">Property(</i></p>
            <p> *<span class="w2"></span><span class="w"></span><span class="w"></span> property="array_key",</p>
            <p> *<span class="w2"></span><span class="w"></span><span class="w"></span> type="array",</p>
            <p> *<span class="w2"></span><span class="w"></span><span class="w"></span> <span class="cs">@OA\</span>Items(
            </p>
            <p> *<span class="w2"></span><span class="w"></span><span class="w2"></span> type="object",</p>
            <p> *<span class="w2"></span><span class="w"></span><span class="w2"></span> <span class="cs">@OA\</span><i
                        class="cskey">Property(</i>property="param1", type="string",example="参数一的值"),</p>
            <p> *<span class="w2"></span><span class="w"></span><span class="w2"></span> <span class="cs">@OA\</span><i
                        class="cskey">Property(</i>property="param2", type="string",example="参数二的值"),</p>
            <p> *<span class="w2"></span><span class="w"></span><span class="w"></span> )</p>
            <p> *<span class="w2"></span><span class="w"></span> ),</p>
            <p> *<span class="w2"></span> ),</p>

            <p><span class="red">不需要的话，返回Header可以省略</span></p>
            <p> *<span class="w2"></span><span class="cs">@OA\</span><i class="cskey">Header(</i></p>
            <p> *<span class="w2"></span><span class="w"></span> <b class="param">header=</b>"X-Expires-After",</p>
            <p> *<span class="w2"></span><span class="w"></span> <b class="param">type=</b>"string",</p>
            <p> *<span class="w2"></span><span class="w"></span> <b class="param">format=</b>"date-time",</p>
            <p> *<span class="w2"></span><span class="w"></span> <b class="param">description=</b>"date in UTC when
                toekn expires"</p>
            <p> *<span class="w2"></span><span class="w"></span> )</p>
            <p>* <span class="w"></span>),</p>
            <p> * )</p>
            */
            <hr>
            <p>以上 Response (除data外)显示的结果为：</p>
            <div class="response_box" style="font-size: 12px; color:#ff0">
                <p>{</p>
                <p><span class="w"></span>"errorcode": "0",</p>
                <p><span class="w"></span>"msg": "操作成功",</p>
                <p><span class="w"></span>"object_key": {</p>
                <p><span class="w2"></span>"param1": "参数一的值",</p>
                <p><span class="w2"></span>"param2": "参数二的值"</p>
                <p><span class="w"></span>},</p>
                <p><span class="w"></span>"array_key": [</p>
                <p><span class="w"></span>{</p>
                <p><span class="w2"></span>"param1": "参数一的值",</p>
                <p><span class="w2"></span>"param2": "参数二的值"</p>
                <p><span class="w"></span>}</p>
                <p><span class="w"></span>]</p>
                <p>}</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>