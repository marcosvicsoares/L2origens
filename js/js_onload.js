function progress_line() {
	var server_online = 0;
	var server_online_max = 0;
	var percent_online = 0;
	var l2b_servers_container = document.getElementById('l2b_servers_container');

	if ( l2b_servers_container != undefined ) {
		var l2b_servers = l2b_servers_container.querySelectorAll('.server_load');
		var l2b_server_percent = l2b_servers_container.querySelectorAll('.l2b_server_percent');
		var servers_total = l2b_servers.length;
		if (servers_total <= 0) {
			return;
		}
		for ( var i = 0; i < servers_total; i++ ) {
			var l2b_server = l2b_servers[i];
			server_online_max = parseInt(l2b_server.getAttribute('data-server-online-max'));
			server_online = parseInt(l2b_server.getAttribute('data-server-online')) || 0;
			if (server_online < server_online_max) {
				percent_online = parseInt((server_online/server_online_max) * 100);
			} else {
				percent_online = 100;
			}
			l2b_server.style.width = percent_online + "%";
			l2b_server_percent[i].innerHTML = percent_online;
		}
	}
}

$(document).ready(function(){
	progress_line();
	$('.content__sroll').jScrollPane({
         autoReinitialise: true,
					autoReinitialiseDelay: 4000
  });
});

$(document).ready(function() {
    //Default Action
    $("ul#top_tabs_server1 li:first").addClass("active").show(); //Activate first tab
    $(".top_player_block_server_1:first").addClass('top_active_block'); //Show first tab content

    //On Click Event
    $("ul#top_tabs_server1 li").click(function() {
        $("ul#top_tabs_server1 li").removeClass("active"); //Remove any "active" class
        $(this).addClass("active"); //Add "active" class to selected tab
        $(".top_player_block_server_1").removeClass('top_active_block'); //Hide all tab content
        var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
        $(activeTab).addClass('top_active_block'); //Fade in the active content
        return false;
    });
});

$(document).ready(function() {
    //Default Action
    $("ul#top_tabs_server2 li:first").addClass("active").show(); //Activate first tab
    $(".top_player_block_server_2:first").addClass('top_active_block'); //Show first tab content

    //On Click Event
    $("ul#top_tabs_server2 li").click(function() {
        $("ul#top_tabs_server2 li").removeClass("active"); //Remove any "active" class
        $(this).addClass("active"); //Add "active" class to selected tab
        $(".top_player_block_server_2").removeClass('top_active_block'); //Hide all tab content
        var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
        $(activeTab).addClass('top_active_block'); //Fade in the active content
        return false;
    });
});

$(document).ready(function() {
    //Default Action
    $("ul#top_tabs_server3 li:first").addClass("active").show(); //Activate first tab
    $(".top_player_block_server_3:first").addClass('top_active_block'); //Show first tab content

    //On Click Event
    $("ul#top_tabs_server3 li").click(function() {
        $("ul#top_tabs_server3 li").removeClass("active"); //Remove any "active" class
        $(this).addClass("active"); //Add "active" class to selected tab
        $(".top_player_block_server_3").removeClass('top_active_block'); //Hide all tab content
        var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
        $(activeTab).addClass('top_active_block'); //Fade in the active content
        return false;
    });
});

$(document).ready(function() {
    //Default Action
    $("ul#top_tabs_server li:first").addClass("active").show(); //Activate first tab
    $(".top_content_server:first").addClass('top_active_block'); //Show first tab content

    //On Click Event
    $("ul#top_tabs_server li").click(function() {
        $("ul#top_tabs_server li").removeClass("active"); //Remove any "active" class
        $(this).addClass("active"); //Add "active" class to selected tab
        $(".top_content_server").removeClass('top_active_block'); //Hide all tab content
        var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
        $(activeTab).addClass('top_active_block'); //Fade in the active content
        return false;
    });
});

$(document).ready(function() {
	$('.animation_zone').parallax();
	  if (screen.width > 1000 && true) {
    var videoPlayer = document.getElementById("videoBG");
    videoPlayer.play();
    videoPlayer.loop = true;
  } else {
  	videoPlayer = document.getElementById("videoBG").style.display = "none";
  }
});