<!DOCTYPE html>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Montserrat|Roboto" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo plugin_dir_url( __FILE__ ) ?>css/feed.css">
</head>
<body>
	<h1><?php  _e('Share on mastodon','mastodon-share-button') ?></h1>

	<label for="instance">Instance with http(s)</label>
	<input type="text" name="instance" id="instance" value=""></p>

	<label for="message">Text of your message</label>
	<textarea name="message" id="message" cols="30" rows="10"><?php echo htmlentities( $_COOKIE['msb_message'] ); ?></textarea>
	<p><button id="send" class="button button-alternative">Send</button></p>

	<script
	src="http://code.jquery.com/jquery-3.2.1.min.js"
	integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
	crossorigin="anonymous"></script>
	<script src="<?php echo plugin_dir_url( __FILE__ ) ?>js/mastodon.js"></script>
	<script>
		var btnSend = document.getElementById('send');
		var instanceUrl = document.getElementById('instance');
		var message = document.getElementById('message');

		btnSend.addEventListener('click', sendToot);

		<?php if ( isset( $_GET['code'] ) ) : ?>
			var api = new MastodonAPI({
				instance: instanceUrl.value,
				api_user_token: ""
			});

			var authCode = '<?php echo $_GET['code']; ?>';

			api.getAccessTokenFromAuthCode(
				localStorage.getItem("mastodon_client_id"),
				localStorage.getItem("mastodon_client_secret"),
				localStorage.getItem("mastodon_client_redirect_uri"),
				authCode,
				function(data) {
					localStorage.setItem('access_token', data['access_token']);
				}
			);
		<?php endif; ?>

		function sendToot(){

			instanceUrl.classList.remove('error');
			message.classList.remove('error');

			if (instanceUrl.value.length == 0){
				instanceUrl.classList.add('error');
			}

			if (message.value.length == 0){
				message.classList.add('error');
			}

			var access_token = localStorage.getItem('access_token');
			console.log(access_token);

			var api = new MastodonAPI({
				instance: instanceUrl.value,
				api_user_token: access_token
			});

			if(access_token == null)
			{
				api.registerApplication("Mastodon Share Button",
					window.location.href,
					["read", "write", "follow"],
					"http://github.com/kernox",
					function(data) {
						localStorage.setItem("mastodon_client_id", data["client_id"]);
						localStorage.setItem("mastodon_client_secret", data["client_secret"]);
						localStorage.setItem("mastodon_client_redirect_uri", data["redirect_uri"]);

						window.location.href = api.generateAuthLink(data["client_id"],
							data["redirect_uri"],
							"code",
							["read", "write", "follow"]
						);
					}
				);
			}
			else
			{
				var result = api.post('statuses',{status: "test bouton mastodon share @hellexis", visibility: "direct"});
				result.promise().then(function(){
					console.log('All is fine !');
				}, function(){
					localStorage.removeItem('access_token');
					sendToot();
				});			
				
			}
		}
	</script>
</body>
</html>

