<?php

	include_once( "community/user_inc.php" ); $page = 'inner';

  
?>
<!DOCTYPE html>

<html lang="en-US">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <title><?= $allLabelsArray[535] ?></title>
        <?php include("community/includes/style.php"); ?>
        <link href="<?= $cms_url ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= $cms_url ?>assets/libs/dropzone/min/dropzone.css" rel="stylesheet" type="text/css" />
		<style>
			.modal-header .close{
				margin-top: unset !important;
			}
		</style>
		<style type="text/css">
        #gallery_image_thumbnail .video_item .active{
	color: #000 !important;
}
 .video_item{
                position: relative;
                height: 200px;
                margin: 15px 0;
              }
              .video_item i{
                position: absolute;
                top: 15px;
                left: 15px;
                background: #ddd;
                padding: 5px;
                color: #ddd;
                font-size: 18px;
                cursor: pointer;  
              }
              .video_item i:hover{
                opacity: .8;
              }
              .video_item img{
              	height: 100%;
              	margin: 15px 0;
              }
        :root { --ck-z-default: 100; --ck-z-modal: calc( var(--ck-z-default) + 999 ); }
        	.bootstrap-tagsinput .tag {
			  background: red;
			  
			}
			.bootstrap-tagsinput .tag [data-role="remove"]:after {
		       content: " x";
		       padding: 0px 2px;
		    }
        	.multi-select{
        		position: relative;
        		height: 50px;
        		border: 1px solid #92683E;
        		border-radius: 5px;
        		overflow: auto;
        	}
        	.multi-select .tag{
        		float: left;
        		margin-top: 9px;
        		padding: 0 10px;
        		background: red;
        		margin-right: 10px;
        		border-radius: 5px;
        	}
        	.multi-select .tag i,.multi-select .tag span{
        		color: #fff;
        	}
        	#category-form ul{
					list-style: none;
					padding: 0;
				}
				#category-form li{
					padding: 10px;
					cursor: pointer;
					transition: all .30s;
				}
				#category-form i{
					margin-right: 10px;
				}
				#category-form li:hover{
					background: rgba(0,0,0,.1);
				}
				#category-form .active{
					background: rgba(0,0,0,.1);
					font-weight: bold;
				}
				#category-form .active i{
					color: green;
				}
				.tages_list{

                width: 100%;
              }
              .tages_list ul{
                width: 100%;
                text-align: center;
                list-style: none;
                display: inline-block;
                padding-left: 0;
                margin-bottom: 15px;
              }
              .tages_list ul li{
                border-radius: 4px;
                display: inline-block;
                background: #986e44;
                color: #fff;
                padding: 5px 10px;
                margin: 5px 0;
                cursor: pointer;
                font-size: 14px;
              }
              .tages_list ul .active:hover{
                background: red;
              }
              .tages_list ul li:hover{
                background: #6e441d;
              }
              .tages_list ul .active{
                background: red;
              }
        </style>
    </head>

<body class="mobile_nav_class jl-has-sidebar">

    <div class="options_layout_wrapper jl_radius jl_none_box_styles jl_border_radiuss">

        <div class="options_layout_container full_layout_enable_front"> 


<?php include("community/includes/header.php"); ?>

<div class="jl_home_section">
				<div class="container">
					<div class="row">
						<div id="display_error" style="margin-right: 25px; margin-top: 30px;"></div>
						
						<div class="col-md-8  loop-large-post" id="content">
							<div class="widget_container content_page">
								<div class="post-2808 post type-post status-publish format-standard has-post-thumbnail hentry category-business tag-gaming tag-morning tag-relaxing" id="editor">
									<div class="single_section_content box blog_large_post_style">
										<div class="jl_single_style2">
											<div class="single_post_entry_content single_bellow_left_align jl_top_single_title jl_top_title_feature"> 
										    <div class="form-group">
										    	<div class="row">
										    		<div class="tages_list">
              <ul>
                <?php 
                $getCate = mysqli_query($conn,"SELECT *,title_french as title_francais FROM category_blog ORDER BY title");
                while($row = mysqli_fetch_assoc($getCate)){
                	$cate_title = empty(getCurLang($langURL,true)) ? '' : '_'.getCurLang($langURL,true);
                	$categoryList = explode(',', $getRow['category']);
                	$active_item = '';
                	for ($i=0; $i < count($categoryList); $i++) {
                		if(str_replace(' ', '', $row['id']) == str_replace(' ', '', $categoryList[$i])){
                			$active_item = 'class="active"';
                		}
                	}
                ?>
                <li data-id="<?= $row['id'] ?>" <?= $active_item ?>><?= $row['title'.$cate_title] ?></li>
                <?php } ?>
              </ul>
            </div>
													<!-- <div class="col-lg-12 multi-select" onclick="SelectCategory();">
														<?php if(empty($getRow['category']) || $getRow['category'] == null){ ?>
														<p style="position: absolute; top: 8px;">Select Category...</p>
														<?php }else{
															$cate_list = explode(',', $getRow['category']);
															for ($i=0; $i < count($cate_list); $i++) {
														?>
														<div class="tag">
															<span><?= $cate_list[$i] ?></span>
														</div>
														<?php } } ?>
													</div> -->
										    	</div>
										    </div>

										    <h1 style="margin-bottom: 20px !important;" class="single_post_title_main"><span id="title_display"><?= $getRow['title'] ?></span>
										    	<span class="editSpan" >
														<a class="btn btn-sm editButton" onclick="ShowHeader($('#title_display'),$('#description_display'));"><i class="fa fa-edit" aria-hidden="true"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
													</span>
										    </h1>
												<span>
													<p class="post_subtitle_text" id="description_display"><?= $getRow['description'] ?></p>
												</span>
											</div>
										</div>
										<div class="post_content" style="margin-top: 20px;">
											<div style="margin-bottom: 30px;">
												<span class="editSpan">
													<!-- <button class="btn btn-sm editButton add_remove">Cancel</button> -->
													<a class="btn btn-sm editButton" onclick="ShowEditor('Content',$('#content_one'),'content_one');"><i class="fa fa-edit" aria-hidden="true"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
												</span>
												<div style="text-align: justify;" id="content_one"><?php if(empty($getRow['content_one'])){}else{echo $getRow['content_one'];} ?></p></div>
											</div>

											<div style="margin-bottom: 30px;">
												<blockquote class="editContent">
													<span class="editSpan">
														<a class="btn btn-sm editButton" onclick="ShowEditor('Quote',$('#blockquote'),'quote');"><i class="fa fa-edit" aria-hidden="true"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
													</span>
													<div style="text-align: center; color: #000;" id="blockquote"><b><?php if(empty($getRow['blockquote'])){}else{echo $getRow['blockquote'];} ?></b></div>
												</blockquote>
											</div>

											<div style="margin-bottom: 30px;">
												<span class="editSpan">
													<a class="btn btn-sm editButton" onclick="ShowEditor('Content',$('#content_two'),'content_two');"><i class="fa fa-edit" aria-hidden="true"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
												</span>
												<div style="text-align: justify;" id="content_two"><?php if(empty($getRow['content_two'])){}else{echo $getRow['content_two'];} ?></div>
											</div>

											<div style="margin-bottom: 30px;">
												<span class="editSpan">
													<a class="btn btn-sm editButton" onclick="ShowEditor('Content',$('#content_three'),'content_three');"><i class="fa fa-edit" aria-hidden="true"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
												</span>
												<div style="text-align: justify;" id="content_three"><?php if(empty($getRow['content_three'])){}else{echo $getRow['content_three'];} ?></div>
											</div>

											<div style="margin-bottom: 30px;">
												<span class="editSpan">
													<a class="btn btn-sm editButton" onclick="ShowEditor('Content',$('#content_four'),'content_four');"><i class="fa fa-edit" aria-hidden="true"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
												</span>
												<div style="text-align: justify;" id="content_four"><?php if(empty($getRow['content_four'])){;}else{echo $getRow['content_four'];} ?></div>
											</div>

										</div>
										<div style="margin-bottom: 30px;">
												<span class="editSpan">
													<a class="btn btn-sm editButton" onclick="loadGalleryImages(); $('#gallery_image_thumbnail').modal()" ><i class="fa fa-plus"></i>&nbsp;<?= $allLabelsArray[499] ?></a>
												</span>
											</div>
										<div style="width: 100%; height: 50px;"></div>
								          <div style="width: 100%; margin-bottom: 15px;">
								            <div class="bootstrap-tagsinput">
									            <input type="text" id="blog_tages" class="form-control" data-role="tagsinput" value="<?= $getRow['tages'] ?>" placeholder="<?= $allLabelsArray[561] ?>">
								            </div>
								          </div>
										<div style="float: right; margin-bottom: 25px;">
											<button onclick="UpdateContent($(this));" class="btn btn-sm" style="background: #C49A6C; color: white;"><i class="fa fa-spin fa-spinner" style="margin-right: 5px; display: none;" aria-hidden="true"></i> <?= $allLabelsArray[536] ?></button>
										</div>
									</div>
								</div>
								<!-- end post -->

							</div>

						</div>
						<?php include_once 'sidebar.php'; ?>
					</div>

				</div>

			</div>

			<div class="modal" id="gallery_image_thumbnail" tabindex="-1" role="dialog">
			  <div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      <div class="modal-header" style="background: #8c6238;">
			        <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[540] ?></h5>
			        <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body" style="height: 300px !important; overflow: auto;">

			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
			      </div>
			    </div>
			  </div>
			</div>

			<!-- category -->
			<div class="modal" id="category-form" tabindex="-1" role="dialog">
			  <div class="modal-dialog modal-md" role="document">
			    <div class="modal-content">
			      <div class="modal-header" style="background: #8c6238;">
			        <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[520] ?></h5>
			        <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close1">
			          <span aria-hidden="true">×</span>
			        </button>
			      </div>
			      <div class="modal-body">
			      	<div id="category-error"></div>
			      	<ul>
			      		<?php
			      		$getCate = mysqli_query($conn,"SELECT * FROM category_blog WHERE status = 1");
						while($row = mysqli_fetch_assoc($getCate)){
			      		$list = explode(",", $getRow['category']);
			      		?>
			      		<li <?php if(in_array($row['title'], explode(',', $getRow['category']))){echo 'class="active"';} ?>><i class="fa fa-check-circle"></i> <span><?= $row['title'] ?></span></li>
			      		<?php } ?>
			      	</ul>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;"><?= $allLabelsArray[452] ?></button>
			        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
			      </div>
			    </div>
			  </div>
			</div>

			<!-- header -->
			<div class="modal" id="header-modal" tabindex="-1" role="dialog">
			  <div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      <div class="modal-header" style="background: #8c6238;">
			        <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[493] ?></h5>
			        <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close1">
			          <span aria-hidden="true">×</span>
			        </button>
			      </div>
			      <div class="modal-body">
			      	<div id="header-error"></div>
			      	<div class="form-group">
			      		<label><?= $allLabelsArray[494] ?></label>
			      		<input type="text" id="content-title" class="form-control">
			      	</div>
			      	<div class="form-group">
			      		<label><?= $allLabelsArray[495] ?></label>
			      		<textarea id="content-description" class="form-control" rows="10"></textarea>
			      	</div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;"><?= $allLabelsArray[452] ?></button>
			        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
			      </div>
			    </div>
			  </div>
			</div>

			<!-- edirot -->
			<div class="modal" id="editor-modal" tabindex="-1" role="dialog">
			  <div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      <div class="modal-header" style="background: #8c6238;">
			        <h5 class="modal-title" style="color: #fff; text-align: center;"></h5>
			        <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close1">
			          <span aria-hidden="true">×</span>
			        </button>
			      </div>
			      <div class="modal-body">
			      	<div id="editor-error"></div>
			        <textarea id="text-editor" class="form-control" style="height: 350px;" aria-hidden="true"></textarea>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;"><?= $allLabelsArray[452] ?></button>
			        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
			      </div>
			    </div>
			  </div>
			</div>

			<form id="blog-form">
				<div class="c_one" style="display: none;"><?= $getRow['content_one'] ?></div>
			    <div class="c_two" style="display: none;"><?= $getRow['content_two'] ?></div>
			    <div class="c_three" style="display: none;"><?= $getRow['content_three'] ?></div>
			    <div class="c_four" style="display: none;"><?= $getRow['content_four'] ?></div>
			    <div class="c_quote" style="display: none;"><?= $getRow['quote'] ?></div>
				<input type="hidden" hidden name="id" value="<?= $getRow['id'] ?>">
				<input type="hidden" hidden name="category" value="<?= $getRow['category'] ?>">
				<input type="hidden" hidden name="old_title" value="<?= $getRow['title'] ?>">
				<input type="hidden" hidden name="title" value="<?= $getRow['title'] ?>">
				<input type="hidden" hidden name="slug" value="<?= $getRow['slug'] ?>">
				<input type="hidden" hidden name="description" value="<?= $getRow['description'] ?>">
				<input type="hidden" hidden name="content_one">
				<input type="hidden" hidden name="quote">
				<input type="hidden" hidden name="content_two">
				<input type="hidden" hidden name="content_three">
				<input type="hidden" hidden name="content_four">
				<input type="hidden" hidden name="lang" value="<?= getCurLang($langURL,true); ?>">

				<input type="hidden" hidden name="display_type" value="<?= $page_url[1] ?>">
				<input type="hidden" hidden name="tages" value="<?= $getRow['tages'] ?>">
				<input type="hidden" name="thumbnail" value="<?= $getRow['content_thumbnail'] ?>">
			</form>

    <?php include("community/includes/footer.php"); ?>


<?php include("community/includes/script.php"); ?>

<!-- <script src="https://cdn.ckeditor.com/ckeditor5/27.0.0/classic/ckeditor.js"></script> -->
    <script src="https://cdn.ckeditor.com/4.16.0/full/ckeditor.js"></script>

<!-- <script src="https://cdn.tiny.cloud/1/0ocxmkvboxs6d2rytc74wz9cbl1a3wuivi9mjiy5gtcgev78/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.5.0/tinymce.min.js" integrity="sha512-GVA/pyUF3G/N6U2o0AdSx02izOM963T6wsJPrJpGLApeIVWtaGDeN7eV/bmlkg2CC1Z+pHt3nQmaXic79mkHwg==" crossorigin="anonymous"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g==" crossorigin="anonymous"></script>
<script type="text/javascript">

function loadGalleryImages(){
	var n = $(document).find('#gallery_image_thumbnail .video_item i.active').siblings("img").attr("img-name");
	var cur = '<?= $getRow['content_thumbnail'] ?>';
	if (n !== undefined){

	}else{
		n = "<?= $getRow['content_thumbnail'] ?>";
	}
	$("#gallery_image_thumbnail .modal-body").load('<?= $main_app ?>load_gallery_images.php?cur='+n+'&content_type=<?= $page_url[1] ?>&edit='+cur+"&lang=<?= getCurLang($langURL,true); ?>");
}
$(document).on('click','#gallery_image_thumbnail .video_item i',function(){
	$(document).find('#gallery_image_thumbnail .video_item i').removeClass("active");
	$(this).toggleClass('active');
	updateCheck = 1;
});
$.fn.modal.Constructor.prototype.enforceFocus = function () {
    var $modalElement = this.$element;
    $(document).on('focusin.modal', function (e) {
        var $parent = $(e.target.parentNode);
        if ($modalElement[0] !== e.target && !$modalElement.has(e.target).length &&
            !$parent.hasClass('cke_dialog_ui_input_select') && !$parent.hasClass('cke_dialog_ui_input_text')) {
            e.target.focus()
        }
    })
};

	var editor_content_one;
var editor_content_two;
var editor_content_three;
var editor_content_four;
var editor_content_quote;
	var updateCheck = 0;
$(document).ready(function(){
	$(".btn-primary").click(function(){
		updateCheck = 1;
	});
    $("#blog-form input[name=content_one]").val($(".c_one").html());
    $("#blog-form input[name=content_two]").val($(".c_two").html());
    $("#blog-form input[name=content_three]").val($(".c_three").html());
    $("#blog-form input[name=content_four]").val($(".c_four").html());
    $("#blog-form input[name=quote]").val($(".c_quote").html());
  });

	$(".tages_list li").click(function(){
    $(this).toggleClass("active");
});

	function SelectCategory(){
		$(".multi-select .tag").each(function(){
			var getItem = $.trim($(this).children("span").text());
			$("#category-form li").each(function(){
				if($.trim($(this).children("span").text()) == getItem){
					$(this).attr("class","active");
				}
			});
		});
		$("#category-form").modal();
	}

	function ShowHeader(title,description){
		$("#header-modal #content-title").val(title.text());
		$("#header-modal #content-description").val(description.text());
		$("#header-modal").modal();

		$("#header-modal .btn-primary").click(function(){
			if($("#content-title").val() == ""){

				$("#header-error").attr("class","alert alert-danger");
				$("#header-error").html("<i class='fa fa-exclamation-triangle' style='margin-right: 10px;'></i> <?= $allLabelsArray[549] ?>");

			}else if($("#content-description").val() == ""){

				$("#header-error").attr("class","alert alert-danger");
				$("#header-error").html("<i class='fa fa-exclamation-triangle' style='margin-right: 10px;'></i> <?= $allLabelsArray[550] ?>");

			}else{
				$("#header-error").attr("class","");
				$("#header-error").html("");
				title.text($("#content-title").val());
				description.text($("#content-description").val());
				$("#blog-form input[name=title]").val($("#content-title").val());
				$("#blog-form input[name=description]").val($("#content-description").val());
				$("#header-modal .close").click();
			}
		});
	}

	function ShowEditor(title,pic,input){
		$("#editor-modal .modal-title").text(title);
		
		$('#text-editor').val(pic.html());
			

		if (editor_content_one) { editor_content_one.destroy(true); }
				    editor_content_one = CKEDITOR.replace( 'text-editor' );
				   

		// $('#text-editor').val(pic.html());
		// tinyMCE.activeEditor.setContent(pic.html());
		
		$("#editor-modal").modal();
		
		$("#editor-modal .btn-primary").attr("input",input);
		$("#editor-modal .btn-primary").attr("content",pic.attr("id"));

		$("#editor-modal .btn-primary").click(function(){
			var input = $(this).attr("input");
			var contant = editor_content_one.getData();
			if(contant == ""){
				$("#"+$(this).attr("content")).html("");
				$("#blog-form input[name="+input+"]").val("");
				$("#editor-modal .close").click();
				// $("#editor-error").attr("class","alert alert-danger");
				// $("#editor-error").html("<i class='fa fa-exclamation-triangle' style='margin-right: 10px;'></i> Content can not be empty!");
			}
			// else if(contant.includes("<img")){
			// 	$("#editor-error").attr("class","alert alert-danger");
			// 	$("#editor-error").html("<i class='fa fa-exclamation-triangle' style='margin-right: 10px;'></i> Image is not allowed!");
			// }
			else{
				$("#editor-error").attr("class","");
				$("#editor-error").html("");
				$("#"+$(this).attr("content")).html(contant);
				$("#blog-form input[name="+input+"]").val(contant);
				$("#editor-modal .close").click();
			}
			
		});
	}

	$(document).ready(function(){

		$('#category-form,#editor-modal,#header-modal').on('hidden.bs.modal', function () {
			$("#category-error,#editor-error,#header-error").attr("class","");
			$("#category-error,#editor-error,#header-error").html("");
		});

		$("#category-form li").click(function(){
			$(this).toggleClass("active");
		});

		$("#category-form .btn-primary").click(function(){			
			if($("#category-form .active").length < 1){
				$("#category-error").attr("class","alert alert-danger");
				$("#category-error").html("<i class='fa fa-exclamation-triangle' style='margin-right: 10px;'></i> <?= $allLabelsArray[554] ?>");
			}else{
				$(".multi-select").html("");
				var active_cate_list = [];
				$("#category-form .active").each(function(){
					active_cate_list.push($(this).text());
					$(".multi-select").append(
						'<div class="tag">'+
							// '<i class="fa fa-close"></i>'+
							'<span>'+$(this).text()+'</span>'+
						'</div>'
					);
				});
				$("#category-error").attr("class","");
				$("#category-error").html("");

				$("#blog-form input[name=category]").val(active_cate_list.join(","));

				$("#category-form .close").click();
			}
		});

	});

	function ShowMessage(type,msg,icon){
		if(type == ""){
			type = "alert alert-danger";
		}else{
			type = "alert alert-success";
		}
		if(icon == ""){
			icon = "fa fa-exclamation-triangle";
		}
		$("#display_error").attr("class",type);
		$("#display_error").html("<i class='"+icon+"' style='margin-right: 10px;'></i> "+msg);
		$("#display_error").show();
		$('html, body').animate({
			scrollTop: $("#display_error").offset().top - 100
		}, 500);
	}

	function UpdateContent(sel){
		var value = [];
			
		$(".tages_list .active").each(function(){
		  value.push($(this).attr("data-id"));
		});
		
		$("#blog-form input[name=thumbnail]").val($(document).find("#gallery_image_thumbnail .video_item .active").siblings("img").attr("img-name"));
		if($("#blog-form input[name=thumbnail]").val() == ""){
			$("#blog-form input[name=thumbnail]").val("<?= $getRow['content_thumbnail'] ?>");
		}

		if($("#blog_tages").val() != '<?= $getRow['tages'] ?>'){
			updateCheck = 1;
		}

		if(value.join(",") != '<?= $getRow['category'] ?>'){
			updateCheck = 1;
		}

		$("#blog-form input[name=category]").val(value.join(","));

		$("#blog-form input[name=tages]").val($("#blog_tages").val());

		if(updateCheck == 0){
			ShowMessage("","<?= $allLabelsArray[553] ?>","");
		}else if($("#blog-form input[name=category]").val() == ""){

			ShowMessage("","<?= $allLabelsArray[554] ?>","");

		}else if($("#blog-form input[name=title]").val() == ""){

			ShowMessage("","<?= $allLabelsArray[549] ?>","");

		}
		else if($("#blog-form input[name=thumbnail]").val() == ""){
        	ShowMessage("error","<?= $allLabelsArray[612] ?>","");
        }
        
		// else if(/^[a-zA-Z\s]*$/i.test($("#blog-form input[name=title]").val()) == false){
			
		// 	ShowMessage("","Only whitespaces & alphabets are allowed in title!","");
		
		// }
		else if($("#blog-form input[name=description]").val() == ""){

			ShowMessage("","<?= $allLabelsArray[550] ?>","");

		}
		// else if($("#blog-form input[name=content_one]").val().includes("<img")){
			
		// 	ShowMessage("","Image is not allowed in content one!","");

		// }else if($("#blog-form input[name=quote]").val().includes("<img")){
			
		// 	ShowMessage("","Image is not allowed in content one!","");

		// }else if($("#blog-form input[name=content_two]").val().includes("<img")){
			
		// 	ShowMessage("","Image is not allowed in content one!","");

		// }else if($("#blog-form input[name=content_three]").val().includes("<img")){
			
		// 	ShowMessage("","Image is not allowed in content one!","");

		// }else if($("#blog-form input[name=content_four]").val().includes("<img")){
			
		// 	ShowMessage("","Image is not allowed in content one!","");

		// }
		else if($("#blog-form input[name=content_one]").val() == "" && $("#blog-form input[name=content_two]").val() == "" && $("#blog-form input[name=content_three]").val() == "" && $("#blog-form input[name=content_four]").val() == ""){
			
			ShowMessage("","<?= $allLabelsArray[613] ?>","");

		}else if($("#blog-form input[name=tages]").val() == ""){
			
			ShowMessage("","<?= $allLabelsArray[556] ?>","");
		
		}else{

			var link = $("input[name=title]").val();
			var final = '';
			link = link.toLowerCase();
			if($("#blog-form input[name=lang]").val() == "" || $("#blog-form input[name=lang]").val() == "english"){
                link = link.replace(/[^a-zA-Z0-9\s+]/g, '');
                final = link.replace(/\s+/g, '-');
			}else{
				final = "";
			}
			$("#blog-form input[name=slug]").val(final);

			$.ajax({
				type: "POST",
				url: "<?= $cms_url ?>ajax.php?h=CreateUpdateSimpleBlog&lang=<?= getCurLang($langURL,true); ?>",
				data: $("#blog-form").serialize(),
				dataType: "json",
				beforeSend: function(){
					sel.children("i").show();
				},success: function(res){
					sel.children("i").hide();
					if(res.success){
			              ShowMessage("alert alert-success","<?= $allLabelsArray[557] ?>");
						setTimeout(function(){
							<?php if($page_url[1] == 'news'){?>
							window.open('<?= $cms_url ?>my-news<?= $langURL ?>','_self');
							<?php }else{ ?>
							window.open('<?= $cms_url ?>my-blog<?= $langURL ?>','_self');
							<?php } ?>
						},3000);
					}else{
						ShowMessage("",res.error,"");
					}
				},error: function(e){
					sel.children("i").hide();
				}
			});

		}
	}
$('p').each(function() {
	    var $this = $(this);
	    if($this.html().replace(/\s|&nbsp;/g, '').length == 0)
	        $this.remove();
	});
</script>
</body>
</html>