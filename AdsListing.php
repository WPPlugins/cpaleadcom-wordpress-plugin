<?php
	if($_GET['action'] == 'delete' && $_GET['id']>0) { 
		deleteBanner($_GET['id']);
		echo '<script>document.location="admin.php?page=manage_ads&message=deleted"</script>';
		exit;
	}
?>
<script type="text/javascript" src="<?php echo plugin_dir_url(__FILE__) ?>3rd/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo plugin_dir_url(__FILE__) ?>3rd/ace/ace.js" type="text/javascript" charset="utf-8"></script>
<link href="<?php echo plugin_dir_url(__FILE__) ?>3rd/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
<link href="<?php echo plugin_dir_url(__FILE__) ?>css/style.css" rel="stylesheet"/>


<div class="container-fluid padded">

<?php if($_GET['message'] == 'added') { ?>
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Done!</strong> Ad was created.
    </div>
<?php } ?>

<?php if($_GET['message'] == 'saved') { ?>
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Done!</strong> Ad was saved.
    </div>
<?php } ?>

<?php if($_GET['message'] == 'deleted') { ?>
	<div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Done!</strong> Ad was deleted.
    </div>
<?php } ?>

<?php if($_GET['message'] == 'updated') { ?>
	<div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Done!</strong> Your Publisher ID was updated.
    </div>
<?php } ?>

	<div class="row-fluid">
        <div class="span12">
            <div class="box">
                <div class="box-header">
                    <span class="title">All Ads</span>
                    <?php if($pub_id > 0) { ?>
                        <span class="title_right">Publisher ID: <b><i class="glyphicon glyphicon-user"></i> <?php echo $pub_id; ?></b> <a href="admin.php?page=set_pub_id">[Change]</a></span>
                    <?php } ?>
                </div>
                <div class="box-content padded">
                	<table class="wp-list-table widefat fixed striped posts">
						<thead>
							<tr>
								<th>Name</th>
								<th>Created</th>
								<th>Size</th>
								<th><b>Placement Code</b></th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
		                    <?php if(!empty($Res)):?>
								<?php foreach($Res as $banner):?>
									<tr>
										<td><?php echo $banner->name ?><br>
											<small><?php if($banner->wp == 1) echo '<i class="dashicons dashicons-wordpress" style="font-size:12px;width:12px;height:12px;line-height:inherit"></i> '; ?>
											<?php switch ($banner->type) {
												case 2: echo 'Custom Ad'; break;
												case 3: echo 'PopUnder Ad'; break;
												case 4: echo 'Interstitial Ad'; break;
												case 5: echo 'Superlink'; break;
												case 6: echo 'PushUp'; break;
												case 7: echo 'Locker'; break;
											} ?></small>
										</td>
										<td><?php echo date("Y/m/d H:i", $banner->created); ?></td>
										<td><?php if($banner->type != 3 && $banner->type != 5 && $banner->type != 6) { echo 'Width: '.$banner->width.$banner->w_type.'<br>Height: '.$banner->height.$banner->h_type; } ?>
										</td>
										<td>
											<?php if($banner->type == 2) { ?>
												<textarea id="code_<?php echo $banner->id; ?>" style="display:none">&lt;iframe src='<?php echo BANNERS_URL; ?>?id=<?php echo $banner->id; ?>' style='border:none;overflow:hidden;<?php echo 'width: '.$banner->width.$banner->w_type.'; height: '.$banner->height.$banner->h_type; ?>'&gt;&lt;/iframe&gt;</textarea>
												<textarea id="shortcode_<?php echo $banner->id; ?>" style="display:none">[cpalead banner="<?php echo $banner->id; ?>" width="<?php echo $banner->width.$banner->w_type; ?>" height="<?php echo $banner->height.$banner->h_type; ?>"]</textarea>
											<?php } else if($banner->type == 3) { ?>
												<textarea id="code_<?php echo $banner->id; ?>" style="display:none">&lt;script type="text/javascript" src="<?php echo SCRIPTS_URL; ?>?js=<?php echo $banner->id; ?>"&gt;&lt;/script&gt;</textarea>
												<textarea id="shortcode_<?php echo $banner->id; ?>" style="display:none">[cpalead banner="<?php echo $banner->id; ?>"]</textarea>
											<?php } else if($banner->type == 4) { ?>
												<textarea id="code_<?php echo $banner->id; ?>" style="display:none">&lt;script type="text/javascript" src="<?php echo SCRIPTS_URL; ?>?js=<?php echo $banner->id; ?>"&gt;&lt;/script&gt;</textarea>
												<textarea id="shortcode_<?php echo $banner->id; ?>" style="display:none">[cpalead banner="<?php echo $banner->id; ?>"]</textarea>
											<?php } else if($banner->type == 5) { ?>
												<textarea id="code_<?php echo $banner->id; ?>" style="display:none">&lt;a href="<?php echo SUPERLINK_URL; ?>?b=<?php echo $banner->id; ?>&s=<?php echo $pub_id; ?>"&gt;Url content&lt;/a&gt;</textarea>
												<textarea id="shortcode_<?php echo $banner->id; ?>" style="display:none">[cpalead banner="<?php echo $banner->id; ?>" content="Click here"]</textarea>
											<?php } else if($banner->type == 6) { ?>
												<textarea id="code_<?php echo $banner->id; ?>" style="display:none">&lt;script type="text/javascript" src="<?php echo SCRIPTS_URL; ?>?js=<?php echo $banner->id; ?>"&gt;&lt;/script&gt;</textarea>
												<textarea id="shortcode_<?php echo $banner->id; ?>" style="display:none">[cpalead banner="<?php echo $banner->id; ?>"]</textarea>
											<?php } else if($banner->type == 7) { ?>
												<textarea id="code_<?php echo $banner->id; ?>" style="display:none">&lt;script type="text/javascript" src="<?php echo SCRIPTS_URL; ?>?js=<?php echo $banner->id; ?>"&gt;&lt;/script&gt;</textarea>
												<textarea id="shortcode_<?php echo $banner->id; ?>" style="display:none">[cpalead banner="<?php echo $banner->id; ?>"]</textarea>
											<?php } ?>
											<a class="btn btn-sm btn-primary" onclick="open_modal(<?php echo $banner->id; ?>, <?php echo $banner->type; ?>, '<?php echo $banner->class; ?>')">Get code</a>
										</td>
										<td>
											<a class="button" href="admin.php?page=edit_banner_ad&id=<?php echo $banner->id ?>">Edit</a>
											<form action="<?php echo API_URL; ?>?q=delete" method="POST" style="display: inline;">
	                                            <input type="hidden" name="id" value="<?php echo $banner->id ?>">
	                                            <input type="hidden" name="pub_id" value="<?php echo $pub_id; ?>">
	                                            <input type="hidden" name="token" value="<?php echo $token; ?>">
	                                            <input type="hidden" name="return_url_success" value="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=manage_ads&message=deleted">
	                                            <input type="hidden" name="return_url_error" value="<?php echo get_site_url(); ?>/wp-admin/admin.php?page=manage_ads">
												<button type="submit" class="button btn-danger" onclick="return confirm('Delete <?php echo $banner->name; ?> banner?');">Delete</button>
											</form>
										</td>
									</tr>
								<?php endforeach;?>
							<?php else:?>
							<tr>
								<td colspan="6">No Banners Found!</td>
							</tr>
							<?php endif;?>
						</tbody>
					</table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="codeModal" role="dialog" aria-labelledby="codeModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="codeModalLabel">Place Your Ad</h4>
      </div>
      <div class="modal-body">
      	<div class="type2" style="display: none">
			<p style="text-align: center;"><a href="https://www.youtube.com/watch?v=2LcoY3OOzHA" class="btn btn-primary" target="_blank"><span class="dashicons dashicons-video-alt3"></span> Watch Tutorial on How to Place Ad</a></p>
			<p>
                <span style="color:green">Step 1</span>: In your Wordpress Admin navigation, click on a <b>Page</b> or <b>Post</b> you want this ad to appear on.
                <br><br>
                <span style="color:green">Step 2</span>: Then click on the <b>Text</b> tab (near <b>Visual</b> tab) to go inside the text/page/post editor.
                <br><br>
                <span style="color:green">Step 3</span>: Inside the editor, paste your code where you want the banner to appear, then save.<br>
            </p>
      	</div>

      	<div class="type3 type4" style="display: none">
      		<p style="text-align: center;"><a href="https://www.youtube.com/watch?v=3K91dUcwHS4" class="btn btn-primary" target="_blank"><span class="dashicons dashicons-video-alt3"></span> Watch Tutorial on How to Place Ad</a></p>
			<p>
                <span style="color:green">Step 1</span>: In your Wordpress Admin navigation, click on a <b>Page</b> or <b>Post</b> you want this ad to appear on.
                <br><br>
                <span style="color:green">Step 2</span>: Then click on the <b>Text</b> tab (near <b>Visual</b> tab) to go inside the text/page/post editor.
                <br><br>
                <span style="color:green">Step 3</span>: Add the class to the link(s) you want to trigger the ad <pre>&lt;a href="link_url" <span style="color:green">class="<span id="class_name">class_name</span>"</span>&gt;Link text&lt;/a&gt;</pre>
                <br>
                <span style="color:green">Step 4</span>: Within the text editor for your page or post, copy and paste this code anywhere on the page. Then save.
                <br>
            </p>
      	</div>

      	<div class="type5" style="display: none">
			<p>
                <span style="color:green">Step 1</span>: In your Wordpress Admin navigation, click on a <b>Page</b> or <b>Post</b> you want this ad to appear on.
                <br><br>
                <span style="color:green">Step 2</span>: Then click on the <b>Text</b> tab (near <b>Visual</b> tab) to go inside the text/page/post editor.
                <br><br>
                <span style="color:green">Step 3</span>: Add the following code to your page. This is the link that will trigger the ad when clicked:
                <br>
            </p>
      	</div>

      	<div class="type6 type7" style="display: none">
      		<p style="text-align: center;" class="type7" style="display: none;"><a href="https://www.youtube.com/watch?v=BEjHdQYFouw" class="btn btn-primary" target="_blank"><span class="dashicons dashicons-video-alt3"></span> Watch Tutorial on How to Place Locker</a></p>
			<p>
                <span style="color:green">Step 1</span>: In your Wordpress Admin navigation, click on a <b>Page</b> or <b>Post</b> you want this ad to appear on.
                <br><br>
                <span style="color:green">Step 2</span>: Then click on the <b>Text</b> tab (near <b>Visual</b> tab) to go inside the text/page/post editor.
                <br><br>
                <span style="color:green">Step 3</span>: Paste this code anywhere within the editor, then save:
                <br>
            </p>
      	</div>
      	<textarea id="paste_code" style="width:100%; height: 70px;"></textarea>
      	<br>
      	<p>or use the Wordpress Shortcode:</p>
      	<pre id="shortcode"></pre>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	function open_modal(id, type, class_name) {
		jQuery(".type2, .type3, .type5, .type6, .type7").hide();
	  	var code = jQuery("#code_"+id).val();
	  	var shortcode = jQuery("#shortcode_"+id).val();
	  	if(type > 0) {
	  		jQuery(".type"+type).show();
	  	}
	  	if(type==3 || type==4) {
	  		jQuery('#class_name').html(class_name);
	  	}
	  	jQuery('#paste_code').val(code);
	  	jQuery('#shortcode').html(shortcode);
	  	jQuery("#codeModal").modal();
	}
</script>