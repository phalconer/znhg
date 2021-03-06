<?php
/**
 * User: Xany <762632258@qq.com>
 * Date: 2017/6/19
 * Time: 16:52
 */
use \app\models\User;

$urlManager = Yii::$app->urlManager;
$this->title = '集市管理';
$this->params['active_nav_group'] = 4;
?>
<div class="alert alert-info rounded-0">
    <div>所有交易欢乐豆总数量： <?php echo  $people['peoplesellcount_huanledou'] ?></div>
    <div>所有系统收取手续费（欢乐豆个数）： <?php echo  $people['peoplesellcount_huanledou_charge'] ?></div>
    <div>所有系统奖励优惠券数量： <?php echo  $people['peoplesellcount_xtjl'] ?></div>
    <div>所有正在售卖优惠券数量： <?php echo  $people['peoplesellcount_num'] ?></div>
    <div>所有活跃买家数量： <?php echo  $people['peoplesellcount'] ?></div>
    <div>所有活跃买家数量： <?php echo  $people['peoplebuyercount'] ?></div>
    <div>注：可以搜索 0/1/2 （未交易/已经交易/全部） </div>
    </div>
</div>
<div class="panel mb-3">
    <div class="panel-header"><?= $this->title ?></div>
    <div class="panel-body">

        <form method="get" class="input-group mb-3" style="max-width: 30rem;">
            <input type="hidden" name="status" value="<?= Yii::$app->request->get('status') ?>">
            <span class="input-group-addon">日期查找</span>
            <input class="form-control" id="date_begin" value="<?= Yii::$app->request->get('date_begin') ?>" name="date_begin">
            <span class="input-group-addon">~</span>
            <input class="form-control" id="date_end" value="<?= Yii::$app->request->get('date_end') ?>" name="date_end">
            <span class="input-group-btn">
                    <button class="btn btn-secondary">查找</button>
                </span>
        </form>

        <div class="dropdown float-left">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php if (isset($_GET['level'])): ?>
                    <?php foreach ($level_list as $index => $value): ?>
                        <?php if ($value['level'] == $_GET['level']): ?>
                            <?= $value['name']; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    全部类型
                <?php endif; ?>
            </button>

            <a class="btn btn-secondary"
               href="<?= Yii::$app->request->url . "&flag=EXPORT" ?>">导出所有交易详情(含条件)</a>
            <a class="btn btn-secondary"
               href="<?= Yii::$app->request->url . "?flag=EXPORT" ?>">导出所有交易详情全部</a>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                 style="max-height: 200px;overflow-y: auto">
                <a class="dropdown-item" href="<?= $urlManager->createUrl(['mch/fair/index']) ?>">全部会员</a>
                <?php foreach ($level_list as $index => $value): ?>
                    <a class="dropdown-item"
                       href="<?= $urlManager->createUrl(array_merge(['mch/fair/index'], $_GET, ['level' => $value['level'], 'page' => 1])) ?>"><?= $value['name'] ?></a>
                <?php endforeach; ?>
            </div>

            <a class="btn btn-secondary"
               href="<?= Yii::$app->request->url . "&flag=EXPORTall" ?>">导出交易总数量额(含条件)</a>
            <a class="btn btn-secondary"
               href="<?= Yii::$app->request->url . "?flag=EXPORTall" ?>">导出交易总数量额全部</a>
        </div>
        <div class="float-right mb-4">
            <form method="get">

                <?php $_s = ['keyword'] ?>
                <?php foreach ($_GET as $_gi => $_gv):if (in_array($_gi, $_s)) continue; ?>
                    <input type="hidden" name="<?= $_gi ?>" value="<?= $_gv ?>">
                <?php endforeach; ?>

                <div class="input-group">
                    <input class="form-control"
                           placeholder="微信昵称/1交易成功/0交易中的"
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
            <thead>
            <tr>
                <th>ID</th>
                <th>头像</th>
                <th>买家头像</th>
                <th>优惠券本次交易数量</th>
                <th>发布时候欢乐豆显示卖价格</th>
                <th>手续费价值欢乐豆</th>
                <th>系统奖励</th>
                <th>已交易</th>
                <th>订单数</th>
                <th>发布时间</th>
                <th>身份</th>
                <th>卡券</th>
                <th>当前欢乐豆</th>
                <th>当前优惠券</th>
                <th>卡券数量</th>
                <th>当前积分</th>
                <th>操作</th>
            </tr>
            </thead>
            <?php foreach ($list as $u): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td>
                        <img src="<?= $u['avatar_url'] ?>" style="width: 34px;height: 34px;"><br><?= $u['nickname']; ?><br><?=$u['wechat_open_id']?>
                    </td>
                    <td>
                     <img src="<?= $u['avatar_url_buyer'] ?>" style="width: 34px;height: 34px;"><br><?= $u['nickname_buyer']; ?><br>
                       ( 欢乐豆:<?=$u['hld_buyer']?>优惠券:<?=$u['coupon_buyer']?>积分:<a class="btn btn-sm btn-link"href="<?= $urlManager->createUrl(['mch/fair/rechange-log', 'user_id' => $u['user_id_buyer']]) ?>"><?= $u['integral'] ?></a>)
                    </td>
                    <td><?= $u['num']; ?> </td>
                    <td><?= $u['huanledou']; ?> </td>
                    <td><?= $u['huanledou_charge']; ?> </td>
                    <td><?= $u['xtjl']; ?>  </td>
                    <td><?= $u['is_exchange']; ?> </td>

                    <td><a class="btn btn-sm btn-link"
                           href="<?= $urlManager->createUrl(['mch/fair/card', 'user_id' => $u['user_id']]) ?>"><?= User::getCardCount($u['id']) ?></a></td>
                    <td><?= date('Y-m-d H:i:s', $u['addtime']) ?></td>
                    <td>
                        <?= $u['l_name'] ? $u['l_name'] : '普通用户' ?>
                        <?= $u['is_clerk'] == 1 ? "（核销员）" : "" ?>
                    </td>
                    <td>
                        <a class="btn btn-sm btn-link"
                           href="<?= $urlManager->createUrl(['mch/order/index', 'user_id' => $u['user_id']]) ?>"><?= User::getCount($u['id']) ?></a>
                    </td>
                    <td>
                        <a class="btn btn-sm btn-link"
                           href="<?= $urlManager->createUrl(['mch/fair/hld', 'user_id' => $u['user_id']]) ?>"><?= $u['hld'] ?></a>
                    </td>
                    <td>
                        <a class="btn btn-sm btn-link"
                           href="<?= $urlManager->createUrl(['mch/fair/hld', 'user_id' => $u['user_id']]) ?>"><?= $u['coupon'] ?></a>
                    </td>
                    <td>
                        <a class="btn btn-sm btn-link"
                           href="<?= $urlManager->createUrl(['mch/fair/coupon', 'user_id' => $u['user_id']]) ?>"><?= User::getCouponcount($u['id']) ?></a>
                    </td>
                    <td>
                        <a class="btn btn-sm btn-link"
                           href="<?= $urlManager->createUrl(['mch/fair/rechange-log', 'user_id' => $u['user_id']]) ?>"><?= $u['integral'] ?></a>
                    </td>
                    <td>
                        <a class="btn btn-sm btn-primary"
                           href="<?= $urlManager->createUrl(['mch/fair/edit', 'id' => $u['user_id']]) ?>">编辑</a>
                        <a class="btn btn-sm btn-success rechangeBtn"
                           data-toggle="modal" data-target="#attrAddModal"
                           href="javascript:;"
                           data-integral="<?= $u['integral'] ?>"
                           data-id="<?= $u['user_id'] ?>">充值积分</a>
                    </td>
                    <!--
                <td>
                    <a class="btn btn-sm btn-danger del" href="javascript:"
                       data-url="<?= $urlManager->createUrl(['mch/fair/del', 'id' => $u['user_id']]) ?>"
                       data-content="是否删除？">删除</a>
                </td>
                -->
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="text-center">
            <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination,]) ?>
            <div class="text-muted"><?= $row_count ?>条数据</div>
        </div>
    </div>
</div>
<!-- 充值积分 -->
<div class="modal fade" id="attrAddModal" data-backdrop="static">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">充值积分</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group short-row">
                    <label class="custom-control custom-radio">
                        <input value="1" checked name="rechangeType" type="radio" class="custom-control-input">
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">充值</span>
                    </label>
                    <label class="custom-control custom-radio">
                        <input value="2" name="rechangeType" type="radio" class="custom-control-input integral-reduce">
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">扣除</span>
                    </label>
                </div>

                <input class="form-control" id="integral" placeholder="请填写充值积分" value="0">
                <input type="hidden" id="user_id" value="">
                <div class="form-error text-danger mt-3 rechange-error" style="display: none">ddd</div>
                <div class="form-success text-success mt-3" style="display: none">sss</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary save-rechange">提交</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '.del', function () {
        var a = $(this);
        $.myConfirm({
            content: a.data('content'),
            confirm: function () {
                $.ajax({
                    url: a.data('url'),
                    type: 'get',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 0) {
                            window.location.reload();
                        } else {
                            $.myAlert({
                                title: res.msg
                            });
                        }
                    }
                });
            }
        });
        return false;
    });
    $(document).on('click', '.rechangeBtn', function () {
        var a = $(this);
        var id = a.data('id');
        var integral = a.data('integral');
        $('#user_id').val(id);
        $('.integral-reduce').attr('data-integral', integral);
    });
    $(document).on('change', '.integral-reduce', function () {
        $('#integral').val($(this).data('integral'));
    });
    $(document).on('click', '.save-rechange', function () {
        var user_id = $('#user_id').val();
        var integral = $('#integral').val();
        var oldIntegral = $('.integral-reduce').data('integral');
        var rechangeType = $("input[type='radio']:checked").val();
        if (rechangeType == '2') {
            if (integral > oldIntegral) {
                $('.rechange-error').css('display', 'block');
                $('.rechange-error').text('当前用户积分不足');
                return;
            }
        }
        if (!integral || integral <= 0) {
            $('.rechange-error').css('display', 'block');
            $('.rechange-error').text('请填写积分');
            return;
        }
        $.ajax({
            url: "<?= Yii::$app->urlManager->createUrl(['mch/fair/rechange']) ?>",
            type: 'post',
            dataType: 'json',
            data: {user_id: user_id, integral: integral, _csrf: _csrf, rechangeType: rechangeType},
            success: function (res) {
                if (res.code == 0) {
                    window.location.reload();
                } else {
                    $('.rechange-error').css('display', 'block');
                    $('.rechange-error').text(res.msg);
                }
            }
        });
    });



    $.datetimepicker.setLocale('zh');

    $(function () {
        $('#date_begin').datetimepicker({
            format: 'Y-m-d',
            onShow: function (ct) {
                this.setOptions({
                    maxDate: $('#date_end').val() ? $('#date_end').val() : false
                })
            },
            timepicker: false
        });
        $('#date_end').datetimepicker({
            format: 'Y-m-d',
            onShow: function (ct) {
                this.setOptions({
                    minDate: $('#date_begin').val() ? $('#date_begin').val() : false
                })
            },
            timepicker: false
        });
    });


</script>
