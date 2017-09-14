<?php
    if (!isset($actiontype)) {$actiontype = 'all';}
	if (!isset($partialid)) {$partialid = 'actions';}
    if (!isset($assigneduserID)) {$assigneduserID = $user->loginid;}
    $actionpanel = new UserActionPanel('cust', $actiontype, $partialid, '#ajax-modal', $config->ajax, $config->modal);
    $actionpanel->setupcustomerpanel($custID, $shipID);
    $actionpanel->setuptasks($input->get->text('action-status'));
    $actionpanel->querylinks = UserAction::getlinkarray();

    $actionpanel->querylinks['assignedto'] = $assigneduserID;
    $actionpanel->querylinks['completed'] = $actionpanel->databasetaskstatus();
    $actionpanel->querylinks['customerlink'] = $custID;
    $actionpanel->querylinks['shiptolink'] = $shipID;
    if ($actiontype != 'all') {
        $actionpanel->querylinks['actiontype'] = $actiontype;
    }
    $actionpanel->count = getuseractionscount($user->loginid, $actionpanel->querylinks, false);
    include $config->paths->content."actions/actions-panel.php";
