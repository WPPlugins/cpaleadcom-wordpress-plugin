<?php
    if (!empty($_POST)) {
        global $wpdb;
        extract($_POST);

        if($action == 'add_pub_id') {
            setPubId($new_pub_id, $new_token);
            echo '<script>window.location="admin.php?page=manage_ads&message=updated"</script>';
        }
        exit;
    }
?>

<script type="text/javascript" src="<?php echo plugin_dir_url(__FILE__) ?>3rd/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo plugin_dir_url(__FILE__) ?>3rd/ace/ace.js" type="text/javascript" charset="utf-8"></script>
<link href="<?php echo plugin_dir_url(__FILE__) ?>3rd/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
<link href="<?php echo plugin_dir_url(__FILE__) ?>css/style.css" rel="stylesheet"/>

<div class="container-fluid padded">
    <div class="row-fluid">
        <?php if($pub_id>0) { ?>
            <?php if($incorrect_token == 1) { ?>
                <div class="span12">
                    <div class="box">
                        <div class="box-header">
                            <span class="title"><i class="dashicons dashicons-warning" style="color:red"></i> Your Publisher ID / Token is wrong!</span>
                        </div>
                        <div class="box-content padded">
                            <div class="row" style="margin: 0">
                                <p>Seems that token key for Publisher ID = <?php echo $pub_id; ?> is incorect.</p>
                                <p>Please sign in into the CPAlead dashboard and then open <a href="https://www.cpalead.com/dashboard/banners/add.php" target="_blank">this page</a>. In the upper right corner you will see the option to generate your Wordpress Token Key. Copy it and paste in form above.</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="span12">
                    <div class="box">
                        <div class="box-header">
                            <span class="title"><i class="dashicons dashicons-yes" style="color:green"></i> Connected to your CPAlead account!</span>
                        </div>
                        <div class="box-content padded">
                            <div class="row" style="margin: 0">
                                <p>Publisher ID: <b><?php echo $pub_id; ?></b>. Wordpress token: <b><?php echo $token; ?></b></p>
                                <p>You can change your Wordpress token by logging into your CPAlead publisher account and then visiting <a href="https://www.cpalead.com/dashboard/banners/add.php" target="_blank">this page</a>. In the upper right corner you will see 'Wordpress Token' key. Click 'Generate new token', copy token and paste it in form above.</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="span12">
                <div class="box">
                    <div class="box-header">
                        <span class="title">How to Activate the CPAlead Ad Plugin</span>
                    </div>
                    <div class="box-content padded">
                        <div class="row" style="margin: 0">
                            <img src="<?php echo plugin_dir_url(__FILE__).'img/logo.png'; ?>" style="float:left; height: 70px; padding-right: 10px; margin-right: 10px; border-right: solid 1px #e1e1e1; margin-bottom: 50px;">
                            <p>To activate this plugin, <a href="https://www.cpalead.com/get-started.php" target="_blank">Signup Here</a> to get a FREE CPAlead publisher account. If you already have a CPAlead publisher account, you can <a href="https://www.cpalead.com/login.php" target="_blank">Login Here</a>.</p><p>Once logged in, you can obtain your Publisher ID and Wordpress Token in the top right corner of <a href="https://www.cpalead.com/dashboard/banners/add.php" target="_blank">This Page</a>. When you have your Publisher ID and Wordpress Token, please insert into the box below.</p>
                            <p><a href="https://www.youtube.com/watch?v=oQ0AEALE9j8" class="btn btn-primary" target="_blank"><span class="dashicons dashicons-video-alt3"></span> Watch Tutorial on How to Activate Plugin</a></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="span12">
            <div class="box">
                <div class="box-header">
                    <span class="title">Your CPAlead Publisher ID and Wordpress Token</span>
                </div>
                <div class="box-content padded">
                    <div class="row" style="margin: 0">
                        <form method="post">
                            <input type="hidden" name="action" value="add_pub_id">
                            <p>Enter Your Publisher ID:</p>
                            <input style="width: 250px" type="text" name="new_pub_id" placeholder="Publisher ID" required value="<?php if($pub_id != 0) echo $pub_id; ?>"/>
                            <p>Enter Your Wordpress Token:</p>
                            <input style="width: 250px" type="text" name="new_token" placeholder="Token key" required value="<?php if($token != '') echo $token; ?>"/> <input type="submit" value="Save" class="button">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>