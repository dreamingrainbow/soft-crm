<legend>Contact</legend>
<table class="table table-striped table-bordered table-condensed">
	<tr>
    	<td class="control-label">Contact Name</td>
        <td> <input type="text" name="contact" class="form-control input-sm required" id="shiptocontact" value="<?= $quote->contact; ?>"> </td>
    </tr>
    <?php if ($config->phoneintl) : ?>
		<tr>
			<td class="control-label">International ?</td>
			<td>
				<select class="form-control input-sm" name="intl" onChange="showphone(this.value)">
					<?php foreach ($config->yesnoarray as $key => $value) : ?>
						<?php $selected = ($quote->phintl == $value) ? 'selected' : ''; ?>
						<option value="<?= $value; ?>" <?= $selected; ?>><?= $key; ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
   		<?php include $config->paths->content.'edit/quotes/quotehead/phone-intl.php'; ?>
    	<?php include $config->paths->content.'edit/quotes/quotehead/phone-domestic.php'; ?>
    <?php else : ?>
    	<?php include $config->paths->content.'edit/quotes/quotehead/phone-domestic.php'; ?>
    <?php endif; ?>
    <tr>
    	<td class="control-label">Contact Email</td>
        <td> <input type="email" name="contact-email" class="form-control input-sm email" value="<?= $quote->emailadr; ?>"> </td>
    </tr>
</table>

<legend>Quote</legend>
<table class="table table-striped table-bordered table-condensed">
	<tr>
    	<td class="control-label">Sales Person</td> <td> <p class="form-control-static"><?= $quote->sp1; ?> - <?= $quote->sp1name; ?></p> </td>
    </tr>
	<tr>
    	<td class="control-label">Cust PO</td> <td> <input type="text" name="custpo" class="form-control input-sm" value="<?= $quote->custpo; ?>"> </td>
    </tr>
    <tr>
    	<td class="control-label">Reference</td> <td> <input type="text" name="reference" class="form-control input-sm" value="<?= $quote->custref; ?>"> </td>
    </tr>

	<tr>
    	<td class="control-label">Terms Code</td> <td class="value"><?= $quote->termcode; ?> - <?= $quote->termcodedesc; ?></td>
    </tr>
    <tr>
    	<td class="control-label">Tax Code</td> <td class="value"><?= $quote->taxcode; ?> - <?= $quote->taxcodedesc; ?></td>
    </tr>
    <tr>
    	<td class="control-label">Quote Date</td> <td class="value text-right"><?= $quote->quotdate; ?></td>
    </tr>
    <tr>
    	<td class="control-label">Review Date</td>
        <td>
			<div class="input-group date">
            	<?php $name = 'reviewdate'; $value = $quote->revdate;  ?>
				<?php include $config->paths->content."common/date-picker.php"; ?>
            </div>
        </td>
    </tr>
    <tr>
    	<td class="control-label">Expire Date</td>
        <td>
			<div class="input-group date">
               	<?php $name = 'expiredate'; $value = $quote->expdate;  ?>
				<?php include $config->paths->content."common/date-picker.php"; ?>
            </div>
        </td>
    </tr>
    <tr>
        <td class="control-label">Shipvia</td>
        <td>
            <select name="shipvia" class="form-control input-sm">
				<option value="N/A">Choose Ship Method</option>
                <?php $shipvias = getshipvias(session_id()); ?>
                <?php foreach($shipvias as $shipvia) : ?>
					<?php $selected = ($quote->sviacode == $shipvia['code']) ? 'selected' : ''; ?>
                    <option value="<?= $shipvia['code']; ?>" <?= $selected; ?>><?= $shipvia['via']; ?> </option>
                <?php endforeach; ?>
            </select>
        </td>
    </tr>
    <tr>
    	<td class="control-label">FOB</td> <td class="value text-right"><?= $quote->fob; ?></td>
    </tr>
    <tr>
    	<td class="control-label">Delivery</td> <td> <input type="text" name="delivery" class="form-control input-sm" value="<?= $quote->deliverydesc; ?>"> </td>
    </tr>
    <tr>
    	<td class="control-label">Whse</td> <td class="value text-right"><?= $quote->whse; ?></td> <?php //TODO ?>
    </tr>
    <tr>
    	<td class="control-label">Care Of</td> <td> <input type="text" name="careof" class="form-control input-sm" value="<?= $quote->careof; ?>"> </td>
    </tr>
</table>
