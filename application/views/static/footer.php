

    <footer>
        <div class="pull-right social-footer">
            <a href="https://www.facebook.com/tugumandiri" target="_blank" class="sf sf-fb"><i class="fa fa-facebook"></i> <span>Tugu Mandiri</span></a>
            <a href="https://twitter.com/Tugu_Mandiri" target="_blank" class="sf sf-ig"><i class="fa fa-twitter"></i> <span>@Tugu_Mandiri</span></a>
            <a href="https://www.youtube.com/channel/UCsKbw383LyKr3x1NbO4EDbw" target="_blank" class="sf sf-yt"><i class="fa fa-youtube"></i> <span>Official Tugu Mandiri </span></a>
            <a href="http://instagram.com/tugumandiri" target="_blank" class="sf sf-ig"><i class="fa fa-instagram"></i> <span>tugumandiri </span></a>
        </div>
        <div class="footer-copyright">
            &copy; Copyright <?=date('Y')?> TMLife
        </div>
    </footer>

</body>
</html>

<script   
    src="https://code.jquery.com/jquery-1.12.3.min.js"   
    integrity="sha256-aaODHAgvwQW1bFOGXMeX+pC4PZIPsvn2h1sArYOhgXQ="   
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" 
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" 
    crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" 
    integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" 
    crossorigin="anonymous"></script>

<script src="/resources/lightslider/js/lightslider.min.js"></script>

<?php if( !empty($js)){ foreach ($js as $key => $value){
    echo '<script type="text/javascript" src="'. $value .'"></script>';
}} ?>

<script src="/resources/script/gg.js"></script>


<div class="modal fade" id="callUsModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
