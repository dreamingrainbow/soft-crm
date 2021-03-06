<?php
    $addtype = $input->urlSegment(2); // CART || ORDER | QUOTE
    $qnbr = $ordn = '';
    $custID = $input->get->text('custID');
    switch ($addtype) {
        case 'cart':
            $page->title = 'Add multiple items for your Cart';
            $formaction = $config->pages->cart."redir/";
            break;
        case 'order':
            $ordn = $input->get->text('ordn');
            $page->title = 'Add multiple items for Order #'. $ordn;
            $custID = get_custid_from_order(session_id(), $ordn);
            $formaction = $config->pages->orders."redir/";
            break;
		case 'quote':
			$qnbr = $input->get->text('qnbr');
            $page->title = 'Add multiple items for Quote #'. $qnbr;
			$custID = getquotecustomer(session_id(), $qnbr, false);
			$formaction = $config->pages->quotes."redir/";
            break;
    }

    $page->body = $config->paths->content."products/ajax/load/add-multiple/add-multiple-item-form.php";

	if ($config->ajax) {
        if ($config->modal) {
            include $config->paths->content."common/modals/include-ajax-modal.php";
        }
	} else {
		include $config->paths->content."common/include-blank-page.php";
	}
?>
