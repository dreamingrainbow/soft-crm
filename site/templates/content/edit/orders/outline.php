<?php
    $activetab = (empty($input->get->show)) ? 'orderhead' : $input->get->text('show');
    $tabs = array(
        'orderhead' => array('href' => 'orderhead', "id" => 'orderhead-link', 'text' => 'Sales Order Header', 'tabcontent' => 'edit/orders/orderhead-form.php'),
        'details' => array('href' => 'details', "id" => 'salesdetail-link', 'text' => 'Sales Order Details', 'tabcontent' => 'edit/orders/order-details/details-page.php'),
        'documents' => array('href' => 'documents', "id" => 'documents-link', 'text' => 'View Documents', 'tabcontent' => 'edit/orders/documents-page.php'),
        'tracking' => array('href' => 'tracking', "id" => 'tracking-tab-link', 'text' => 'View Tracking', 'tabcontent' => 'edit/orders/tracking-page.php'),
        'actions' => array('href' => 'actions', "id" => 'actions-tab-link', 'text' => 'View Actions', 'tabcontent' => 'edit/orders/actions-page.php')
    );
?>
<?php if ((!$ordereditdisplay->canedit)) : ?>
   <div class="row">
       <div class="col-xs-12"><?php include $config->paths->content.'edit/orders/read-only-msg.php'; ?></div>
    </div>
<?php endif; ?>

<ul id="order-tab" class="nav nav-tabs nav_tabs">
    <?php foreach ($tabs as $tab) : ?>
        <?php if ($tab == $tabs[$activetab]) : ?>
            <li class="active"><a href="<?= '#'.$tab['href']; ?>" id="<?=$tab['id']; ?>" data-toggle="tab"><?=$tab['text']; ?></a></li>
        <?php else : ?>
            <li><a href="<?= '#'.$tab['href']; ?>" id="<?=$tab['id']; ?>" data-toggle="tab"><?=$tab['text']; ?></a></li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>

<div id="order-tabs" class="tab-content">
    <?php foreach ($tabs as $tab) : ?>
        <?php if ($tab == $tabs[$activetab]) : ?>
            <div class="tab-pane fade in active" id="<?= $tab['href']; ?>">
                <br>
                <?php include $config->paths->content.$tab['tabcontent']; ?>
            </div>
        <?php else : ?>
            <div class="tab-pane fade" id="<?= $tab['href']; ?>">
                <br>
                <?php include $config->paths->content.$tab['tabcontent']; ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<?php if ($session->editdetail) : ?>
    <script>
        $(function() {
            $('#salesdetail-link').click();
        })
    </script>
    <?php $session->remove('editdetail'); ?>
<?php endif; ?>
