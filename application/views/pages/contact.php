<?php $this->load->view('static/header'); ?>

<section id="contact">
	<div class="container">
		<div class="row">
			<div class="col-sm-2 col-md-3"></div>
			<div class="col-sm-8 col-md-6">
				<div class="contact-under-map_" style="padding: 10px 0 40px;">

					<h1 class="page-title">Get In Touch</h1>
					<form action="/welcome/sendcontact" method="post">
						<?php if ($this->session->flashdata('ct_error') != null) {
							echo '<div class="alert alert-danger">'. $this->session->flashdata('ct_error') .'</div>';
						} ?>
						<?php if ($this->session->flashdata('ct_success') != null) {
							echo '<p style="text-align: center;">'. lang('ct_success') .'</p>';
						} else { ?>
		    				<div class="form-group">
								<input type="text" class="form-control" name="name" placeholder="<?=lang('ct_name')?>" required>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" name="email" placeholder="<?=lang('ct_email')?>" required>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" name="phone" placeholder="<?=lang('ct_phone')?>">
							</div>
		                    <div class="form-group">
			                    <textarea class="form-control" type="textarea" id="message" name="message" placeholder="<?=lang('ct_message')?>" maxlength="140" rows="7"></textarea>
		                    </div>
		                    <div class="form-group">
		                    	<button type="submit" class="btn btn-block btn-primary"><?=lang('ct_send')?></button>
		                    </div>
	                    <?php } ?>
	                </form>
	            </div>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('static/footer'); ?>
