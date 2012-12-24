<div class = "NextEvent_Box" style="width: 250px;"><iframe name="countdown" id="mgframe" src="http://www.eventbrite.com/countdown-widget?eid=600020678" width="250" height="382" marginheight="0" marginwidth="0" scrolling="no"  frameborder="0" ></iframe><a href="http://www.eventbrite.com/r/ecount"><img src="http://www.eventbrite.com/s.gif" alt="Events" border="0"/></a></div>

<div class="new_add_most_read_and_latest_comments">
				<div class="NextEvent_Box ForumBox" style="display: block;" id="content1">
                	<div class="Top_bar">
                    	<ul class="TabMenu">
							<li class="box1 activated"><a href="javascript: swapPanel('content1')">Most Read</a></li>
							<li class="box2"><a href="javascript: swapPanel('content2')">Latest Comments</a></li>
                        </ul>
                    </div>
                    <div class="Bottom_bar Lists">
                    	<?php if (function_exists('get_mostpopular')) get_mostpopular(); ?>
                    </div>
                </div>

				<div class="NextEvent_Box ForumBox" style="display: none;" id="content2">
                	<div class="Top_bar">
                    	<ul class="TabMenu">
							<li class="box1 "><a href="javascript: swapPanel('content1')">Most Read</a></li>
							<li class="box2 activated2"><a href="javascript: swapPanel('content2')">Latest Comments</a></li>
                        </ul>
                    </div>
                    <div class="Bottom_bar Lists">
                    	<?php if (function_exists('src_simple_recent_comments')) { src_simple_recent_comments(10, 60, '', ''); } ?>
                    </div>
                </div>

		<!--div style="display: block;" id="content1">
			<div class="toptabs">
				<div class="tab1"><a href="javascript: swapPanel('content1')">Most Read</a></div>
				<div class="tab2"><a href="javascript: swapPanel('content2')">Latest Comments</a></div>
			</div>
			<div class="top_border"></div>
			<div class="caseText">
				<?php if (function_exists('get_mostpopular')) get_mostpopular(); ?>
			</div>
		</div>
		
		<div style="display: none;" id="content2">
			<div class="toptabs">
				<div class="tab1"><a href="javascript: swapPanel('content1')">Most Read</a></div>
				<div class="tab2"><a href="javascript: swapPanel('content2')">Latest Comments</a></div>
			</div>
			<div class="top_border"></div>
			<div class="caseText">
				<?php if (function_exists('src_simple_recent_comments')) { src_simple_recent_comments(10, 60, '', ''); } ?>
			</div>
		</div-->
</div>