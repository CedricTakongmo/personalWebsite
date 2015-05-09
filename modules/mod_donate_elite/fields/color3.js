/**
 * @package		Donate Elite
 * @subpackage  mod_donate_elite
 * @copyright   Copyright (C) 2013 Elite Developers All rights reserved.
 * @license   	GNU/GPL v3 http://www.gnu.org/licenses/gpl.html
 */
/*Minified*/

if(jQuery)(function($){$(document).ready(function(){$('.a_color').acolor();});$.acolor={defaultSettings:{animationSpeed:100,animationEasing:'swing',change:null,changeDelay:0,control:'hue',defaultValue:'',hide:null,hideSpeed:100,inline:false,letterCase:'lowercase',opacity:false,position:'default',show:null,showSpeed:100,swatchPosition:'left',textfield:true,theme:'default'}};$.extend($.fn,{acolor:function(method,data){switch(method){case'destroy':$(this).each(function(){destroy($(this));});return $(this);case'opacity':if(data===undefined){return $(this).attr('data-opacity');}else{$(this).each(function(){refresh($(this).attr('data-opacity',data));});return $(this);}case'rgbObject':return rgbObject($(this),method==='rgbaObject');case'rgbString':case'rgbaString':return rgbString($(this),method==='rgbaString')case'settings':if(data===undefined){return $(this).data('acolor-settings');}else{$(this).each(function(){var settings=$(this).data('acolor-settings')||{};destroy($(this));$(this).acolor($.extend(true,settings,data));});return $(this);}case'value':if(data===undefined){return $(this).val();}else{$(this).each(function(){refresh($(this).val(data));});return $(this);}case'create':default:if(method!=='create')data=method;$(this).each(function(){init($(this),data);});return $(this);}}});function init(input,settings){var acolor=$('<span class="acolor" />'),defaultSettings=$.acolor.defaultSettings;if(input.data('acolor-initialized'))return;settings=$.extend(true,{},defaultSettings,settings);acolor.addClass('acolor-theme-'+settings.theme).addClass('acolor-swatch-position-'+settings.swatchPosition).toggleClass('acolor-swatch-left',settings.swatchPosition==='left').toggleClass('acolor-with-opacity',settings.opacity);if(settings.position!==undefined){$.each(settings.position.split(' '),function(){acolor.addClass('acolor-position-'+this);});}input.addClass('acolor-input').data('acolor-initialized',true).data('acolor-settings',settings).prop('size',7).prop('maxlength',7).wrap(acolor).after('<span class="acolor-panel acolor-slider-'+settings.control+'">'+'<span class="acolor-slider">'+'<span class="acolor-picker"></span>'+'</span>'+'<span class="acolor-opacity-slider">'+'<span class="acolor-picker"></span>'+'</span>'+'<span class="acolor-grid">'+'<span class="acolor-grid-inner"></span>'+'<span class="acolor-picker"><span></span></span>'+'</span>'+'</span>');input.parent().find('.acolor-panel').on('selectstart',function(){return false;}).end();if(settings.swatchPosition==='left'){input.before('<span class="acolor-swatch"><span></span></span>');}else{input.after('<span class="acolor-swatch"><span></span></span>');}if(!settings.textfield)input.addClass('acolor-hidden');if(settings.inline)input.parent().addClass('acolor-inline');updateFromInput(input);}function destroy(input){var acolor=input.parent();input.removeData('acolor-initialized').removeData('acolor-settings').removeProp('size').removeProp('maxlength').removeClass('acolor-input');acolor.before(input).remove();}function refresh(input){updateFromInput(input);}function show(input){var acolor=input.parent(),panel=acolor.find('.acolor-panel'),settings=input.data('acolor-settings');if(!input.data('acolor-initialized')||input.prop('disabled')||acolor.hasClass('acolor-focus'))return;hide();acolor.addClass('acolor-focus');panel.stop(true,true).fadeIn(settings.showSpeed,function(){if(settings.show)settings.show.call(input);});}function hide(){$('.acolor-input').each(function(){var input=$(this),settings=input.data('acolor-settings'),acolor=input.parent();if(settings.inline)return;acolor.find('.acolor-panel').fadeOut(settings.hideSpeed,function(){if(acolor.hasClass('acolor-focus')){if(settings.hide)settings.hide.call(input);}acolor.removeClass('acolor-focus');});});}function move(target,event,animate){var input=target.parents('.acolor').find('.acolor-input'),settings=input.data('acolor-settings'),picker=target.find('[class$=-picker]'),offsetX=target.offset().left,offsetY=target.offset().top,x=Math.round(event.pageX-offsetX),y=Math.round(event.pageY-offsetY),duration=animate?settings.animationSpeed:0,wx,wy,r,phi;if(event.originalEvent.changedTouches){x=event.originalEvent.changedTouches[0].pageX-offsetX;y=event.originalEvent.changedTouches[0].pageY-offsetY;}if(x<0)x=0;if(y<0)y=0;if(x>target.width())x=target.width();if(y>target.height())y=target.height();if(target.parent().is('.acolor-slider-wheel')&&picker.parent().is('.acolor-grid')){wx=75-x;wy=75-y;r=Math.sqrt(wx*wx+wy*wy);phi=Math.atan2(wy,wx);if(phi<0)phi+=Math.PI*2;if(r>75){r=75;x=75-(75*Math.cos(phi));y=75-(75*Math.sin(phi));}x=Math.round(x);y=Math.round(y);}if(target.is('.acolor-grid')){picker.stop(true).animate({top:y+'px',left:x+'px'},duration,settings.animationEasing,function(){updateFromControl(input);});}else{picker.stop(true).animate({top:y+'px'},duration,settings.animationEasing,function(){updateFromControl(input);});}}function updateFromControl(input){function getCoords(picker,container){var left,top;if(!picker.length||!container)return null;left=picker.offset().left;top=picker.offset().top;return{x:left-container.offset().left+(picker.outerWidth()/2),y:top-container.offset().top+(picker.outerHeight()/2)};}var hue,saturation,brightness,opacity,rgb,hex,x,y,r,phi,acolor=input.parent(),settings=input.data('acolor-settings'),panel=acolor.find('.acolor-panel'),swatch=acolor.find('.acolor-swatch'),grid=acolor.find('.acolor-grid'),slider=acolor.find('.acolor-slider'),opacitySlider=acolor.find('.acolor-opacity-slider'),gridPicker=grid.find('[class$=-picker]'),sliderPicker=slider.find('[class$=-picker]'),opacityPicker=opacitySlider.find('[class$=-picker]'),gridPos=getCoords(gridPicker,grid),sliderPos=getCoords(sliderPicker,slider),opacityPos=getCoords(opacityPicker,opacitySlider);switch(settings.control){case'wheel':x=(grid.width()/2)-gridPos.x;y=(grid.height()/2)-gridPos.y;r=Math.sqrt(x*x+y*y);phi=Math.atan2(y,x);if(phi<0)phi+=Math.PI*2;if(r>75){r=75;gridPos.x=69-(75*Math.cos(phi));gridPos.y=69-(75*Math.sin(phi));}saturation=keepWithin(r/0.75,0,100);hue=keepWithin(phi*180/Math.PI,0,360);brightness=keepWithin(100-Math.floor(sliderPos.y*(100/slider.height())),0,100);hex=hsb2hex({h:hue,s:saturation,b:brightness});slider.css('backgroundColor',hsb2hex({h:hue,s:saturation,b:100}));break;case'saturation':hue=keepWithin(parseInt(gridPos.x*(360/grid.width())),0,360);saturation=keepWithin(100-Math.floor(sliderPos.y*(100/slider.height())),0,100);brightness=keepWithin(100-Math.floor(gridPos.y*(100/grid.height())),0,100);hex=hsb2hex({h:hue,s:saturation,b:brightness});slider.css('backgroundColor',hsb2hex({h:hue,s:100,b:brightness}));acolor.find('.acolor-grid-inner').css('opacity',saturation/100);break;case'brightness':hue=keepWithin(parseInt(gridPos.x*(360/grid.width())),0,360);saturation=keepWithin(100-Math.floor(gridPos.y*(100/grid.height())),0,100);brightness=keepWithin(100-Math.floor(sliderPos.y*(100/slider.height())),0,100);hex=hsb2hex({h:hue,s:saturation,b:brightness});slider.css('backgroundColor',hsb2hex({h:hue,s:saturation,b:100}));acolor.find('.acolor-grid-inner').css('opacity',1-(brightness/100));break;default:hue=keepWithin(360-parseInt(sliderPos.y*(360/slider.height())),0,360);saturation=keepWithin(Math.floor(gridPos.x*(100/grid.width())),0,100);brightness=keepWithin(100-Math.floor(gridPos.y*(100/grid.height())),0,100);hex=hsb2hex({h:hue,s:saturation,b:brightness});grid.css('backgroundColor',hsb2hex({h:hue,s:100,b:100}));break;}if(settings.opacity){opacity=parseFloat(1-(opacityPos.y/opacitySlider.height())).toFixed(2);}else{opacity=1;}input.val(convertCase(hex,settings.letterCase));if(settings.opacity)input.attr('data-opacity',opacity);swatch.find('SPAN').css({backgroundColor:hex,opacity:opacity});if(hex+opacity!==input.data('acolor-lastChange')){input.data('acolor-lastChange',hex+opacity);if(settings.change){if(settings.changeDelay){clearTimeout(input.data('acolor-changeTimeout'));input.data('acolor-changeTimeout',setTimeout(function(){settings.change.call(input,hex,opacity);},settings.changeDelay));}else{settings.change.call(input,hex,opacity);}}}}function updateFromInput(input,preserveInputValue){var hex,hsb,opacity,x,y,r,phi,acolor=input.parent(),settings=input.data('acolor-settings'),swatch=acolor.find('.acolor-swatch'),grid=acolor.find('.acolor-grid'),slider=acolor.find('.acolor-slider'),opacitySlider=acolor.find('.acolor-opacity-slider'),gridPicker=grid.find('[class$=-picker]'),sliderPicker=slider.find('[class$=-picker]'),opacityPicker=opacitySlider.find('[class$=-picker]');hex=convertCase(parseHex(input.val(),true),settings.letterCase);if(!hex)hex=convertCase(parseHex(settings.defaultValue,true));hsb=hex2hsb(hex);if(!preserveInputValue)input.val(hex);if(settings.opacity){opacity=input.attr('data-opacity')===''?1:keepWithin(parseFloat(input.attr('data-opacity')).toFixed(2),0,1);input.attr('data-opacity',opacity);swatch.find('SPAN').css('opacity',opacity);y=keepWithin(opacitySlider.height()-(opacitySlider.height()*opacity),0,opacitySlider.height());opacityPicker.css('top',y+'px');}swatch.find('SPAN').css('backgroundColor',hex);switch(settings.control){case'wheel':r=keepWithin(Math.ceil(hsb.s*0.75),0,grid.height()/2);phi=hsb.h*Math.PI/180;x=keepWithin(75-Math.cos(phi)*r,0,grid.width());y=keepWithin(75-Math.sin(phi)*r,0,grid.height());gridPicker.css({top:y+'px',left:x+'px'});y=150-(hsb.b/(100/grid.height()));if(hex==='')y=0;sliderPicker.css('top',y+'px');slider.css('backgroundColor',hsb2hex({h:hsb.h,s:hsb.s,b:100}));break;case'saturation':x=keepWithin((5*hsb.h)/12,0,150);y=keepWithin(grid.height()-Math.ceil(hsb.b/(100/grid.height())),0,grid.height());gridPicker.css({top:y+'px',left:x+'px'});y=keepWithin(slider.height()-(hsb.s*(slider.height()/100)),0,slider.height());sliderPicker.css('top',y+'px');slider.css('backgroundColor',hsb2hex({h:hsb.h,s:100,b:hsb.b}));acolor.find('.acolor-grid-inner').css('opacity',hsb.s/100);break;case'brightness':x=keepWithin((5*hsb.h)/12,0,150);y=keepWithin(grid.height()-Math.ceil(hsb.s/(100/grid.height())),0,grid.height());gridPicker.css({top:y+'px',left:x+'px'});y=keepWithin(slider.height()-(hsb.b*(slider.height()/100)),0,slider.height());sliderPicker.css('top',y+'px');slider.css('backgroundColor',hsb2hex({h:hsb.h,s:hsb.s,b:100}));acolor.find('.acolor-grid-inner').css('opacity',1-(hsb.b/100));break;default:x=keepWithin(Math.ceil(hsb.s/(100/grid.width())),0,grid.width());y=keepWithin(grid.height()-Math.ceil(hsb.b/(100/grid.height())),0,grid.height());gridPicker.css({top:y+'px',left:x+'px'});y=keepWithin(slider.height()-(hsb.h/(360/slider.height())),0,slider.height());sliderPicker.css('top',y+'px');grid.css('backgroundColor',hsb2hex({h:hsb.h,s:100,b:100}));break;}}function rgbObject(input){var hex=parseHex($(input).val(),true),rgb=hex2rgb(hex),opacity=$(input).attr('data-opacity');if(!rgb)return null;if(opacity!==undefined)$.extend(rgb,{a:parseFloat(opacity)});return rgb;}function rgbString(input,alpha){var hex=parseHex($(input).val(),true),rgb=hex2rgb(hex),opacity=$(input).attr('data-opacity');if(!rgb)return null;if(opacity===undefined)opacity=1;if(alpha){return'rgba('+rgb.r+', '+rgb.g+', '+rgb.b+', '+parseFloat(opacity)+')';}else{return'rgb('+rgb.r+', '+rgb.g+', '+rgb.b+')';}}function convertCase(string,letterCase){return letterCase==='uppercase'?string.toUpperCase():string.toLowerCase();}function parseHex(string,expand){string=string.replace(/[^A-F0-9]/ig,'');if(string.length!==3&&string.length!==6)return'';if(string.length===3&&expand){string=string[0]+string[0]+string[1]+string[1]+string[2]+string[2];}return'#'+string;}function keepWithin(value,min,max){if(value<min)value=min;if(value>max)value=max;return value;}function hsb2rgb(hsb){var rgb={};var h=Math.round(hsb.h);var s=Math.round(hsb.s*255/100);var v=Math.round(hsb.b*255/100);if(s===0){rgb.r=rgb.g=rgb.b=v;}else{var t1=v;var t2=(255-s)*v/255;var t3=(t1-t2)*(h%60)/60;if(h===360)h=0;if(h<60){rgb.r=t1;rgb.b=t2;rgb.g=t2+t3;}else if(h<120){rgb.g=t1;rgb.b=t2;rgb.r=t1-t3;}else if(h<180){rgb.g=t1;rgb.r=t2;rgb.b=t2+t3;}else if(h<240){rgb.b=t1;rgb.r=t2;rgb.g=t1-t3;}else if(h<300){rgb.b=t1;rgb.g=t2;rgb.r=t2+t3;}else if(h<360){rgb.r=t1;rgb.g=t2;rgb.b=t1-t3;}else{rgb.r=0;rgb.g=0;rgb.b=0;}}return{r:Math.round(rgb.r),g:Math.round(rgb.g),b:Math.round(rgb.b)};}function rgb2hex(rgb){var hex=[rgb.r.toString(16),rgb.g.toString(16),rgb.b.toString(16)];$.each(hex,function(nr,val){if(val.length===1)hex[nr]='0'+val;});return'#'+hex.join('');}function hsb2hex(hsb){return rgb2hex(hsb2rgb(hsb));}function hex2hsb(hex){var hsb=rgb2hsb(hex2rgb(hex));if(hsb.s===0)hsb.h=360;return hsb;}function rgb2hsb(rgb){var hsb={h:0,s:0,b:0};var min=Math.min(rgb.r,rgb.g,rgb.b);var max=Math.max(rgb.r,rgb.g,rgb.b);var delta=max-min;hsb.b=max;hsb.s=max!==0?255*delta/max:0;if(hsb.s!==0){if(rgb.r===max){hsb.h=(rgb.g-rgb.b)/delta;}else if(rgb.g===max){hsb.h=2+(rgb.b-rgb.r)/delta;}else{hsb.h=4+(rgb.r-rgb.g)/delta;}}else{hsb.h=-1;}hsb.h*=60;if(hsb.h<0){hsb.h+=360;}hsb.s*=100/255;hsb.b*=100/255;return hsb;}function hex2rgb(hex){hex=parseInt(((hex.indexOf('#')>-1)?hex.substring(1):hex),16);return{r:hex>>16,g:(hex&0x00FF00)>>8,b:(hex&0x0000FF)};}$(document).on('mousedown.acolor touchstart.acolor',function(event){if(!$(event.target).parents().add(event.target).hasClass('acolor')){hide();}}).on('mousedown.acolor touchstart.acolor','.acolor-grid, .acolor-slider, .acolor-opacity-slider',function(event){var target=$(this);event.preventDefault();$(document).data('acolor-target',target);move(target,event,true);}).on('mousemove.acolor touchmove.acolor',function(event){var target=$(document).data('acolor-target');if(target)move(target,event);}).on('mouseup.acolor touchend.acolor',function(){$(this).removeData('acolor-target');}).on('mousedown.acolor touchstart.acolor','.acolor-swatch',function(event){var input=$(this).parent().find('.acolor-input'),acolor=input.parent();if(acolor.hasClass('acolor-focus')){hide(input);}else{show(input);}}).on('focus.acolor','.acolor-input',function(event){var input=$(this);if(!input.data('acolor-initialized'))return;show(input);}).on('blur.acolor','.acolor-input',function(event){var input=$(this),settings=input.data('acolor-settings');if(!input.data('acolor-initialized'))return;input.val(parseHex(input.val(),true));if(input.val()==='')input.val(parseHex(settings.defaultValue,true));input.val(convertCase(input.val(),settings.letterCase));hide(input);}).on('keydown.acolor','.acolor-input',function(event){var input=$(this);if(!input.data('acolor-initialized'))return;switch(event.keyCode){case 9:hide();break;case 27:hide();input.blur();break;}}).on('keyup.acolor','.acolor-input',function(event){var input=$(this);if(!input.data('acolor-initialized'))return;updateFromInput(input,true);}).on('paste.acolor','.acolor-input',function(event){var input=$(this);if(!input.data('acolor-initialized'))return;setTimeout(function(){updateFromInput(input,true);},1);});})(jQuery);