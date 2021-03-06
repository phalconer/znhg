<?php
/**
 * User: Xany <762632258@qq.com>
 * Date: 2017/6/19
 * Time: 16:52
 * @var \yii\web\View $this
 */
$urlManager = Yii::$app->urlManager;
$this->title = '我的商城';
$this->params['active_nav_group'] = 0;
?>
<style>
    .home-row {
        margin-right: -.5rem;
        margin-left: -.5rem;
    }

    .home-row .home-col {
        padding-left: .5rem;
        padding-right: .5rem;
        margin-bottom: 1rem;
    }

    .panel-1 {
        height: 10rem;
    }

    .panel-2 {
        height: 10rem;
    }

    .panel-3 {
        height: 15rem;
    }

    .panel-4 {
        height: 17rem;
    }

    .panel-5 {
        height: 20rem;
    }

    .panel-6 {
        height: 12rem;
    }

    .panel-7 {
        height: 20rem;
    }
    .panel-2 hr {
        border-top-color: #eee;
    }

    .panel-2-item {
        height: 8rem;
        border-right: 1px solid #eee;
    }

    .panel-2-item .item-icon {
        width: 42px;
        height: 42px;
    }

    .panel-2-item > div {
        padding: 0 0;
    }

    @media (min-width: 1100px) {
        .panel-2-item > div {
            padding: 0 1rem;
        }
    }

    @media (min-width: 1300px) {
        .panel-2-item > div {
            padding: 0 2rem;
        }
    }

    @media (min-width: 1500px) {
        .panel-2-item > div {
            padding: 0 3.5rem;
        }
    }

    @media (min-width: 1700px) {
        .panel-2-item > div {
            padding: 0 5rem;
        }
    }

    .panel-3-item {
        height: calc(13rem - 50px);
    }

    .panel .panel-body .tab-body {
        display: none;
    }

    .panel .panel-body .tab-body.active {
        display: block;
    }

    .panel-5 table {
        table-layout: fixed;
        margin-top: -1rem;
    }

    .panel-5 td:nth-of-type(2) div {
        width: 100%;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .panel-5 table th {
        border-top: none;
    }

    .panel-5 .table td, .panel-5 .table th {
        padding: .5rem;
    }

    .panel-6 .user-top-list {
        margin-left: -1rem;
        white-space: nowrap;
    }

    .panel-6 .user-top-item {
        display: inline-block;
        width: 75px;
        margin-left: 1rem;
    }

    .panel-6 .user-avatar {
        background-size: cover;
        width: 100%;
        height: 75px;
        background-position: center;
        margin-bottom: .2rem;
    }

    .panel-6 .user-nickname,
    .panel-6 .user-money {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.25;
    }
</style>
<div class="row home-row" id="app" style="display: none">

    <div class="home-col col-md-4">
        <div class="panel panel-1" v-if="panel_1">
            <div class="panel-header">今日数据</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-4 text-center">
                        <div style="font-size: 1.75rem">{{panel_1.jruser_count}}</div>
                        <div>今日新增用户</div>
                    </div>

                    <div class="col-4 text-center">
                        <div style="font-size: 1.75rem">{{panel_1.jrintegral_count}}</div>
                        <div>今日积分总数</div>
                    </div>
                <div class="col-4 text-center">
                    <div style="font-size: 1.75rem">{{panel_1.jrhld_count}}</div>
                    <div>今日欢乐豆总数</div>
                </div>

                </div>
            </div>
        </div>
    </div>
    <div class="home-col col-md-4">
        <div class="panel panel-1" v-if="panel_1">
            <div class="panel-header">商城信息</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-4 text-center">
                        <div style="font-size: 1.75rem">{{panel_1.user_count}}</div>
                        <div>用户数</div>
                    </div>
                    <div class="col-4 text-center">
                        <div style="font-size: 1.75rem">{{panel_1.goods_count}}</div>
                        <div>商品数</div>
                    </div>
                    <div class="col-4 text-center">
                        <div style="font-size: 1.75rem">{{panel_1.order_count}}</div>
                        <div>订单数</div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="home-col col-md-4">
        <div class="panel panel-1" v-if="panel_1">
            <div class="panel-header">平台营销数据</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-4 text-center">
                        <div style="font-size: 1.75rem">{{panel_1.coupon_count}}</div>
                        <div>优惠券总数</div>
                    </div>

                    <div class="col-4 text-center">
                        <div style="font-size: 1.75rem">{{panel_1.integral_count}}</div>
                        <div>积分总数</div>
                    </div>
                    <div class="col-4 text-center">
                        <div style="font-size: 1.75rem">{{panel_1.hld_count}}</div>
                        <div>欢乐豆总数</div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="home-col col-md-4">
        <div class="panel panel-1" v-if="panel_1">
            <div class="panel-header">昨日数据</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-4 text-center">
                        <div style="font-size: 1.75rem">{{panel_1.htuser_count}}</div>
                        <div>昨日新增用户</div>
                    </div>
                    <div class="col-4 text-center">
                        <div style="font-size: 1.75rem">{{panel_1.htintegral_count}}</div>
                        <div>昨日积分总数</div>
                    </div>
                    <div class="col-4 text-center">
                        <div style="font-size: 1.75rem">{{panel_1.hthld_count}}</div>
                        <div>昨日欢乐豆总数</div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="home-col col-md-8">
        <div class="panel panel-2" v-if="panel_2">
            <div class="panel-body">
                <div class="row">
                    <div class="col-4 panel-2-item" flex="cross:center main:center">
                        <div flex="dir:left box:last" class="w-100">
                            <div flex="cross:center">
                                <img class="mr-3 item-icon"
                                     src="<?= Yii::$app->request->baseUrl ?>/statics/images/mch-home/1.png">
                            </div>
                            <div style="width: 100px;text-align: center">
                                <div style="font-size: 1.75rem">{{panel_2.goods_zero_count}}</div>
                                <div>已售罄商品商品</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 panel-2-item" flex="cross:center main:center">
                        <div flex="dir:left box:last" class="w-100">
                            <div flex="cross:center">
                                <img class="mr-3 item-icon"
                                     src="<?= Yii::$app->request->baseUrl ?>/statics/images/mch-home/2.png">
                            </div>
                            <div style="width: 100px;text-align: center">
                                <div style="font-size: 1.75rem">{{panel_2.order_no_send_count}}</div>
                                <div>待发货订单</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 panel-2-item" flex="cross:center main:center">
                        <div flex="dir:left box:last" class="w-100">
                            <div flex="cross:center">
                                <img class="mr-3 item-icon"
                                     src="<?= Yii::$app->request->baseUrl ?>/statics/images/mch-home/3.png">
                            </div>
                            <div style="width: 100px;text-align: center">
                                <div style="font-size: 1.75rem">{{panel_2.order_refunding_count}}</div>
                                <div>维权中订单</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="home-col col-md-6">
        <div class="panel panel-3 mb-3" v-if="panel_3">
            <div class="panel-header">
                <span>订单概述</span>
                <ul class="nav nav-right">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:" data-tab=".tab-1">今日</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:" data-tab=".tab-2">昨日</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:" data-tab=".tab-3">最近7天</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:" data-tab=".tab-4">最近30天</a>
                    </li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-body tab-1 active">
                    <div class="row">
                        <div class="col-sm-4 panel-3-item" flex="cross:center main:center">
                            <div class="text-center">
                                <div style="font-size: 1.75rem;color: #facf5b;">{{panel_3.data_1.order_goods_count}}
                                </div>
                                <div class="">成交量（件）</div>
                            </div>
                        </div>
                        <div class="col-sm-4 panel-3-item" flex="cross:center main:center">
                            <div class="text-center">
                                <div style="font-size: 1.75rem;color: #facf5b;">{{panel_3.data_1.order_price_count}}
                                </div>
                                <div class="">成交额（元）</div>
                            </div>
                        </div>
                        <div class="col-sm-4 panel-3-item" flex="cross:center main:center">
                            <div class="text-center">
                                <div style="font-size: 1.75rem;color: #facf5b;">{{panel_3.data_1.order_price_average}}
                                </div>
                                <div class="">订单平均消费（元）</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-body tab-2">
                    <div class="row">
                        <div class="col-sm-4 panel-3-item" flex="cross:center main:center">
                            <div class="text-center">
                                <div style="font-size: 1.75rem;color: #facf5b;">{{panel_3.data_2.order_goods_count}}
                                </div>
                                <div class="">成交量（件）</div>
                            </div>
                        </div>
                        <div class="col-sm-4 panel-3-item" flex="cross:center main:center">
                            <div class="text-center">
                                <div style="font-size: 1.75rem;color: #facf5b;">{{panel_3.data_2.order_price_count}}
                                </div>
                                <div class="">成交额（元）</div>
                            </div>
                        </div>
                        <div class="col-sm-4 panel-3-item" flex="cross:center main:center">
                            <div class="text-center">
                                <div style="font-size: 1.75rem;color: #facf5b;">{{panel_3.data_2.order_price_average}}
                                </div>
                                <div class="">订单平均消费（元）</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-body tab-3">
                    <div class="row">
                        <div class="col-sm-4 panel-3-item" flex="cross:center main:center">
                            <div class="text-center">
                                <div style="font-size: 1.75rem;color: #facf5b;">{{panel_3.data_3.order_goods_count}}
                                </div>
                                <div class="">成交量（件）</div>
                            </div>
                        </div>
                        <div class="col-sm-4 panel-3-item" flex="cross:center main:center">
                            <div class="text-center">
                                <div style="font-size: 1.75rem;color: #facf5b;">{{panel_3.data_3.order_price_count}}
                                </div>
                                <div class="">成交额（元）</div>
                            </div>
                        </div>
                        <div class="col-sm-4 panel-3-item" flex="cross:center main:center">
                            <div class="text-center">
                                <div style="font-size: 1.75rem;color: #facf5b;">{{panel_3.data_3.order_price_average}}
                                </div>
                                <div class="">订单平均消费（元）</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-body tab-4">
                    <div class="row">
                        <div class="col-sm-4 panel-3-item" flex="cross:center main:center">
                            <div class="text-center">
                                <div style="font-size: 1.75rem;color: #facf5b;">{{panel_3.data_4.order_goods_count}}
                                </div>
                                <div class="">成交量（件）</div>
                            </div>
                        </div>
                        <div class="col-sm-4 panel-3-item" flex="cross:center main:center">
                            <div class="text-center">
                                <div style="font-size: 1.75rem;color: #facf5b;">{{panel_3.data_4.order_price_count}}
                                </div>
                                <div class="">成交额（元）</div>
                            </div>
                        </div>
                        <div class="col-sm-4 panel-3-item" flex="cross:center main:center">
                            <div class="text-center">
                                <div style="font-size: 1.75rem;color: #facf5b;">{{panel_3.data_4.order_price_average}}
                                </div>
                                <div class="">订单平均消费（元）</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-4" v-if="panel_4">
            <div class="panel-body">
                <div id="echarts_1" style="height:15rem;"></div>
            </div>
        </div>
        <div class="panel panel-4" v-if="panel_9">
            <div class="panel-body">
                <div id="echarts_2" style="height:15rem;"></div>
            </div>
        </div>


    </div>
    <div class="home-col col-md-6">


        <div class="panel panel-5 mb-3" v-if="panel_5">
            <div class="panel-header">
                <span>后台系统公告</span>
                <ul class="nav nav-right">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:" data-tab=".tab-1">功能</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:" data-tab=".tab-2">运营</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:" data-tab=".tab-3">数据</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:" data-tab=".tab-4">报表</a>
                    </li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-body tab-1 active">
                    <table class="table">
                        <col style="width: 10%">
                        <col style="width: 75%">
                        <col style="width: 15%">
                        <thead>
                        <tr>
                            <th>排名</th>
                            <th>功能名称</th>
                            <th class="text-center">信息</th>
                        </tr>
                        </thead>
                        <tr  >
                            <td>1</td>
                            <td>
                                <div style="color:red">预售1新增须知2.阶段价格显示3.达到人数下降余款4.后台一键计算尾款5.预售增加整体时间</div>
                            </td>
                            <td class="text-center" style="color:red">注意</td>
                        </tr>
                        <tr  >
                            <td>2</td>
                            <td>
                                <div style="color:red">新增7等级会员</div>
                            </td>
                            <td class="text-center" style="color:red">注意</td>
                        </tr>
                        <tr  >
                            <td>2</td>
                            <td>
                                <div style="color:red">用户申请前端一键申请经销后台审核（代理商设置优惠券门槛和推广人数/代理商类目设置扣除的优惠券或者积分）</div>
                            </td>
                            <td class="text-center" style="color:red">注意</td>
                        </tr>

                    </table>
                </div>
                <div class="tab-body tab-2">
                    <table class="table">
                        <col style="width: 10%">
                        <col style="width: 75%">
                        <col style="width: 15%">
                        <thead>
                        <tr>
                            <th>排名</th>
                            <th>功能名称</th>
                            <th class="text-center">信息</th>
                        </tr>
                        </thead>

                        <tr  >
                            <td>1</td>
                            <td>
                                <div style="color:red">可以创建客服了（右上角）</div>
                            </td>
                            <td class="text-center" style="color:red">注意</td>
                        </tr>
                        <tr  >
                            <td>2</td>
                            <td>
                                <div>后台可以一键导出订单数据啦</div>
                            </td>
                            <td class="text-center">使用</td>
                        </tr>
                        <tr  >
                            <td>3</td>
                            <td>
                                <div>可以按照商品名称搜索订单并且导出啦</div>
                            </td>
                            <td class="text-center">使用</td>
                        </tr>

                        <tr  >
                            <td>5</td>
                            <td>
                                <div style="color:red">白天请不要过多拉取数据</div>
                            </td>
                            <td class="text-center" style="color:red">注意</td>
                        </tr>

                        <tr  >
                            <td>6</td>
                            <td>
                                <div style="color:red">客服账号请不要外流，可以使用没有做完整的安全测试</div>
                            </td>
                            <td class="text-center" style="color:red">注意</td>
                        </tr>

                        <tr  >
                            <td>7</td>
                            <td>
                                <div style="color:red">客服不可以拉去数据报表只可以查看和发货</div>
                            </td>
                            <td class="text-center" style="color:red">注意</td>
                        </tr>
                    </table>
                </div>
                <div class="tab-body tab-3">
                    <table class="table">
                        <col style="width: 10%">
                        <col style="width: 75%">
                        <col style="width: 15%">
                        <thead>
                        <tr>
                            <th>排名</th>
                            <th>功能名称</th>
                            <th class="text-center">信息</th>
                        </tr>
                        </thead>
                        <tr >
                            <td>1</td>
                            <td>
                                <div>预售</div>
                            </td>
                            <td class="text-center"  >可以测试并使用啦</td>
                        </tr>
                        <tr >
                            <td>1</td>
                            <td>
                                <div>报名/众筹</div>
                            </td>
                            <td class="text-center">可以创建发起报名活动啦</td>
                        </tr>
                        <tr >
                            <td>1</td>
                            <td>
                                <div>众筹资格</div>
                            </td>
                            <td class="text-center">可以发起众筹抢购啦（请在首页布局增加众筹模块）</td>
                        </tr>
                    </table>
                </div>
                <div class="tab-body tab-4">
                    <table class="table">
                        <col style="width: 10%">
                        <col style="width: 75%">
                        <col style="width: 15%">
                        <thead>
                        <tr>
                            <th>排名</th>
                            <th>功能名称</th>
                            <th class="text-center">信息</th>
                        </tr>
                        </thead>
                        <tr>
                            <td>8</td>
                            <td>
                                <div style="color:red">报表功能逐步移到财务报表模块</div>
                            </td>
                            <td class="text-center" style="color:red">注意</td>
                        </tr>
                        <tr >
                            <td>1</td>
                            <td>
                                <div>奖金结算/用户推荐统计</div>
                            </td>
                            <td class="text-center">可以按时间统计推荐付费用户数量啦可以并且拉出数据</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>
                                <div style="color:red">管理员所有的报表均可拉取（订单/商城/兑换/用户推荐统计）</div>
                            </td>
                            <td class="text-center" style="color:red">注意</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>
                                <div style="color:red">券商也可以拉取报表了（每次只能拉去一个用户的所有下级，先搜索再拉取）</div>
                            </td>
                            <td class="text-center" style="color:red">注意</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>


        <div class="panel panel-5 mb-3" v-if="panel_5">
            <div class="panel-header">
                <span>商品销量排行</span>
                <ul class="nav nav-right">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:" data-tab=".tab-1">今日</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:" data-tab=".tab-2">昨日</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:" data-tab=".tab-3">最近7天</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:" data-tab=".tab-4">最近30天</a>
                    </li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-body tab-1 active">
                    <table class="table">
                        <col style="width: 10%">
                        <col style="width: 75%">
                        <col style="width: 15%">
                        <thead>
                        <tr>
                            <th>排名</th>
                            <th>商品名称</th>
                            <th class="text-center">成交数量</th>
                        </tr>
                        </thead>
                        <tr v-if="panel_5.data_1.length==0">
                            <td colspan="3" class="text-center">今日暂无销售记录</td>
                        </tr>
                        <tr v-else v-for="(item,index) in panel_5.data_1">
                            <td>{{index+1}}</td>
                            <td>
                                <div>{{item.name}}</div>
                            </td>
                            <td class="text-center">{{item.num}}</td>
                        </tr>
                    </table>
                </div>
                <div class="tab-body tab-2">
                    <table class="table">
                        <col style="width: 10%">
                        <col style="width: 75%">
                        <col style="width: 15%">
                        <thead>
                        <tr>
                            <th>排名</th>
                            <th>商品名称</th>
                            <th class="text-center">成交数量</th>
                        </tr>
                        </thead>
                        <tr v-if="panel_5.data_2.length==0">
                            <td colspan="3" class="text-center">今日暂无销售记录</td>
                        </tr>
                        <tr v-else v-for="(item,index) in panel_5.data_2">
                            <td>{{index+1}}</td>
                            <td>
                                <div>{{item.name}}</div>
                            </td>
                            <td class="text-center">{{item.num}}</td>
                        </tr>
                    </table>
                </div>
                <div class="tab-body tab-3">
                    <table class="table">
                        <col style="width: 10%">
                        <col style="width: 75%">
                        <col style="width: 15%">
                        <thead>
                        <tr>
                            <th>排名</th>
                            <th>商品名称</th>
                            <th class="text-center">成交数量</th>
                        </tr>
                        </thead>
                        <tr v-if="panel_5.data_3.length==0">
                            <td colspan="3" class="text-center">今日暂无销售记录</td>
                        </tr>
                        <tr v-else v-for="(item,index) in panel_5.data_3">
                            <td>{{index+1}}</td>
                            <td>
                                <div>{{item.name}}</div>
                            </td>
                            <td class="text-center">{{item.num}}</td>
                        </tr>
                    </table>
                </div>
                <div class="tab-body tab-4">
                    <table class="table">
                        <col style="width: 10%">
                        <col style="width: 75%">
                        <col style="width: 15%">
                        <thead>
                        <tr>
                            <th>排名</th>
                            <th>商品名称</th>
                            <th class="text-center">成交数量</th>
                        </tr>
                        </thead>
                        <tr v-if="panel_5.data_4.length==0">
                            <td colspan="3" class="text-center">今日暂无销售记录</td>
                        </tr>
                        <tr v-else v-for="(item,index) in panel_5.data_4">
                            <td>{{index+1}}</td>
                            <td>
                                <div>{{item.name}}</div>
                            </td>
                            <td class="text-center">{{item.num}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="panel panel-6" v-if="panel_6">
            <div class="panel-body">
                <div class="mb-3">用户购买力排行</div>
                <div style="overflow-x: auto">
                    <div class="user-top-list">
                        <div class="user-top-item" v-for="(item,index) in panel_6">
                            <div class="user-avatar" v-bind:style="'background-image:url('+item.avatar+')'"></div>
                            <div class="user-nickname fs-sm">{{item.nickname}}</div>
                            <div class="user-money fs-sm text-muted">{{item.money}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="panel panel-5 mb-3" v-if="panel_7">
            <div class="panel-header">
                <span>优惠券兑换销量排行</span>
                <ul class="nav nav-right">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:" data-tab=".tab-1">今日</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:" data-tab=".tab-2">昨日</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:" data-tab=".tab-3">最近7天</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:" data-tab=".tab-4">最近30天</a>
                    </li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-body tab-1 active">
                    <table class="table">
                        <col style="width: 10%">
                        <col style="width: 75%">
                        <col style="width: 15%">
                        <col style="width: 15%">
                        <col style="width: 15%">
                        <thead>
                        <tr>
                            <th>排名</th>
                            <th>商品名称</th>
                            <th class="text-center">成交数量</th>
                            <th class="text-center">成交积分</th>
                            <th class="text-center">成交优惠券</th>
                        </tr>
                        </thead>
                        <tr v-if="panel_7.data_1.length==0">
                            <td colspan="3" class="text-center">今日暂无销售记录</td>
                        </tr>
                        <tr v-else v-for="(item,index) in panel_7.data_1">
                            <td>{{index+1}}</td>
                            <td>
                                <div>{{item.name}}</div>
                            </td>
                            <td class="text-center">{{item.num}}</td>
                            <td class="text-center">{{item.integral}}</td>
                            <td class="text-center">{{item.coupon}}</td>
                        </tr>
                    </table>
                </div>
                <div class="tab-body tab-2">
                    <table class="table">
                        <col style="width: 10%">
                        <col style="width: 75%">
                        <col style="width: 15%">
                        <col style="width: 15%">
                        <col style="width: 15%">
                        <thead>
                        <tr>
                            <th>排名</th>
                            <th>商品名称</th>
                            <th class="text-center">成交数量</th>
                            <th class="text-center">成交积分</th>
                            <th class="text-center">成交优惠券</th>
                        </tr>
                        </thead>
                        <tr v-if="panel_7.data_2.length==0">
                            <td colspan="3" class="text-center">今日暂无销售记录</td>
                        </tr>
                        <tr v-else v-for="(item,index) in panel_7.data_2">
                            <td>{{index+1}}</td>
                            <td>
                                <div>{{item.name}}</div>
                            </td>
                            <td class="text-center">{{item.num}}</td>
                            <td class="text-center">{{item.integral}}</td>
                            <td class="text-center">{{item.coupon}}</td>
                        </tr>
                    </table>
                </div>
                <div class="tab-body tab-3">
                    <table class="table">
                        <col style="width: 10%">
                        <col style="width: 75%">
                        <col style="width: 15%">
                        <col style="width: 15%">
                        <col style="width: 15%">
                        <thead>
                        <tr>
                            <th>排名</th>
                            <th>商品名称</th>
                            <th class="text-center">成交数量</th>
                            <th class="text-center">成交积分</th>
                            <th class="text-center">成交优惠券</th>
                        </tr>
                        </thead>
                        <tr v-if="panel_7.data_3.length==0">
                            <td colspan="3" class="text-center">今日暂无销售记录</td>
                        </tr>
                        <tr v-else v-for="(item,index) in panel_7.data_3">
                            <td>{{index+1}}</td>
                            <td>
                                <div>{{item.name}}</div>
                            </td>
                            <td class="text-center">{{item.num}}</td>
                            <td class="text-center">{{item.integral}}</td>
                            <td class="text-center">{{item.coupon}}</td>
                        </tr>
                    </table>
                </div>
                <div class="tab-body tab-4">
                    <table class="table">
                        <col style="width: 10%">
                        <col style="width: 75%">
                        <col style="width: 15%">
                        <col style="width: 15%">
                        <col style="width: 15%">
                        <thead>
                        <tr>
                            <th>排名</th>
                            <th>商品名称</th>
                            <th class="text-center">成交数量</th>
                            <th class="text-center">成交积分</th>
                            <th class="text-center">成交优惠券</th>
                        </tr>
                        </thead>
                        <tr v-if="panel_7.data_4.length==0">
                            <td colspan="3" class="text-center">今日暂无销售记录</td>
                        </tr>
                        <tr v-else v-for="(item,index) in panel_7.data_4">
                            <td>{{index+1}}</td>
                            <td>
                                <div>{{item.name}}</div>
                            </td>
                            <td class="text-center">{{item.num}}</td>
                            <td class="text-center">{{item.integral}}</td>
                            <td class="text-center">{{item.coupon}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel panel-6" v-if="panel_8">
            <div class="panel-body">
                <div class="mb-3">用户兑换排行</div>
                <div style="overflow-x: auto">
                    <div class="user-top-list">
                        <div class="user-top-item" v-for="(item,index) in panel_8">
                            <div class="user-avatar" v-bind:style="'background-image:url('+item.avatar+')'"></div>
                            <div class="user-nickname fs-sm">{{item.nickname}}</div>
                            <div class="user-money fs-sm text-muted">积{{item.integral}}+券{{item.coupon}}</div>
                            <div class="user-money fs-sm text-muted"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>







    </div>
</div>


<script src="<?= Yii::$app->request->baseUrl ?>/statics/echarts/echarts.min.js"></script>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            panel_1: null,
            panel_2: null,
            panel_3: null,
            panel_4: null,
            panel_5: null,
            panel_6: null,
            panel_7: null,
            panel_8: null,
            panel_9: null,
        },
    });
    $('#app').show();
    $(document).on('click', '.panel .panel-header .nav-link', function () {
        $(this).parents('.panel').find('.nav-link').removeClass('active');
        $(this).parents('.panel').find('.tab-body').removeClass('active');
        var target = $(this).attr('data-tab');
        $(this).addClass('active');
        $(this).parents('.panel').find(target).addClass('active');
    });


    $.loading();
    $.ajax({
        dataType: 'json',
        success: function (res) {
            $.loadingHide();
            if (res.code != 0) {
                $.alert({
                    content: res.msg,
                });
                return;
            }
            app.panel_1 = res.data.panel_1;
            app.panel_2 = res.data.panel_2;
            app.panel_3 = res.data.panel_3;
            app.panel_4 = res.data.panel_4;
            app.panel_5 = res.data.panel_5;
            app.panel_6 = res.data.panel_6;
            app.panel_7 = res.data.panel_7;
            app.panel_8 = res.data.panel_8;
            app.panel_9 = res.data.panel_9;

            console.log(res.data.panel_4);
            console.log(res.data.panel_9);

            setTimeout(function () {
                var echarts_1 = echarts.init(document.getElementById('echarts_1'));
                // 指定图表的配置项和数据
                var echarts_1_option = {
                    title: {
                        text: '近七日交易走势'
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data: ['成交量', '成交额']
                    },
                    grid: {
                        left: '0%',
                        right: '0%',
                        bottom: '0%',
                        containLabel: true
                    },
                    xAxis: {
                        data: res.data.panel_4.date,
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        {
                            name: '成交量',
                            type: 'line',
                            data: res.data.panel_4.order_goods_data.data,
                        },
                        {
                            name: '成交额',
                            type: 'line',
                            data: res.data.panel_4.order_goods_price_data.data,
                        },
                    ]
                };
                // 使用刚指定的配置项和数据显示图表。
                echarts_1.setOption(echarts_1_option);
            }, 500);



            setTimeout(function () {
                var echarts_2 = echarts.init(document.getElementById('echarts_2'));
                // 指定图表的配置项和数据
                var echarts_2_option = {
                    title: {
                        text: '近七日兑换商城走势'
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data: ['成交量', '成交积分额', '成交优惠券额']
                    },
                    grid: {
                        left: '0%',
                        right: '0%',
                        bottom: '0%',
                        containLabel: true
                    },
                    xAxis: {
                        data: res.data.panel_9.date,
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        {
                            name: '成交量',
                            type: 'line',
                            data: res.data.panel_9.order_goods_data.data,
                        },
                        {
                            name: '成交积分',
                            type: 'line',
                            data: res.data.panel_9.order_goods_price_data.data.integral,
                        },
                        {
                            name: '成交优惠券',
                            type: 'line',
                            data: res.data.panel_9.order_goods_price_data.data.coupon,
                        },
                    ]
                };
                // 使用刚指定的配置项和数据显示图表。
                echarts_2.setOption(echarts_2_option);
            }, 500);
        }
    });

</script>