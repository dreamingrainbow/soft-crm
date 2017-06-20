<div class="modal fade" id="add-item-modal" tabindex="-1" role="dialog" aria-labelledby="add-item-modal-label">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title" id="add-item-modal-label">Add Item to </h4>
            </div>
            <div class="modal-body">
                <div>
                    <form action="<?php echo $config->pages->products."redir/"; ?>" id="add-item-search-form">
                        <input type="hidden" name="action" value="item-search">
                        <input type="hidden" class="custid" name="custID">
                        <input type="hidden" class="addonurl" name="addonurl">
                        <input type="hidden" class="linenumber" name="linenumber">
                        <div class="row form-group">
                            <div class="col-xs-12">
                                <div class="input-group add-item-search-form">
                                    <input type="text" class="form-control not-round searchfield" name="q" placeholder="Search itemID, X-ref, UPC">
                                    <span class="input-group-btn">
                                    	<button type="submit" class="btn btn-default not-round"> <span class="glyphicon glyphicon-search"></span> </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-xs-12"> <div class="results"> </div> </div>
                </div>
            </div>
        </div>
    </div>
</div>
