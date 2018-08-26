<?php
@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '3000' );
add_image_size( 'clip-thumb', 1500, 900, true ); 
function one_flow_actions()
{
	global $post; 
	if(empty($post->post_type)){
		return false;
	}
	if($post->post_type =="shop_order"){
		 $customer = new WC_Customer($post->ID);
		 $iser_id = $customer->get_ID();
		 echo $iser_id. " ************"; 
  		//echo "<pre>"; print_r(get_post_meta($post->ID)); echo "</pre>"; 
		$meta = get_post_meta($post->ID); 
  		$first_name = isset($meta['_billing_first_name'][0]) ? $meta['_billing_first_name'][0] : "x"; 
  		$company = isset($meta['_billing_company'][0]) ? $meta['_billing_company'][0] : "x"; 
  		$address_1 = isset($meta['_billing_address_1'][0]) ? htmlspecialchars($meta['_billing_address_1'][0]) : "x"; 
  		$address_2 = isset($meta['_billing_address_2'][0]) ? htmlspecialchars($meta['_billing_address_2'][0]) : "x"; 
  		$city = isset($meta['_billing_city'][0]) ? $meta['_billing_city'][0] : "x"; 
  		$country = isset($meta['_billing_country'][0]) ? $meta['_billing_country'][0] : "x"; 
  		$woo = WC()->countries;
  		$country_name = isset($woo->countries[$country]) ? $woo->countries[$country] : "Unatied States"; 
  		$zip = isset($meta['_billing_postcode'][0]) ? $meta['_billing_postcode'][0] : "9000"; 
  		$phone = isset($meta['_billing_phone'][0]) ? $meta['_billing_phone'][0] : "313213213";
  		$email = isset($meta['_billing_email']) ? $meta['_billing_email'][0] : "test@amil.com"; 
  		$state = isset($meta['_billing_state'][0]) ? $meta['_billing_state'][0] : "sdfsdsdf"; 
  		global $states; 
  		$state = isset($states['US'][$state]) ? $states['US'][$state] : "CA"; 

		?>
		
<script src="https://clippingmagic.com/api/v1/ClippingMagic.js" type="text/javascript"></script>
<script src="https://transitiontales.com/wp-content/themes/bookshelf/js/superfish.js?SDfsdf" type="text/javascript"></script>

		<script type="text/javascript">
		 ClippingMagic.initialize({apiId: 6392}); //6377
			var oneFlowSubmit = "<span id='oneFlowOrder' class='button button-primary'>Create OneFlow Order</span>"; 

			//setTimeout(function () {
				jQuery(".field_key-field_59ee2d97607d4").after(oneFlowSubmit); 
			//}, 3000);
			
			
			jQuery("#the_second_file_url").val(); 
			var oneFlowData = {first_name:"<?=$first_name?>", company:"<?=$company?>", 
			address_1:"<?= $address_1?>", address_2:"<?=$address_2?>", city:"<?=$city?>",country:"<?=$country?>",
			country_name:"<?=$country_name?>", zip:"<?=$zip?>", phone:"<?=$phone?>", 
			email:"<?=$email?>", state:"<?=$state?>", postId:acf.post_id
			  }; 
			console.log(oneFlowData); 
			jQuery(document).on('click', '#oneFlowOrder', function () {
				oneFlowData['file_path'] = jQuery(".field_key-field_59e50c52d60bd .acf-file-value").val(); 
				oneFlowData['file_path_2'] = jQuery(".field_key-field_59ee2d97607d4 .acf-file-value").val(); 
				oneFlowData['full-length-image-of-child'] = jQuery("#acf-full-length-image-of-child .acf-file-value").val(); 
				var skuName = jQuery(".wc-order-item-name").html().split("-");
				oneFlowData['sku'] = skuName[1] || "reg"; 
				jQuery.ajax({
					type:"POST", 
					url:"/oneflow-sdk-php-master/samples/single-item.php",
					data:oneFlowData,
					success:function (d) {
						console.log(d); 
						var oneFlowData = d.order._id +" "+	d.order.orderData.sourceOrderId; 
						jQuery("#acf-field-oneflow_api_data_").val(oneFlowData); 
						jQuery("#acf-field-one_flow_report").val('Success! Your order has been received. Here is the order ID: '+d.order.orderData.sourceOrderId);
					}
				})
			}); 


			var editedImageLIst = jQuery("#order_line_items .name table tr:nth-child(9) td p"); 
			
			var imageCoords = editedImageLIst.text(); 
			//editedImageLIst.after();
			var imageList = imageCoords .split("|"); 
			var clippingmagic = [], singelImage; 
			var links = "";
			var imageNames = ['Full length image of child',' Child Sitting Down ', 'Child Smiling and Laughing '];
			for(var i=0; i<imageList.length; i++){
				singelImage = imageList[i].split(":"); 
				if(singelImage[0].length> 5){
					clippingmagic[i] = {id : (singelImage[0]-0), secret : singelImage[1]};	
					links += '<a href="https://clippingmagic.com/api/v1/images/'+clippingmagic[i].id+'" target="_blank" class="button button-primary">'+imageNames[i]+'</a><br />';
				}
				
			}
			editedImageLIst.after("<span id='checkImage' class='button button-primary'>Check Image</span><br />"+links); 
			//jQuery(".field_key-field_59ee2d97607d4").after(links); 
			function callback (event, image, error) {
				console.log(event); 
				//clearImages[response.image.id] = 1; 
				if(event.event=="result-generated"){
					//clearImages[event.image.id] = 1;
				}
				/*console.log(clearImages); 
				console.log(image); 
				console.log(error); */
			}
			//editedImageLIst.append('');
			jQuery(document).on('click', '#checkImage', function  () {
				ClippingMagic.edit({
					    "images" : clippingmagic,
					    "locale" : "en-US"
					  }, callback);
			}); 
			jQuery(document).on('click', '#clupImageDownloadX', function () {
				//clippingmagic
				 /*jQuery.ajax({
				 	type:'GET', 
				 	headers: {
				        'Content-Type': 'multipart/form-data',
		    			'6377':'rvc2i9g6nunrsp6v55eo276opgsv603t7n79tfqhhfp8jeuept0o',
		    			'Access-Control-Allow-Origin':'*',

				    },
				 	url:'https://clippingmagic.com/api/v1/images/'+clippingmagic[0].id
				 }); */
				window.open('https://clippingmagic.com/api/v1/images/'+clippingmagic[0].id);
				//jQuery("#link-0").click();
				setTimeout(function () {
					jQuery("#link-1").click();
					window.open('https://clippingmagic.com/api/v1/images/'+clippingmagic[1].id);
					console.log("----------- "+clippingmagic[1].id);
				}, 3000);
				setTimeout(function () {
					//jQuery("#link-2").click();
					window.open('https://clippingmagic.com/api/v1/images/'+clippingmagic[2].id);
					console.log("-----------"+clippingmagic[2].id);
				}, 5000);

			}); 
			
		</script>
		<?php
	}
}
add_action('admin_footer', 'one_flow_actions');

function header_stuff($v='')
{
	
	?>
	<style type="text/css">
		#cover-type{
			border: 1px solid #888;
		}
		form.cart .form-row:nth-child(10){
			display:none
		}
		.video-wrap{
			display: inline-block;
		    float: left;
		    margin-bottom: 30px;
		    float: left;
		    width: 100%;
		}
		.video-js.vjs-fluid, .video-js.vjs-16-9, .video-js.vjs-4-3{
			display: inline-block;
    		float: left;
		}
		#cource-rows{
			display: none;
			width: 100%;
		}
		.tutorial{
			display: inline-block;
		    width: 100%;
		    margin-top: 0px !important;
		    float: left;
		}
		.tutorial-row h2{
			font-size: 25px;
		}
		.tutorial-row{
			padding:0;
			min-height: 100px; 
			
		}
		.green-text{
			color: #080; 
			position: relative;
    		padding-right: 20px;
    		font-weight: bold;
		}
		.green-text:after{
			content: "";
			background: url(https://transitiontales.com/wp-content/themes/bookshelf/css/images/green-icon.svg);
			background-size: cover;
			width: 15px;
		    height: 15px;
		    position: absolute;
		    top: 0px;
		}
		.red-text{
			color: #800;
			position: relative;
    		padding-right: 20px;
    		font-weight: bold;
		}
		.red-text:after{
			content: "";
			background: url(https://transitiontales.com/wp-content/themes/bookshelf/css/images/red-icon.svg);
			background-size: cover;
			width: 15px;
		    height: 15px;
		    position: absolute;
		    top: 0px;
		}
		.start-loading{
			position: relative;
		}
		.start-loading:after{
			content: "";
			background: url(https://transitiontales.com/wp-content/themes/bookshelf/images/ajax-loader.gif);
			background-size: cover;
			width: 15px;
		    height: 15px;
		    position: absolute;
		   display: inline-block;
    		right: -70%;
    		top:-20px;
		}
		.in-active{
			background: #888 !important
		}
		.in-active:hover{
			background: #999 !important
		}
		.clip-iframe-arraw{
			display: none;
			text-align: center;
		}
		.form-row.form-row-wide.addon-wrap-1100-background-images-1:nth-child(odd){
			vertical-align: top; 
			width: 30%;
		    display: inline-block;
		    padding: 0;
		}
		.form-row.form-row-wide.addon-wrap-1100-background-images-1:nth-child(even){
			width: 69%;
		}
		.col-md-7.example-item{
			float: right;
			padding:0; 
			text-align: center; 
		}
		.example-item{
			text-align: center;
		}
		.example-item img{
			display: inline-block !important;
			max-height: 110px;
		}
		.help_text_wrap{
			display: none;
			padding: 5px 0;
		    border-top: 1px solid #888;
		    border-bottom: 1px solid #888;
		    margin-bottom: 10px;
		}
		.help_text_wrap p{
			margin-bottom: 0;
		}
		#product_follow_steps{
			display: none;
		}
		#follow-steps{
			display: inline-block;
			width: 100%;
		}
		@media(min-width: 320px) and (max-width: 767px){
			.start-loading:after{
				right: 5px;
	    		top: 20px;
			}	
			.clip-iframe-arraw{
				display: inline-block;
				width: 100%;
			
			}
			.clip-iframe-arraw .icon-clip-arrow{
				display: inline-block;
			    padding: 5px 15px;
			    border: 2px solid #fff;
			    color: #fff;
			}
			#clipping-magic-iframe{
				max-width: 200%;
    			width: 200% !important;
    			margin-top: 10px;
			}
		}
		
		/*
		https://transitiontales.com/wp-content/uploads/2017/11/green-add.png
		https://transitiontales.com/wp-content/uploads/2017/11/red-remove.png
		*/
		/*.video-wrap p{
			display: inline-block;
			float: left;
			width: 48%;

		}
		#youtube-frame{
			width: 100%;
		}*/
	</style>
	<?php
	
}
function header_stuff_new(){
	?>
	<style type="text/css">
		.form-row.form-row-wide.addon-wrap-1100-background-images-1:nth-child(even){
			vertical-align: top; 
			width: 30%;
		    display: inline-block;
		    padding: 0;
		}
		.form-row.form-row-wide.addon-wrap-1100-background-images-1:nth-child(odd){
			width: 69%;
		}
		#product_follow_steps{
			display: none;
		}
		#follow-steps{
			display: inline-block;
			width: 100%;
		}
	</style>
	
	<?php
}

add_action('wp_head', 'header_stuff');


function iconic_variable_price_format( $price, $product ) {
 
    $prefix = sprintf('%s: ', __('From', 'iconic'));
 
    $min_price_regular = $product->get_variation_regular_price( 'min', true );
    $min_price_sale    = $product->get_variation_sale_price( 'min', true );
    $max_price = $product->get_variation_price( 'max', true );
    $min_price = $product->get_variation_price( 'min', true );
 
    $price = ( $min_price_sale == $min_price_regular ) ?
        wc_price( $min_price_regular ) :
        '<del>' . wc_price( $min_price_regular ) . '</del>' . '<ins>' . wc_price( $min_price_sale ) . '</ins>';
 
    return ( $min_price == $max_price ) ? wc_price($min_price) : wc_price($min_price) ." - ".wc_price( $max_price ); 
    //( $min_price == $max_price ) ?        $price :        sprintf('%s%s', $prefix, $price);
 
}
 
add_filter( 'woocommerce_variable_sale_price_html', 'iconic_variable_price_format', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'iconic_variable_price_format', 10, 2 );
add_action('wp_ajax_cvf_upload_files', 'cvf_upload_files');
add_action('wp_ajax_nopriv_cvf_upload_files', 'cvf_upload_files'); // Allow front-end submission 

function cvf_upload_files(){
    

  /* img upload */

 $condition_img=7;
 $img_count = 1;//count(explode( ',',$_POST["image_gallery"] )); 
 $image_key = $_POST['image_key'];  
 //print_r($_FILES[$image_key]); 
 if(!empty($_FILES[$image_key])){

 require_once( ABSPATH . 'wp-admin/includes/image.php' );
 require_once( ABSPATH . 'wp-admin/includes/file.php' );
 require_once( ABSPATH . 'wp-admin/includes/media.php' );
  

 $files = $_FILES[ $image_key ];  
 $attachment_ids=array();
 $attachment_idss='';

 if($img_count>=1){
 $imgcount=$img_count;
 }else{
 $imgcount=1;
 }
  

 $ul_con='';

 /*foreach ($files['name'] as $key => $value) {            
   if ($files['name'][$key]) { 
    $file = array( 
     'name' => $files['name'][$key],
     'type' => $files['type'][$key], 
     'tmp_name' => $files['tmp_name'][$key], 
     'error' => $files['error'][$key],
     'size' => $files['size'][$key]
    ); 
    //$_FILES = array ( $image_key=> $file); */
    //print_r($_FILES);
    
    foreach ($_FILES as $file => $array) {              
      
      if(empty($array['name']) or $file !==  $image_key){ continue; } 

	     require_once(ABSPATH . "wp-admin" . '/includes/image.php');
	     require_once(ABSPATH . "wp-admin" . '/includes/file.php');
	     require_once(ABSPATH . "wp-admin" . '/includes/media.php');
	     
	     //$newupload = my_handle_attachment($file,$pid); 

	     $attach_id = media_handle_upload( $file, $post_id );
	      $attachment_ids[] = $attach_id; 

	      $image_link = wp_get_attachment_image_src( $attach_id, apply_filters( 'easy_image_gallery_linked_image_size', 'full' ) );
	   /* $ul_con.='<div id="li_'.$attach_id.'"><img   src="'.$image_link[0].'"  class="thumb "><br>
	           <a onclick="remove_img('.$attach_id.')" href="javascript:;" class="delete check">Remove</a> 
	      </div>'; */
	     // print_r($image_link); 
	      $total_size = $image_link[1] * $image_link[2];
	      if($total_size > 8000000){
	      	$image_link = wp_get_attachment_image_src( $attach_id, apply_filters( 'easy_image_gallery_linked_image_size', 'clip-thumb' ) );
	
	      }
	      $image_link = str_replace(home_url(), "",  $image_link[0]); 
	      
	    }
    //if($imgcount>$condition_img){ break; } 
    //$imgcount++;
  // } 
 // }

  
 } 
/*img upload */

 //$image_gallery=$_POST['image_gallery'];

$attachment_idss = array_filter( $attachment_ids  );
$attachment_idss =  implode( ',', $attachment_idss );  

 //if($image_gallery){ $attachment_idss=$image_gallery.",".$attachment_idss;  }


$arr = array();
$arr['img_link'] = $image_link;
//$arr['ul_con'] =$ul_con; 

echo json_encode( $arr );
 die();

}


function getCurlValue($filename, $contentType, $postname)
	{
	    // PHP 5.5 introduced a CurlFile object that deprecates the old @filename syntax
	    // See: https://wiki.php.net/rfc/curl-file-upload
	    if (function_exists('curl_file_create')) {
	        return curl_file_create($filename, $contentType, $postname);
	    }
	 
	    // Use the old style if using an older version of PHP
	    $value = "@{$filename};filename=" . $postname;
	    if ($contentType) {
	        $value .= ';type=' . $contentType;
	    }
	 
	    return $value;
	}

$action_ajax  = isset($_POST['action']) ? 	$_POST['action'] : "";
if(isset($_POST['image_key']) and $action_ajax!=="cvf_upload_files"){

	$secret = "816sa78sc6vc7df1v13jl8q23erstkmko540vsi9j73sjrjckcjs";
	$apiID = 6392; 
	$C = curl_init();
		$data = [];
		$ipsp_post = $_POST;
		ksort($ipsp_post);
		$signature = "";
		foreach ($ipsp_post as $key => $v) {
				$signature .= $v;
				$data[$key] = $v;
		}
		$tmp = tempnam(sys_get_temp_dir(), 'php');
		$image_key = $_POST['image_key'];
		$root_path = realpath('./'); 
		$list_ = [
			'addon-1100-background-images-1-full-length-image-of-child'=> 'full-length-image-of-child',
			'addon-1100-background-images-1-child-sitting-down'=>'child-sitting-down',
			'addon-1100-background-images-1-caregiver-and-child-smiling-and-laughing'=>'caregiver-and-child-smiling-and-laughing'
		]; 
		$filename  =  $root_path.$image_key; //$_FILES[$image_key]['tmp_name'];
 		$handle    = fopen($filename, "r");
 		$img     = fread($handle, filesize($filename));
 		//$uploaddir = realpath('./') . '/wp-content/uploads/2017/11/';
		//$uploadfile = $uploaddir . basename($_FILES['image']['name']);
		$localFile = getCurlValue($filename,'image/jpeg',$list_[$image_key].'.jpg');
		//'@/var/www/vhosts/solid.am/kayqer.solid.am/topnia/wp-content/uploads/2017/11/writer.png';
		//$img; //base64_encode($img); //'@'.$_FILES['image']['tmp_name']; 

		//$data['test'] = 'true';	
		$data['image'] = $localFile;//'@/var/www/vhosts/solid.am/kayqer.solid.am/topnia/wp-content/uploads/2017/11/writer.png';
		$data['imageFile'] = $localFile; 
		//"@".$_FILES['file']['tmp_name'];  //fopen($_FILES['image']['tmp_name'], 'r'); 
		//'@/var/www/vhosts/solid.am/kayqer.solid.am/topnia/wp-content/uploads/2017/11/writer.png';
		$fp = $data['image']; //fopen($data['image'], 'r');
		$data['originalFilename'] = 'writer.png';
		$data['contentType'] = 'image/png';
		//'@/var/www/vhosts/solid.am/kayqer.solid.am/topnia/wp-content/uploads/2017/11/writer.png'; //$fp; //'@'. $_FILES['image']['tmp_name']. ';filename=' . $_FILES['image']['name'];
		$data[$apiID] = $secret; //'rvc2i9g6nunrsp6v55eo276opgsv603t7n79tfqhhfp8jeuept0o';
		/*;
		move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);*/
		//$data['signature'] = sha1($signature);
		ksort($data);
		curl_setopt($C, CURLOPT_HTTPHEADER, array(
		    'Content-Type: multipart/form-data',
		    $apiID.':'.$secret //rvc2i9g6nunrsp6v55eo276opgsv603t7n79tfqhhfp8jeuept0o 6377
		    ));

		

		//curl_setopt($C, CURLFORM_CONTENTTYPE, 'multipart/form-data');
		//curl_setopt($C, CURLOPT_BUFFERSIZE, 128);
		curl_setopt($C, CURLOPT_TIMEOUT, 30);
		curl_setopt($C, CURLOPT_USERPWD,  $apiID. ":" .$secret); // "rvc2i9g6nunrsp6v55eo276opgsv603t7n79tfqhhfp8jeuept0o" "6377"
		curl_setopt($C, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Widows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		curl_setopt($C, CURLOPT_URL, 'https://clippingmagic.com/api/v1/images?csrfToken=NjM3NzpydmMyaTlnNm51bnJzcDZ2NTVlbzI3Nm9wZ3N2NjAzdDduNzl0ZnFoaGZwOGpldWVwdDBv'); 
		curl_setopt($C, CURLOPT_POST, 1);
		curl_setopt($C, CURLOPT_POSTFIELDS, $data);
		//curl_setopt($C, CURLOPT_INFILE, $fp);
		curl_setopt($C, CURLOPT_RETURNTRANSFER, 1); 
		//echo $uploadfile."**";
		//print_r($_FILES);
		//print_r($data);
		header('Content-Type: application/json');
		
		echo curl_exec($C);
		curl_close($C);
		die;
}
function imageExamples($aim='')
{
	$full_length_image_of_child = ot_get_option($aim);
	$html = ""; 
	$i = 0; 
	foreach ($full_length_image_of_child as $key => $v) {
		$col = ($i==0) ? 4 : 7;
		$html .= "<div class='col-md-".$col." col-sm-6 col-xs-12 example-item'><img src='".$v['image']."' alt='".$v['title']."' class='example-pic' /></div>"; 
		$i++;
	}  
	return $html;
}

function clip_stuff()
{
	$videp_ = ot_get_option('video_');
	$videoEl = ""; 
	if(!empty($videp_)){
		$ex_video = explode("=", $videp_); 
		$videoEl = '<div class="required-product-addon product-addon"><iframe id="youtube-frame" width="500" height="315" src="https://www.youtube.com/embed/'.$ex_video[1].'" frameborder="0" allowfullscreen></iframe></div>'; 
	}

	$example_rows = "<div class='tutorial required-product-addon product-addon'>
	<button id='start-learning' class='button'>".ot_get_option('start_learning_button')."</button>
	<div id='cource-rows'>
	"; 
	$clippingmagic__steps_items = ot_get_option('clippingmagic__steps_items');
	$r= 1; 
	foreach ($clippingmagic__steps_items as $key => $v ) {
		$image = ""; 
		if(!empty($v['image'])){
			$image = "<img src='".$v['image']."' alt='".$v['title']."'/>";
		}
		$example_rows .= "<div class='tutorial-row col-md-12 col-sm-12 col-xs-12'><div class='col-md-4 col-sm-4 col-xs-12'>
					<h2>".$r.". ".$v['title']."</h2>
					<p>".do_shortcode($v['description'])."</p>
					</div>
					<div class='col-md-7 col-sm-7 col-xs-12'>
						<p>".do_shortcode($v['link']).$image ."</p>
						
					</div></div>"; 
					$r++; 
	}
	$example_rows .= "
	</div></div>";
?>

<!--form action="https://clippingmagic.com/api/v1/images?csrfToken=NjM3NzpydmMyaTlnNm51bnJzcDZ2NTVlbzI3Nm9wZ3N2NjAzdDduNzl0ZnFoaGZwOGpldWVwdDBv" id="mform" method="POST" enctype="multipart/form-data" class="test-up-form" style="display:none">
<div class="form-group">
<input type="file" name="image" class="test-upload active">
</div>
<div class="checkbox">
<label>
<input type="checkbox" checked="true" value="true" name="test"> test &nbsp; 
</label>
</div>
<input type="submit" value="Submit">
<input type="text" name="appId" value="">
<input type="text" name="username" value="6377">
<input type="text" name="Password" value="rvc2i9g6nunrsp6v55eo276opgsv603t7n79tfqhhfp8jeuept0o">
</form-->

<div id="extravideo"><?php //echo do_shortcode('[videojs_video url="https://transitiontales.com/wp-content/uploads/video/how-to-clipping-magic.webm"]');
?></div>
<?php
$exampleList = "var exampleList = {"; 
$exampleList .= '1:"'.imageExamples('full_length_image_of_child') .'",';
$exampleList .= '2:"'.imageExamples('child_sitting_down') .'",';
$exampleList .= '3:"'.imageExamples('caregiver_and_child_smiling_and_laughing') .'",';
$exampleList .="};"; 
$image_upload_help_text = ot_get_option('image_upload_help_text');
?>
<!-- <div id="image_upload_help_text"></div> -->
<?php
/*
<div id="example-steps"><?=$example_rows?></div>
<div id="bottom-text"><div class="help_text_wrap"><?=$image_upload_help_text ?></div><?=ot_get_option('bottom_text');?></div>
*/
?>
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script> -->
<!-- <script src="https://clippingmagic.com/api/v1/ClippingMagic.js" type="text/javascript"></script> -->
<!-- <script src="https://transitiontales.com/wp-content/themes/bookshelf/js/superfish.js?SDfsdf" type="text/javascript"></script> -->
<script type="text/javascript">
<?=$exampleList?>
 var imageList = [];
 var imageListCount = 0; 
 var clearImages = {};
 var taregt
var ImageSizeError = "<?php echo ot_get_option('error_message');?>";
var ajax_url = "<?=home_url()?>/wp-admin/admin-ajax.php";
jQuery(document).ready(function () {
	
	var explaeCount = 1; 
	jQuery(".addon-wrap-1100-background-images-1").each(function (e, i) {
		
		jQuery(i).after("<div class='form-row form-row-wide addon-wrap-1100-background-images-1'>"+ exampleList[explaeCount] +"</div>"); 
		
		explaeCount++; 
	});
	
});
</script>
	<?php
}     



//add_action('wp_footer', 'clip_stuff');
function green_tool($value='')
{
	return '<span class="green-text">green tool </span>';
}
add_shortcode('green_tool', 'green_tool');


function red_tool($value='')
{
	return '<span class="red-text">red tool </span>';
}
add_shortcode('red_tool', 'red_tool');
function button_($value='')
{
	return '<button id="test-upload-button">Upload</button>';
}
add_shortcode('button','button_');

function product_layout_customization()
{
	$product_follow_steps = ot_get_option('product_follow_steps'); 
	?>
	<div id="product_follow_steps"><?=$product_follow_steps?></div>
	<script type="text/javascript">
	var product_follow_steps = jQuery("#product_follow_steps");
	setTimeout(function(){
		jQuery("form.cart").before('<div id="follow-steps">'+product_follow_steps.html()+'</div>'); 
		product_follow_steps.remove(); 
	}, 1000); 
	
	
	</script>
	<?
}


if(isset($_GET['xxxdd'])){
	$c = '[vc_row][vc_column][rev_slider alias="NewHomeSlideer"][trx_section bg_color="#1eaace" class="collector-of-email"][trx_content][vc_column_text][mc4wp_form id="2396"][/vc_column_text][/trx_content][/trx_section][/vc_column][/vc_row][vc_row][vc_column width="1/4"][/vc_column][vc_column width="1/2"][vc_column_text]<iframe style="width: 800px; height: 400px;" src="https://s3.amazonaws.com/online.anyflip.com/gyuu/wtfu/index.html" width="300" height="150" frameborder="0" scrolling="no" seamless="seamless" allowfullscreen="allowfullscreen"></iframe>[/vc_column_text][/vc_column][vc_column width="1/4"][/vc_column][/vc_row]';
	global $wpdb;
	$table = $wpdb->prefix."postmeta";
	echo $table; 
	/*
	UPDATE wp_options SET option_value = replace(option_value, 'http://www.oldurl', 'http://www.newurl') WHERE option_name = 'home' OR option_name = 'siteurl';

	UPDATE wp_posts SET guid = replace(guid, 'http://www.oldurl','http://www.newurl');
	UPDATE wp_posts SET post_content = replace(post_content, 'http://www.oldurl', 'http://www.newurl');
	UPDATE wp_postmeta SET meta_value = replace(meta_value,'http://www.oldurl','http://www.newurl');
	*/
	$res = $wpdb->get_results("SELECT * FROM ".$table." WHERE meta_value LIKE '%transitiontales.com%' limit 2 ");
	echo "<pre>"; print_r($res); echo "</pre>";
	/*$wpdb->update( 
	 $wpdb->posts, 
	array( 
		'post_content' => $c
		
	), 
	array( 'ID' => 3171 ), 
	array( 
		'%s',	// value1
		
	), 
	array( '%d' ) 
);*/
}