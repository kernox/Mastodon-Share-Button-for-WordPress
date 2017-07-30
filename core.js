function msb_action(plugin_url, message){

    console.log(window.location.origin);
    document.cookie = 'msb_message='+encodeURI(message)+'; path=/';

    window.open(plugin_url + 'feed.php');
}