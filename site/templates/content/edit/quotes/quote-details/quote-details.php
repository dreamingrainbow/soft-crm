<div id="no-more-tables">
    <table class="table-condensed cf order-details table-bordered numeric">
        <thead class="cf">
            <tr>
                <th>Item / Description</th> <th class="numeric" width="90">Price</th> <th class="numeric">Quantity</th> <th class="numeric" width="90">Total</th>
                <th>Whse</th>
                <th>
                	<div class="row">
                    	<div class="col-xs-3">Details</div><div class="col-xs-3">Documents</div> <div class="col-xs-2">Notes</div> <div class="col-xs-4">Edit</div>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
       		<?php $quote_details = get_quotedetails(session_id(), $quote->quotnbr, false, false); ?>
            <?php foreach ($quote_details as $detail) : ?>
            	<?php
					$detailnoteurl = $config->pages->notes.'redir/?action=get-quote-notes&qnbr='.$quote->quotnbr.'&linenbr='.$detail['linenbr'].'&modal=modal';

					if ($detail['notes'] != 'Y') {
						$detnoteicon = '<a class="load-notes text-muted" href="'.$detailnoteurl.'" data-modal="#ajax-modal"><i class="material-icons md-36" title="View order notes">&#xE0B9;</i></a>';
					} else {
						$detnoteicon = '<a class="load-notes" href="'.$detailnoteurl.'" data-modal="#ajax-modal"> <i class="material-icons md-36" title="View order notes">&#xE0B9;</i></a>';
					}

                    /*
                    if ($detail['haveitemdoc'] != 'Y') {
                        $detaildocumenticon = '<a href="#" class="text-muted"><i class="material-icons md-36">&#xE873;</i></a> ';
                    } else {
                        $detaildocumenticon = '<a href="'.$detailnoteurl.'"><i class="material-icons md-36">&#xE873;</i></a> ';
                    }
                    */

                    $detaildocumenticon = '';

				?>
            <tr>
                <td data-title="Item">
                    <?php if ($detail['errormsg'] != '') : ?>
                        <div class="btn-sm btn-danger">
                          <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <strong>Error!</strong> <?= $detail['errormsg']; ?>
                        </div>
                    <?php else : ?>
                        <?= $detail['itemid']; ?>
                        <?php if (strlen($detail['vendoritemid'])) { echo ' '.$detail['vendoritemid'];} ?>
                        <br> <?= $detail['desc1']; ?>
					<?php endif; ?>
                </td>
                <td data-title="Price" class="text-right">$ <?= formatMoney($detail['quotprice']); ?></td>
                <td data-title="Ordered" class="text-right"><?= $detail['quotunit'] + 0; ?></td>
                <td data-title="Total" class="text-right">$ <?= formatMoney($detail['quotprice'] * $detail['quotunit']); ?></td>
                <td data-title="Warehouse">MN</td>
                <td class="action">
                    <div class="row">
                        <div class="col-xs-3">
                            <span class="visible-xs-block action-label">Details</span>
                            <a href="<?= $config->pages->ajax."load/view-detail/quote/?qnbr=".$quote->quotnbr."&line=".$detail['linenbr']; ?>" class="btn btn-xs btn-primary view-item-details" data-itemid="<?= $detail['itemid']; ?>" data-kit="<?php echo $detail['kititemflag']; ?>" data-modal="#ajax-modal"> <i class="material-icons">&#xE8DE;</i><a>
                        </div>
                        <div class="col-xs-3"> <span class="visible-xs-block action-label">Documents</span> <?= $detaildocumenticon; ?></div>
                        <div class="col-xs-2"> <span class="visible-xs-block action-label">Notes</span> <?= $detnoteicon; ?></div>
                        <div class="col-xs-4"> <span class="visible-xs-block action-label">Update</span>
                            <?php if ($editquotedisplay->canedit) : ?>
                                <a href="<?= $config->pages->ajax."load/edit-detail/quote/?qnbr=".$quote->quotnbr."&line=".$detail['linenbr']; ?>" class="btn btn-sm btn-warning update-line" data-line="<?= $detail['recno']; ?>" data-itemid="<?= $detail['itemid']; ?>" data-kit="<?php echo $detail['kititemflag']; ?>"  data-custid="<?= $quote->custid; ?>">
                                    <i class="fa fa-pencil fa-1-5x" aria-hidden="true"></i><span class="sr-only">Edit</span>
                                </a>&nbsp;
                            <?php else : ?>
                                <a href="<?= $config->pages->ajax."load/edit-detail/quote/?qnbr=".$quote->quotnbr."&line=".$detail['linenbr']; ?>" class="btn btn-sm btn-warning update-line" data-line="<?= $detail['recno']; ?>" data-itemid="<?= $detail['itemid']; ?>" data-kit="<?php echo $detail['kititemflag']; ?>"  data-custid="<?= $quote->custid; ?>">
                                    <i class="fa fa-pencil fa-1-5x" aria-hidden="true"></i><span class="sr-only">Edit</span>
                                </a>&nbsp;
                            <?php endif; ?>
                            <form class="inline-block" action="<?php echo $config->pages->quotes."redir/"; ?>" method="post">
                                <input type="hidden" name="action" value="remove-line">
                                <input type="hidden" name="qnbr" value="<?= $qnbr; ?>">
                                <input type="hidden" name="linenbr" value="<?= $detail['linenbr']; ?>">
                                <button type="submit" class="btn btn-sm btn-danger" name="button">
                                    <i class="fa fa-trash fa-1-5x" aria-hidden="true"></i><span class="sr-only">Delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
			<?php endforeach; ?>
        </tbody>
    </table>
</div>
