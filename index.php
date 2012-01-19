<?php
session_start();

require("facebook.php");

$facebook = new Facebook(array(  
    'appId'  => '229145840478188',  
    'secret' => '8331b4225e283125ceaece6725765242',  
    'cookie' => true  
)); 

# Get the feed of ceids  
try {
	$at = $facebook->getAccessToken();
  	$ceids = $facebook->api('/113308478750658'); 
	//$ceids = $facebook->api('/me/feed');		
} catch (Exception $e){} 

$feed = json_decode(json_encode($facebook->api('/113308478750658/feed')));

//print_r($feed->data[0]->message);

$nposts = count($feed->data);

$posts = array();

/*for($i=0;$i<=1;$i++){
	//array_push($posts,$feed->data[$i]->message);
	
	if($feed->data[$i]->link == null){
		echo "null";
	}
	else {
		echo $feed->data[$i]->link;
	}
}*/

//print_r($posts);

?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="generator" content="Bluefish 2.0.3" />
<meta name="robots" content="index,follow" />
<meta name="title" content="Círculo de Estudios, Investigación y Desarrollo de Software" />
<meta name="description" content="Círculo de Estudios,Investigación y Desarrollo de Software de la Universidad de Lima que fomenta la investigación e implementa soluciones que satisfagan los requerimientos de sus clientes y forma integralmente a sus miembros." />
<meta name="author" content="Daniel Flores" />
<meta name="keywords" content="universidad de lima, ulima, ceids, circulo de estudios, investigacion y desarrollo de software"/>
<meta name="category" content="Educación"/>
<meta name="rating" content="General"/>
<meta name="language" content="Español"/>
<meta name="robots" content="All"/>
<title>Ceids 2.0</title>
<link rel="stylesheet" href="styles/estilo.css" type="text/css" media="screen" />
<link rel="shortcut icon" href="favicon.ico" />
<link href='http://www.ceids.herobo.com/favicon.ico' rel='shortcut icon' type='image/x-icon'/>
<link href='http://www.ceids.herobo.com/favicon.ico' rel='shortcut icon' type='image/x-icon'/>

<script type="text/javascript" src="js/autext.js"></script>
<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="js/slider.js"></script>      
<script type="text/javascript">

$(window).load(function(){
	
	$("#publish-send").click(function(){
		cont = document.querySelector("#publish-textarea").value;
		txt = encodeURIComponent(cont);		
		$.ajax({
		   type: "POST",
		   url: "post.php",
		   data: "cont=" + txt + "&title=" + $("#title").val(),
		   success: function(msg){
			   alert(msg);
		   }
		});
	});
	
	var textarea = $("#publish-textarea");
		
	textarea.keydown(function(event){
		if(event.keyCode == '32'){	
				
				//var cont =  $('<div/>').text($(this).val()).html();
				cont = document.querySelector("#publish-textarea").value;
				txt = encodeURIComponent(cont);
				$.ajax({
				   type: "POST",
				   url: "extract.php",
				   data: "cont=" + txt,
				   success: function(msg){
					//. 
				   }
				});
			}
	});
	
	/*textarea.keyup(function(event){
		if(event.keyCode == '17'){		
			if(typeof student.url == "undefined"){
				var val =  $('<div/>').text($(this).val()).html();
				student.action = "writting";
				student.textarea = val;
				socket.send(student); 
			}
		}
	});*/
	
	/*$(".app").click(function(){
		$(this).find(".app-metainfo").toggle("fast");
	});*/
	
	/*-----------------
		SLIDER
	-------------------*/
	slider();
					
	/*-----------
		LOGOUT
		------------*/
		
		$(".logout").click(function(){
			window.location.href = "logout.php";
			});
			
	/*$(".postmin").click(function(){
		$(this).html($(this).attr("data-message"));
	});*/
	
});
</script>
</head>
<body>
<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<?php if (!$_SESSION["id"]): ?>
	<script>
    FB.init({
        appId  : '177971028917849',
        status : true, // check login status
        cookie : true, // enable cookies to allow the server to access the session
        xfbml  : true  // parse XFBML
    });
    
    FB.provide("UIServer.Methods",
       { 'permissions.request' : { size : {width: 575, height: 300}, 
                        url: 'connect/uiserver.php',
                    transform : FB.UIServer.genericTransform }
            } );
      
    function fblogin(){
        if(FB.getSession() == null){
            FB.login();
        }
        else{
                $.ajax({
                   type: "GET",
                   url: "login.php",
                   success: function(data){
                     std = JSON.parse(data);
					 $("#fb-login").remove();
					 var user = $('<div class="user">'+
									'<ul>'+
										'<li class="profile">'+
											'<img src="https://graph.facebook.com/' + std.id + '/picture">'+
											'<span>' + std.name + '</span>'+
										'</li>'+
										'<li><a href="slate.php">Mi Slate</a></li>'+
										'<li><a class="logout">Salir</a></li>' +
									'</ul>'+
								'</div>');
									
					user.appendTo(".header-user-inner");
					
                   }
                 });
        }
    }
    </script>
<?php endif ?>



<!--<script type="text/javascript" src="http://widgets.amung.us/tab.js"></script><script type="text/javascript">WAU_tab('lo3w6j0yw7nr', 'left-lower')</script>-->

<div id="header">

	<!--<div class="header-user">
        <div class="header-user-inner">
        
        <?php if ($_SESSION["id"]): ?>
            <div class="user">
           		<ul>
                    <li class="profile">
                        <img src="https://graph.facebook.com/<?php echo $_SESSION["fid"] ?>/picture">
                        <span><?=$_SESSION["name"]?></span>
                    </li>
                    <li><a href="slate.php">Mi Slate</a></li>
					<li><a class="logout">Salir</a></li>
                </ul>
            </div>
            <?php else:?>
            <div class="login">
				<div class="fb_button" id="fb-login" style="margin-top:8px;float:left; background-position: left -188px">          
						<a onClick="fblogin();" style="text-decoration:none" class="fb_button_medium">       
						  <span id="fb_login_text" class="fb_button_text"> 
							Entrar                    
						  </span>                                    
						</a>                                         
				</div>
            </div>
            <?php endif ?>
        </div>
    </div>-->
    
	<div class="inner-header">
    	<span class="logo"><img src="img/logotipo.png" width="120"></span>
        
        <div class="menu">
        	<ul>
            <!--<li><a href="/foros">Foros</a></li>
            <li><a href="/wiki">Wiki</a></li>-->
            </ul>
        </div>
        <div style="clear:both"></div>
    </div>
   
</div>

 
<div id="wrapper">

	<div id="scroll_vista">

        <div id="scroll_cuerpo">
        
                <div class="tira_imagenes">
                	<img src="img/slider/slider4_5.png" name="1" alt="1" />
                	<img src="img/slider/slider1_2.png" name="2" alt="2" />
                	<img src="img/slider/slider2_2.png" name="3" alt="3" />
                </div>
                
        </div>
        
        <div class="navegacion">
            <a href="#" rel="1">&nbsp;</a></span>
            <a href="#" rel="2">&nbsp;</a></span>
            <a href="#" rel="3">&nbsp;</a></span>
        </div>
    
    </div>
	
    <!-- CONTEIN -->
    <div id="cont">
    
    	<!-- TEAMS -->
        <div id="teams">
            <div class="team web">
			<div class="team-img"><img src="img/teams/web.png"/></div>
            <h3 class="team-title">Aplicaciones Web</h3>
			<p>Desarrollo de aplicaciones e investigación de tecnologías web. Actualmente se enfoca en la creación de juegos con HTML5 y Javascript.</p>
            </div>
            
            <div class="team metodologias-agiles">
			<div class="team-img"><img src="img/teams/agil.png"/></div>
            <h3 class="team-title">Metodologías ágiles</h3>
			<p>Buenas prácticas para trabajar en equipo y aplicar diferentes metodologías para una mejor gestión de los recursos humanos.</p>
            </div>
			
			<div class="team android">
            <div class="team-img"><img src="http://movilae.com/img/movilae/2009/12/android-top-50-aplicaciones.jpg" alt="Team Android" /></div>
			<h3 class="team-title">Aplicaciones Android</h3>
			<p>Desarrollo de aplicaciones e investigación para dispositivos móviles Android. Conformada por jóvenes y expertos programadores en JAVA. </p>
            </div>
        </div>
		
		<!-- PROJECTS -->
		<div id="projects">
		
		</div>
		<!-- -->
        
    	<!-- NEWS -->
        <div id="events">
            <h3 class="events-title">Eventos</h3>
            <ul>
            <!--<li><a href="">2da Conferencia sobre Competencia ACM 2011-2012: Capacitación universitaria</a></li>-->
            <li class="event"><a href="http://ulimaibmday.eventbrite.com/">Ulima IBM Day</a><span class="date">(14/04/2011)</span>
				<div class="event-description">
				<!--<img class="event-description-picture" src="http://www.geekets.com/wp-content/uploads/2008/11/ibm-logo.jpg"/>-->
				<strong>Lugar :</strong> Universidad de Lima - Auditorio W.<br/>
				<strong>Inscripciones :</strong> <a href="http://ulimaibmday.eventbrite.com/">http://ulimaibmday.eventbrite.com/</a><br/>
				<strong>Dirigido a : </strong> Alumnos de la Facultad de Ingeniería de Sistemas de la Universidad de Lima.<br/>
				<strong>Organiza :</strong> Facultad de Ingeniería de Sistemas.
				</div>
			</li>
			<li class="event"><a href="blog/ulima-agile-day.php">Ulima Agile Day</a><span class="date">(11/11/2010)</span>
				<div class="event-description">
					En Noviembre de 2010, se realizó el evento ULIMA Agile Day. El evento estuvo dirigido a la comunidad académica de la Universidad de Lima y el público en general.
				</div>
			</li>
            </ul>              
        </div><!-- / EVENTS -->
        
        <!-- SLATES -->
        <!--<div id="slates">
        	<div class="slates-title">Pizarras</div>
            <ul>
            <li class="empty">Aún no tenemos contenido</li>
            <li class="web"><i></i><a href="">Documentación sobre HTML5</a></li>
            <li class="android"><i></i><a href="">Actualización de código</a></li>
            </ul>              
        </div>--><!-- / BLOGS -->
		
		<div id="feed">
			<h3 class="feed-title">Noticias</h3>
			<ul>
			<?php
			
			for($i=0;$i<=4;$i++){
				//array_push($posts,$feed->data[$i]->message);
				
				if($feed->data[$i]->link == null){
					
					$message = preg_replace('/\n/', '&nbsp;', $feed->data[$i]->message);
					
					if(strlen($message) > 50 ){
						$message_min = substr($message,0,50);
						echo "<li class='post postmin' data-message='" . $message . "'><i class='message'></i>" . utf8_decode($message_min) ." ...</li>";
					}
					else {
						echo "<li class='post'><i class='message'></i>" . utf8_decode($message) ."</li>"; 
					}
				}
				else {
					if(strlen($feed->data[$i]->link) > 50){
						$mlink = substr($feed->data[$i]->link,0,50) . "...";
						echo "<li class='post'><i class='link'></i><a href='" . $feed->data[$i]->link . "'>" . $mlink . "</a></li>";
					} else {
						echo "<li class='post'><i class='link'></i><a href='" . $feed->data[$i]->link . "'>" . $feed->data[$i]->link . "</a></li>";
					}
				}
			}
			?>			
			</ul>
		</div>
        
        <!-- APPS -->
        <div id="apps">
			<h3 class="feed-title">Aplicaciones</h3>
                
                <!-- APP -->
                <div class="app">
                
                <!--<div class="app-image">
                	<img src="http://profile.ak.fbcdn.net/hprofile-ak-snc4/174846_101438079941277_7455776_n.jpg" width="50">
                </div>-->
                
                <div class="app-info">
                	<div class="app-title"><a href="http://www.facebook.com/apps/application.php?id=101438079941277">SchedUL</a></div>
                    <div class="app-description">Aplicación para guardar y compartir horarios de la Universidad de Lima, además halla coincidencias entre los mismos.</div>
                </div>
                
                <div class="app-metainfo">
                	<!--<div class="app-developers">Desarrolladores : <br/>
                   		<img class="app-developer" src="http://profile.ak.fbcdn.net/hprofile-ak-snc4/186155_1440246516_6500249_q.jpg"/>
                    </div>-->
                    <div class="app-link">Enlace : <br/>
                    	<a href="http://www.facebook.com/apps/application.php?id=101438079941277">http://www.facebook.com/apps/application.php?id=101438079941277</a>
                    </div>
                </div>
                
                <div style="clear:both"></div>
                </div> <!-- / APP -->
                
                <!-- APP -->
                <div class="app">
                
                <!--<div class="app-image">
                	<img src="http://www.cs.umd.edu/class/winter2011/cmsc389c/Projects/P2/tic_tac_toe.jpg" width="50">
                </div>-->
                
                <div class="app-info">
                	<div class="app-title"><a href="https://github.com/dnielF/Tic-Tac-Toe-HTML5-Node.js">Michi</a></div>
                    <div class="app-description">Juego de tres en raya creado en HTML5, con soporte multijugador gracias a Node.JS y Socket.io</div>
                </div>
                
                <div class="app-metainfo">
                	<!--<div class="app-developers">Desarrolladores : <br/>
                   		<img class="app-developer" src="http://profile.ak.fbcdn.net/hprofile-ak-snc4/186155_1440246516_6500249_q.jpg"/>
                    </div>-->
                    <div class="app-link">Enlace : <br/>
                    	<a href="https://github.com/dnielF/Tic-Tac-Toe-HTML5-Node.js">https://github.com/dnielF/Tic-Tac-Toe-HTML5-Node.js</a>
                    </div>
                </div>
                
                <div style="clear:both"></div>
                </div> <!-- / APP -->
                
			<div style="clear:both"></div>
            </div><!-- / APPS -->
            
            <!-- MIEMBROS -->
            <!--<div class="students">
            	<div class="students-header">
                CEIDS Students
                </div>
                <div class="student"><img src="http://profile.ak.fbcdn.net/hprofile-ak-snc4/186155_1440246516_6500249_q.jpg"/></div>
                <div class="student"><img src="http://profile.ak.fbcdn.net/hprofile-ak-snc4/49149_100001456197604_4120_q.jpg"/></div>
                <div class="student"><img src="http://profile.ak.fbcdn.net/hprofile-ak-snc4/27432_100000661905255_3388_q.jpg"/></div>
                <div class="student"><img src="http://profile.ak.fbcdn.net/hprofile-ak-snc4/174294_607703626_990063_q.jpg"/></div>
                <div class="student"><img src="http://profile.ak.fbcdn.net/hprofile-ak-snc4/41468_653345419_140_q.jpg"/></div>
                <div class="student"><img src="http://profile.ak.fbcdn.net/hprofile-ak-snc4/49057_659218782_3438_q.jpg"/></div>
                <div class="student"><img src="http://profile.ak.fbcdn.net/hprofile-ak-snc4/41506_591060712_1245289_q.jpg"/></div>
            </div>-->
            
        <!--</div>-->
        
        <div style="clear:both"></div>
	</div>
<div style="clear:both"></div>
</div>

<div id="footer">
CEIDS v0.2 - 2011
</div>
</body>
</html>

