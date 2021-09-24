
<?php $this->load->view('static/menu'); ?>

<section id="search-result">
    <div class="search-caption"><h2><?=$this->input->get('q')?></h2></div>
</section>

<section id="content" class="content-ok clearfix"><?php $this->load->view('pages/content'); ?></section>