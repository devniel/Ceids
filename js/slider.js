/* SLIDER */
/*
Copyright (c) 2011 Daniel Flores

Permission is hereby granted, free of charge, to any
person obtaining a copy of this software and associated
documentation files (the "Software"), to deal in the
Software without restriction, including without limitation
the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the
Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice
shall be included in all copies or substantial portions of
the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY
KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS
OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR
OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

*/
function slider(){

	$(".navegacion a:first").addClass("active");

	$(".tira_imagenes img").css({'opacity':0});

	$(".tira_imagenes img:first").css({'opacity':1});

	controlCambiar = function(){

	

		empezar = setInterval(function(){

		

			$activo = $(".navegacion a.active").next();

			

			if($activo.length == 0){

			

				$activo = $('.navegacion a:first');

				

				$(".tira_imagenes img").animate({

					'opacity':0

				},500);

				

				$(".tira_imagenes img:first").animate({

					'opacity':1

				},500)

			}

			

			cambiar();

			

			},5000)

	};

				

	cambiar = function(){

	

				var turno = $activo.attr("rel");

				

				$(".navegacion a").removeClass('active');

				

				$activo.addClass('active');

				

				var i=turno;

				

				$(".tira_imagenes img[name='"+(i-1)+"']").animate({

					opacity:0

				},500);

				

				$(".tira_imagenes img[name='"+i+"']").animate({

					opacity:1

				},500)};

				

				controlCambiar();

				

				$(".tira_imagenes img").hover(function(){

					clearInterval(empezar)

				},function(){

					controlCambiar();

				});

				

				$(".navegacion a").click(function(){var rel=$(this).attr('rel');

				

				clearInterval(empezar);$(".tira_imagenes img").animate({'opacity':0},500);

				

				$(".tira_imagenes img[name='" + rel + "']").animate({opacity:1},1000);

				

				controlCambiar();

	});
}