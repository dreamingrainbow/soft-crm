<?php
    $shipID = '';
    switch ($input->urlSegment(2)) { 
        case 'item-search-results':
            $page->title = "Searching items for " . $input->get->text('q');
            $q = $input->get->text('q');
            $page->body = $config->paths->content."cust-information/item-search-results.php";
            break;
		case 'ci-shiptos':
			$custID = $input->get->text('custID');
			$page->title = 'Viewing ' . get_customer_name($custID) . ' shiptos';
			$page->body = $config->paths->content."cust-information/cust-shiptos.php";
			break;
		case 'ci-shipto-info':
			$custID = $input->get->text('custID');
			$shipID = $input->get->text('shipID');
			$page->title = 'Viewing ' . get_customer_name($custID) . ' shipto ' . $shipID;
			$page->content = $config->paths->content."cust-information/cust-shipto-info.php";
			break;
        case 'ci-pricing-search':
            $page->title = 'Search for an Item';
            $action = 'ci-pricing';
            $custID = $input->get->text('custID');
            if ($input->get->q) {$q = $input->get->text('q'); $page->title = "Searching for '$q'";}

			if ($config->modal) {
				$page->body = $config->paths->content."cust-information/forms/item-search-form.php";
			} else {
				$page->body = $config->paths->content."cust-information/item-search-results.php";
			}
            break;
        case 'ci-pricing':
            $custID = $input->get->text('custID');
            $itemID = $input->get->text('itemID');
            $page->title = 'Viewing Pricing for ' . $itemID;
			$page->body = $config->paths->content."cust-information/item-pricing.php";
            break;
		case 'ci-open-invoices':
			$custID = $input->get->text('custID');
			$page->title = get_customer_name($custID) . ' Open Invoice Inquiry';
			$page->body = $config->paths->content."cust-information/cust-open-invoices.php";
			break;
		case 'ci-standing-orders':
			$custID = $input->get->text('custID');
			$page->title = get_customer_name($custID) . ' Standing Orders Inquiry';
			$page->body = $config->paths->content."cust-information/cust-standing-orders.php";
			break;
		case 'ci-payment-history':
			$custID = $input->get->text('custID');
			$page->title = get_customer_name($custID) . ' Payment History Inquiry';
			$page->body = $config->paths->content."cust-information/cust-payment-history.php";
			break;
		case 'ci-documents':
			$custID = $input->get->text('custID');
            switch ($input->urlSegment(3)) {
                case 'order':
                    $page->title = "Order #" . $input->get->text('ordn'). ' Documents';
                    break;
                default:
                    $page->title = get_customer_name($custID) . ' Documents';
                    break;
            }
			$page->body = $config->paths->content."cust-information/cust-documents.php";
			break;
		case 'ci-quotes':
			$custID = $input->get->text('custID');
			$page->title = get_customer_name($custID) . ' Quote Inquiry';
			$page->body = $config->paths->content."cust-information/cust-quotes.php";
			break;
		case 'ci-contacts':
			$custID = $input->get->text('custID');
			$page->title = get_customer_name($custID) . ' Contacts Inquiry';
			$page->body = $config->paths->content."cust-information/cust-contacts.php";
			break;
		case 'ci-contacts':
			$custID = $input->get->text('custID');
			$page->title = get_customer_name($custID) . ' Contacts Inquiry';
			$page->body = $config->paths->content."cust-information/cust-contacts.php";
			break;
		case 'ci-credit':
			$custID = $input->get->text('custID');
			$page->title = get_customer_name($custID) . ' Credit Inquiry';
			$page->body = $config->paths->content."cust-information/cust-credit.php";
			break;
		case 'ci-payments':
			$custID = $input->get->text('custID');
			$page->title = get_customer_name($custID) . ' Credit Inquiry';
			$page->body = $config->paths->content."cust-information/cust-credit.php";
			break;
        case 'ci-sales-orders':
			$custID = $input->get->text('custID');
			$page->title = get_customer_name($custID) . ' Sales Order Inquiry';
			$page->body = $config->paths->content."cust-information/cust-sales-orders.php";
			break;
        case 'ci-sales-history':
			$custID = $input->get->text('custID');
            if ($input->urlSegment4 == 'form') {
                $action = 'ci-sales-history';
                $page->title = get_customer_name($custID) . ' Choose a Starting Date';
    			$page->body = $config->paths->content."cust-information/forms/cust-sales-history-form.php";
            } else {
                $page->title = get_customer_name($custID) . ' Sales History Inquiry';
    			$page->body = $config->paths->content."cust-information/cust-sales-history.php";
            }
			break;
        case 'ci-custpo':
			$custID = $input->get->text('custID');
			$page->title = get_customer_name($custID) . ' Customer PO Inquiry';
			$page->body = $config->paths->content."cust-information/cust-po.php";
			break;
        case 'ci-53weeks':
			$custID = $input->get->text('custID');
			$page->title = get_customer_name($custID) . ' 52 Week Sales Data';
			$page->body = $config->paths->content."cust-information/cust-sales-data.php";
			break;
        default:
            $page->title = 'Search for a customer';
            if ($input->get->q) {$q = $input->get->text('q');}
            $page->body = $config->paths->content."cust-information/forms/cust-search-form.php";
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
		$config->scripts->append($config->urls->templates.'scripts/libs/datatables.js');
		$config->scripts->append($config->urls->templates.'scripts/ci/cust-functions.js');
		$config->scripts->append($config->urls->templates.'scripts/ci/cust-info.js');
		include $config->paths->content."common/include-blank-page.php";
	}




 ?>