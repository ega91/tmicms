<?php if ( !empty($data['__meta']->page_count) and $data['__meta']->page_count > 1 ): ?>
    <?php if (empty($page_uri)) $page_uri = current_url(); ?>
    <ul class="pagination">
        <?php 

        $uri_str = $this->input->get();
        echo '<li>';
        if ( !empty($uri_str['page']) ){
            $uri_str['page'] = 0;
            echo '<a href="'. $page_uri .'?'. http_build_query($uri_str) .'">First</a>';
        } else {
            echo '<span>First</span>';
        }
        echo '</li>';

        $uri_str = $this->input->get();
        echo '<li>';
        if ( !empty($uri_str['page']) ){
            $uri_str['page'] = $uri_str['page'] -1;
            echo '<a href="'. $page_uri .'?'. http_build_query($uri_str) .'"><i class="fa fa-chevron-left"></i></a>';
        } else {
            echo '<span><i class="fa fa-chevron-left"></i></span>';
        }
        echo '</li>';

        $dataDisplay = 0;
        $uri_str = $this->input->get();
        for ($i=0; $i < $data['__meta']->page_count; $i++) { 
            if ( $dataDisplay > 3 ){
                echo '<li><span>...</span></li>';
                break;
            }
            $uri_str['page'] = $i;
            echo '<li class="';
            if ( $i == $this->input->get('page') ) echo 'active';
            echo '"><a href="'. $page_uri .'?'. http_build_query($uri_str) .'">'. ($i +1) .'</a></li>';

            $dataDisplay++;
        }

        $uri_str = $this->input->get();
        echo '<li>';
        if ( empty($uri_str['page']) or $uri_str['page'] < ($data['__meta']->page_count -1) ){
            $uri_str['page'] = (!empty($uri_str['page'])) ? $uri_str['page'] +1 : 1;
            echo '<a href="'. $page_uri .'?'. http_build_query($uri_str) .'"><i class="fa fa-chevron-right"></i></a>';
        } else {
            echo '<span><i class="fa fa-chevron-right"></i></span>';
        } 
        echo '</li>';

        $uri_str = $this->input->get();
        echo '<li>';
        if ( empty($uri_str['page']) or $uri_str['page'] < ($data['__meta']->page_count -1) ){
            $uri_str['page'] = $data['__meta']->page_count -1;
            echo '<a href="'. $page_uri .'?'. http_build_query($uri_str) .'">Last</a>';
        } else {
            echo '<span>Last</span>';
        } 
        echo '</li>'; 

        ?>

    </ul>
<?php endif; ?>
