document.body.addEventListener('htmx:configRequest', function(event) {
    
    // doc https://htmx.org/docs/#config_request_with_events
    event.detail.headers['Authorization'] = getAuthToken(); 
    

    function getAuthToken(){
        const session = appGetCookie('web-app-session-id');
        if (session === null) {
            return '';
        }
        return 'Basic ' + session;
    }

    function appGetCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }
});
