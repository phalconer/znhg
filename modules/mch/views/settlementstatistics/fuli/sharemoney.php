<?php
/**
 * User: Xany <762632258@qq.com>
 * Date: 2017/11/2
 * Time: 9:17
 */
$urlManager = Yii::$app->urlManager;
$this->title = '福利每个期数总佣金明细';
$this->params['active_nav_group'] = 4;
?>

<!--    <iframe style="height:1000px;width:1200px"  src="https://mta.qq.com/wechat_mini/base/ctr_realtime_data?app_id=500706424">-->
<!--    </iframe>>-->
        <div class="alert alert-info rounded-0">
    <div>注：确认超过设置的售后时间且没有在售后的订单 系统自动按最新设置的匹配期数计算</div>
    <div>注：设置层级福利      未设置0 （所有统计福利不包含自身，自身消费请单独统计）</div>
    <div>注：福利商品 分别结算栏目可以看到 分别计算出的 商城/预售/众筹 兑换暂未统计</div>
    <div>注：福利设置启用（未启用为0） 商品id 层级名称 福利比例 福利购买类型（1商城2预售3众筹）自动启用
        暂时未做导出
        <a target="_blank"
           href="<?= $urlManager->createUrl(['/mch/settlementstatistics/data/user1']) ?>">福利统计数据页面的最后6列</a>、
        <a target="_blank" href="<?= $urlManager->createUrl(['/mch/settlementstatistics/data/user']) ?>">查询自身消费情况</a>。
    </div>
</div>
<div class="panel mb-3">
    <div class="panel-header"><?= $this->title ?></div>
    <div class="panel-body">
        <a class="btn btn-primary" href="<?= $urlManager->createUrl(['mch/settlementstatistics/fuli/level-edit']) ?>">福利设置</a>
        <div class="float-right mb-4">
            <form method="get">

                <?php $_s = ['keyword'] ?>
                <?php foreach ($_GET as $_gi => $_gv):if (in_array($_gi, $_s)) continue; ?>
                    <input type="hidden" name="<?= $_gi ?>" value="<?= $_gv ?>">
                <?php endforeach; ?>

                <div class="input-group">
                    <input class="form-control"
                           placeholder="福利用户id"
                           name="keyword"
                           autocomplete="off"
                           value="<?= isset($_GET['keyword']) ? trim($_GET['keyword']) : null ?>">
                    <span class="input-group-btn">
                    <button class="btn btn-primary">搜索</button>
                </span>
                </div>
            </form>
        </div>
        <table class="table table-bordered bg-white">
            <tr>
                <td>id</td>
                <td>订单号</td>
                <td>结算最后用户</td>
                <td>maxuser_id</td>
                <td>类别</td>
                <td>期数 </td>
                <td>金额 </td>
                <td>佣金状态</td>
                <td>下单时间</td>
                <td>创建时间</td>
                <td>操作</td>
            </tr>
            <?php foreach ($list as $index => $value): ?>
                <tr>
                    <td class="nowrap">  <?= $value['id'] ?> </td>
                    <td class="order-tab-1">
                        <span class="mr-5"><?= $value['order_no'] ?></span>
                    </td>
                    <td class="nowrap">id<?= $value['user_id'] ?>
                        <span>昵称：<?= $value['us_nickname'] ?></span></td>
                    <td class="nowrap">id<?= $value['max_user_id'] ?> </td>
                    <td class="nowrap">
                        <?php if ($value['type'] == 3): ?>众筹<?php endif; ?>
                        <?php if ($value['type'] == 2): ?>预售<?php endif; ?>
                        <?php if ($value['type'] == 1): ?>商城<?php endif; ?>
                    </td>
                    <td class="nowrap"><?= $value['source'] ?>级</td>
                    <td class="nowrap"><?= $value['money'] ?></td>
                    <td class="nowrap">
                        <?php if ($value['status'] == 3): ?>驳回<?php endif; ?>
                        <?php if ($value['status'] == 2): ?>成功发发放<?php endif; ?>
                        <?php if ($value['status'] == 1): ?>用户申请中<?php endif; ?>
                        <?php if ($value['status'] == 0): ?>系统成功计算<?php endif; ?>
                    </td>

                    <td class="order-tab-1">
                        <span class="mr-5"><?= date('Y-m-d', $value['addtime']) ?></span>
                    </td>
                    <td class="nowrap"><?= date('Y-m-d H:i:s', $value['usm_addtime']) ?></td>

                    <td class="nowrap">
                        <a class="btn btn-sm update" href="javascript:" data-toggle="modal"
                           data-target="#price" data-id="<?= $value['order_id'] ?>">查看</a>
                        <a class="btn btn-sm"
                           href="<?= $urlManager->createUrl(['mch/order/detail', 'order_id' => $value['order_id']]) ?>">订单</a>
                        <a class="btn btn-sm btn-primary"
                           href="<?= $urlManager->createUrl(['mch/settlementstatistics/fuli/sharemoney-edit', 'id' => $value['id']]) ?>">编辑</a>
                        <a class="btn btn-sm btn-danger del" href="javascript:" data-content="是否删除？"
                           data-url="<?= $urlManager->createUrl(['mch/settlementstatistics/fuli/sharemoney-del', 'id' => $value['id']]) ?>">删除</a>

                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="text-center">
            <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination,]) ?>
            <div class="text-muted"><?= $row_count ?>条数据</div>
        </div>
    </div>
</div>


<!--新加入的-->
<!-- 修改价格 -->
<div class="modal fade" data-backdrop="static" id="price">
    <div class="modal-dialog modal-sm" role="document" style="max-width: 400px">
        <div class="modal-content">
            <div class="modal-header">
                <b class="modal-title">确认发放</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input class="order-id" type="hidden">
                商城业绩:<input class="all_son_sum_price" ><br/>
                商城点奖:<input class="all_son_sum_price_level" ><br/>
                预售业绩:<input class="all_son_sum_price_bookmall" ><br/>
                预售点奖:<input class="all_son_sum_price_level_bookmall" ><br/>
                众筹业绩:<input class="all_son_sum_price_crowdc" ><br/>
                众筹点奖:<input class="all_son_sum_price_level_crowdc" ><br/>
                预计发放:<input class="all" ><br/>
                <input class=" form-control money" type="number" placeholder="请填写增加或减少的积分">
                <div class="text-danger form-error mb-3" style="display: none">错误信息</div>
            </div>
            <div class="modal-footer">
                <!--                <a href="javascript:" class="btn btn-primary add-price" data-type="1">确认</a>-->
                <!--                <a href="javascript:" class="btn btn-primary add-price" data-type="2">奖金</a>-->
                <a href="javascript:" class="btn btn-primary add-price" data-type="1">加价</a>
                <a href="javascript:" class="btn btn-danger add-price" data-type="2">优惠</a>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '.update', function () {
        var order_id = $(this).data('id');
        $('.order-id').val(order_id);

        $.loading();
        $.ajax({
            url: "<?=$urlManager->createUrl(['mch/settlementbonus/order/getsettlementbonus'])?>",
            type: 'get',
            dataType: 'json',
            data: {
                order_id: order_id,
            },
            success: function (res) {
                if (res.code == 0) {
                    $('.all_son_sum_price').val(res.data.all_son_sum_price);
                    $('.all_son_sum_price_level').val(res.data.all_son_sum_price_level);
                    $('.all_son_sum_price_bookmall').val(res.data.all_son_sum_price_bookmall);
                    $('.all_son_sum_price_level_bookmall').val(res.data.all_son_sum_price_level_bookmall);
                    $('.all_son_sum_price_crowdc').val(res.data.all_son_sum_price_crowdc);
                    $('.all_son_sum_price_level_crowdc').val(res.data.all_son_sum_price_level_crowdc);
                    $('.all').val(res.data.all);

                    $.loadingHide();
                } else {
                    $('.send-price').val(res.msg);
                }
            }
        });
    });
    $(document).on('click', '.status', function () {
        var type = $(this).data('type');
        var id = $(this).data('id');
        var text = '';
        if (type == 0) {
            text = "禁用";
        } else {
            text = "启用";
        }
        $.myConfirm({
            title: '提示',
            content: '是否' + text + '？',
            confirm: function () {
                $.ajax({
                    url: "<?=$urlManager->createUrl(['mch/settlementstatistics/fuli/level-type'])?>",
                    dataType: 'json',
                    type: 'get',
                    data: {
                        type: type,
                        id: id
                    },
                    success: function (res) {
                        if (res.code == 0) {
                            window.location.reload();
                        } else {
                            $.myAlert({
                                title: '提示',
                                content: res.msg
                            });
                        }
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).on('click', '.del', function () {
        var a = $(this);
        $.myConfirm({
            title: '提示',
            content: a.data('content'),
            confirm: function () {
                $.ajax({
                    url: a.data('url'),
                    dataType: 'json',
                    type: 'get',
                    success: function (res) {
                        if (res.code == 0) {
                            window.location.reload();
                        } else {
                            $.myAlert({
                                title: '提示',
                                content: res.msg
                            });
                        }
                    }
                });
            }
        });
    });

</script>
