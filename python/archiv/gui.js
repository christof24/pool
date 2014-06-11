function init() {
		//proxy_stat();
		//checkcerts();
		get_logs();
		status();
		disable_buttons();
		//console.log('init was called');
	}
	function setpassword() {
		pass = $('#newpass').val();
		$.post('php/updateht.php', {password:pass}, function(e) {
			history.go(0)
		}); 
	}
  

    
	function startProxy() {
		$("#proxyLoad").html('<img src="images/ok.gif" width="20" />');
		
		$.get('php/startProxy.php', function(e) {
			setTimeout("$('#proxyLoad').html('');",1000);
			$("#captureData").html('');
			$("#proxyData").html('');
			get_logs()
			
		});	
	}

  function test(box)
    {

		var e = document.getElementById(box);
		var opt = e.options[e.selectedIndex].value;

		$.get("php/getSwitchFach.php?cat=" + opt, function(data,status){
			//alert("test: " + status);
			$('#switchtyp_fach').html(data)	
		});
		$.get("php/get_sw_from_file.php?filename=" + opt, function(data,status){
			//alert("test: " + status);
			$('#switch_sw').html(data)	
		});
    }

function disable_buttons(){
	$.get('php/check.php', function(data) {
		if (data == 1) {
			$("#start_config").prop('disabled', true);
		}
		else {
			$("#start_config").prop('disabled', false);
		}
					
	});
}


	function get_switch_status() {
		$.get('php/get_steps.php',function(data) {
			alert(data);
			$('#switch_status').html(value)	
		});
	}
	function killall() {
		$("#captureLoad, #proxyLoad").html('<img src="images/load.gif" />');
		$.get('php/killall.php', function(e) {
			setTimeout("$('#captureLoad, #proxyLoad').html('');",1000);
		});	
	}
	function nl2br_js(myString){
		return myString.replace( /\n/g, '<br />\n' );
	}
	function get_logs() {
		//console.log('Logs are being loaded.. Please Wait');
		$.get('perl/logs/logout.txt', function (content) {
				content = nl2br_js(content);
				$('#temp2').html(content);	
				display = $("#konsole").html();
				temp = $("#temp2").html()
				if (display == temp) {
					//console.log('We don\'t need to update');
					//well what we have already, is fine, no need to update
				}
				else {
					console.log('it doesnt match. We need to update the logs');
					$('#konsole').html(content);
					$('#konsole').animate({ scrollTop: ($('#konsole')[0].scrollHeight + 200) }, "fast");	
				}
		});
	}
	function status() {
		$.get('php/status.php',function(data) {
			$('#status').html(data)	
		});
		
	}
	function gen_cert_conf() {
		var val  = $('#server_text_in').val();
		$.post('php/generate_openssl.php', {commonname:val}, function(e) {
			//alert(e);
			$('#server_text_in').val('')
			$('#server_text_result').html('Done!')		
		});
	}
	function clear_log() {
		$.get('php/clearlog.php');
	}
	function wipe_keys() {
		$.get('php/wipekeys.php');
	}
	function gen_dns_conf()  {
	var addr  = $('#dns_text_in').val();
		$.post('php/generate_dns.php', {addr:addr}, function(e) {
		$('#dns_text_in').val('')
		$('#dns_text_result').html('Done!')		
	});
	}

