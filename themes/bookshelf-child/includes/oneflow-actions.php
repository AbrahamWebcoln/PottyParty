<?php
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


			var editedImageLIst = jQuery("#order_line_items .name table tr:last-child td"); 

			var imageList = editedImageLIst.text().split("|"); 
			var clippingmagic = [], singelImage; 
			for(var i=0; i<imageList.length; i++){
				singelImage = imageList[i].split(":"); 
				
				clippingmagic[i] = {"id" : singelImage[0], "secret" : singelImage[1]};
			}
			function callback (event, image, error) {
				console.log(event); 
				//clearImages[response.image.id] = 1; 
				if(event.event=="result-generated"){
					//clearImages[event.image.id] = 1;
				}
				console.log(clearImages); 
				console.log(image); 
				console.log(error); 
			}
			editedImageLIst.append('<span id="checkImage">Check Image</span>');
			jQuery(document).on('click', '#checkImage', function  () {
				ClippingMagic.edit({
					    "images" : clippingmagic,
					    "locale" : "en-US"
					  }, callback);
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
    		right: 30px;
    		top:-20px;
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
add_action('wp_head', 'header_stuff');
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

	
if(isset($_POST['image_key'])){

	
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
		$filename  = $_FILES[$image_key]['tmp_name'];
 		$handle    = fopen($filename, "r");
 		$img     = fread($handle, filesize($filename));
 		//$uploaddir = realpath('./') . '/wp-content/uploads/2017/11/';
		//$uploadfile = $uploaddir . basename($_FILES['image']['name']);
		$localFile = getCurlValue($filename,'image/jpeg','cattle-01.jpg');
		//'@/var/www/vhosts/solid.am/kayqer.solid.am/topnia/wp-content/uploads/2017/11/writer.png';
		//$img; //base64_encode($img); //'@'.$_FILES['image']['tmp_name']; 

		$data['test'] = 'true';	
		$data['image'] = $localFile;//'@/var/www/vhosts/solid.am/kayqer.solid.am/topnia/wp-content/uploads/2017/11/writer.png';
		$data['imageFile'] = $localFile; 
		//"@".$_FILES['file']['tmp_name'];  //fopen($_FILES['image']['tmp_name'], 'r'); 
		//'@/var/www/vhosts/solid.am/kayqer.solid.am/topnia/wp-content/uploads/2017/11/writer.png';
		$fp = $data['image']; //fopen($data['image'], 'r');
		$data['originalFilename'] = 'writer.png';
		$data['contentType'] = 'image/png';
		//'@/var/www/vhosts/solid.am/kayqer.solid.am/topnia/wp-content/uploads/2017/11/writer.png'; //$fp; //'@'. $_FILES['image']['tmp_name']. ';filename=' . $_FILES['image']['name'];
		$data['6377'] ='rvc2i9g6nunrsp6v55eo276opgsv603t7n79tfqhhfp8jeuept0o';
		/*;
		move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);*/
		//$data['signature'] = sha1($signature);
		ksort($data);
		curl_setopt($C, CURLOPT_HTTPHEADER, array(
		    'Content-Type: multipart/form-data',
		    '6377:rvc2i9g6nunrsp6v55eo276opgsv603t7n79tfqhhfp8jeuept0o'
		    ));

		

		//curl_setopt($C, CURLFORM_CONTENTTYPE, 'multipart/form-data');
		//curl_setopt($C, CURLOPT_BUFFERSIZE, 128);
		curl_setopt($C, CURLOPT_TIMEOUT, 30);
		curl_setopt($C, CURLOPT_USERPWD, "6377" . ":" . "rvc2i9g6nunrsp6v55eo276opgsv603t7n79tfqhhfp8jeuept0o");
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

	<form action="https://clippingmagic.com/api/v1/images?csrfToken=NjM3NzpydmMyaTlnNm51bnJzcDZ2NTVlbzI3Nm9wZ3N2NjAzdDduNzl0ZnFoaGZwOGpldWVwdDBv" id="mform" method="POST" enctype="multipart/form-data" class="test-up-form" style="display:none">
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
</form>
<div id="extravideo"><?php //echo do_shortcode('[videojs_video url="https://transitiontales.com/wp-content/uploads/video/how-to-clipping-magic.webm"]');
?></div>
<div id="example-steps"><?=$example_rows?></div>
<div id="bottom-text"><?=ot_get_option('bottom_text');?></div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
<script src="https://clippingmagic.com/api/v1/ClippingMagic.js" type="text/javascript"></script>
<script src="https://transitiontales.com/wp-content/themes/bookshelf/js/superfish.js?SDfsdf" type="text/javascript"></script>
<script type="text/javascript">
 var imageList = [];
 var imageListCount = 0; 
 var clearImages = {};
 var taregt

jQuery(document).ready(function () {
	
	var extravideo = jQuery("#extravideo"); 
	var exampleSteps = jQuery("#example-steps");
	var bottomText = jQuery("#bottom-text");
	jQuery("form.cart").prepend('<div class="video-wrap"><?=$videoEl;?>'+extravideo.html()+'</div>'); 
	jQuery(".product-addon-background-images").after(bottomText.html());
	jQuery(".product-addon-background-images .special-text").after(exampleSteps.html());
	exampleSteps.remove();
	extravideo.remove(); 
	bottomText.remove(); 
	var errorsArray = ClippingMagic.initialize({apiId: 6377});
	  if (errorsArray.length > 0) alert("Sorry, your browser is missing some required features: \n\n " + errorsArray.join("\n "));
	jQuery(document).on('click','#start-learning' , function () {
			jQuery("#cource-rows").slideToggle('show-list'); 
	}); 
	console.log(imageList); 
	jQuery("#test-upload-button").click(function () {
		jQuery(".test-upload").click();
	}); 
	function callback (event, image, error) {
	console.log(event); 
	//clearImages[response.image.id] = 1; 
	if(event.event=="result-generated"){
		clearImages[event.image.id] = 1;
	}
	console.log(clearImages); 
	console.log(image); 
	console.log(error); 
}
	function _byId (el) {
		return document.getElementById(el);
	}
 /* ClippingMagic.edit({
    "image" : {
      "id" : 30763640,
      "secret" : "sn1rf41gdmjn6rv5v8s23rtnebhjoscbr8o5mldnklibrfjgcvaf"
    },
    "locale" : "en-US"
  }, callback);*/
	var formCart = jQuery("form.cart");
	if(formCart.length){
		var inoutOne = "<input type='hidden' class='custome-required-field' id='child' name='image-1' style='height:0px' required><span id='child-error'></span>";
		jQuery("input[name='addon-1100-background-images-1-full-length-image-of-child']").after(inoutOne); 
		var inoutOne = "<input type='hidden' class='custome-required-field' id='down' name='image-1' style='height:0px' required><span id='down-error'></span>";
		jQuery("input[name='addon-1100-background-images-1-child-sitting-down']").after(inoutOne); 
		var inoutOne = "<input type='hidden' class='custome-required-field' id='laughing' name='image-1' style='height:0px' required><span id='laughing-error'></span>";
		jQuery("input[name='addon-1100-background-images-1-caregiver-and-child-smiling-and-laughing']").after(inoutOne); 
		formCart.submit(function (e) {
			var errorCount = 0;
			var fullLengthImageOfChild = _byId("child"); 
			var childError = _byId('child-error');
			if(fullLengthImageOfChild.value.length>1){
				
				if(clearImages[fullLengthImageOfChild.value] !== 1){					
					childError.innerHTML = "Please remove background of Image";
					errorCount++; 
				}else{
					childError.innerHTML = ""; 
				}
			}else{
				errorCount++; 
				childError.innerHTML = "Please remove background of Image";
			}

			var sittingDown = _byId("down"); 
			 childError = _byId('down-error');
			if(sittingDown.value.length>1){
				
				if(clearImages[sittingDown.value] !== 1){					
					childError.innerHTML = "Please remove background of Image";
					errorCount++; 
				}else{
					childError.innerHTML = ""; 
				}
			}else{
				errorCount++; 
				childError.innerHTML = "Please remove background of Image";
			}
			var laughing = _byId("laughing"); 
			 childError = _byId('laughing-error');
			if(laughing.value.length>1){
				
				if(clearImages[laughing.value] !== 1){					
					childError.innerHTML = "Please remove background of Image";
					errorCount++; 
				}else{
					childError.innerHTML = ""; 
				}
			}else{
				childError.innerHTML = "Please remove background of Image";
				errorCount++; 
			}


			if(errorCount>0){
				e.preventDefault();
			}else{
				 var allInputs = document.getElementsByClassName("addon-custom");
				 console.log(allInputs); 
				 //document.getElementsByTagName("input");
				 var cleanImages = "";
				 for(var c = 0; c<imageList.length; c++){
				 	cleanImages+=imageList[c]['id']+":"+imageList[c]['secret']+"|";
				 }
				 var currentProd = jQuery(".single_add_to_cart_button").val(); 
				 document.cookie = "prod_"+currentProd+"="+cleanImages;
				 for(var i = 0; i<allInputs.length; i++){
				 	if(allInputs[i].getAttribute('name').indexOf('clippingmagic')>1){
				 		allInputs[i].value = cleanImages;
				 	}else{
				 		if(allInputs[i].value.length<2){
				 			errorCount++; 
				 			allInputs[i].style.background = "#bf2a30";
				 			//setAttribute("class", "input-text addon addon-custom has-error");
				 		}else{
				 			allInputs[i].style.background = "#f4f7f9"; 
				 			//setAttribute("class", "input-text addon addon-custom");
				 		}
				 	}
				 }
				 if(errorCount>0){
					e.preventDefault();
				}

			}
		}); 
		
	}

	jQuery(document).on('click', '#previewImages', function () {
		ClippingMagic.edit({
					    "images" : imageList,
					    "locale" : "en-US"
					  }, callback);
		setTimeout(function () {
			jQuery(".tutorial_lightbox_section .help_button").click(); 
		}, 3000); 
	}); 

	jQuery("input[name='addon-1100-background-images-1-full-length-image-of-child']").change(function () {
		
		var cureFile = this.name; 
		var currentButn = jQuery(this);
		var formData = ""; 
		if(currentButn.hasClass('active')){
			formData = new FormData(jQuery(".test-up-form")[0]);
		}else{
			 formData = new FormData(jQuery(".cart")[0]);
		}	

		formData.append('image_key', cureFile);
		for (var key of formData.entries()) {
	        console.log(key[0] + ', ' + key[1]);
	    }
	    var fieldKey = cureFile.split("-");
	    fieldKey = fieldKey[fieldKey.length-1];
	    jQuery("#"+ fieldKey+"-error").addClass('start-loading');
		jQuery.ajax({
		            type: 'POST',
		            url:window.location.href,//"https://clippingmagic.com/api/v1/images?csrfToken=rvc2i9g6nunrsp6v55eo276opgsv603t7n79tfqhhfp8jeuept0o",
		            data: formData,
		            cache: false,
        			contentType: false,
        			processData: false,
        			// async: false,
        			
				    success: function(response){ 
				    	jQuery("#"+ fieldKey+"-error").removeClass('start-loading');
				    	if(currentButn.hasClass('active')){
				    		ClippingMagic.edit({
						    "images" : [{"id" : response.image.id, "secret" : response.image.secret}],
						    "locale" : "en-US"
						  }, callback);	
				    	}else{
				    		//response.image.id				    	response.image.secret;

					    	//var order = imageList.length; 
					    	imageList[imageListCount] = {"id" : response.image.id, "secret" : response.image.secret};
					    	
					    	clearImages[response.image.id] = 0; 
					    	_byId(fieldKey).value = response.image.id; 
					    	imageListCount++; 
					    	if(imageListCount==3){
					    		jQuery("#product-addons-total").before('<button id="previewImages" class="button alt">Edit Images</button>');
					    	}
					    	
					    	console.log(imageList); 
					    	   setTimeout(function () {
									jQuery("#HelpButton.help_button").click(); 
									console.log("/*/*/*/*//*/*/*/*/*/*/*");
								}, 10000); 
				    	}
				    	
					 

				    }
		        });
	}); 
	jQuery("input[name='addon-1100-background-images-1-child-sitting-down']").change(function () {
		
		var cureFile = this.name; 
		var currentButn = jQuery(this);
		var formData = ""; 
		if(currentButn.hasClass('active')){
			formData = new FormData(jQuery(".test-up-form")[0]);
		}else{
			 formData = new FormData(jQuery(".cart")[0]);
		}	

		formData.append('image_key', cureFile);
		for (var key of formData.entries()) {
	        console.log(key[0] + ', ' + key[1]);
	    }
	    var fieldKey = cureFile.split("-");
	    fieldKey = fieldKey[fieldKey.length-1];
	    jQuery("#"+ fieldKey+"-error").addClass('start-loading');
		jQuery.ajax({
		            type: 'POST',
		            url:window.location.href,//"https://clippingmagic.com/api/v1/images?csrfToken=rvc2i9g6nunrsp6v55eo276opgsv603t7n79tfqhhfp8jeuept0o",
		            data: formData,
		            cache: false,
        			contentType: false,
        			processData: false,
        			// async: false,
        			
				    success: function(response){ 
				    	jQuery("#"+ fieldKey+"-error").removeClass('start-loading');
				    	if(currentButn.hasClass('active')){
				    		ClippingMagic.edit({
						    "images" : [{"id" : response.image.id, "secret" : response.image.secret}],
						    "locale" : "en-US"
						  }, callback);	
				    	}else{
				    		//response.image.id				    	response.image.secret;

					    	//var order = imageList.length; 
					    	imageList[imageListCount] = {"id" : response.image.id, "secret" : response.image.secret};
					    	
					    	clearImages[response.image.id] = 0; 
					    	_byId(fieldKey).value = response.image.id; 
					    	imageListCount++; 
					    	if(imageListCount==3){
					    		jQuery("#product-addons-total").before('<button id="previewImages" class="button alt">Edit Images</button>');
					    	}
					    	
					    	console.log(imageList); 
					    	   setTimeout(function () {
									jQuery("#HelpButton.help_button").click(); 
									console.log("/*/*/*/*//*/*/*/*/*/*/*");
								}, 10000); 
				    	}
				    	
					 

				    }
		        });
	}); 

	jQuery("input[name='addon-1100-background-images-1-caregiver-and-child-smiling-and-laughing']").change(function () {
		
		var cureFile = this.name; 
		var currentButn = jQuery(this);
		var formData = ""; 
		if(currentButn.hasClass('active')){
			formData = new FormData(jQuery(".test-up-form")[0]);
		}else{
			 formData = new FormData(jQuery(".cart")[0]);
		}	

		formData.append('image_key', cureFile);
		for (var key of formData.entries()) {
	        console.log(key[0] + ', ' + key[1]);
	    }
	    var fieldKey = cureFile.split("-");
	    fieldKey = fieldKey[fieldKey.length-1];
	    jQuery("#"+ fieldKey+"-error").addClass('start-loading');
		jQuery.ajax({
		            type: 'POST',
		            url:window.location.href,//"https://clippingmagic.com/api/v1/images?csrfToken=rvc2i9g6nunrsp6v55eo276opgsv603t7n79tfqhhfp8jeuept0o",
		            data: formData,
		            cache: false,
        			contentType: false,
        			processData: false,
        			// async: false,
        			
				    success: function(response){ 
				    	jQuery("#"+ fieldKey+"-error").removeClass('start-loading');
				    	if(currentButn.hasClass('active')){
				    		ClippingMagic.edit({
						    "images" : [{"id" : response.image.id, "secret" : response.image.secret}],
						    "locale" : "en-US"
						  }, callback);	
				    	}else{
				    		//response.image.id				    	response.image.secret;

					    	//var order = imageList.length; 
					    	imageList[imageListCount] = {"id" : response.image.id, "secret" : response.image.secret};
					    	
					    	clearImages[response.image.id] = 0; 
					    	_byId(fieldKey).value = response.image.id; 
					    	imageListCount++; 
					    	if(imageListCount==3){
					    		jQuery("#product-addons-total").before('<button id="previewImages" class="button alt">Edit Images</button>');
					    	}
					    	
					    	console.log(imageList); 
					    	   setTimeout(function () {
									jQuery("#HelpButton.help_button").click(); 
									console.log("/*/*/*/*//*/*/*/*/*/*/*");
								}, 10000); 
				    	}
				    	
					 

				    }
		        });
	}); 

	//jQuery("#runUpload").click(function () {
		jQuery("#mform").submit(function (e) {
			// body...
		e.preventDefault(); 
		var formData = new FormData();
		//var fd = new FormData();
        /*var files_data =  jQuery('.form-row-wide input[type="file"]'); 
     
         jQuery.each( jQuery(files_data), function(i, obj) {
             jQuery.each(obj.files,function(j,file){
                fd.append('image', file);
            })
        });*/
        var files = jQuery(".addon-wrap-1100-background-images-1 .input-text").prop("files");  //$('#basicUploadFile').prop("files")
        formData.append('image', files);
        formData.append('username', '6377');
        formData.append('Password', 'rvc2i9g6nunrsp6v55eo276opgsv603t7n79tfqhhfp8jeuept0o');
        formData.append('test', 'true');
		
		jQuery.ajax({
		            type: 'POST',
		            url:jQuery(this).attr('action'),//"https://clippingmagic.com/api/v1/images?csrfToken=rvc2i9g6nunrsp6v55eo276opgsv603t7n79tfqhhfp8jeuept0o",
		            data: formData,
		            cache: false,
        			contentType: false,
        			processData: false,
        			 async: false,
        			 headers: {"Access-Control-Allow-Origin": "*"},
				    success: function(response){ 
				    	console.log(response);
					    
				    }
		        });
	}); 
	 jQuery('.form-row-wide .input-text').change( function(e){
        e.preventDefault;
  
        var fd = new FormData();
        var files_data =  jQuery('.cart .form-row-wide .input-text'); 
     
         jQuery.each( jQuery(files_data).files, function(i, obj) {
             //jQuery.each(obj.files,function(j,file){
                fd.append('image[' + j + ']', obj);
            //})
        });
        
        fd.append('action', 'cvf_upload_files');   
        //Getting coords of elemets to insert results
//         var currentID = jQuery(this).attr('id');
//         var resultValSelector = jQuery("#"+currentID).data('val_target');
//   		var resultHtmlSelector = jQuery("#"+currentID).data('html_target');

// console.log(resultValSelector+ "|"+resultHtmlSelector+"| #"+currentID);
//  		var image_gallery=document.getElementById(currentID).value;
        
//         fd.append('post_id', ''); 
// 		fd.append('image_gallery',image_gallery); 
// 		  if(typeof feedbacklink !== 'undefined'){
		  
		//[your-name] <info@laordesign.com>
		  	jQuery.ajax({
		            type: 'POST',
		            url:"https://clippingmagic.com/api/v1/images?csrfToken=rvc2i9g6nunrsp6v55eo276opgsv603t7n79tfqhhfp8jeuept0o",
		            data: fd,
		            contentType: false,
		            processData: false,
				    dataType: "json",
				    success: function(response){ 
				    	console.log(response);
					    
				    }
		        });
		  });
         
    
  jQuery(".addon-wrap-1100-background-images-1 .input-textx").change(function () {
  	// body...
  		




  		return false;
		/*  var data = new FormData();
		jQuery(".addon-wrap-1100-background-images-1 .input-text").each(function(i, file) {
		    data.append('image', file);
		});*/
		var data = new FormData();
        var files_data =  jQuery('.input-text'); 
     
         //jQuery.each( jQuery(files_data), function(i, obj) {
             jQuery.each(jQuery(".form-row-wide .form-row ").files,function(j,file){
                data.append('my_file_upload[' + j + ']', file);
            })
        //});
		console.log("*******");
		console.log(data);
		jQuery.ajax({type:"POST", 
			url:"https://clippingmagic.com/api/v1/images?csrfToken=rvc2i9g6nunrsp6v55eo276opgsv603t7n79tfqhhfp8jeuept0o",
		    cache: false,
		    contentType: false,
		    processData: false,
		     dataType: 'text/html',
		    beforeSend: function( xhr ) {
			    xhr.overrideMimeType( "text/plain; enctype=multipart/form-data" );
			  },
		    
		    method: 'POST',
		    data:data, 
		    success:function(d){console.log(d)} 
		});
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
