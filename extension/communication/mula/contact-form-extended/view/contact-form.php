<?php if (!defined("RAZOR_BASE_PATH")) die("No direct script access to this content"); ?>

<?php

	// include class if not loaded
	include_once(RAZOR_BASE_PATH.'library/php/razor/razor_api.php');
	// include class if not loaded (error handler should always be loaded)
	include_once(RAZOR_BASE_PATH.'library/php/razor/razor_error_handler.php');
	
	// check server details
	$signature = null;
    if (isset($_SERVER["REMOTE_ADDR"], $_SERVER["HTTP_USER_AGENT"]) && !empty($_SERVER["REMOTE_ADDR"]) && !empty($_SERVER["HTTP_USER_AGENT"]))
    {
	    // signature generation
	    $signature = sha1($_SERVER["REMOTE_ADDR"].$_SERVER["HTTP_USER_AGENT"].rand(0, 100000));
	    $_SESSION["signature"] = $signature;
    }
	// grab settings for this content area and from that, find folder to use
	$c = json_decode($c_data["json_settings"]);

?>

<!-- module output -->
<div class="communication-mula-contact-form-extended" class="ng-cloak" ng-controller="main" ng-init="init()">
	<div class="row">
		<div class="col-sm-12" ng-show="response || robot || error">
			<p class="alert alert-success ng-cloak" ng-show="response"><i class="fa fa-check"></i>{{extSettings.success}}</p>
			<p class="alert alert-danger ng-cloak" ng-show="robot"><i class="fa fa-exclamation-triangle"></i>{{extSettings.nohuman}}</p>
			<p class="alert alert-danger ng-cloak" ng-show="error"><i class="fa fa-exclamation-triangle"></i>{{extSettings.error}}</p>
		</div>			
	</div>
	<div class="row">
		<div class="col-sm-12">
			<form name="form" class="form-horizontal" role="form" ng-class="{'message-sent': response}" novalidate id="contactform">
				<input type="hidden" ng-model="signature" ng-init="signature = '<?php echo $signature ?>'">
				<input type="hidden" ng-model="extSettings.captcha">
				<div class="form-group">
					<label for="contact-form-name" class="col-sm-3 control-label">Your Name</label>
					<div class="col-sm-7">
						<input id="contact-form-name" name="name" class="form-control" type="text" ng-model="name" placeholder="Please enter your full name" required>
					</div>	
				</div>
				<div class="form-group">				
					<label for="contact-form-email" class="col-sm-3 control-label">Your Email</label>
					<div class="col-sm-7">
						<input id="contact-form-email" name="email" class="form-control" type="email" ng-model="email" placeholder="you@somewhere.com" ng-pattern="/^\S+@\S+\.\S+$/" required>
					</div>
					<div class="col-sm-2 error-block ng-cloak" ng-show="form.email.$dirty && form.email.$invalid">
						<span class="alert alert-danger alert-form" ng-show="form.email.$error.required">Required</span>
						<span class="alert alert-danger alert-form" ng-show="form.email.$error.pattern">Invalid</span>
					</div>
				</div>
				<div class="form-group">
					<label for="contact-form-message" class="col-sm-3 control-label">Message</label>
					<div class="col-sm-7">
						<textarea id="communication-mula-contact-form-extended" rows="10" name="message" class="form-control" type="text" ng-model="message" required></textarea>
					</div>
					<div class="col-sm-2 error-block ng-cloak" ng-show="form.message.$dirty && form.message.$invalid">
						<span class="alert alert-danger alert-form" ng-show="form.message.$error.required">Required</span>
					</div>
				</div>	
				<div class="form-group" ng-show="!extSettings.captcha">
					<label for="contact-form-human" class="col-sm-3 control-label">Are You Human?</label>
					<div class="col-sm-7">
						<input id="contact-form-human" name="human" class="form-control" type="text" ng-model="human" ng-init="human = 'DELETE THIS TEXT IF HUMAN'">
					</div>
				</div>		
				<div class="form-group" ng-show="extSettings.captcha">	
					<label for="contact-form-captcha" class="col-sm-3 control-label">Captcha</label> 
						<div class="col-sm-7">							
							<div id="recaptchacontainer"></div>							
						</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-7">
						<button type="submit" class="btn btn-success" ng-click="send()" ng-disabled="form.$invalid || processing || !valid">
							<i class="fa fa-envelope"></i> 
							Send
						</button>
					</div>
				</div>				
			</form>
		</div>
	</div>
</div> 
<!-- module output -->
<!-- load dependancies -->
<?php if (!in_array("communication-mula-contact-form-style", $ext_dep_list)): ?>
	<?php $ext_dep_list[] = "communication-mula-contact-form-style" ?>
	<link type="text/css" rel="stylesheet" property="stylesheet" href="<?php echo RAZOR_BASE_URL ?>extension/communication/mula/contact-form-extended/style/style.css">
<?php endif ?>
<?php if (!in_array("communication-mula-contact-form-module", $ext_dep_list)): ?>
	<?php $ext_dep_list[] = "communication-mula-contact-form-module" ?>
	<script src="<?php echo RAZOR_BASE_URL ?>extension/communication/mula/contact-form-extended/js/module.js"></script>
<?php endif ?>
<!-- load dependancies -->