<?php
get_header();
?>
    <div class="wrapper">
      <header class="header">
        <div class="inner">
          <div class="branding">
            <h1 class="logo">
              <a href="#" title="Echelon 2013" alt="Echelon" >Echelon</a>
            </h1>
            <span class="year">2013</span>
            <div class="date">11-12 June 2013</div>
            <p>Singapore</p>
          </div>
          <div class="slogan">
            <em>Driving Asia's<br/>Tech Industry Forward</em>
          </div>
          <div class="banner-wrapper">
            <div class="banner-1">Banner 1</div>
            <span class="social-top">
            <ul class="clearfix">
              <li><a href="<?php echo get_option("echelon_fb_url"); ?>" class="facebook"></a></li> 
              <li><a href="<?php echo get_option("echelon_tw_url"); ?>" class="twitter">twitter</a></li>
              <li><a href="<?php echo get_option("echelon_gp_url"); ?>" class="google">google</a></li>
              <li class="last"><a href="<?php echo get_option("echelon_in_url"); ?>" class="linkedin">linkedin</a></li>
            </ul>          
          </span>
          </div>
        </div>
      </header>
    
      <div class="navbar">
        <div class="navbar-inner">
          <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </a>
            <a class="register" href="#">Project name</a>
            <div class="nav-collapse collapse">
              <ul class="nav">
                <li><a href="about.html">About</a></li>
                <li><a href="agenda.html">Agenda</a></li>
                <li><a href="#speaker">Speakers</a></li>
                <li><a href="#satellites">Satellites</a></li>
                <li><a href="#startups">Startups</a></li>
                <li><a href="#venue">Venue</a></li>
                <li><a href="#partner">Partner</a></li>
                <li><a href="#contact">Contact</a></li>
              </ul>
            </div><!--/.nav-collapse -->
          </div>
        </div>
      </div>
      <div class="navbar-border"></div>
  
      <div class="showcase">
        <div class="container">
          <div class="row">
            <div id="slides" class="banner-rotate">
              <div class="slides_container" style='background:white'>
				<?php
				$ptype = "e_carousel";
				$args = array(
					'post_type'=> $ptype,
					'order'    => 'ASC',
					'orderby'	=> 'meta_value',
					'meta_key' 	=> $ptype.'_order'
				);              
				$the_query = new WP_Query( $args );
				if($the_query->have_posts() ){
					while ( $the_query->have_posts() ){
						$the_query->the_post();
						$p = get_post( get_the_ID(), OBJECT );
						$image_id = get_post_meta( $p->ID, $ptype.'_image_id', true );
						$image_src = wp_get_attachment_url( $image_id );
						$alt = get_post_meta( $p->ID, $ptype.'_alt_tag', true );
						$title = get_post_meta( $p->ID, $ptype.'_title_tag', true );
						$order = get_post_meta($p->ID, $ptype.'_order', true );
						?><img width="490" height="300" alt="<?php echo htmlentities($alt); ?>" title="<?php echo htmlentities($title); ?>" src="<?php echo $image_src ?>" style="max-width:100%;" /><?php
					}
				}
				wp_reset_postdata();
				?>
              </div>
            </div>
            
            <div class="video-wrapper">
            <?php
				$ptype = "e_youtube";
				$args = array(
					'post_type'=> $ptype,
					'order'    => 'ASC',
					'orderby'	=> 'rand'
				);              
				$the_query = new WP_Query( $args );
				if($the_query->have_posts() ){
					while ( $the_query->have_posts() ){
						$the_query->the_post();
						$p = get_post( get_the_ID(), OBJECT );
						$youtube_link = get_post_meta( $p->ID, $ptype.'_youtube_link', true );
						$youtube_id = explode("watch?v=", $youtube_link);
						$youtube_id = $youtube_id[1];
						$youtube_id = explode("&", $youtube_id);
						$youtube_id = $youtube_id[0];
						?> <iframe width="449" height="337" src="http://www.youtube.com/embed/<?php echo $youtube_id; ?>" frameborder="0" allowfullscreen></iframe><?php
						break;
					}
				}
				wp_reset_postdata();
			
			?>
            </div>
          </div>
        </div>            
      </div>


    <div class="container">
      <div class="row add-bot-med">
        <div class="span9 highlights">
          <h2>The Biggest TechBiz Event in the Region</h2>
          <p>Echelon 2013 is a <a href="">two-day, double-track event on June 11-12</a> with over 1,100 delegates, a <a href="">startup marketplace of up to 50 startups</a> and various workshops. Echelon 2012 will be the biggest ever edition of Asia's best startup event. It will discover Southeast Asia's best startups on an all new scale.</p>
          <p>Echelon 2013 will be the biggest ever edition of Asia's best startup event. It will discover Southeast Asia's best startups on an all new scale.</p>        
          <div class="par-comment">
            <div class="row-fluid comment-wrapper">
              <div class="green-quote">quote</div>
              <div class="client-badge">quote</div>
              <div class="sayings"><p>e27 is the foundation of the startup<br/>& entreprenuerial ecosystem in<br/>Southeast Asia</p><p>- Hugh Mason Co-founder - JFDI Asia</p></div>
              <div class="register-small"><a href="" alt="Register" title="Early Bird Registration">Early Bird</a></div>
            </div>
          </div>
          <h2 class="add-top">Featured Speakers</h2>
          <p>Renowned for our ability to bring in top notch speakers and judges from around the world including US and Asia. You can be assured that we will delivered the utmost relevant trending Asia content. <a href="">Check out our full list of speakers</a>.</p>
          <div class="row-fluid add-top">
			 <?php
				$ptype = "e_speaker";
				$args = array(
					'post_type'=> $ptype,
					'order'    => 'ASC',
					'orderby'	=> 'meta_value',
					'meta_key' 	=> $ptype.'_order'
				);              
				$the_query = new WP_Query( $args );
				$i=0;
				if($the_query->have_posts() ){
					while ( $the_query->have_posts() ){
						if($i%4==0){
							if($i>0){
								?></div><?php
							}
							?><div class="wrapper-speakers"><?php
						}
						$the_query->the_post();
						$p = get_post( get_the_ID(), OBJECT );
						$image_id = get_post_meta( $p->ID, $ptype.'_image_id', true );
						$designation = get_post_meta( $p->ID, $ptype.'_designation', true );
						$image_src = wp_get_attachment_url( $image_id );
						?>
						 <div class="span3 txt-c">
							<img style='height:128px; width:128px' src="<?php echo $image_src?>" title="<?php echo htmlentities($p->post_title) ?>" alt="<?php echo htmlentities($p->post_title) ?>" class="rounded"/>
							<p><em><?php echo htmlentities($p->post_title) ?></em><br/><?php echo $designation;?></p>
						  </div>
						<?php
						$i++;
					}
					?></div><?php
				}
				wp_reset_postdata();
			
			?>
         
          </div>
          
          <div class="view-more"><a href="#" class="pull-right add-top">Check out our full list of speakers</a></div>          
          <div class="par-comment">
            <div class="row-fluid comment-wrapper">
              <div class="green-quote">quote</div>
              <div class="client-badge">quote</div>
              <div class="sayings"><p>e27 is the foundation of the startup<br/>& entreprenuerial ecosystem in<br/>Southeast Asia</p><p>- Hugh Mason Co-founder - JFDI Asia</p></div>
              <div class="register-small"><a href="" alt="Register" title="Early Bird Registration">Early Bird</a></div>
            </div>
          </div>
          <div class="row-fluid add-top">
            <div class="span6">
              <h2>Startups</h2>
              <div class="startups-img">Image</div>
              <p><a href="">With the high number of quality applications</a> for the Japan Satellite, the startups were put through a preliminary round and 9 startups were selected to pitch tomorrow at the main Japan Satellite. The Japan Satellite kicked off with the Preliminaries today at the Open Network Labs' offices today.</p>
              <p>With the high number of quality applications for the Japan Satellite, the startups were put through a preliminary round and 9 startups were selected to pitch tomorrow at the main Japan Satellite. The Japan Satellite kicked off with the Preliminaries today at the Open Network Labs' offices today.</p>            
            </div>
            <div class="span6">
              <h2>Satellites</h2>
              <p>With the high number of quality applications for the Japan Satellite, the startups were put through a preliminary round and 9 startups were selected to pitch tomorrow at the main Japan Satellite. The Japan Satellite kicked off with the Preliminaries today at the Open Network Labs' offices today.</p>
              <div class="satellites-img">Image</div>
              <p>With the high number of quality applications for the Japan Satellite, the startups were put through a preliminary round and 9 startups were selected to pitch tomorrow at the main <a href="">Japan Satellite</a>. The Japan Satellite kicked off with the Preliminaries today at the Open Network Labs' offices today.</p>
            </div>
          </div>
          <div class="row-fluid fourth-lvl">
            <h2>News & Update</h2>
            <div class="row-fluid">
              <div class="span6 nu-box">
                <h3>Startup Pitch is opening, hurry up!</h3>
                <p>With the high number of quality applications for the Japan Satellite, the startups were put through a preliminary round and 9 startups were selected to pitch tomorrow at the main Japan Satellite. The Japan Satellite kicked off with the Preliminaries today at the Open Network Labs' offices today.</p>            
                <a href="" class="readmore">Read more</a>              
              </div>
              <div class="span6 nu-box">
                <h3>Startup Pitch is opening, hurry up!</h3>
                <p>With the high number of quality applications for the Japan Satellite, the startups were put through a preliminary round and 9 startups were selected to pitch tomorrow at the main Japan Satellite. The Japan Satellite kicked off with the Preliminaries today at the Open Network Labs' offices today.</p>            
                <a href="" class="readmore">Read more</a>              
              </div>
            </div>
          </div>
        </div>
        
        <div class="span3 side-pillar txt-c">
			<?php
			$ptype = "e_sponsor";
			$args = array(
				'post_type'=> $ptype,
				'order'    => 'ASC',
				'orderby'	=> 'meta_value',
				'meta_key' 	=> $ptype.'_order'
			);              
			$the_query = new WP_Query( $args );
			$premier_sponsors = array();
			$sponsors = array();
			if($the_query->have_posts() ){
				while ( $the_query->have_posts() ){
					$the_query->the_post();
					$p = get_post( get_the_ID(), OBJECT );
					$image_id = get_post_meta( $p->ID, $ptype.'_image_id', true );
					$type = get_post_meta( $p->ID, $ptype.'_type', true );
					$link = get_post_meta( $p->ID, $ptype.'_link', true );
					$html = get_post_meta( $p->ID, $ptype.'_html', true );
					
					$image_src = wp_get_attachment_url( $image_id );
					$v = array();
					$v['post'] = $p;
					$v['image_src'] = $image_src;
					$v['link'] = $link;
					$v['html'] = $html;
					
					if(strtolower($type)=='premier'){
						$premier_sponsors[] = $v;
					}
					else{
						$sponsors[] = $v;
					}
				}
			}
			
			wp_reset_postdata();
			
			$t = count($premier_sponsors);
			if($t){
				?>
				<div class="head-pillar"><p>Premier Sponsors</p></div>
				<ul>
				<?php
				for($i=0; $i<$t; $i++){
					?>
					<li>
					<?php
					if(trim($premier_sponsors[$i]['html'])){
						echo trim($premier_sponsors[$i]['html']);
					}
					else{
						if(trim($premier_sponsors[$i]['link'])){
							?>
							<a href="<?php echo $premier_sponsors[$i]['link']; ?>"><img src="<?php echo $premier_sponsors[$i]['image_src']; ?>" title="<?php echo htmlentities($premier_sponsors[$i]['post']->post_title); ?>" alt="<?php echo htmlentities($premier_sponsors[$i]['post']->post_title); ?>"><a/>
							<?php
						}
						else{
							?>
							<img src="<?php echo $premier_sponsors[$i]['image_src']; ?>" title="<?php echo htmlentities($premier_sponsors[$i]['post']->post_title); ?>" alt="<?php echo htmlentities($premier_sponsors[$i]['post']->post_title); ?>">
							<?php
						}
					}
					?>
					</li>
					<?php
				}
				?>
				</ul>
				<?php
			}
			
			$t = count($sponsors);
			if($t){
				?>
				<div class="inner-pillar"><p>Sponsors</p></div>
				<ul>
				<?php
				for($i=0; $i<$t; $i++){
					?>
					<li>
					<?php
					if(trim($sponsors[$i]['html'])){
						echo trim($sponsors[$i]['html']);
					}
					else{
						if(trim($sponsors[$i]['link'])){
							?>
							<a href="<?php echo $sponsors[$i]['link']; ?>"><img src="<?php echo $sponsors[$i]['image_src']; ?>" title="<?php echo htmlentities($sponsors[$i]['post']->post_title); ?>" alt="<?php echo htmlentities($sponsors[$i]['post']->post_title); ?>"><a/>
							<?php
						}
						else{
							?>
							<img src="<?php echo $sponsors[$i]['image_src']; ?>" title="<?php echo htmlentities($sponsors[$i]['post']->post_title); ?>" alt="<?php echo htmlentities($sponsors[$i]['post']->post_title); ?>">
							<?php
						}
					}
					?>
					</li>
					<?php
				}
				?>
				</ul>
				<?php
			}
			
			
			
			
			
			$ptype = "e_mediapartners";
			$args = array(
				'post_type'=> $ptype,
				'order'    => 'ASC',
				'orderby'	=> 'meta_value',
				'meta_key' 	=> $ptype.'_order'
			);              
			$the_query = new WP_Query( $args );
			$premier_mps = array();
			$mps = array();
			if($the_query->have_posts() ){
				while ( $the_query->have_posts() ){
					$the_query->the_post();
					$p = get_post( get_the_ID(), OBJECT );
					$image_id = get_post_meta( $p->ID, $ptype.'_image_id', true );
					$type = get_post_meta( $p->ID, $ptype.'_type', true );
					$link = get_post_meta( $p->ID, $ptype.'_link', true );
					$html = get_post_meta( $p->ID, $ptype.'_html', true );
					
					$image_src = wp_get_attachment_url( $image_id );
					$v = array();
					$v['post'] = $p;
					$v['image_src'] = $image_src;
					$v['link'] = $link;
					$v['html'] = $html;
					
					if(strtolower($type)=='premier'){
						$premier_mps[] = $v;
					}
					else{
						$mps[] = $v;
					}
				}
			}
			
			wp_reset_postdata();
			
			$t = count($premier_mps);
			if($t){
				?>
				<div class="inner-pillar"><p>Premier Media Partners</p></div>
				<ul>
				<?php
				for($i=0; $i<$t; $i++){
					?>
					<li>
					<?php
					if(trim($premier_mps[$i]['html'])){
						echo trim($premier_mps[$i]['html']);
					}
					else{
						if(trim($premier_mps[$i]['link'])){
							?>
							<a href="<?php echo $premier_mps[$i]['link']; ?>"><img src="<?php echo $premier_mps[$i]['image_src']; ?>" title="<?php echo htmlentities($premier_mps[$i]['post']->post_title); ?>" alt="<?php echo htmlentities($premier_mps[$i]['post']->post_title); ?>"><a/>
							<?php
						}
						else{
							?>
							<img src="<?php echo $premier_mps[$i]['image_src']; ?>" title="<?php echo htmlentities($premier_mps[$i]['post']->post_title); ?>" alt="<?php echo htmlentities($premier_mps[$i]['post']->post_title); ?>">
							<?php
						}
					}
					?>
					</li>
					<?php
				}
				?>
				</ul>
				<?php
			}
			
			$t = count($mps);
			if($t){
				?>
				<div class="inner-pillar"><p>Media Partners</p></div>
				<ul>
				<?php
				for($i=0; $i<$t; $i++){
					?>
					<li>
					<?php
					if(trim($mps[$i]['html'])){
						echo trim($mps[$i]['html']);
					}
					else{
						if(trim($mps[$i]['link'])){
							?>
							<a href="<?php echo $mps[$i]['link']; ?>"><img src="<?php echo $mps[$i]['image_src']; ?>" title="<?php echo htmlentities($mps[$i]['post']->post_title); ?>" alt="<?php echo htmlentities($mps[$i]['post']->post_title); ?>"><a/>
							<?php
						}
						else{
							?>
							<img src="<?php echo $mps[$i]['image_src']; ?>" title="<?php echo htmlentities($mps[$i]['post']->post_title); ?>" alt="<?php echo htmlentities($mps[$i]['post']->post_title); ?>">
							<?php
						}
					}
					?>
					</li>
					<?php
				}
				?>
				</ul>
				<?php
			}
			?>
			
          
           
          <!--
          <div class="inner-pillar"><p>Sponsors</p></div>
          <ul>
            <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/themes/img/sponsors/amazon.png" alt="Amazon Web Services"></a></li>
            <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/themes/img/sponsors/dena.png" alt="Dena"></a></li>
            <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/themes/img/sponsors/innov8.png" alt="Innov8"></a></li>
            <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/themes/img/sponsors/google.png" alt="Google"></a></li>
            <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/themes/img/sponsors/lenovo.png" alt="Lenovo"></a></li>
            <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/themes/img/sponsors/pnp.png" alt="Plug and Play Tech Center"></a></li>
            <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/themes/img/sponsors/roof.png" alt="Roof"></a></li>
            <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/themes/img/sponsors/doob.png" alt="Doob Bean Bags"></a></li>
          </ul>
		  
          <div class="inner-pillar"><p>Premier Media Partners</p></div>
          <ul>              
            <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/themes/img/sponsors/cbs.png" alt="CBS Interactive"></a></li>
            <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/themes/img/sponsors/zdnet.png" alt="ZDNet"></a></li>
          </ul>
          <div class="inner-pillar"><p>Media Partners</p></div>
          <ul>              
            <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/themes/img/sponsors/sdating.png" alt="Startup Dating"></a></li>
            <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/themes/img/sponsors/s-weekend.png" alt="Startup Weekend"></a></li>
            <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/themes/img/sponsors/t65.png" alt="Tech 65"></a></li>
            <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/themes/img/sponsors/tgndu.png" alt="Techgoondu"></a></li>
          </ul>  
        </div>
		-->

      </div>

      <div class="row-fluid socials add-bot">
        <div class="span4">
          facebook here     
        </div>
        <div class="span4">
            <div class="twitter-btn add-bot">Twitter Button</div>
            <div class="twitter-feed">
              <p>Call for startup pitch! hurry up for the life time experience!<br/><em>6 hours ago by <span class="text-success">e27</span></em></p>  
            </div>
            <div class="twitter-feed">
              <p>Call for startup pitch! hurry up for the life time experience!<br/><em>6 hours ago by <span class="text-success">e27</span></em></p>  
            </div>
        </div>
        <div class="span4">
          <div class="subscribe add-left-med">
            <h3>Subscribe for <br/>Echelon Newsletter</h3>
            <input type="text" placeholder="Your Email"/>
            <a class="btn btn-success subscribe" data-toggle="modal" href="#signupModal">Subscribe</a>
            <p class="txt-small">Don't worry! we hate spam too!</p>
          </div>            
        </div>
      </div>
    </div>
    <!-- /container -->
    <div class="footer-extras">
      <div class="container">
        <div class="row">
          <div class="span3-ftr-cnter  logo-e27"><a href="" alt="e27 Web Innovation Asia" title="e27 Web Innovation Asia">e27 logo</a></div>
          <div class="span7 about-small">
            <h3>Your event organizer, e27</h3>
            <p>Founded in 2007, e27 is a media organization focused on the Asian technology startup industry.
              We believe in building the community of technology innovators across Asia by reporting on the latest,
              breaking news relevant to technology startups, technology companies as well as investors on the  while
              keeping our ears to the ground by connecting with our readers </p>
          </div>
          <div class="span2 social-footer pull-right">
            <h3>Stay Connected</h3>
            <div class="inner-social-footer">
              <ul class="social-icons-footer clearfix">
                <li>
                  <span class="twitter"></span>
                  <a href="<?php echo get_option("echelon_tw_url"); ?>">Twitter</a>
                </li>
                <li>
                  <span class="facebook"></span>                  
                  <a href="<?php echo get_option("echelon_fb_url"); ?>">Facebook</a>
                </li>
                <li>
                  <span class="google"></span>
                  <a href="<?php echo get_option("echelon_gp_url"); ?>">Google+</a>
                </li>   
                <li>
                  <span class="linkedin"></span>  
                  <a href="<?php echo get_option("echelon_in_url"); ?>">LinkedIn</a></li>
              </ul>
            </div>
          </div>
        </div>      
      </div>
    </div>
    <footer class="footer">
      <div class="container add-top-small c-text">
        <div class="pull-left">&copy;2012 Echelon | e27 Web Innovation Asia</div>
        <div class="pull-right"><a href="">About</a> | <a href="">Contact</a> | <a href="">Register</a></div>  
      </div>    
    </footer>
</div>
<?php
get_footer();
?>