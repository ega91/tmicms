<?php if (empty($section_idx)):
  echo '<div class="alert alert-danger">You need to specify $section_idx (section index)</div>'; else: ?>


<?php
  $content_idx = ( !empty($section->contents) )? $section->contents[ count($section->contents) -1 ]->order_number : 0; ?>
<ul 
  class="new-content-container new-content-container-<?php echo $section_idx?>" 
  content-idx="<?php echo $content_idx?>" 
  section-idx="<?php echo $section_idx?>">
  <?php if ( !empty($section->contents) ){ foreach ($section->contents as $content) {
    $this->load->view( 'post/_content-'. $content->content_type, Array( 'content' => $content, 'content_idx' => $content->order_number ) );
  }} ?>
</ul>

<div class="new-section-container">
  <div class="new-content-btn-cnt hidden">
    <button type="button" class="btn btn-default btn-block"><i class="fa fa-align-left"></i>&nbsp; Add Content</button>
  </div>
  <div class="new-content-cnt">
    <h2 class="text-center new-section-title">Add Content</h2>
    <h4 class="text-center new-section-subtitle">Add new content to this section.</h4>
    <p class="text-center">You also can add image and embed video, widget, map inside article section. <a href="#">Lean more</a></p>
    <ul class="new-section-options">
      <div class="new-section-overlay"><i class="fa fa-spinner fa-spin"></i> Loading...</div>
      <li><a href="#article" section-idx="<?php echo $section_idx?>" content-type="article"><div><i class="fa fa-file-text-o"></i></div>Text Article</a></li>
      <li>
        <a href="#image"><div><i class="fa fa-file-image-o"></i></div>Image Content</a>
        <ul style="display: none;">
          <li><a href="#back" class="content-back-btn"><div><i class="fa fa-chevron-left"></i></div>Back</a></li>
          <li>
            <a href="#image-gallery" section-idx="<?php echo $section_idx?>" content-type="image_gallery">
              <div class="content-image-gallery">
                <i class="fa fa-image fa-image-1"></i>
                <i class="fa fa-image fa-image-2"></i>
              </div>Images Gallery
            </a>
          </li>
          <li>
            <a href="#iamge-360" section-idx="<?php echo $section_idx?>" content-type="image_360">
              <div class="content-image-360"><span>360<sup>o</sup></span></div>360 Image
            </a>
          </li>
        </ul>
      </li>
      <li>
        <a href="#video"><div><i class="fa fa-file-movie-o"></i></div>Video</a>
        <ul style="display: none;">
          <li><a href="#back" class="content-back-btn"><div><i class="fa fa-chevron-left"></i></div>Back</a></li>
          <li><a href="#video-youtube" section-idx="<?php echo $section_idx?>" content-type="video_youtube"><div><i class="fa fa-youtube"></i></div>Youtube Video</a></li>
          <li class="hidden"><a href="#video-other" section-idx="<?php echo $section_idx?>" content-type="video_embed"><div><i class="fa fa-file-code-o"></i></div>Embed Video</a></li>
        </ul>
      </li>
      <li class="hidden"><a href="#quote" section-idx="<?php echo $section_idx?>" content-type="quote"><div><i class="fa fa-quote-right"></i></div>Quote</a></li>
      <li><a href="#widget" section-idx="<?php echo $section_idx?>" content-type="widget"><div><i class="fa fa-file-code-o"></i></div>Widget</a></li>
      <li><a href="#map" section-idx="<?php echo $section_idx?>" content-type="map_embed"><div><i class="fa fa-map-o"></i></div>Map</a></li>
    </ul>
    </div>
</div>

<?php endif; ?>
