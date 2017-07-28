<?php
	$ajax = new stdClass();
	$ajax->link = $actionpanel->getpanelrefreshlink();
	$ajax->data = $actionpanel->data;
	$ajax->insertafter = $actionpanel->getinsertafter();

	$totalcount = $actionpanel->count;

	//$popover_content = "<div class='form-group'><a href='".$actionpanel->getpanelnewtaskschedulelink()."' class='btn btn-info load-task-item' data-modal='".$actionpanel->modal."'  role='button' title='Schedule Task'> <i class='material-icons md-18'>&#xE192;</i> Create a New Scheduled Task</a></div>";
	
	//$$popover_content .= "<div class='form-group'><a href='".$actionpanel->getpanelloadtaskschedulelink()."' class='btn btn-info load-task-item' data-modal='".$actionpanel->modal."' role='button' title='View Scheduled Tasks'> <i class='material-icons md-18'>&#xE85D;</i> View List of Scheduled Tasks</a></div>";
?>

<div class="panel panel-primary not-round" id="actions-panel">
    <div class="panel-heading not-round" id="action-panel-heading">
    	<a href="#actions-div" class="panel-link" data-parent="#actions-panel" data-toggle="collapse">
        	<span class="glyphicon glyphicon-check"></span> &nbsp; <?php echo $actionpanel->getpaneltitle(); ?> <span class="caret"></span>  &nbsp;&nbsp;<span class="badge"><?= $actionpanel->count; ?></span>
        </a>

		<?php if ($actionpanel->needsaddactionlink()) : ?>
			<a href="<?= $actionpanel->getaddactiontypelink(); ?>" class="btn btn-info btn-xs add-action pull-right hidden-print" data-modal="<?= $actionpanel->modal; ?>" role="button" title="Add Task">
	            <i class="material-icons md-18">&#xE146;</i>
	        </a>
		<?php endif; ?>

        <span class="pull-right">&nbsp; &nbsp;&nbsp; &nbsp;</span>
        <a href="<?= $actionpanel->getpanelrefreshlink(); ?>" class="btn btn-info btn-xs load-link actions-refresh pull-right hidden-print" <?= $ajax->data; ?> role="button" title="Refresh Tasks">
            <i class="material-icons md-18">&#xE86A;</i>
        </a>
        <span class="pull-right"><?php if ($input->pageNum > 1 ) {echo 'Page '.$input->pageNum;} ?> &nbsp; &nbsp;</span>
    </div>
    <div id="actions-div" class="<?= $actionpanel->collapse; ?>">
        <div>
        	<div class="panel-body">
				<div class="row">
					<div class="col-xs-4">
                        <select name="" id="" class="form-control change-action-type" data-link="<?php echo $actionpanel->getactiontyperefreshlink(); ?>" <?= $ajax->data; ?>>
                            <?php $actiontypes = $pages->get('/activity/')->children(); ?>
                            <?php foreach ($actiontypes as $actiontype) : ?>
								<?php if ($actiontype->name == $actionpanel->getactiontypepage()) : ?>
									<option value="<?= $actiontype->name; ?>" selected><?= $actiontype->title; ?></option>
								<?php else : ?>
									<option value="<?= $actiontype->name; ?>"><?= $actiontype->title; ?></option>
								<?php endif; ?>
                            <?php endforeach; ?>
                        </select>
					</div>
				</div>
            </div>
             <?php include $config->paths->content.'pagination/ajax/pagination-start-no-form.php'; ?>
             <?php include $config->paths->content.'actions/'.$actionpanel->getactiontypepage().'/lists/'.$actionpanel->type.'-list.php'; ?>
             <?php $totalpages = ceil($totalcount / $config->showonpage); ?>
             <?php include $config->paths->content.'pagination/ajax/pagination-links.php'; ?>
        </div>
    </div>
</div>