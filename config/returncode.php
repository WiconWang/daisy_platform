<?php

return [
    0 => "SUCCESS",    //	正确返回

    // HTTP 类返回码
    1000 => "ERROR",  // 通用错误
    1001 => "TOKEN_LOST", // API签名缺失
    1002 => "TOKEN_ERROR", // API签名校验错误
//    1002 => "INVALID_PROTOCOL", //	协议不合法, 无法使用HTTP调用HTTPS
    1003 => "FORBIDDEN",  // 拒绝调用相关接口
    1004 => "NOT_FOUND", // 未找到相应API
    1005 => "METHOD_NOT_ALLOWED", // API调用方法错误
    1008 => "REQUEST_TIMEOUT", // API响应超时
    1009 => "CONFLICT", // 请求冲突
    1010 => "GONE",  // 资源删除导致此请求已不再可用
    1014 => "URI_TOO_LONG", // URI过长，无法响应
    1023 => "LOCKED",// 资源被锁定，暂无法处理
    1024 => "FAILED_DEPENDENCY", // 此请求的前置条件未达成，导致无法响应
    1026 => "UPGRADE_REQUIRED", // 此接口已放弃使用，需要升级
    1029 => "TOO_MANY_REQUESTS",   // 请求过于频繁

    // 资源故障类返回码
    1100 => "SERVER_ERROR",    //	服务器出现错误
    1101 => "SERVER_BUSY",    //	服务器繁忙无法处理
    1110 => "DATABASE_ERROR",    //	数据库未知错误
    1111 => "DATABASE_CONNECT_ERROR",    //	数据库连接故障
    1112 => "DATABASE_SQL_ERROR",    //	数据库SQL语句错误
    1120 => "CACHE_ERROR",    //	缓存服务器未知错误
    1121 => "CACHE_CONNECT_ERROR",    //	缓存服务器连接故障
    1130 => "FILE_ERROR",    //	文件系统未知错误
    1131 => "FILE_OPEN_FAIL",    //	文件无法打开
    1132 => "FILE_SAVE_FAIL",    //	文件无法写入

    // 参数类返回码
    1200 => "PARAM_PARSE_FAIL",    //	参数无法解析
    1201 => "PARAM_ERROR",    //	参数错误
    1202 => "PARAM_LACK",    //	必选参数缺少
    1203 => "PARAM_TOO_LONG",    //	必选参数太长

    // 表单类返回码
    1300 => "FORM_ERROR",    //	通用
    1301 => "FORM_PARAM_ERROR",    //	提交参数错误
    1302 => "FORM_CONTENT_INVALID",    //	提交包含非法内容
    1303 => "FORM_LACK",    //	提交参数缺少
    1304 => "FORM_FORMAT_ERROR",    //	传入的文件格式不正确
    1305 => "FORM_TOO_LONG",    //	传入内容过长
    1306 => "FORM_EXISTED",    //	提交相同的信息，或者记录已经存在

    // 数据库记录类
    1400 => "RECORD_NOT_FOUND",    //	未能检索到记录
    1401 => "RECORD_INSERT_ERROR",    //	记录增加失败
    1402 => "RECORD_UPDATE_ERROR",    //	记录修改失败
    1403 => "RECORD_DELETE_ERROR",    //	记录删除失败

    // 功能模块：
    //用户
    2001 => "USER_NOT_EXIST",    //	 用户不存在
    2002 => "USER_PASSWORD_ERROR",    //	 用户密码错误
    2003 => "USER_DISABLED",    //	 用户被禁用
    2004 => "USER_FORBIDDEN",    //	 用户没有访问权限
    2005 => "USER_IS_EXIST",   //	 用户已存在
    2006 => "USER_MOBILE_IS_EXIST",   //	 用户已存在
    2007 => "USER_NAME_IS_EXIST",   //	 用户已存在


    //订单
    2100 => "ORDER_DISABLED",    //	订单状态已不允许支付
    2110 => "ORDER_PAYMENT_ERROR",    //	无法更新支付方式
    2111 => "ORDER_PAYMENT_LOST",    // 支付方式不存在
    2130 => "ORDER_REFUND_DISABLED",    // 不符合退款条件
    2140 => "ORDER_DELIVER_NOT_FOUND",    // 暂时无此订单的物流信息
    2150 => "ORDER_TAKE_FAIL",    // 暂时无此订单的物流信息
    // 评论
    2200 => "COMMENT_DEL_FAIL",    // 删除评论
    2201 => "REPLAY_DEL_FAIL",    // 删除回复
    // 代理商
    2300 => "AGENT_EXPIRE",    // 代理商过期
    2301 => "AGENT_CODE_LIMIT",    // 代理商可用条数上限
    2302 => "AGENT_NOT_OWN_THIS_CUSTOMER",    //代理商名下没有此用户
    2310 => "INVITE_CODE_HAS_USED",    // 邀请码已使用
    2311 => "INVITE_CODE_NOT_FOUND",    // 未找到此邀请码
    2312 => "INVITE_CODE_LESS_THAN_USER",    // 未找到此邀请码

    2322 => "CHANNEL_HAS_CHILDREN", //此栏目下有子栏目"
];
