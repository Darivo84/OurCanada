<?php
$page = 'inner'; ?>
<?php include_once( "community/user_inc.php" ); 

?>
<style type="text/css">
#gallery_image_thumbnail .video_item .active{
	color: #000 !important;
}
	.bootstrap-tagsinput .tag {
	  background: red;
	  
	}
	:root { --ck-z-default: 100; --ck-z-modal: calc( var(--ck-z-default) + 999 ); }
	.bootstrap-tagsinput .tag [data-role="remove"]:after {
       content: " x";
       padding: 0px 2px;
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
			<?php if(getCurLang($langURL,true) == 'arabic' || getCurLang($langURL,true) == 'urdu'){ ?>
				.urdu_arabicBTN .editSpan{
					width: 100%;
				}
				.urdu_arabicBTN .editButton{
					float: left;
				}
				.urdu_arabicBTN #selected_file{
					text-align: right !important;
					height: 50px;
					margin-top: 0 !important;
				}
				.bootstrap-tagsinput{
					width: 100% !important;
					float: left;
					margin-bottom: 15px;
				}
            <?php } ?>
              
</style>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<div class="jl_home_section">
				<div class="container">
					<div class="row">
						<div class="col-md-8 col-lg-offset-2 loop-large-post" id="content">
							<div class="widget_container content_page">
								<!-- start post -->
								<div class="post-2808 post type-post status-publish format-standard has-post-thumbnail hentry category-business tag-gaming tag-morning tag-relaxing" id="editor">
									<div id="display_error"></div>
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
										                	$cate_title = empty($_GET['lang']) ? '' : '_'.$_GET['lang'];
										                ?>
										                <li data-id="<?= $row['id'] ?>"><?= $row['title'.$cate_title] ?></li>
										                <?php } ?>
										              </ul>
										            </div>
										    	</div>
										    </div>

										    <h1 class="single_post_title_main title"><span class="content_title_span"><?=$allLabelsArray[804] ?> </span>
										    	<span class="editSpan" >
														<a class="btn btn-sm editButton" onclick="content_header($('#content_header').text())" ><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
													</span>
										    </h1>
												<span>
													<p class="post_subtitle_text"><?= $allLabelsArray[559] ?></p>
												</span>
											</div>
										</div>
										<div class="post_content" style="margin-top: 20px;">
											<div style="margin-bottom: 30px;">
												<span class="editSpan">
													<a class="btn btn-sm editButton" onclick="content_one($('#content_one').html())" ><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
												</span>
												<p style="text-align: justify;" id="content_one"><?= $allLabelsArray[529] ?></p> 
											</div>
											
											<div style="margin-bottom: 30px;">
												<blockquote class="editContent">
													<span class="editSpan">
														<a class="btn btn-sm editButton" onclick="quote($('#blockquote').html())" ><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
													</span>
													<p style="text-align: center;" id="blockquote"><b></b></p>
												</blockquote>
											</div>

											<div style="margin-bottom: 30px;">
												<span class="editSpan">
													<a class="btn btn-sm editButton" onclick="content_two($('#content_two').html())" ><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
												</span>
												<p style="text-align: justify;" id="content_two"></p>
											</div>

											<div style="margin-bottom: 30px;">
												<span class="editSpan">
													<a class="btn btn-sm editButton" onclick="content_three($('#content_three').html())" ><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
												</span>
												<p style="text-align: justify;" id="content_three"></p>
											</div>
											
											<div style="margin-bottom: 30px;">
												<span class="editSpan">
													<a class="btn btn-sm editButton" onclick="content_four($('#content_four').html())" ><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
												</span>
												<p style="text-align: justify;" id="content_four"></p>
											</div>
											
										</div>

										<div style="margin-bottom: 30px;" class="urdu_arabicBTN">
											<span class="editSpan">
												<input type="file" class="d-none" onchange="selectPDF($(this));" style="display: none !important;" hidden accept="application/pdf" name="pdf_file" id="pdf_file">
												<a class="btn btn-sm editButton" onclick="$('#pdf_file').click();"><i class="fa fa-plus"></i>&nbsp;<?= $allLabelsArray[806] ?></a>
												<div id="selected_file" style="width: 100%; text-align: left; margin-top: -50px; height: 50px;"></div>
											</span>
										</div>
										
										<div style="margin-bottom: 30px;">
											<span class="editSpan">
												<a class="btn btn-sm editButton" onclick="loadGalleryImages();$('#gallery_image_thumbnail').modal();" ><i class="fa fa-plus"></i>&nbsp;<?= $allLabelsArray[499] ?></a>
											</span>
										</div>
										
										<div style="width: 100%; height: 50px;"></div>
								          <div style="width: 100%; margin-bottom: 15px;">
								            <input type="text" id="blog_tages" class="form-control" data-role="tagsinput" placeholder="<?= $allLabelsArray[561] ?>">
								          </div>
										<div style="float: right; margin-bottom: 25px;">
											<button onclick="CreateBlog($(this));" class="btn btn-sm" style="background: #C49A6C; color: white;"><i class="fa fa-spin fa-spinner" style="margin-right: 5px; display: none;"></i> <?= $allLabelsArray[498] ?></button>
										</div>
									</div>
								</div>
								<!-- end post -->
								
							</div>
							
						</div>
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

			<div class="modal" id="content_one_changer" tabindex="-1" role="dialog">
			  <div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      <div class="modal-header" style="background: #8c6238;">
			        <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[544] ?></h5>
			        <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close1">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body" id="modal_body_contentone">
			      	<div class="error"></div>
			        <textarea id="modal_content_one" class="form-control" style="height: 350px;"></textarea>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;"><?= $allLabelsArray[452] ?></button>
			        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="CloseEditor('#modal_content_one')"><?= $allLabelsArray[174] ?></button>
			      </div>
			    </div>
			  </div>
			</div>

			<div class="modal" id="quote_changer" tabindex="-1" role="dialog">
			  <div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      <div class="modal-header" style="background: #8c6238;">
			        <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[562] ?></h5>
			        <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="quote_ch">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			      	<div class="error"></div>
			        <textarea id="modal_quote" class="form-control" style="height: 200px;"></textarea>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;"><?= $allLabelsArray[452] ?></button>
			        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
			      </div>
			    </div>
			  </div>
			</div>

			<div class="modal" id="content_two_changer" tabindex="-1" role="dialog">
			  <div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      <div class="modal-header" style="background: #8c6238;">
			        <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[544] ?></h5>
			        <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close2">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			      	<div class="error"></div>
			        <textarea id="modal_content_two" class="form-control" style="height: 350px;"></textarea>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;"><?= $allLabelsArray[452] ?></button>
			        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
			      </div>
			    </div>
			  </div>
			</div>

			<div class="modal" id="content_three_changer" tabindex="-1" role="dialog">
			  <div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      <div class="modal-header" style="background: #8c6238;">
			        <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[544] ?></h5>
			        <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close3">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			      	<div class="error"></div>
			        <textarea id="modal_content_three" class="form-control" style="height: 350px;"></textarea>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;"><?= $allLabelsArray[452] ?></button>
			        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
			      </div>
			    </div>
			  </div>
			</div>

			<div class="modal" id="content_four_changer" tabindex="-1" role="dialog">
			  <div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      <div class="modal-header" style="background: #8c6238;">
			        <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[544] ?></h5>
			        <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close5">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			      	<div class="error"></div>
			        <textarea id="modal_content_four" class="form-control" style="height: 350px;"></textarea>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;"><?= $allLabelsArray[452] ?></button>
			        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
			      </div>
			    </div>
			  </div>
			</div>

			<div class="modal" id="content_header" tabindex="-1" role="dialog">
			  <div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      <div class="modal-header" style="background: #8c6238;">
			        <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[493] ?></h5>
			        <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="header_content_close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        <div class="form-group">
			        	<label><?= $allLabelsArray[494] ?></label>
			        	<input type="text" name="blog_title" class="form-control">
			        </div>
			        <div class="form-group">
			        	<label><?= $allLabelsArray[495] ?></label>
			        	<textarea name="blog_desc" class="form-control"></textarea>
			        </div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;" onclick="saveHeadContent();"><?= $allLabelsArray[452] ?></button>
			        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
			      </div>
			    </div>
			  </div>
			</div>

			<div class="modal com_not" tabindex="-1" role="dialog" style="background: rgba(0,0,0,.3);">
			  <div role="document" class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header text-center" style="background: #92683e;">
										<i aria-hidden="true" style="font-size: 128px;color: #fff;" class="fa fa-smile-o"></i>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('.com_not').slideUp();">
			          <span aria-hidden="true">×</span>
			        </button>
			      <div></div></div>
			      <div class="modal-body">
			        <p style="text-align: center;font-size: 36px;color: green;font-style: italic;"><?= $allLabelsArray[565] ?></p><p style="text-align: center;font-size: 15px;color: #484848;/*! font-style: italic; */"><?= $allLabelsArray[566] ?></p>
			      </div>
			      <div class="modal-footer" style="/*! border-top: 0; */border: 0;text-align: center;">
			        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
			        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('.com_not').slideUp();" style="width: 150px;background: #92683e;color: #fff;"><?= $allLabelsArray[171] ?></button>
			      </div>
			    </div>
			  </div>
			</div>

			<div class="modal" id="error_model" tabindex="-1" role="dialog">
			  <div class="modal-dialog modal-md" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title"><?= $allLabelsArray[563] ?></h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			      	<div></div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
			      </div>
			    </div>
			  </div>
			</div>

			<form id="create_blog">
				<input type="hidden" name="title">
				<input type="hidden" name="description">
				<input type="hidden" name="content_one" class="content_one" hidden>
				<input type="hidden" name="content_two" class="content_two" hidden>
				<input type="hidden" name="quote" class="blockquote" hidden>
				<input type="hidden" name="content_three" class="content_three" hidden>
				<input type="hidden" name="content_four" class="content_four" hidden>
				<input type="hidden" name="slug" value="" hidden>
				<input type="hidden" name="display_type" hidden value="<?= $_GET['content_type'] ?>">
				<input type="hidden" name="type" hidden value="">
				<input type="hidden" name="tages" hidden>
				<input type="hidden" name="category" hidden>
				<input type="hidden" name="lang" value="<?= $_GET['lang'] ?>">
				<input type="hidden" name="thumbnail">
			</form>
			<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

			<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.5.0/tinymce.min.js" integrity="sha512-GVA/pyUF3G/N6U2o0AdSx02izOM963T6wsJPrJpGLApeIVWtaGDeN7eV/bmlkg2CC1Z+pHt3nQmaXic79mkHwg==" crossorigin="anonymous"></script> -->
			<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g==" crossorigin="anonymous"></script>
<!-- <script src="https://cdn.tiny.cloud/1/0ocxmkvboxs6d2rytc74wz9cbl1a3wuivi9mjiy5gtcgev78/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> -->
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/27.0.0/classic/ckeditor.js"></script> -->
    <script src="https://cdn.ckeditor.com/4.16.0/full/ckeditor.js"></script>

<script type="text/javascript">
function loadGalleryImages(){
	var n = $(document).find('#gallery_image_thumbnail .video_item i.active').siblings("img").attr("img-name");
	if (n !== undefined){
		
	}
	$("#gallery_image_thumbnail .modal-body").load('<?= $main_app ?>load_gallery_images.php?cur='+n+'&content_type=<?= $_GET['content_type'] ?>&lang=<?= getCurLang($langURL,true); ?>');
}
$(document).on('click','#gallery_image_thumbnail .video_item i',function(){
	$(document).find('#gallery_image_thumbnail .video_item i').removeClass("active");
	$(this).toggleClass('active');
});
// $("#gallery_image_thumbnail .video_item i").on('click',function(){
// 	$("#gallery_image_thumbnail .video_item i").removeClass("active");
// 	$(this).toggleClass('active');
// });

function selectPDF(sel){
	$(document).find("#selected_file").text("<?= $allLabelsArray[812] ?>"+sel[0].files[0].name);
	if(sel[0].files[0].type == 'application/pdf'){
	}else{
		// $(document).find("#selected_file").text("");
		sel.val("");
	}
}

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

$(".tages_list li").click(function(){
    $(this).toggleClass("active");
});
				setTimeout(function (){
		          $('.js-example-basic-multiple').select2({
		            placeholder: "<?= $allLabelsArray[567] ?>",
		          });
		        },1000);

				$('.js-example-basic-multiple').select2({
					placeholder: "<?= $allLabelsArray[567] ?>",
				});


				function content_header(value){
					$("#content_header").modal();
					$("#content_header input[name=blog_title]").val($("h1.title span:first").text());
					$("#content_header textarea[name=blog_desc]").val($(".post_subtitle_text").text());
				}

				function saveHeadContent(){
					$("#header_content_close").click();

					$("h1.title span:first").text($("#content_header input[name=blog_title]").val());
					$("input[name=title]").val($("#content_header input[name=blog_title]").val());
					
					$(".post_subtitle_text").text($("#content_header textarea[name=blog_desc]").val());
					$("input[name=description]").val($("#content_header textarea[name=blog_desc]").val());
					
				}
				function content_one(value){
					$("#content_one_changer .error").attr("class","error");
					$("#content_one_changer .error").text("");

				    $('#content_one_changer').modal();

				    $('#modal_content_one').val(value);


				    if (editor_content_one) { editor_content_one.destroy(true); }
				    editor_content_one = CKEDITOR.replace( 'modal_content_one' );

			        $("#content_one_changer .btn-primary").click(function(){
			        	$("#content_one_changer .close").click();
			        	$("#content_one").html(editor_content_one.getData());
			        	// $("#content_one p").each(function(){
			        	// 	$("")
			        	// });
			        	$("#create_blog input[name=content_one]").val(editor_content_one.getData());
			        });
				}

				function quote(value){
					$("#quote_changer .error").attr("class","error");
					$("#quote_changer .error").text("");

				    $('#quote_changer').modal();

				    $('#modal_quote').val(value);

				    if (editor_content_quote) { editor_content_quote.destroy(true); }
				    editor_content_quote = CKEDITOR.replace('modal_quote');

			        $("#quote_changer .btn-primary").click(function(){
			        	$("#quote_changer .close").click();
			        	$("#blockquote").html(editor_content_quote.getData());
			        	$("#create_blog input[name=quote]").val(editor_content_quote.getData());
			        });

				}

				function content_two(value){
					$("#content_two_changer .error").attr("class","error");
					$("#content_two_changer .error").text("");

				    $('#content_two_changer').modal();
				    $('#modal_content_two').val(value);
				    
				    if (editor_content_two) { editor_content_two.destroy(true); }
				    editor_content_two = CKEDITOR.replace('modal_content_two');
				   

			        $("#content_two_changer .btn-primary").click(function(){
			        	$("#content_two_changer .close").click();
			        	$("#content_two").html(editor_content_two.getData());
			        	$("#create_blog input[name=content_two]").val(editor_content_two.getData());
			        });

				}

				function content_three(value){
					$("#content_three_changer .error").attr("class","error");
					$("#content_three_changer .error").text("");

				    $('#content_three_changer').modal();
				    $('#modal_content_three').val(value);
				    if (editor_content_three) { editor_content_three.destroy(true); }

				    editor_content_three = CKEDITOR.replace('modal_content_three');
				  

			        $("#content_three_changer .btn-primary").click(function(){
			        	$("#content_three_changer .close").click();
			        	$("#content_three").html(editor_content_three.getData());
			        	$("#create_blog input[name=content_three]").val(editor_content_three.getData());
			        });
				}

				function content_four(value){
					$("#content_four_changer .error").attr("class","error");
					$("#content_four_changer .error").text("");
					
				    $('#content_four_changer').modal();
				    $('#modal_content_four').val(value);
				    
				    if (editor_content_four) { editor_content_four.destroy(true); }
				    editor_content_four = CKEDITOR.replace('modal_content_four');
				    
			        $("#content_four_changer .btn-primary").click(function(){
			        	$("#content_four_changer .close").click();
			        	$("#content_four").html(editor_content_four.getData());
			        	$("#create_blog input[name=content_four]").val(editor_content_four.getData());
			        });
				}

				function ShowMessage(type,msg,icon){
					if(type == "error"){
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

					setTimeout(function(){
						$("#display_error").html("");
						$("#display_error").hide();
					},5000);
				}

				function CreateBlog(sel){
					var value = [];
					$(".tages_list .active").each(function(){
					  value.push($(this).attr("data-id"));
					});

					var pdfFile = $("#pdf_file");
					
					$("#create_blog input[name=category]").val(value.join(","));
					$("#create_blog input[name=tages]").val($("#blog_tages").val());
					$("#create_blog input[name=display_type]").val($("input[name=getType]").val());
					$("#create_blog input[name=type]").val("pdf-"+$("input[name=getType]").val());
					$("#create_blog input[name=thumbnail]").val($(document).find("#gallery_image_thumbnail .video_item .active").siblings("img").attr("img-name"));

					var link = $("input[name=title]").val();
					var final = '';
					link = link.toLowerCase();
					if($("#create_blog input[name=lang]").val() == "" || $("#create_blog input[name=lang]").val() == "english"){
	                    link = link.replace(/[^a-zA-Z0-9\s+]/g, '');
	                    final = link.replace(/\s+/g, '-');
					}else{
						final = '';
					}
                    

                    $("#create_blog input[name=slug]").val(final);
                    
                    if($("input[name=display_type]").val() == ""){

                    	ShowMessage("error","<?= $allLabelsArray[569] ?>","");

                    }else if($.isArray($("input[name=display_type]").val(),["news","blog"])){

                    	ShowMessage("error","<?= $allLabelsArray[570] ?>","");

                    }else if($("input[name=category]").val() == ""){

                    	ShowMessage("error","<?= $allLabelsArray[609] ?>","");

                    }else if($("input[name=title]").val() == ""){

                    	ShowMessage("error","<?= $allLabelsArray[610] ?>","");

                    }else if($("input[name=description]").val() == ""){

                    	ShowMessage("error","<?= $allLabelsArray[611] ?>","");

                    }else if($("#create_blog input[name=thumbnail]").val() == ""){
                    	ShowMessage("error","<?= $allLabelsArray[612] ?>","");
                    }
                
                    else if($("input[name=content_one]").val() == "" && $("input[name=content_two]").val() == "" && $("input[name=content_three]").val() == "" && $("input[name=content_four]").val() == ""){
						
						ShowMessage("error","<?= $allLabelsArray[613] ?>","");
                    
                    }else if($("input[name=tages]").val() == ""){

                    	ShowMessage("error","<?= $allLabelsArray[587] ?>","");

                    }else if(pdfFile.val() == ""){
                    
                    	ShowMessage("error","<?= $allLabelsArray[807] ?>","");
                    
                    }else if(pdfFile[0].files[0].type != "application/pdf"){
                    
                    	ShowMessage("error","<?= $allLabelsArray[807] ?>","");
                    
                    }else{
                    	var form = $('#create_blog')[0];
                    	var formData = new FormData(form);
                    	formData.append("pdf_file",pdfFile[0].files[0]);
                        $.ajax({
							type: "POST",
							url: "<?php echo $cms_url ?>ajax.php?h=CreateUpdatePdfBlog&lang="+$("input[name=lang]").val(),
							data: formData,
							enctype: 'multipart/form-data',
							dataType: "json",
							contentType: false,
				            cache: false,
				            processData:false,
							beforeSend: function(){
								sel.children("i").show();
							},success: function(res){
								sel.children("i").hide();
								if(res.error){
									
									ShowMessage("error",res.error,"");

								}else if(res.success){

									ShowMessage("","<?= $allLabelsArray[634] ?>","fa fa-smile-o");

									setTimeout(function(){
										if($("input[name=display_type]").val() == "news"){
				                            window.location.href = '<?= $cms_url ?>my-news<?= $langURL ?>';
				                        }else{
				                           window.location.href = '<?= $cms_url ?>my-blog<?= $langURL ?>';
				                        }


									},3000);

								}else{
									
									ShowMessage("error","<?= $allLabelsArray[588] ?>","");

								}
							},error: function(e){
								sel.children("i").hide();
							}
						});
                    }
				}

			</script>
