<?php
	$tb = new Table('class=table table-striped table-bordered table-condensed table-excel|id=invoices');
	$tb->tablesection('thead');
		for ($x = 1; $x < $table['detail']['maxrows'] + 1; $x++) {
			$tb->tr();
			for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
				if (isset($table['detail']['rows'][$x]['columns'][$i])) {
					$column = $table['detail']['rows'][$x]['columns'][$i];
					$class = $config->textjustify[$fieldsjson['data']['detail'][$column['id']]['headingjustify']];
					$colspan = $column['col-length'];
					$tb->th('colspan='.$colspan.'|class='.$class, $column['label']);
					if ($colspan > 1) { $i = $i + ($colspan - 1); }
				} else {
					$tb->th();
				}
			}
		}
	$tb->closetablesection('thead');
	$tb->tablesection('tbody');
		foreach($invoicejson['data']['invoices'] as $invoice) {
			if ($invoice != $invoicejson['data']['invoices']['TOTAL']) {
				for ($x = 1; $x < $table['detail']['maxrows'] + 1; $x++) {
					$tb->tr();
					for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
						if (isset($table['detail']['rows'][$x]['columns'][$i])) {
							$column = $table['detail']['rows'][$x]['columns'][$i];
							$class = $config->textjustify[$fieldsjson['data']['detail'][$column['id']]['datajustify']];
							$colspan = $column['col-length'];
							
							if ($i == 1 && !empty($invoice['Invoice Number'])) {
								$ordn = $invoice['Ordn'];
								$onclick = 'loadorderdocuments("'.$ordn.'")';
								$celldata = Table::generatejsoncelldata($fieldsjson['data']['detail'][$column['id']]['type'], $invoice, $column);
								$celldata .= "&nbsp; <a href='#' title='load order documents' data-load='#ajax-modal' onclick='$onclick'><i class='fa fa-folder-open' aria-hidden='true'></i></a>";
								$tb->td('colspan='.$colspan.'|class='.$class, $celldata);
							} else {
								$celldata = Table::generatejsoncelldata($fieldsjson['data']['detail'][$column['id']]['type'], $invoice, $column);
								$tb->td('colspan='.$colspan.'|class='.$class, $celldata);
							}
							if ($colspan > 1) { $i = $i + ($colspan - 1); }
						} else {
							$tb->td();
						}
					}
				}
			}

		}

	$tb->closetablesection('tbody');
	$tb->tablesection('tfoot');
		$invoice = $invoicejson['data']['invoices']['TOTAL'];
		//for ($x = 1; $x < $table['detail']['maxrows'] + 1; $x++) {
		$x = 1;
			$tb->tr('class=has-warning');
			for ($i = 1; $i < $table['maxcolumns'] + 1; $i++) {
				if (isset($table['detail']['rows'][$x]['columns'][$i])) {
					$column = $table['detail']['rows'][$x]['columns'][$i];
					$class = $config->textjustify[$fieldsjson['data']['detail'][$column['id']]['datajustify']];
					$colspan = $column['col-length'];
					$celldata = Table::generatejsoncelldata($fieldsjson['data']['detail'][$column['id']]['type'], $invoice, $column);
					$tb->td('colspan='.$colspan.'|class='.$class, $celldata);
					if ($colspan > 1) { $i = $i + ($colspan - 1); }
				} else {
					$tb->td();
				}
			}
		//}
	$tb->closetablesection('tfoot');
	echo $tb->close();
