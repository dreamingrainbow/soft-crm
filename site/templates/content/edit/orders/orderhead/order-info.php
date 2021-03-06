<legend>Contact</legend>
<table class="table table-striped table-bordered table-condensed">
	<tr>
    	<td class="control-label">Contact Name</td>
        <td> <input type="text" name="contact" class="form-control input-sm required" id="shiptocontact" value="<?= $order->contact; ?>"> </td>
    </tr>
    <?php if ($config->phoneintl) : ?>
		<tr>
			<td class="control-label">International ?</td>
			<td>
				<select class="form-control input-sm" name="intl" onChange="showphone(this.value)">
					<?php foreach ($config->yesnoarray as $key => $value) : ?>
						<?php if ($order->phintl == $value) {$selected = 'selected';} else {$selected = '';} ?>
						<option value="<?= $value; ?>" <?= $selected; ?>><?= $key; ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
   		<?php include $config->paths->content.'edit/orders/orderhead/phone-intl.php'; ?>
    	<?php include $config->paths->content.'edit/orders/orderhead/phone-domestic.php'; ?>
    <?php else : ?>
    	<?php include $config->paths->content.'edit/orders/orderhead/phone-domestic.php'; ?>
    <?php endif; ?>
    
    <tr>
    	<td class="control-label">Contact Email</td>
        <td> <input type="email" name="contact-email" class="form-control input-sm email" value="<?= $order->email; ?>"> </td>
    </tr>
</table>

<legend>Sales Order</legend>
<table class="table table-striped table-bordered table-condensed">
	<tr class="bg-info">
    	<td class="control-label">Sales Person</td> <td> <p class="form-control-static"><?= $order->sp1; ?> - <?= $order->sp1name; ?></p> </td>
    </tr>
	<tr>
    	<td class="control-label">Cust PO<b class="text-danger">*</b></td> <td> <input type="text" name="custpo" class="form-control input-sm required" value="<?= $order->custpo; ?>"> </td>
    </tr>
    <tr>
    	<td class="control-label">Release #</td> <td> <input type="text" name="release-number" class="form-control input-sm" value="<?= $order->releasenbr; ?>"> </td>
    </tr>
	<tr>
    	<td>Shipvia</td>
        <td>
            <select name="shipvia" class="form-control input-sm">
				<?php $shipvias = getshipvias(session_id()); ?>
                <?php foreach($shipvias as $shipvia) : ?>
					<?php if ($order->shipviacd == $shipvia['code']) {$selected = 'selected'; } else {$selected = ''; } ?>
                    <option value="<?= $shipvia['code']; ?>" <?= $selected; ?>><?= $shipvia['via']; ?> </option>
                <?php endforeach; ?>
            </select>
        </td>
    </tr>
	<tr>
    	<td class="control-label">Terms Code</td> <td class="value"><?= $order->termcode; ?> - <?= $order->termdesc; ?></td>
    </tr>
    <tr>
    	<td class="control-label">Order Date</td> <td class="value text-right"><?= $order->orderdate; ?></td>
    </tr>
    <tr>
    	<td class="control-label">Request Date</td>
        <td>
			<div class="input-group date">
                <?php $name = 'rqstdate'; $value = $order->rqstdate; ?>
				<?php include $config->paths->content."common/date-picker.php"; ?>
            </div>
        </td>
    </tr>
    <tr>
    	<td class="control-label">Ship Complete</td>
        <td>
			<select name="ship-complete" class="form-control input-sm">
				<?php foreach ($config->yesnoarray as $key => $value) : ?>
                    <?php if ($order->shipcom == $value) {$selected = 'selected'; } else {$selected = ''; } ?>
                    <option value="<?= $value; ?>" <?= $selected; ?>><?= $key; ?></option>
                <?php endforeach; ?>
            </select>
        </td>
    </tr>
    <?php if ($order->termtype == 'STD') : ?>
        <tr>
            <td class="control-label">Payment Type</td>
            <td>
                <select name="paytype" class="form-control input-sm required" onChange="showcredit(this.value)">
                    <option value="<?= $order->paytype; ?>">-- Choose Payment Type -- </option>
                    <option value="billacc" <?php if ($order->paytype == 'bill') echo 'selected'; ?> >Bill To Account</option>
                    <option value="cc" <?php if ($order->paytype == 'cc') {echo 'selected';} ?>>Credit Card</option>
                </select>
            </td>
        </tr>
    <?php endif; ?>
</table>
<?php $creditcard = $ordereditdisplay->get_creditcard(); ?>
<?php if ($order->termtype == 'STD') : ?>
    <div id="credit" class="<?= $ordereditdisplay->showhide_creditcard($order); ?>">
        <?php include $config->paths->content.'edit/orders/orderhead/credit-card-form.php'; ?>
    </div>
<?php else : ?>
	<?php include $config->paths->content.'edit/orders/orderhead/credit-card-form.php'; ?>
<?php endif; ?>
