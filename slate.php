<?php
session_start();
?>
<!doctype html>
<html>
<head>
<title>Ceids Slate</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="styles/slate.css" />
<link href='http://www.ceids.herobo.com/favicon.ico' rel='shortcut icon' type='image/x-icon' />
<link href='http://www.ceids.herobo.com/favicon.ico' rel='shortcut icon' type='image/x-icon' />

<script type="text/javascript" src="js/autext.js"></script>
<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>

<script type="text/javascript" src="js/user-tools.js"></script>

<script type="text/javascript">
// GLOBALS
var url = null;
	
window.onload = function(){

	/*-------------------------------------------
		SLATE
	------------------------------------------*/
	
	var ncols = ($("#slate").width()/340).toFixed();
										
	var col = [];
					
	// CREATE COLUMNS ACCORD TO THE SCREEN SIZE
					
	for(var i=0;i<ncols;i++){
		col[i] = $('<section class="col ' + i + '"/>');
		col[i].appendTo($("#slate"));
	}

	// LOAD POSTS
	
	$.ajax({
				   type: "GET",
				   <?php if(isset($_GET["id"])): ?>
				   url: "load.php?id=<?=$_GET["id"]?>",
				   <?php else: ?>
				   url: "load.php",
				   <?php endif ?>
				   success: function(msg){
					   //console.log(msg);
					   posts = JSON.parse(msg);
					   
						var n =0;
					   for(n;n<posts.length;n++){
								
				// POST TEXT
				if(posts[n].type == "text"){							 
					var post = $('<article class="post text" data-post-id="' + 1 + '">'+
											'<!--<div class="info-post"><img src="'+1+'"><span class="nameStudent">'+1+'</span></div>-->'+
											'<div class="contein-post" style="background:' + 
											1 + '">' + posts[n].post + '</div>'+
											'<footer>'+
											'<img src="'+1+'"><span class="nameStudent">'+1+'</span>'+				
											'<a title="Ocultar comentarios" class="btnHideComments">Ocultar</a>'+
											'<a title="Comenta este aporte" class="btnComment"><span class="nComments">0</span> Comentarios</a>'+
											'</footer>'+
											'</article>');
				}
				// POST URL
				else if(posts[n].type == "url"){
					
					if(posts[n].title.length > 40){			
						posts[n].title = posts[n].title.substring(0,40);
						posts[n].title += " ...";
					}
					
					// There aren't images
					if(posts[n].image == false){				
						var post = $('<article class="post text" data-post-id="' + 1 + '">'+
									'<div class="contein-post" style="background:' + 1 + '">' +
										'<span class="data-title">' + posts[n].title + '</span>'+
										'<span class="data-description">' + posts[n].description + '</span>'+
									'</div>'+
									'<footer>'+
												'<img src="'+1+'"><span class="nameStudent">'+1+'</span>'+				
												'<a title="Ocultar comentarios" class="btnHideComments">Ocultar</a>'+
												'<a title="Comenta este aporte" class="btnComment"><span class="nComments">0</span> Comentarios</a>'+
									'</footer>'+
									'</article>');
					}
					else {
						var post = $('<article class="post text" data-post-id="' + 1 + '">'+
									'<div class="contein-post" style="background:' + 1 + '">' +
										'<span class="data-title">' + posts[n].title + '</span>'+
										'<img src="' + posts[n].image + '"/>' +
										'<span class="data-description">' + posts[n].description + '</span>'+
									'</div>'+
									'<footer>'+
												'<img src="'+1+'"><span class="nameStudent">'+1+'</span>'+				
												'<a title="Ocultar comentarios" class="btnHideComments">Ocultar</a>'+
												'<a title="Comenta este aporte" class="btnComment"><span class="nComments">0</span> Comentarios</a>'+
									'</footer>'+
									'</article>');
									
									
					}
				}
				// POST YOUTUBE
				else if(posts[n].type == "youtube"){			
						var post = $('<article class="post video" data-video-id="' + data.youtube.id + '" data-post-id="' + data.post.id_post + '">'+
									'<div class="contein-post" style="background:' + data.post.background + '">' +
										'<div class="data-title">' + data.youtube.title + '</div>'+
										'<img src="' + data.youtube.thumbnail + '"/>' +
										'<div class="data-description">' + data.youtube.description + '</div>'+
									'</div>'+
									'<footer>'+
												'<img src="'+data.avatar+'"><span class="nameStudent">'+data.name+'</span>'+				
												'<a title="Ocultar comentarios" class="btnHideComments">Ocultar</a>'+
												'<a title="Comenta este aporte" class="btnComment"><span class="nComments">0</span> Comentarios</a>'+
									'</footer>'+
									'</article>');
				}
						
						ncols = $(".col").size();
						ncols = ncols - 1; // 0 1 2 3 4
						scol = null;
						less = $(".0 article").size();
						
						for(var i = 0; i<=ncols;i++){
							if($("." + i + " article").size() <= less){
								scol = "." + i;
								less = $("." + i + " article").size();
							}
						}
						if($(scol + " article:first-child").length > 0){
							$(scol).prepend(post);
						}
						else {
							post.appendTo($(scol));
						}
					  }
				   }
	});
	
	/*-------------------------------------------
		OPT
	------------------------------------------*/
		
	$(".opt-publish").click(function(){
		if($(".students").css("display") != "none"){
			$(".students").toggle();
		}
			$(".publish").toggle("fast");
		
	});
	
	$(".opt-students").click(function(){
		if($(".publish").css("display") != "none"){
			$(".publish").toggle();
		}
		$(".students").toggle("fast");
	});
	
	/*--------------------------------------
		WRITING
	-------------------------------------------*/
	document.querySelector("#publish-textarea").addEventListener("keydown",function(event){
		if(event.keyCode == '32'){	
				cont = document.querySelector("#publish-textarea").value;
				// Detect url
				var reg = /((\b(https?|ftp|file):\/\/|www)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|])/ig;
				
				if(reg.test(cont)){					
					if($("#url-info").length == 0){$("<section id='url-info'/>").appendTo($(".publish").find('section'));}
					document.querySelector("#url-info").style.padding = "10px 5px";
					txt = encodeURIComponent(cont);
					
					$.ajax({
					   type: "POST",
					   url: "extract.php",
					   data: "cont=" + txt,
					   success: function(msg){
						console.log(msg);
						url = JSON.parse(msg);

						document.querySelector("#url-info").style.background = "#FFF";
						document.querySelector("#url-info").style.padding = "5px";
						
						$("#url-info").html('<div class="data-title">' + url.title.substring(0, 47) + ' ...</div>'+
						'<img id="data-img" data-image-id="0" src="' + url.images[0] + '"/>' +
						'<div class="data-description">' + url.description.substring(0,140) + '</div>'+
						'<div style="clear:both"></div>'+
						'<footer id="publish-tools">'+
							'<ul>'+
							'<li title="Siguiente imagen" class="img-previous"></li>'+
							'<li title="Anterior imagen"class="img-next"></li>'+	
							'</ul>'+					
						'</footer>');
						
						id_img = 0;
						
						$(".img-previous").click(function(){
							if(id_img > 0){
								id_img+=1;
								$("#url-info").find("img").attr("data-image-id", url.images[id_img]);
								$("#url-info").find("img").attr("src", url.images[id_img]);
								//student.url.image = $("#url-info").find("img").attr("src");
							}
						});
						
						$(".img-next").click(function(){
							if(id_img <= url.images.length){
								id_img+=1;
								$("#url-info").find("img").attr("data-image-id", url.images[id_img]);
								$("#url-info").find("img").attr("src", url.images[id_img]);
								//student.url.image = $("#url-info").find("img").attr("src");
							}
						});
						
					   }});
				}
			}
	},false);
	
	/*-------------------------------------------
		SEND
	------------------------------------------*/
	
	$("#publish-send").click(function(){
		
		var parameters = null;
		var textarea = $("#publish-textarea");
		var cont = $('<div/>').text(textarea.val()).html();
		// REPLACES BREAK LINES
		var formatext = cont.replace(/\n\r?/g, '<br />');
		
		txt = encodeURIComponent(formatext);
			
		$(".publish").toggle("fast");
		textarea.val(" ");
		
			if(url != null){
				data = {
					type : 'url',
					title : encodeURIComponent($('<div/>').text(url.title).html()),
					description : encodeURIComponent(url.description),
					image : url.images[id_img]
				}
				
				obj = {data : JSON.stringify(data)}
				parameters = obj;		
			}
			else{
				data = {
					type : 'text',
					text : txt
				}				
				obj = {data : JSON.stringify(data)}				
				parameters = obj;
			}	
		// SEND BY AJAX
		$.ajax({
			type: "POST",
			url: "post.php",
			data: parameters,
			success: function(data){
			
				console.log(data);
				
				data = JSON.parse(data);
								
				// POST TEXT
				if(data.type == "text"){							 
					var post = $('<article class="post text" data-post-id="' + 1 + '">'+
											'<!--<div class="info-post"><img src="'+1+'"><span class="nameStudent">'+1+'</span></div>-->'+
											'<div class="contein-post" style="background:' + 
											1 + '">' + decodeURIComponent(data.text) + '</div>'+
											'<footer>'+
											'<img src="'+1+'"><span class="nameStudent">'+1+'</span>'+				
											'<a title="Ocultar comentarios" class="btnHideComments">Ocultar</a>'+
											'<a title="Comenta este aporte" class="btnComment"><span class="nComments">0</span> Comentarios</a>'+
											'</footer>'+
											'</article>');
				}
				// POST URL
				else if(data.type == "url"){
	
					if(data.title.length > 40){			
						data.title = data.title.substring(0,40);
						data.title += " ...";
					}
					
					// There aren't images
					if(data.image == false){				
						var post = $('<article class="post text" data-post-id="' + 1 + '">'+
									'<div class="contein-post" style="background:' + 1 + '">' +
										'<span class="data-title">' + data.title + '</span>'+
										'<span class="data-description">' + data.description + '</span>'+
									'</div>'+
									'<footer>'+
												'<img src="'+1+'"><span class="nameStudent">'+1+'</span>'+				
												'<a title="Ocultar comentarios" class="btnHideComments">Ocultar</a>'+
												'<a title="Comenta este aporte" class="btnComment"><span class="nComments">0</span> Comentarios</a>'+
									'</footer>'+
									'</article>');
					}
					else {
						var post = $('<article class="post text" data-post-id="' + 1 + '">'+
									'<div class="contein-post" style="background:' + 1 + '">' +
										'<span class="data-title">' + data.title + '</span>'+
										'<img src="' + data.image + '"/>' +
										'<span class="data-description">' + data.description + '</span>'+
									'</div>'+
									'<footer>'+
												'<img src="'+1+'"><span class="nameStudent">'+1+'</span>'+				
												'<a title="Ocultar comentarios" class="btnHideComments">Ocultar</a>'+
												'<a title="Comenta este aporte" class="btnComment"><span class="nComments">0</span> Comentarios</a>'+
									'</footer>'+
									'</article>');
									
									
					}
				}
				// POST YOUTUBE
				else if(data.post.type == "youtube"){			
						var post = $('<article class="post video" data-video-id="' + data.youtube.id + '" data-post-id="' + data.post.id_post + '">'+
									'<div class="contein-post" style="background:' + data.post.background + '">' +
										'<div class="data-title">' + data.youtube.title + '</div>'+
										'<img src="' + data.youtube.thumbnail + '"/>' +
										'<div class="data-description">' + data.youtube.description + '</div>'+
									'</div>'+
									'<footer>'+
												'<img src="'+data.avatar+'"><span class="nameStudent">'+data.name+'</span>'+				
												'<a title="Ocultar comentarios" class="btnHideComments">Ocultar</a>'+
												'<a title="Comenta este aporte" class="btnComment"><span class="nComments">0</span> Comentarios</a>'+
									'</footer>'+
									'</article>');
				}
				
				
				
				ncols = $(".col").size();
				ncols = ncols - 1;
				scol = null;
				less = $(".0 article").size();
				for(var i = 0; i<=ncols;i++){
					if($("." + i + " article").size() <= less){
						scol = "." + i;
						less = $("." + i + " article").size();
					}
				}
				
				if($(scol + " article:first-child").length > 0){
					$(scol).prepend(post);
				}
				else {
						post.appendTo($(scol));
					}
				}
			});	// END - SEND BY AJAX						
		});	
}

</script>
</head>
<body>

	<header id="header">
		<div id="logo">
			<span class="img"><img src="img/icon.png" height="22"> </span> <span
				class="text">CEIDS Group</span>
		</div>
		<?php if ($_SESSION["id"]): ?>
		<div id="menu">
			<ul>
				<li class="user"><img src="https://graph.facebook.com/<?php echo $_SESSION["fid"] ?>/picture" width="20"
					height="20" /><a href="/"><?=$_SESSION["name"]?> </a></li>
				<li class="opt-publish">Publicar</li>
			</ul>
		</div>
        <?php endif ?>
		</div>
	</header>

	<div id="page">

		<!-- PUBLISH -->
		<div class='publish'>
			<section>
				<textarea id="publish-textarea" onFocus="autoTextArea(this);"
					placeholder="Publica en tu pizarra"></textarea>
			</section>
			<button id="publish-send">Publicar</button>
		</div>
		<!-- END - PUBLISH -->

		<!-- STUDENTS -->
		<div class='students'>
			<section></section>
		</div>
		<!-- END - STUDENTS -->

		<!-- CONTAINER -->
		<div id="container">
			<!-- SLATE -->
			<div id="slate">

				<div style="clear: both"></div>
			</div>
			<!-- END SLATE -->
		</div>
		<!-- END CONTAINER -->
	</div>
	<!-- END PAGE -->

	<!-- others -->
	<div id="tooltip"></div>

</body>
</html>
