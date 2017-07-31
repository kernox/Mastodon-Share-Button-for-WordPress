function msb_action(plugin_url, message){

    console.log(window.location.origin);
    document.cookie = 'msb_message='+encodeURI(message)+'; path=/';

    window.open(plugin_url + 'feed.php', 'msb_feed', 'left=100px,right=100px,menubar=no,location=no,width=490px,height=550px,resizable=no,titlebar=no,toolbar=no,scrollbar=no');
}