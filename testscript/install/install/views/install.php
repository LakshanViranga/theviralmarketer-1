<?php 

$project_name = "TweetPost - Twitter Scheduling Tool";
$php_version_success = false;
$mysql_success = false;
$curl_success = false;
$gd_success = false;
$allow_url_fopen_success = false;
$allow_install_success = false;
$php_version_required = "5.6.0";
$current_php_version = PHP_VERSION;

//check required php version
if (version_compare($current_php_version, $php_version_required) >= 0) {
    $php_version_success = true;
}

//check mySql 
if (function_exists("mysqli_connect")) {
    $mysql_success = true;
}

//check curl 
if (function_exists("curl_version")) {
    $curl_success = true;
}

//check gd
if (extension_loaded('gd') && function_exists('gd_info')) {
    $gd_success = true;
}


//check allow_url_fopen
if (ini_get('allow_url_fopen')) {
    $allow_url_fopen_success = true;
}

//check if all requirement is success
if ($php_version_success && $mysql_success && $curl_success && $gd_success && $allow_url_fopen_success) {
    $all_requirement_success = true;
} else {
    $all_requirement_success = false;
}


$writeable_directories = array(
    'config' => '/app/config.php',
    'index'  => '/index.php',
    // 'install'  => '/install/instal/',
);

foreach ($writeable_directories as $value) {
    if (!is_writeable(".." . $value)) {
        $all_requirement_success = false;
    }
}

$dashboard_url = $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
$dashboard_url = preg_replace('/install.*/', '', $dashboard_url); //remove everything after index.php
if (!empty($_SERVER['HTTPS'])) {
    $dashboard_url = 'https://' . $dashboard_url;
} else {
    $dashboard_url = 'http://' . $dashboard_url;
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" >
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="fairsketch">
        <link rel="icon" href="assets/images/favicon.png" />
        <title><?=$project_name?> Installation</title>
        <link rel='stylesheet' type='text/css' href='assets/bootstrap/css/bootstrap.min.css' />
        <link rel='stylesheet' type='text/css' href='assets/js/font-awesome/css/font-awesome.min.css' />

        <link rel='stylesheet' type='text/css' href='assets/css/install.css' />

        <script type='text/javascript'  src='assets/js/jquery-1.11.3.min.js'></script>
        <script type='text/javascript'  src='assets/js/jquery-validation/jquery.validate.min.js'></script>
        <script type='text/javascript'  src='assets/js/jquery-validation/jquery.form.js'></script>
        <script type="text/javascript">
	        var token = '<?=$this->security->get_csrf_hash()?>';
		</script>

    </head>
    <body>
        <div class="install-box">
            <div class="panel panel-install">
                <div class="panel-heading text-center">                    
                    <h2> <?=$project_name?> Installation</h2>
                </div>
                <div class="panel-body no-padding">
                    <div class="tab-container clearfix">
                        <div id="pre-installation" class="tab-title col-sm-4 active"><i class="fa fa-circle-o"></i><strong> Pre-Installation</strong></span></div>
                        <div id="configuration" class="tab-title col-sm-4"><i class="fa fa-circle-o"></i><strong> Configuration</strong></div>
                        <div id="finished" class="tab-title col-sm-4"><i class="fa fa-circle-o"></i><strong> Finished</strong></div> 
                    </div>
                    <div id="alert-container">

                    </div>


                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="pre-installation-tab">
                            <div class="section">
                                <p>1. Please configure your PHP settings to match following requirements:</p>
                                <hr />
                                <div>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th width="25%">PHP Settings</th>
                                                <th width="27%">Current Version</th>
                                                <th>Required Version</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>PHP Version</td>
                                                <td><?php echo $current_php_version; ?></td>
                                                <td><?php echo $php_version_required; ?>+</td>
                                                <td class="text-center">
                                                    <?php if ($php_version_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="section">
                                <p>2. Please make sure the extensions/settings listed below are installed/enabled:</p>
                                <hr />
                                <div>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th width="25%">Extension</th>
                                                <th width="27%">Current Settings</th>
                                                <th>Required Settings</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>MySQLi</td>
                                                <td> <?php if ($mysql_success) { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($mysql_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>GD</td>
                                                <td> <?php if ($gd_success) { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($gd_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>cURL</td>
                                                <td> <?php if ($curl_success) { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($curl_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>allow_url_fopen</td>
                                                <td> <?php if ($allow_url_fopen_success) { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($allow_url_fopen_success) { ?>
                                                        <i class="status fa fa-check-circle-o"></i>
                                                    <?php } else { ?>
                                                        <i class="status fa fa-times-circle-o"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="section">
                                <p>3. Please make sure you have set the <strong>writable</strong> permission on the following folders/files:</p>
                                <hr />
                                <div>
                                    <table>
                                        <tbody>
                                            <?php
                                            foreach ($writeable_directories as $value) {
                                                ?>
                                                <tr>
                                                    <td style="width:87%;"><?php echo $value; ?></td>  
                                                    <td class="text-center">
                                                        <?php if (is_writeable(".." . $value)) { ?>
                                                            <i class="status fa fa-check-circle-o"></i>
                                                            <?php
                                                        } else {
                                                            $all_requirement_success = false;
                                                            ?>
                                                            <i class="status fa fa-times-circle-o"></i>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="panel-footer">
                                <button <?php
                                if (!$all_requirement_success) {
                                    echo "disabled=disabled";
                                }
                                ?> class="btn btn-info form-next"><i class='fa fa-chevron-right'></i> Next</button>
                            </div>

                        </div>
                        <div role="tabpanel" class="tab-pane" id="configuration-tab">
                            <form name="config-form" id="config-form" action="./index.php/ajax_install" method="post">

                                <div class="section clearfix">
                                    <p>1. Please enter your database connection details.</p>
                                    <hr />
                                    <div>
                                        <div class="form-group clearfix">
                                            <label for="host" class=" col-md-3">Database Host</label>
                                            <div class="col-md-9">
                                                <input type="text" value="" id="host"  name="host" class="form-control" placeholder="Database Host (usually localhost)" />
                                                <input type="hidden" name="token" value="<?=$this->security->get_csrf_hash()?>">
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <label for="dbuser" class=" col-md-3">Database User</label>
                                            <div class=" col-md-9">
                                                <input type="text" value="" name="dbuser" class="form-control" autocomplete="off" placeholder="Database user name" />
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <label for="dbpassword" class=" col-md-3">Password</label>
                                            <div class=" col-md-9">
                                                <input type="password" value="" name="dbpassword" class="form-control" autocomplete="off" placeholder="Database user password" />
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <label for="dbname" class=" col-md-3">Database Name</label>
                                            <div class=" col-md-9">
                                                <input type="text" value="" name="dbname" class="form-control" placeholder="Database Name" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="section clearfix">
                                    <p>2. Please enter your account details for administration.</p>
                                    <hr />
                                    <div>

                                        <div class="form-group clearfix">
                                            <label for="fullname" class=" col-md-3">Your Name</label>
                                            <div class="col-md-9">
                                                <input type="text" value=""  id="admin_username"  name="admin_username" class="form-control"  placeholder="Your Name" />
                                            </div>
                                        </div>

                                        <div class="form-group clearfix">
                                            <label for="email" class=" col-md-3">Email</label>
                                            <div class=" col-md-9">
                                                <input type="text" value="" name="email" class="form-control" placeholder="Your email" />
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <label for="password" class=" col-md-3">Password</label>
                                            <div class=" col-md-9">
                                                <input type="password" value="" name="password" class="form-control" placeholder="Login password" />
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <label class=" col-md-3">Timezone server</label>
                                            <div class=" col-md-9">
                                                <select name="timezone" class="form-control">
                                                <?php foreach(tz_list() as $t) { ?>
                                                    <option value="<?=$t['zone'] ?>" >
                                                        <?=$t['diff_from_GMT'] . ' - ' . $t['zone'] ?>
                                                    </option>
                                                <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="section clearfix">
                                    <p>3. Please enter your item purchase code.</p>
                                    <hr />
                                    <div>
                                        <div class="form-group clearfix">
                                            <label for="purchase_code" class=" col-md-3">Item purchase code</label>
                                            <div class="col-md-9">
                                                <input type="text" value=""  id="purchase_code"  name="purchase_code" class="form-control"  placeholder="Find in codecanyon item download section" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-footer">
                                    <button type="submit" class="btn btn-info form-next">
                                        <span class="loader hide"> Processing...</span>
                                        <span class="button-text"><i class='fa fa-chevron-right'></i> Finish</span> 
                                    </button>
                                </div>

                            </form>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="finished-tab">
                            <div class="section">
                                <div class="clearfix">
                                    <i class="status fa fa-check-circle-o pull-left" style="font-size: 50px"> </i><span class="pull-left"  style="line-height: 50px;">Congratulation! You have successfully installed <?=$project_name?></span>  
                                </div>

                                <div style="margin: 15px 0 15px 60px; color: #d73b3b;">
                                    Don't forget to delete your installation directory!
                                </div>
                                <a class="go-to-login-page" href="<?php echo $dashboard_url; ?>">
                                    <div class="text-center">
                                        <div style="font-size: 100px;"><i class="fa fa-desktop"></i></div>
                                        <div>GO TO YOUR LOGIN PAGE</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<script type="text/javascript">

    var onFormSubmit = function ($form) {
        $form.find('[type="submit"]').attr('disabled', 'disabled').find(".loader").removeClass("hide");
        $form.find('[type="submit"]').find(".button-text").addClass("hide");
        $("#alert-container").html("");
    };
    var onSubmitSussess = function ($form) {
        $form.find('[type="submit"]').removeAttr('disabled').find(".loader").addClass("hide");
        $form.find('[type="submit"]').find(".button-text").removeClass("hide");
    };

    $(document).ready(function () {
        var $preInstallationTab = $("#pre-installation-tab"),
                $configurationTab = $("#configuration-tab");

        $(".form-next").click(function () {
            if ($preInstallationTab.hasClass("active")) {
                $preInstallationTab.removeClass("active");
                $configurationTab.addClass("active");
                $("#pre-installation").find("i").removeClass("fa-circle-o").addClass("fa-check-circle");
                $("#configuration").addClass("active");
                $("#host").focus();
            }
        });

        $("#config-form").submit(function () {
            var $form = $(this);
            onFormSubmit($form);
            $form.ajaxSubmit({
                dataType: "json",
                success: function (result) {
                    onSubmitSussess($form, result);
                    if (result.status == 'success') {
                        $configurationTab.removeClass("active");
                        $("#configuration").find("i").removeClass("fa-circle-o").addClass("fa-check-circle");
                        $("#finished").find("i").removeClass("fa-circle-o").addClass("fa-check-circle");
                        $("#finished").addClass("active");
                        $("#finished-tab").addClass("active");
                    } else {
                        $("#alert-container").html('<div class="alert alert-danger" role="alert">' + result.message + '</div>');
                    }
                }
            });
            return false;
        });

    });
</script>