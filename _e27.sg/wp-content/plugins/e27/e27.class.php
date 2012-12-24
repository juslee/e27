<?php

require_once('sybase/_sylli.class.php');

class e27 extends Sylli_WP_BaseObject {

	public function __construct() {
		parent::__construct();
	}

	public function playground() {
	?>
		<style>
			#disqus blockquote {
				color: white;
				-webkit-border-radius: 10px;
				-moz-border-radius: 10px;
				border-radius: 10px;
				padding: 15px;
				background-color: #bbb;
			}
		</style>

		<script type="text/javascript">
			(function($) {
				var dqs = {
					endpoint : 'https://disqus.com/api/',
					resourcePath : 'threads/listHot',
					type : 'json',
					version : '3.0',
					params : {
						api_key : 'qkRnRQB5jkKOXWY6osKiBI3MBhB9Mencp5UlQiXHEIDgBgTBJAzN3LW3xKOeN0xq',
						forum : 'e27sg',
					},
					url : function() {
						var me = this;
						return me.endpoint+me.version+'/'+me.resourcePath+'.'+me.type;
					}
				};

				$(document).ready(function() {

					var a = '<a href="'+dqs.url()+'" target="_blank">'+dqs.url()+'</a>'
					$('#disqus #url').html(a);

					$('#doit').click(function() {
						$out = $('#disqus .output');
						$.ajax({
							url : dqs.url(),
							type : 'get', 
							data : dqs.params,
							dataType : 'jsonp',
							success : function( data, textStatus, jqXHR ) {
								console.log('read in [', textStatus, '] = ', data);
								if (data.response.length > 0) {
									$out.append('ok (' + data.response.length + ')');

									// get urls
									var post_ids = []; 
									for ( var i in data.response) {
										var o = data.response[i];
										post_ids.push(o.identifiers[0].split(" ")[0]);
									}

									console.log("extracted ... ", post_ids);

									$.ajax({
										url : '<?= $this->ajax_url("post_first_image") ?>',
										data : {
											width : 90,
											post_ids : post_ids
										},
										type : 'get',
										dataType : 'jsonp',
										success : function( data, textStatus, jqXHR ) {
											if (data.result) {
												console.log('read in ok [', textStatus, '] = ', data);

												$ul = $('<ul></ul>');
												for(var key in data.data) {
													var $li = $('<li>['+key+'] = <img src="'+data.data[key]+'"/></li>');

													$ul.append( $li );
												}
												$out.append($ul);
											} else {
												console.log('read in ok but logic error [', textStatus, '] = ', data);
											}
										},
										error : function( jqXHR, textStatus, errorThrown ) {
											console.log('read error [',textStatus,'] as ',jqXHR);
											$out.append('error: ' + textStatus);
										}
									});
								}
								else
									$out.append('ok, but read in nothing (0)');
							},
							error : function( jqXHR, textStatus, errorThrown ) {
								console.log('read error [',textStatus,'] as ',jqXHR);
								$out.append('error: ' + textStatus);
							}
						});
					});

			 		/* doc ready code */
			 		$('.ajax-call').click(function() {
			 			window.open($(this).data('url'));
			 		});
				});
			})(jQuery);
		</script>

		<h2>e27 Utilities</h2>
		<h3>DISQUS Testing platform</h3>
		<div id="disqus">
			<blockquote id="url"></blockquote>
			<p class="control">
				<a class="button-primary" href="javascript:void(0)" id="doit">Fire</a>
			</p>
			<h4>Result</h4>
			<p class="output">
			</p>
		</div>

	<?
	}

	public function ajax_adapter( $method_name ) {
		switch ($method_name) {
		case 'post_first_image':
			$_width = $_REQUEST['width'];

			if (empty($_width)) {
				$_width = 150;
			}
			return $this->post_first_image($_REQUEST['post_ids'], $_width);
			break;
		default:
			throw new Exception("No handler for $method_name");
		}
	}

	function post_first_image($_post_ids, $_width = 150) {
		global $wpdb;
		$data = array();
		if ( ! empty($_post_ids) ) {
			foreach ($_post_ids as $_post_id) {
				// sanitize post_id
				$post = get_post($_post_id);
				if ($post->post_status == 'inherit') {
					$pid = $post->post_parent;
				} else {
					$pid = $_post_id;
				}

				$image = $this->first_image( $pid, $_width );
				if ( ! empty($image)) {
					$data[$_post_id] = $image[0];
				} else {
					$data[$_post_id] = null;
				}
			}
		}
		return $data;
	}

	function first_image ($postID, $width = 150) {
		$media_ids = array();
		if (has_post_thumbnail($postID)) {
			$media_ids[] = get_post_thumbnail_id($postID);
		} else {
			$args = array(
					'numberposts' => 1,
					'order'=> 'ASC',
					'post_mime_type' => 'image',
					'post_parent' => $postID,
					'post_status' => null,
					'post_type' => 'attachment'
			);
			
			$attachments = get_children( $args );
			
			if ( ! empty($attachments) ) {
				foreach($attachments as $attachment) {
					$media_ids[] = $attachment->ID;
				}
			}
		}

		foreach ($media_ids as $media_id) {
			$image = wp_get_attachment_image_src( $media_id, array($width, $width), FALSE );
			if ( ! $image) {
				continue;
			} else {
				return $image;
				break;
			}
		}
		return null;
	}
}	

?>