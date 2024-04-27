<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">商店暂不可用，可能是网络问题</div><?php endif ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">应用商店 - <?= $sub_title ?></h1>
</div>
<div class="row mb-4 ml-1">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./store.php">模板主题</a></li>
        <li class="nav-item"><a class="nav-link active" href="./store.php?action=plu"><i class="icofont-plugin"></i> 扩展插件</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="./store.php?action=svip">铁杆SVIP专属</a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=mine">我的已购</a></li>
    </ul>
</div>
<div class="d-flex flex-column flex-sm-row justify-content-between mb-4 ml-1">
    <div class="mb-3 mb-sm-0">
        <a href="./store.php?action=plu" class="badge badge-success m-1 p-2">全部</a>
        <a href="./store.php?action=plu&tag=free" class="badge badge-success m-1 p-2">仅看免费</a>
        <a href="./store.php?action=plu&tag=paid" class="badge badge-warning m-1 p-2">仅看付费</a>
        <a href="./store.php?action=plu&tag=promo" class="badge badge-danger m-1 p-2">限时优惠</a>
        <a href="./store.php?action=plu&tag=free_top" class="badge badge-light text-primary m-1 p-2 small">免费排行榜</a>
        <a href="./store.php?action=plu&tag=paid_top" class="badge badge-light text-primary m-1 p-2 small">付费排行榜</a>
    </div>
    <div class="d-flex mb-3 mb-sm-0">
        <form action="#" method="get" class="mr-sm-2">
            <select name="action" id="plugin-category" class="form-control">
                <?php foreach ($categories as $k => $v) { ?>
                    <option value="<?= $k; ?>" <?= $sid == $k ? 'selected' : '' ?>><?= $v; ?></option>
                <?php } ?>
            </select>
        </form>
        <form action="./store.php" method="get" class="form-inline ml-2">
            <div class="input-group">
                <input type="hidden" name="action" value="plu">
                <input type="text" name="keyword" value="<?= $keyword ?>" class="form-control small" placeholder="搜索插件...">
                <div class="input-group-append">
                    <button class="btn btn-outline-success" type="submit">搜索</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="mb-3">
    <?php if (!empty($plugins)): ?>
        <div class="d-flex flex-wrap app-list">
            <?php foreach ($plugins as $k => $v):
                $icon = $v['icon'] ?: "./views/images/plugin.png";
                ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card mb-4 shadow-sm">
                        <a href="#appModal" class="p-1" data-toggle="modal" data-target="#appModal" data-name="<?= $v['name'] ?>" data-url="<?= $v['app_url'] ?>" data-buy-url="<?= $v['buy_url'] ?>">
                            <img class="bd-placeholder-img card-img-top" alt="cover" width="100%" height="225" src="<?= $icon ?>">
                        </a>
                        <div class="card-body">
                            <p class="card-text font-weight-bold">
                                <?php if ($v['top'] === 1): ?>
                                    <span class="badge badge-success p-1">今日推荐</span>
                                <?php endif; ?>
                                <a href="#appModal" data-toggle="modal" data-target="#appModal" data-name="<?= $v['name'] ?>" data-url="<?= $v['app_url'] ?>" data-buy-url="<?= $v['buy_url'] ?>"><?= $v['name'] ?></a>
                            </p>
                            <p class="card-text text-muted">
                                售价：
                                <?php if ($v['price'] > 0): ?>
                                    <?php if ($v['promo_price'] > 0): ?>
                                        <span style="text-decoration:line-through"><?= $v['price'] ?><small>元</small></span>
                                        <span class="text-danger"><?= $v['promo_price'] ?><small>元</small></span>
                                    <?php else: ?>
                                        <span class="text-danger"><?= $v['price'] ?><small>元</small></span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-success">免费</span>
                                <?php endif; ?>
                                <br>
                                <small>
                                    开发者：<a href="./store.php?action=plu&author_id=<?= $v['author_id'] ?>"><?= $v['author'] ?></a><br>
                                    版本号：<?= $v['ver'] ?><br>
                                    下载次数：<?= $v['downloads'] ?><br>
                                    更新时间：<?= $v['update_time'] ?><br>
                                </small>
                            </p>
                            <div class="card-text d-flex justify-content-between">
                                <div class="installMsg"></div>
                                <div>
                                    <?php if ($v['svip']): ?>
                                        <a href="https://www.emlog.net/register" class="btn btn-warning" target="_blank">铁杆专属</a>
                                    <?php endif; ?>
                                    <?php if ($v['price'] > 0): ?>
                                        <a href="https://www.emlog.net/order/submit/plugin/<?= $v['id'] ?>" class="btn btn-danger" target="_blank">立即购买</a>
                                    <?php else: ?>
                                        <a href="#" class="btn btn-success installBtn" data-url="<?= urlencode($v['download_url']) ?>" data-type="plu">免费安装</a>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <div class="col-md-12 page my-5"><?= $pageurl ?></div>
    <?php else: ?>
        <div class="col-md-12">
            <div class="alert alert-info">暂未找到结果，应用商店进货中，敬请期待：）</div>
        </div>
    <?php endif ?>
</div>
<div class="modal fade" id="appModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <div>
                    <a href="" class="modal-buy-url text-muted" target="_blank">去官网查看</a>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $("#menu_store").addClass('active');
        setTimeout(hideActived, 3600);

        $('#plugin-category').on('change', function () {
            var selectedCategory = $(this).val();
            if (selectedCategory) {
                window.location.href = './store.php?action=plu&sid=' + selectedCategory;
            }
        });

        // 查看应用信息
        $('#appModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var name = button.data('name');
            var url = button.data('url');
            var buy_url = button.data('buy-url');
            var modal = $(this);

            modal.find('.modal-body').empty();
            modal.find('.modal-title').html(name);
            modal.find('.modal-buy-url').attr('href', buy_url);
            var iframe = $('<iframe>', {
                'class': 'iframe-content',
                'src': url,
                'frameborder': 0,
                'style': 'width: 100%; height: 100%;'
            });
            modal.find('.modal-body').append(iframe);
        });
    });
</script>
