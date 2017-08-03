<tr class="detail">
    <th class="text-center">Item ID</th>
    <th colspan="2">Description</th>
    <th>Price</th>
    <th>Qty</th>
    <th>Ext Price</th>
    <th>Notes</th>
    <th></th>
</tr>

<?php $quotedetails = get_quote_details(session_id(), $qtnbr, false); ?>
<?php foreach ($quotedetails as $quotedetail) : ?>
    <?php
        $detailnoteurl = $config->pages->notes.'redir/?action=get-quote-notes&qnbr='.$qtnbr.'&linenbr='.$quotedetail['linenbr'].'&modal=modal'; 
        if ($quotedetail['notes'] == 'Y') {
            $detnoteicon = '<a class="h3 load-notes" href="'.$detailnoteurl.'" data-modal="#ajax-modal"> <i class="material-icons" title="View quote notes">&#xE0B9;</i></a>';
        } else {
            $detnoteicon = '<a class="h3 load-notes text-muted" href="'.$detailnoteurl.'" data-modal="#ajax-modal"><i class="material-icons" title="View quote notes">&#xE0B9;</i></a>';
        }


    ?>
    <tr class="detail">
        <td class="text-center"><?= $quotedetail['itemid']; ?></td>
        <td colspan="2"><?= $quotedetail['desc1']; ?></td>
        <td class="text-right">$ <?= $quotedetail['quotprice']; ?></td>
        <td class="text-right"><?= $quotedetail['quotunit']; ?></td>
        <td class="text-right">$ <?= formatmoney($quotedetail['quotprice'] * $quotedetail['quotunit']); ?></td>
        <td><?= $detnoteicon; ?></td>
        <td></td>
    </tr>
<?php endforeach; ?>
