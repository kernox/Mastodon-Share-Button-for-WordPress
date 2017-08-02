function msb_action(site_url, message) {
    document.cookie = 'msb_message='+encodeURI(message)+'; path=/';
    window.open(site_url + '/mastodon-share-feed', 'msb_feed', 'left=100px,right=100px,menubar=no,location=no,width=490px,height=550px,resizable=no,titlebar=no,toolbar=no,scrollbar=no');
}