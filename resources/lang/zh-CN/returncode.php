<?php

return [
    "SUCCESS" => "成功",
    //HTTP 类返回码
    "ERROR" => "请求出现错误",
    "TOKEN_LOST" => "API签名缺失",
    "TOKEN_ERROR" =>  "API签名校验错误",
    "INVALID_PROTOCOL" => "协议不合法, 无法使用HTTP调用HTTPS",
    "FORBIDDEN" => "拒绝调用相关接口",
    "NOT_FOUND" => "未找到相应API",
    "METHOD_NOT_ALLOWED" => "API请求方法错误",
    "REQUEST_TIMEOUT" => "API响应超时",
    "CONFLICT" => "请求冲突",
    "GONE" => "资源删除导致此请求已不再可用",
    "URI_TOO_LONG" => "URI过长，无法响应",
    "LOCKED" => "资源被锁定，暂无法处理",
    "FAILED_DEPENDENCY" => "此请求的前置条件未达成，导致无法响应",
    "UPGRADE_REQUIRED" => "此接口已放弃使用，需要升级",
    "TOO_MANY_REQUESTS" => "请求过于频繁",

    //资源故障类返回码
    "SERVER_ERROR" => "服务器出现错误",
    "SERVER_BUSY" => "服务器繁忙无法处理",
    "DATABASE_ERROR" => "数据库未知错误",
    "DATABASE_CONNECT_ERROR" => "数据库连接故障",
    "DATABASE_SQL_ERROR" => "数据库SQL语句错误",
    "CACHE_ERROR" => "缓存服务器未知错误",
    "CACHE_CONNECT_ERROR" => "缓存服务器连接故障",
    "FILE_ERROR" => "文件系统未知错误",
    "FILE_OPEN_FAIL" => "文件无法打开",
    "FILE_SAVE_FAIL" => "文件无法写入",

    //参数类返回码
    "PARAM_PARSE_FAIL" => "请求参数无法解析",
    "PARAM_ERROR" => "请求参数错误",
    "PARAM_LACK" => "请求的参数缺失或格式错误",
    "PARAM_TOO_LONG" => "请求参数内容过长",

    //表单类返回码
    "FORM_ERROR" => "通用",
    "FORM_PARAM_ERROR" => "提交参数错误",
    "FORM_CONTENT_INVALID" => "提交包含非法内容",
    "FORM_LACK" => "提交参数缺少",
    "FORM_FORMAT_ERROR" => "传入的文件格式不正确",
    "FORM_TOO_LONG" => "传入内容过长",
    "FORM_EXISTED" => "提交相同的信息，或者记录已经存在",

    //数据库记录类
    "RECORD_NOT_FOUND" => "未能检索到记录",
    "RECORD_INSERT_ERROR" => "记录增加失败",
    "RECORD_UPDATE_ERROR" => "记录修改失败",
    "RECORD_DELETE_ERROR" => "记录删除失败",

    //功能模块：

    "USER_NOT_EXIST"           => "用户不存在",
    "USER_PASSWORD_ERROR"      => "用户密码错误",
    "USER_DISABLED"            => "用户被禁用",
    "USER_FORBIDDEN"           => "用户没有访问权限",
    "USER_IS_EXIST"           => "此用户已经存在",
    "USER_MOBILE_IS_EXIST"  => "此手机号用户已经存在",
    "USER_NAME_IS_EXIST"  => "此用户名已经存在",


    "ORDER_DISABLED" => "订单状态已不允许支付",
    "ORDER_PAYMENT_ERROR" => "无法更新支付方式",
    "ORDER_PAYMENT_LOST" => "支付方式不存在",
    "ORDER_REFUND_DISABLED" => "不符合退款条件",
    "ORDER_DELIVER_NOT_FOUND" => "暂时无此订单的物流信息",
    "ORDER_TAKE_FAIL" => "暂时无此订单的物流信息",
    //评论
    "COMMENT_DEL_FAIL" => "删除评论",
    "REPLAY_DEL_FAIL" => "删除回复",


    "AGENT_EXPIRE" => "此代理商帐号已过期",
    "AGENT_CODE_LIMIT" => "邀请码条数已用完",

    "INVITE_CODE_HAS_USED" => "邀请码已使用",
    "INVITE_CODE_NOT_FOUND" => "此邀请码未找到或已被使用",
    "INVITE_CODE_LESS_THAN_USER" => "开通码等级比用户等级低",
    "AGENT_NOT_OWN_THIS_CUSTOMER" =>  "代理商名下没有此用户",


    "CHANNEL_HAS_CHILDREN" =>  "此栏目下有子栏目",

];
