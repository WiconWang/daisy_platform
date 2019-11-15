<?php
/**
 * Created by IntelliJ IDEA.
 * User: yanyan
 * Date: 2019/1/11
 * Time: 2:44 PM
 */

namespace App\Utilities;


class ConstantHelper
{
    // 文章
    public const ARTICLE_NORMAL = 1;
    public const ARTICLE_VIDEO = 2;
    public const ARTICLE_VOICE = 3;

    public const ARTICLE_VISIBLE = 0;
    public const ARTICLE_INVISIBLE = 1;

    public const ARTICLE_STATUS_AUDITING = 0;
    public const ARTICLE_STATUS_FAILED = 1;
    public const ARTICLE_STATUS_SUCCESS = 2;

    public const ARTICLE_OPERATE = 0;
    public const ARTICLE_OPERATE_CANCEL = 1;

    // 栏目
    public const ARTICLE_LIST_COUNT = 50; //  默认首页栏目下显示的列表文章数量
    public const ARTICLE_HOT_COUNT = 5; //  默认热门推荐列表文章数量
    public const COLUMN_HOMEPAGE = 1;
    public const COLUMN_DISCOVER = 2;
    public const COLUMN_STATUS_ALIVE = 0;
    public const COLUMN_STATUS_DEAD = 1;

    // 评论
    public const COMMENT_TARGET_ARTICLE = 0;
    public const COMMENT_TARGET_COMMENT = 1;
    public const COMMENT_STATUS_AUDITING = 0;
    public const COMMENT_STATUS_REFUSE = 1;
    public const COMMENT_STATUS_PASS = 2;

    public const COMMENT_OPERATE = 0;
    public const COMMENT_OPERATE_CANCEL = 1;

}
