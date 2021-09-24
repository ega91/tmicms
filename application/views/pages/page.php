
    <?php $this->load->view('static/header'); ?>

    <section class="big-header" style="background-image: url('<?=(!empty($data->header_image))?$data->header_image->image_920:''?>')">
        <div class="overlay"></div>
        <div class="pt-container">
            <h1 class="page-title"><?=$data->title?></h1>
            <h2 class="page-subtitle"><?=$data->subtitle?></h2>
        </div>
        <div class="explore-more" style="display: none;"">
            <div class="container">
                <a href="#">
                    <p>Explore More</p>
                    <div class="em-arrow"></div>
                </a>
            </div>
        </div>
    </section>

    <section class="article-after-bg article">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-editor">
                    <?=(!empty($data->content))?$data->content:'<p><br /></p>'?>
                </div>
            </div>
        </div>
    </section>

    <?php $this->load->view('static/footer'); ?>
