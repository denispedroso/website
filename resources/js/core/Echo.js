import Echo from 'laravel-echo'

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'key',
    wsHost: window.location.hostname,
    wsPort: 6001,
    disableStats: true,
});

window.Echo.private('occurence.23').listen('OccurenceRegistered', e => {
    console.log('Event dispatched!');
    console.log(e);
});