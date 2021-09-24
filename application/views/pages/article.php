
    <?php $this->load->view('static/header'); ?>

    <section id="story">
        <div class="container">
            <h1 class="page-title"><?=$title?></h1>
            <?php if (!empty($subtitle)): ?>
                <p class="page-subtitle"><?=$subtitle?></p>
            <?php endif; ?>
            <div class="articles <?=$articleStyle?>">
                <?php if (empty($articles)): ?>
                    <div class="coming-soon"><img src="/resources/img/coming-soon.png"></div>
                <?php else: foreach ($articles as $key => $value) { ?>
                    <?php 
                        $articleClass = ''; 
                        if ( $key == 0 or $key == 6 )
                            $articleClass = 'articles-item-wide';
                    ?>
                    <div class="articles-item <?=($key%2==1)?'':'articles-item-l'?> <?=$articleClass?> <?=(empty($value->featured_image))?'articles-item-no-img':''?>">
                        <a href="/<?=$parent->slug?>/<?=$value->slug?>">
                            <div class="ar-item-img" style="background-image: url('<?=(!empty($value->featured_image))?$value->featured_image->image_920:''?>');"></div>
                        </a>
                        <div class="overlay"></div>
                        <div class="ar-item-info">
                            <h3 class="ar-item-title"><a href="/<?=$parent->slug?>/<?=$value->slug?>"><?=$value->title?></a></h3>
                            <div class="ar-item-date"><a href="/<?=$parent->slug?>/<?=$value->slug?>"><?=date('d M Y H:i', $value->publish_date)?></a></div>
                            <p class="ar-item-desc"><?=substr($value->description, 0, 270)?>...</p>
                            <a href="/<?=$parent->slug?>/<?=$value->slug?>">View more...</a>
                        </div>
                    </div>
                <?php } endif; ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </section>

    <?php $this->load->view('static/footer'); ?>
