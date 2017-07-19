<?php
    if (!empty($_POST)) {
        global $wpdb;
        extract($_POST);

        if($action == 'add_pub_id') {
            setPubId($pub_id, $token);
            echo '<script>window.location="admin.php?page=exclusive_offers"</script>';
        }
        exit;
    }

    $ads_banners = getBanners();
?>

<script type="text/javascript" src="<?php echo plugin_dir_url(__FILE__) ?>3rd/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo plugin_dir_url(__FILE__) ?>3rd/datatable/dt.js" type="text/javascript" charset="utf-8"></script>
<link href="<?php echo plugin_dir_url(__FILE__) ?>3rd/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
<link href="<?php echo plugin_dir_url(__FILE__) ?>3rd/datatable/dt.css" rel="stylesheet"/>
<link href="<?php echo plugin_dir_url(__FILE__) ?>css/style.css" rel="stylesheet"/>


<div class="container-fluid padded">

    <div class="row-fluid">
        <div class="span12">
            <div class="box">
                <div class="box-header">
                    <span class="title">CPAlead</span>
                    <?php if($pub_id > 0) { ?>
                        <span class="title_right">Publisher ID: <b><i class="glyphicon glyphicon-user"></i> <?php echo $pub_id; ?></b> <a href="admin.php?page=set_pub_id">[Change]</a></span>
                    <?php } ?>
                </div>
                <div class="box-content padded">
                    <p>CPAlead will display high performing targeted ads to your visitor based on your visitor's location and device (desktop, iOS, Android) they are using.</p>
                    <p>You will earn revenue when your visitor interacts with an ad.</p>

                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation">
                            <div class="span2 action-nav-button">
                                <a href="admin.php?page=add_banner_ad">
                                    <i class="dashicons dashicons-format-image"></i>
                                    <span>Banner</span>
                                </a>
                            </div>
                        </li>
                        <li role="presentation">
                            <div class="span2 action-nav-button">
                                <a href="admin.php?page=add_custom_ad">
                                    <i class="dashicons dashicons-editor-code"></i>
                                    <span>CustomAd</span>
                                </a>
                            </div>
                        </li>
                        <li role="presentation">
                            <div class="span2 action-nav-button">
                                <a href="admin.php?page=add_pop_under_ad">
                                    <i class="dashicons dashicons-format-gallery"></i>
                                    <span>Pop Under</span>
                                </a>
                            </div>
                        </li>
                        <li role="presentation">
                            <div class="span2 action-nav-button">
                                <a href="admin.php?page=add_interstitial_ad">
                                    <i class="dashicons dashicons-feedback"></i>
                                    <span>Interstitial</span>
                                </a>
                            </div>
                        </li>

                        <li role="presentation">
							<div class="span2 action-nav-button">
						      	<a href="admin.php?page=add_superlink_ad">
						        	<i class="dashicons dashicons-admin-links"></i>
						        	<span>Superlink</span>
						      	</a>
						    </div>
						</li>
					
						<li role="presentation">
							<div class="span2 action-nav-button">
						      	<a href="admin.php?page=add_push_up_ad">
						        	<i class="dashicons dashicons-megaphone"></i>
						        	<span>PushUp</span>
						      	</a>
						    </div>
						</li>

                        <li style="float:right">
                            <div class="span2 action-nav-button">
                                <a href="http://blog.cpalead.com/category/display-ads/" target="_blank">
                                    <i class="dashicons dashicons-sos" aria-hidden="true"></i>
                                    <span>Help Tutorials</span>
                                </a>
                            </div>
                        </li>
                        <li style="float:right">
                            <div class="span2 action-nav-button">
                                <a href="admin.php?page=manage_ads">
                                    <i class="dashicons dashicons-admin-generic" aria-hidden="true"></i>
                                    <span>Manage Ads</span>
                                </a>
                            </div>
                        </li>
                        <li style="float:right">
                            <div class="span2 action-nav-button">
                                <a href="admin.php?page=hot_offers">
                                    <i class="dashicons dashicons-star-filled"></i>
                                    <span>Hot Offers</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid padded">

    <?php if($pub_id=='' || $pub_id < 1) { ?>
        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-header">
                        <span class="title"><i class="dashicons dashicons-warning"></i> Set your Publisher ID from CPAlead</span>
                    </div>
                    <div class="box-content padded">
                        <div class="row" style="margin: 0">
                            <form method="post">
                                <input type="hidden" name="action" value="add_pub_id">
                                <p>To create new ad you need to set your publisher id and token firstly. Enter you Publisher ID:</p>
                                <input style="width: 250px" type="text" name="pub_id" placeholder="Publisher ID" required value="<?php echo $pub_id; ?>"/>
                                <p><small>Log into your CPAlead publisher account. This number will be in the upper right corner of your publisher dashboard.</small></p>
                                <p>Enter you Token:</p>
                                <input style="width: 250px" type="text" name="token" placeholder="Token key" required value="<?php echo $token; ?>"/> <input type="submit" value="Save" class="button">
                                <p><small>Token key is available on <a href="https://www.cpalead.com/dashboard/banners/manage.php" target="_blank">Manage banners page</a>. This number will be in the upper right corner of 'Manage Banners' panel.</small></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php } else { ?>

        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-header">
                        <span class="title">Exclusive Offers</span>
                    </div>
                    <div class="box-content padded">
                        <table class="offers-table">
                            <thead>
                                <th><div>Logo</div></th>
                                <th><div>Offer Name</div></th>
                                <th><div>Payout</div></th>
                                <th><div>-</div></th>
                                <th><div>Daily Network Budget</div></th>
                                <th><div>-</div></th>
                                <th><div>Promote</div></th>
                            </thead>
                            <tbody>
                                <?php foreach ($Offers as $Offer) { ?>
                                    <tr>
                                        <td><img src="<?php echo MAIN_URL; ?><?php echo $Offer->img; ?>" style="width:75px;height:75px;"></td>
                                        <td><?php echo $Offer->title; ?></td>
                                        <td><?php echo $Offer->earn; ?></td>
                                        <td><?php echo $Offer->earn_score; ?></td>
                                        <td><?php echo $Offer->percent; ?>%</td>
                                        <td><?php echo $Offer->percent; ?></td>
                                        <td><a class="btn btn-sm btn-green" href="#exclusive_offer_<?php echo $Offer->id; ?>" data-toggle="modal">Promote</a></td>
    
                                        <div class="modal cmodal fade" id="exclusive_offer_<?php echo $Offer->id; ?>" role="dialog">
                                            <div class="modal-dialog cmodal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="exclusive_offer_<?php echo $Offer->id; ?>Label"><?php echo $Offer->title; ?></h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row-fluid">
                                                            <p><?php echo $Offer->description; ?></p>
                                                            <p><?php echo $Offer->terms; ?></p>
                                                            <center style="display: none" id="link_for_offer_<?php echo $Offer->id; ?>"><strong><span style="font-size:22px; display: block;padding: 30px 0;"><a><?php echo $Offer->url; ?></a></span></strong></center>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-default" data-dismiss="modal" style="color: #686868;text-shadow: none;">Close</button>
                                                        <button class="btn btn-sm btn-green" onclick="get_offer_url(<?php echo $Offer->id; ?>)">Promote</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<script type="text/javascript">

    function get_offer_url(id) {

        if(jQuery('#exclusive_offer_'+id+' :checkbox:not(:checked)').length == 0){ 
            jQuery('#link_for_offer_'+id).show();
        } else {
            alert('You need to accept all terms!');
        }
    }

    jQuery(document).ready(function(jQuery) {

        jQuery('.offers-table').dataTable({
            'columnDefs': [
                { 
                    'orderable': false,
                    'targets': 0 
                },
                { 
                    'orderable': false,
                    'targets': 6 
                },
                {
                    'orderData':[ 3 ],
                    'targets': [ 2 ]
                },
                {
                    'targets': [ 3 ],
                    'visible': false
                },
                {
                    'orderData':[ 5 ],
                    'targets': [ 4 ]
                },
                {
                    'targets': [ 5 ],
                    'visible': false
                },
            ],
            bJQueryUI: false,
            bAutoWidth: false,
            sPaginationType: 'full_numbers',
            sDom: '<\'table-header\'fl>t<\'table-footer\'ip>',
            order: [[ 1, 'desc' ]],
            iDisplayLength: 50
        });
    });
</script>