<?php
    $shipID = '';
    switch ($input->urlSegment(2)) {
        case 'vi-open-invoices':
            $vendorID = $input->get->text('vendorID');
            $page->title = get_vendorname($vendorID) . ' Open Invoices';
            $page->body = $config->paths->content."vend-information/vend-open-invoices.php";
            break;
        case 'vi-payments':
            $vendorID = $input->get->text('vendorID');
            $page->title = get_vendorname($vendorID) . ' Payment';
            $page->body = $config->paths->content."vend-information/payment-history.php";
            break;
        case 'vi-shipfrom':
            $vendorID = $input->get->text('vendorID');
            $page->title = get_vendorname($vendorID) . ' Ship-From Information';
            $page->body = $config->paths->content."vend-information/vend-shipfrom.php";
            break;
        case 'vi-purchase-history':
            $vendorID = $input->get->text('vendorID');
            $shipfromID = $input->get->text('shipfromID');
            if ($input->urlSegment(3) == 'form') {
				$page->title = 'Enter the Starting Report Date ';
				$page->body = $config->paths->content."vend-information/forms/purchase-history-form.php";
			} else {
                $page->title = get_vendorname($vendorID) . ' Purchase History';
                $page->body = $config->paths->content."vend-information/vend-purchase-history.php";
			}
            break;
        case 'vi-purchase-orders':
            $vendorID = $input->get->text('vendorID');
            $page->title = get_vendorname($vendorID) . ' Purchase Orders';
            $page->body = $config->paths->content."vend-information/vend-purchase-order.php";
            break;
        case 'vi-contact':
            $vendorID = $input->get->text('vendorID');
            $page->title = get_vendorname($vendorID) . ' Contacts';
            $page->body = $config->paths->content."vend-information/vend-contact.php";
            break;
        case 'vi-notes':
            $vendorID = $input->get->text('vendorID');
            $page->title = get_vendorname($vendorID) . ' Notes';
            $page->body = $config->paths->content."vend-information/vend-notes.php";
            break;
        case 'vi-costing-search':
            $page->title = 'Search for an Item';
            $action = 'vi-costing';
            $vendorID = $input->get->text('vendorID');
            if ($input->get->q) {$q = $input->get->text('q'); $page->title = "Searching for '$q'";}

			if ($config->modal) {
				$page->body = $config->paths->content."vend-information/forms/item-search-form.php";
			} else {
				$page->body = $config->paths->content."vend-information/item-search-results.php";
			}
            break;
        case 'vi-costing':
            $vendorID = $input->get->text('vendorID');
            $itemID = $input->get->text('itemID');
            $page->title = 'Viewing Cost for ' . $itemID;
			$page->body = $config->paths->content."vend-information/vend-costing.php";
            break;
        case 'vi-unreleased-purchase-orders':
            $vendorID = $input->get->text('vendorID');
            $page->title = get_vendorname($vendorID) . ' Unreleased Purchase Orders';
            $page->body = $config->paths->content."vend-information/vend-unreleased-purchase-order.php";
            break;
        case 'vi-uninvoiced':
            $vendorID = $input->get->text('vendorID');
            $page->title = get_vendorname($vendorID) . ' Uninvoiced';
            $page->body = $config->paths->content."vend-information/vend-uninvoiced.php";
            break;
        case 'vi-24-month-summary':
            $vendorID = $input->get->text('vendorID');
            $page->title = get_vendorname($vendorID) . ' Purchase Orders';
            $page->body = $config->paths->content."vend-information/vend-24-month-summary.php";
            break;
        case 'vi-docview':
            $vendorID = $input->get->text('vendorID');
            $page->title = get_vendorname($vendorID) . ' Payment';
            $page->body = $config->paths->content."vend-information/payment-history.php";
            break;
        default:
            $page->title = 'Search for a vendor';
            if ($input->get->q) {$q = $input->get->text('q');}
            $page->body = $config->paths->content."vend-information/forms/vend-page-form.php";
            break;
    }

	if ($config->ajax) {
		if ($config->modal) {
			include $config->paths->content."common/modals/include-ajax-modal.php";
		} else {
			include $page->body;
		}
	} else {
		$config->styles->append('//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css');
		$config->scripts->append('//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js');
		$config->scripts->append('//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js');
		$config->scripts->append(hashtemplatefile('scripts/libs/datatables.js'));
		$config->scripts->append(hashtemplatefile('scripts/vi/vend-functions.js'));
		$config->scripts->append(hashtemplatefile('scripts/vi/vend-info.js'));
		include $config->paths->content."common/include-blank-page.php";
	}




 ?>
