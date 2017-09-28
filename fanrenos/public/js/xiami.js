$(window).load(function() {
	fPlay();
});
$(function() {
	/*显示歌词部分*/
	var scrollt = 0;
	var lytext = new Array(); //放存汉字的歌词 
	var lytime = new Array(); //存放时间
	var line = 0;
	var scrollh = 0;
	var songIndex = 0;
	var mPath = $('#def-path').val();
	/*点击列表播放按钮*/
	$(".player_music").click(function() {
		/*开始放歌*/
		var e = $(this);
		var sid = mPath + '/' + e.attr("data_path");//当前一首
		var songImage = e.parents('.album-b-title').prev('figure').find('img').attr('src');
		songIndex = e.parents('.item-album').index();
		songPrev = mPath + '/' + e.attr("data-prev");//上一首路径
		songNext = mPath + '/' + e.attr("data-next");//下一首路径
		songNextName = e.attr("data-next");//下一首音乐名称
		songTitle = e.prev('.b-title').children('.b-name').attr('title');
		songArtist = e.prev('.b-title').children('.b-art').attr('title');
		songAlbum = e.prev('.b-title').children('.b-alb').attr('title');
		$("#audio").attr("src", sid);
		audio = document.getElementById("audio"); //获得音频元素
		/*显示歌曲总长度*/
		if (audio.paused) {
			audio.play();
		} else{
			audio.pause();
		}
		audio.addEventListener('timeupdate', updateProgress, false);

		audio.addEventListener('play', audioPlay, false);
		audio.addEventListener('pause', audioPause, false);
		audio.addEventListener('ended', audioEnded, false);

		$('#musicTitle').children('span').html(songTitle);
		$('#musicTitle').children('.m-album').html('专辑：'+songAlbum);
		$('#musicTitle').children('.m-artist').html('演唱：'+songArtist);
		/*播放歌词*/
		//播放前的歌词准备
		var ly = getLy(songIndex); //得到歌词
		if (ly.length==0) {
			$("#lyr").html("纯音乐或本歌暂无歌词！");
		}

		var arrly = ly.split("."); //转化成数组
		var tflag = 0;
		for (var i = 0; i < lytext.length; i++) {
			lytext[i] = "";
		}
		for (var i = 0; i < lytime.length; i++) {
			lytime[i] = "";
		}
		$("#lyr").html("");
		document.getElementById("lyr").scrollTop = 0;
		for (var i = 0; i < arrly.length; i++) {
			var str = arrly[i];
			var left = 0; //"["的个数
			var leftAr = new Array();
			for (var k = 0; k < str.length; k++) {
				if (str.charAt(k) == "[") {
					leftAr[left] = k;
					left++;
				}
			}
			if (left != 0) {
				for (var h = 0; h < leftAr.length; h++) {
					var lr = str.substring(str.lastIndexOf("]") + 1);
					var ti = conSeconds(str.substring(leftAr[h] + 1, leftAr[h] + 6));
					if(lr!=''){
						lytext[tflag] = lr; //放歌词
						lytime[tflag] = ti; //放时间
						tflag++;
					}
				}
			}
		}

		//按时间重新排序时间和歌词的数组 
		var temp = null;
		var temp1 = null;
		for (var k = 0; k < lytime.length; k++) {
			for (var j = 0; j < lytime.length - k; j++) {
				if (lytime[j] > lytime[j + 1]) {
					temp = lytime[j];
					temp1 = lytext[j];
					lytime[j] = lytime[j + 1];
					lytext[j] = lytext[j + 1];
					lytime[j + 1] = temp;
					lytext[j + 1] = temp1;
				}
			}
		}

		mPlay(lytext,lytime,scrollh); //显示歌词

		//对audio元素监听pause事件
		/*外观改变*/
		$(".player_music").children('i').css({
			"background":"",
			"color":"",
			"width":"",
			"height":"",
		});
		$(".player_music").children('i').removeClass('am-icon-stop');
		$(".player_music").children('i').addClass('am-icon-play-circle-o');
		$('.item-album').css({
			"background-color":"",
			"border":"none",
		});
		e.css("background-color","#f5f5f5");
		e.children('i').css({
			"background":'url("css/images/T1X4JEFq8qXXXaYEA_-11-12.gif") no-repeat',
			"color":"transparent",
			"width":"15px",
			"height":"22px",
		});
		e.parents('.item-album').css({
			"background-color":"#f0f0f0",
			"border":"1px solid #d8a868",
		});

		/*底部显示歌曲信息*/
		var songName = e.prev('div').find(".b-name").attr('title');
		var singerName = e.prev('div').find(".b-art").attr('title');
		$(".songName").html(songName);
		$(".songPlayer").html(singerName);
		/*换右侧图片*/
		$("#canvas1").attr("src",songImage);
		$(".blur").css("opacity", "0");
		$(".blur").animate({
			opacity: "1"
		}, 1000);

	});
	/*底部进度条控制*/
	var len = $('.pro2').width();
	$(".dian").draggable({
		containment: ".pro2",
		drag: function() {
			var l = $(".dian").css("left");
			var le = parseInt(l);
			audio.currentTime = audio.duration * (le / len);
		}
	});
	/*音量控制*/
	$(".dian2").draggable({
		containment: ".volControl",
		drag: function() {
			var l = $(".dian2").css("left");
			var le = parseInt(l);
			audio.volume = (le / 80);
		}
	});
	/*底部播放按钮*/
	$(".playBtn").click(function() {
		var p = $(this).attr("isplay");
		if (p == 0) {
			$(this).css("background-position", "0 -30px");
			$(this).attr("isplay", "1");
		};
		if (p == 1) {
			$(this).css("background-position", "");
			$(this).attr("isplay", "0");
			$(".player_music").children('i').css({
				"background":"",
				"color":"",
				"width":"",
				"height":"",
			});
			$(".player_music").children('i').removeClass('am-icon-stop');
			$(".player_music").children('i').addClass('am-icon-play-circle-o');
			$('.item-album').css({
				"background-color":"",
				"border":"none",
			});
		};
		if (audio.paused){
			audio.play();
		}
		else{
			audio.pause();
		}
	});
	$(".mode").click(function() {
		var t = calcTime(Math.floor(audio.currentTime)) + '/' + calcTime(Math.floor(audio.duration));
		var p = Math.floor(audio.currentTime) / Math.floor(audio.duration);
	});
	/*切歌*/
	$(".prevBtn").click(function() {
		songPrev = $('.item-album').eq(songIndex).find('.player_music').attr('data-prev');
		if (songPrev.replace(/(^s*)|(s*$)/g,"").length != 0 && songPrev!='undefined') {
			$('.player_music[data_path="' + songPrev + '"]').click();
		}else{
			//当上一首不存在时，自动切换至最后一首
			var songLast = $('.item-album:last').find('.player_music').attr('data_path');
			$('.player_music[data_path="' + songLast + '"]').click();
		}
	});
	$(".nextBtn").click(function() {
		songNext = $('.item-album').eq(songIndex).find('.player_music').attr('data-next');

		if (songNext.replace(/(^s*)|(s*$)/g,"").length != 0 && songNext!='undefined') {
			$('.player_music[data_path="' + songNext + '"]').click();
		}else{
			//当下一首不存在时，自动切换至第一首
			var songFirst = $('.item-album:first').find('.player_music').attr('data_path');
			$('.player_music[data_path="' + songFirst + '"]').click();
		}
	});

});

/*首尾模糊效果*/
function loadBG() {
	var c = document.getElementById("canvas");
	var ctx = c.getContext("2d");
	var img = document.getElementById("canvas1");
	ctx.drawImage(img, 45, 45, 139, 115, 0, 0, 1366, 700);
	stackBlurCanvasRGBA('canvas', 0, 0, 1366, 700, 60);
}

function calcTime(time) {
	var hour;
	var minute;
	var second;
	hour = String(parseInt(time / 3600, 10));
	if (hour.length == 1) hour = '0' + hour;
	minute = String(parseInt((time % 3600) / 60, 10));
	if (minute.length == 1) minute = '0' + minute;
	second = String(parseInt(time % 60, 10));
	if (second.length == 1) second = '0' + second;
	return minute + ":" + second;
}

function updateProgress(ev) {
	/*显示歌曲总长度*/
	var len = $('.pro2').width();
	var songTime = calcTime(Math.floor(audio.duration));
	$(".duration").html(songTime);
	/*显示歌曲当前时间*/
	var curTime = calcTime(Math.floor(audio.currentTime));
	$(".position").html(curTime);
	/*进度条*/
	var lef = len * (Math.floor(audio.currentTime) / Math.floor(audio.duration));
	var llef = Math.floor(lef).toString() + "px";
	$(".dian").css("left", llef);
}
//播放
function audioPlay(ev) {
	$(".iplay").css("background", 'url("./css/images/T1oHFEFwGeXXXYdLba-18-18.gif") 0 0');
	$(".playBtn").css("background-position", "0 -30px");
	$(".playBtn").attr("isplay", "1");
}
//暂停
function audioPause(ev) {
	$(".iplay").css("background", "");
	$(".start em").css({
		"background":'url("css/images/pause.png") no-repeat 50% 50%',
		"color":"transparent"
	});
}
//自动播放
function audioEnded(ev) {
	if (songNextName.replace(/(^s*)|(s*$)/g,"").length != 0 && songNextName!='undefined') {
		$('.player_music[data_path="' + songNextName + '"]').click();
	} else {
		var songAutoNext = $('.item-album:first').find('.player_music').attr('data_path');
		$('.player_music[data_path="' + songAutoNext + '"]').click();
	}
}

function getLy(songIndex) //取得歌词 
{
	var ly = $('.item-album').eq(songIndex).find('.m_lyr').html();
	if(ly.length==0){
		ly = "[00:00].[00:02]纯音乐暂无歌词";
	}
	return ly;
}

function show(t, lytext, lytime,scrollh) //显示歌词 
{
	var len = $('#lyr').width();
	var div1 = document.getElementById("lyr"); //取得层
	document.getElementById("lyr").innerHTML = " "; //每次调用清空以前的一次 
	if (t < lytime[lytime.length - 1]) //先舍弃数组的最后一个
	{
		for (var k = 0; k < lytext.length; k++) {
			//让当前的滚动条的顶部改变一行的高度 
			if (lytime[k] <= t && t < lytime[k + 1]) {
				if(parseInt(lytext[k].length)*12>len){
					if(len==140){
						$('#lyr').css({'height':'275px'});
						scrollh = k * 55;
					}else{
						$('#lyr').css({'height':'225px'});
						scrollh = k * 45;
					}
				}else{
					$('#lyr').css({'height':'149px'});
					scrollh = k * 30;
				}
				div1.innerHTML += "<font color=#f60 style=font-weight:bold>" + lytext[k] + "</font><br>";
			} else if (t < lytime[lytime.length - 1]){
				div1.innerHTML += lytext[k] + "<br>";
			} //数组的最后一个要舍弃
		}
	} else //加上数组的最后一个
	{
		for (var j = 0; j < lytext.length - 1; j++){
			div1.innerHTML += lytext[j] + "<br>";
		}
		div1.innerHTML += "<font color=red style=font-weight:bold>" + lytext[lytext.length - 1] + "</font><br>";
	}
	//写在这边，保证当前歌词处于中间位置
	//快进滚动速度
	if (document.getElementById("lyr").scrollTop <= scrollh){
		document.getElementById("lyr").scrollTop += 15;
	}
	//回退滚动速度
	if (document.getElementById("lyr").scrollTop >= scrollh + 50){
		document.getElementById("lyr").scrollTop -= 15;
	}
}
//此方法暂时无用，内容已被提出
function getReady(songIndex,lytext,lytime) //在显示歌词前做好准备工作 
{
	var scrollh = 0;
	var ly = getLy(songIndex); //得到歌词

	if (ly == "") {
		$("#lry").html("本歌暂无歌词！");
	};
	var arrly = ly.split("."); //转化成数组

	var tflag = 0;
	for (var i = 0; i < lytext.length; i++) {
		lytext[i] = "";
	}
	for (var i = 0; i < lytime.length; i++) {
		lytime[i] = "";
	}
	$("#lry").html(" ");
	document.getElementById("lyr").scrollTop = 0;
	for (var i = 0; i < arrly.length; i++){
		var str = arrly[i];
		var left = 0; //"["的个数
		var leftAr = new Array();
		for (var k = 0; k < str.length; k++) {
			if (str.charAt(k) == "[") {
				leftAr[left] = k;
				left++;
			}
		}
		if (left != 0) {
			for (var h = 0; h < leftAr.length; h++) {
				lytext[tflag] = str.substring(str.lastIndexOf("]") + 1); //放歌词 
				lytime[tflag] = conSeconds(str.substring(leftAr[h] + 1, leftAr[h] + 6)); //放时间
				tflag++;
			}
		}
	}
	//按时间重新排序时间和歌词的数组 
	var temp = null;
	var temp1 = null;
	for (var k = 0; k < lytime.length; k++) {
		for (var j = 0; j < lytime.length - k; j++) {
			if (lytime[j] > lytime[j + 1]) {
				temp = lytime[j];
				temp1 = lytext[j];
				lytime[j] = lytime[j + 1];
				lytext[j] = lytext[j + 1];
				lytime[j + 1] = temp;
				lytext[j + 1] = temp1;
			}
		}
	}
}

function conSeconds(t) //把形如：01：25的时间转化成秒；
{
	var m = t.substring(0, t.indexOf(":"));
	var s = t.substring(t.indexOf(":") + 1);
	m = parseInt(m.replace(/0/, ""));
	var totalt = parseInt(m) * 60 + parseInt(s);
	return totalt;
}

function mPlay(lytext,lytime,scrollh) //开始播放
{
	var ms = audio.currentTime;
	show(ms,lytext,lytime,scrollh);
	window.setTimeout(mPlay,100,lytext,lytime,scrollh);
}

var _st = window.setTimeout;
window.setTimeout = function(fRef, mDelay) {　　
	if (typeof fRef == 'function') {　　
		var argu = Array.prototype.slice.call(arguments, 2);　　
		var f = (function() {
			fRef.apply(null, argu);
		});　　
		return _st(f, mDelay);　　
	}　　
	return _st(fRef, mDelay);　　
}

function fPlay() {
	songFirst = $('.item-album').eq(0).find('.player_music').attr('data-path');
	if (songFirst != '') {
		$('.player_music[data_path="' + songFirst + '"]').click();
	}
}