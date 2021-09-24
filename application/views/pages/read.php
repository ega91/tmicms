
    <?php $this->load->view('static/header'); ?>

    <?php if ( $data->parent->slug == 'trips' and !empty($data->images) ): ?>
      <section class="trip-img-cnt" id="trip-img-cnt" style="<?=(!empty($data->image_active))?'background-image: url(\''. $data->image_active->image_920 .'\')':''?>">
        <div class="add-timg-cnt" id="trip-images">
          <?php if ( isset($data->images) ): foreach ($data->images as $key => $value) { ?>
            <a href="#" media-id="<?=$value->id?>" media-hd="<?=$value->image_920?>" class="trip-image <?=(!empty($value->active))?'active':''?>" style="background-image: url('<?=$value->image_270?>');">&nbsp;</a>
          <?php } endif; ?>
        </div>
      </section>
    <?php endif; ?>

    <section class="article">
        <div class="container">
            <div class="row">

                <div class="col-md-8 col-editor">

                  <h1 class="post-title"><?=(!empty($data->title))?$data->title:''?></h1>

                  <?php $data->display_author = false; ?>
                  <?php if (!empty($data->display_author)): ?>
                    <?php $month = Array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'); ?>
                    <div id="article-user" class="article-user form-group">
                      <img src="/admin/resources/images/user.png" alt="">
                      <div class="au-name"><?=$data->author->first_name?> <?=$data->author->last_name?>
                        <div class="au-date">
                          <?php if (!empty($data->author->about)): ?>
                            <?=(!empty($data->publish_date))?$month[date('n', $data->publish_date) -1]:$month[date('n') -1]?>
                            <?=(!empty($data->publish_date))?date('d', $data->publish_date):date('d')?> 
                            <?=date('Y')?> 
                            at 
                            <?=(!empty($data->publish_date))?date('h', $data->publish_date):date('h')?>:<?=(!empty($data->publish_date))?date('i', $data->publish_date):date('i')?><?=(!empty($data->publish_date))?date('a', $data->publish_date):date('a')?>
                          <?php endif; ?>
                        </div>
                      </div>
                      <p class="au-about">
                        <?php if (!empty($data->author->about)){
                          echo substr($data->author->about, 0, 70);
                        } else { ?>
                          <?=(!empty($data->publish_date))?$month[date('n', $data->publish_date) -1]:$month[date('n') -1]?>
                          <?=(!empty($data->publish_date))?date('d', $data->publish_date):date('d')?> 
                          <?=date('Y')?> 
                          at 
                          <?=(!empty($data->publish_date))?date('h', $data->publish_date):date('h')?>:<?=(!empty($data->publish_date))?date('i', $data->publish_date):date('i')?><?=(!empty($data->publish_date))?date('a', $data->publish_date):date('a')?>
                        <?php } ?>
                      <div class="clearfix"></div>
                    </div>
                  <?php endif; ?>

                  <div class="share-container pull-right" style="display: none;">
                      <a href="https://www.facebook.com/sharer/sharer.php?u=<?=urlencode(current_url())?>" target="_blank" class="share-to share-to-fb"><i class="fa fa-facebook"></i></a>
                      <a href="https://twitter.com/intent/tweet?text=<?=urlencode($data->title)?>&url=<?=urlencode(current_url())?>" target="_blank" class="share-to share-to-twitter"><i class="fa fa-twitter"></i></a>
                      <a href="https://plus.google.com/share?url=<?=urlencode(current_url())?>" target="_blank" class="share-to share-to-google"><i class="fa fa-google-plus"></i></a>
                      <a href="whatsapp://send?text=<?=urlencode($data->title .' '. current_url())?>" class="share-to-wa"><i class="fa fa-whatsapp"></i></a>
                      <a href="https://line.me/R/msg/text/?<?=urlencode($data->title .' '. current_url())?>" target="_blank" class="share-to share-to-line"><i class="fa fa-line"></i></a>
                      <div class="clearfix"></div>
                  </div>

                  <?=(!empty($data->content))?$data->content:'<p><br /></p>'?>

                  <div class="clearfix"></div>
                  <div class="share-container share-container-bot">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?=urlencode(current_url())?>" target="_blank" class="share-to share-to-fb"><i class="fa fa-facebook"></i></a>
                    <a href="https://twitter.com/intent/tweet?text=<?=urlencode($data->title)?>&url=<?=urlencode(current_url())?>" target="_blank" class="share-to share-to-twitter"><i class="fa fa-twitter"></i></a>
                    <a href="https://plus.google.com/share?url=<?=urlencode(current_url())?>" target="_blank" class="share-to share-to-google"><i class="fa fa-google-plus"></i></a>
                    <a href="whatsapp://send?text=<?=urlencode($data->title .' '. current_url())?>" class="share-to-wa"><i class="fa fa-whatsapp"></i></a>
                    <a href="https://line.me/R/msg/text/?<?=urlencode($data->title .' '. current_url())?>" target="_blank" class="share-to-line"><i class="fa fa-line"></i></a>
                    <div class="clearfix"></div>
                  </div>

                </div>

		<div class="col-sm-4">
		    <div class="article-banner">
			<img src="/resources/img/article-banner.jpg">
		    </div>

		    <h2 class="page-title page-title-2">Profil Lainya</h2>
                    <div class="wn-list">
                        <?php if (!empty($wanita)){ foreach($wanita as $key => $value){ ?>
                        <?php $bgImg = (!empty($value->featured_image->image_90)) ? $value->featured_image->image_90 : ''; ?>
                        <div class="wn-item">
                          <a href="/wanita-hebat/<?=$value->slug?>">
                            <div class="wn-photo" style="background-image: url('<?=str_replace("'", "\'", $bgImg)?>')"></div>
                            <div class="wn-info">
                                <h3><?=$value->title?></h3>
                                <p></p>
                            </div>
                          </a>
                            <div class="clearfix"></div>
                        </div>
                        <?php }} ?>
                     </div>
		</div>

            </div>
        </div>
    </section>

    <?php if (!empty($related)): ?>
      <section id="related">
        <div class="container">
          <h2 class="page-title">Recomended for you</h2>
          <div class="row-related">
            <?php foreach ($related as $key => $relItem) { ?>
              <div class="col-related col-related-<?=$key?>">
                <a href="/<?=$data->parent->slug?>/<?=$relItem->slug?>">
                    <div class="rel-item-img" style="background-image: url('<?=(!empty($relItem->featured_image))?$relItem->featured_image->image_920:''?>');"></div>
                </a>
                <div class="rel-item-info">
                    <h3><a href="/<?=$data->parent->slug?>/<?=$relItem->slug?>"><?=$relItem->title?></a></h3>
                    <div class="rel-item-date"><a href="/<?=$data->parent->slug?>/<?=$relItem->slug?>">22 Feb 2018 15:30</a></div>
                    <p class="rel-item-desc"><?=substr($relItem->description, 0, 120)?>...</p>
                    <a href="/<?=$data->parent->slug?>/<?=$relItem->slug?>">View more...</a>
                </div>
              </div>
            <?php } ?>
            <div class="clearfix"></div>
          </div>
        </div>
      </section>
    <?php endif; ?>


    <?php $this->load->view('static/footer'); ?>
