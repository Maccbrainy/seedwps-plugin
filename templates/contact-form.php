<form id="paragonContactForm" class="" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php');?>">
	<div class="form-group">
		<input type="text" class="form-control paragon-form-control" placeholder="Your Name" id="name" name="name"><small class="text-danger form-control-msg"> Your Name is Required</small>
	</div>
	<div class="form-group">
		<input type="email" class="form-control paragon-form-control" placeholder="Your Email" id="email" name="email"><small class="text-danger form-control-msg"> Your Email is Required</small>
	</div>
	<div class="form-group">
		<textarea name="message" class="form-control paragon-form-control" placeholder="Your Message" id="message"></textarea><small class="text-danger form-control-msg"> A Message is Required</small> 
	</div>
	<div class="text-center">
		<button type="submit" class="btn btn-default btn-lg btn-paragon-form">Submit</button>
		<small class="text-info form-control-msg js-form-submission"> Submission in progress, please wait...</small>
		<small class="text-success form-control-msg js-form-success"> Message successfully submitted, thank you!</small>
		<small class="text-danger form-control-msg js-form-error"> There was a problem with the contact form, please try again!</small>
	</div>
</form>

