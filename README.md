<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Laravel Real Time Notifications | Events | Notifications | Websockets | Broadcasting

This project is a basic example of how real time notification work in laravel, In this exmaple we have updated our UI when a notification is broadcasted by listening to it using web sockets. Here is some of the Laravel packages which we have used in this project:

- Laravel Events
- Laravel Notifications
- Laravel Broadcasting
- Laravel Web Sockets

## Steps

Websockets are used to implement realtime, live-updating user interface in may modern apps like fb, twitter etc. When there any kind of update in server a message is typically send over a websocket conection to be handled by the client. Websockets helps to continually pulling server data in order to change the UI on every time when there is any kind of changes in the server side.

### First we need to install pusher 
```
composer require pusher/pusher-php-server "~4.0"
```
### Then we need to setup our env file. 
### Change BROADCAST_DRIVER log to .....
```
BROADCAST_DRIVER=pusher
```
### And set up the pusher keys
### For Localhost setup.... (We are not using pusher here. just using pusher  key inordre to use websockets).
```
PUSHER_APP_ID=local
PUSHER_APP_KEY=local
PUSHER_APP_SECRET=local
PUSHER_APP_CLUSTER=mt1
```
### Change option in config/broadcasting to
```
'options' => [
    'cluster' => env('PUSHER_APP_CLUSTER'),
    'encrypted' => true,
    'host' => '127.0.0.1',
    'port' => 6001,
	'scheme' => 'http'
],
```

### uncomment this line in the config/app.php. Its very important for using the service of broadcasting in our app.
```
App\Providers\BroadcastServiceProvider::class,
```
### now we will create and event and implements it with ShouldBroadcast. [implements ShouldBroadcast] important*.
```
php artisan make:event SampleBroadcastEvent
```
### and in broadcastOn() method create your channel name to identify your broadcasting...

------------------------------------- Now the Receiving Broadcast Part ---------------------------------------

 ### Now the next task is to get the bradcast message and show it in our frontend.

 ### command to install the package echo and pusher using npm
 ```
 npm install --save-dev laravel-echo pusher-js
```
 ### create a route and view for the notifications 

 ### Now uncomment the laravel-echo and pusher-js in the js/bootstrap file.. in resources...

 ### Change js/bootstrap file to...
```
	import Echo from "laravel-echo";

	window.Pusher = require("pusher-js");

	window.Echo = new Echo({
	    broadcaster: "pusher",
	    key: process.env.MIX_PUSHER_APP_KEY,
	    // cluster: process.env.MIX_PUSHER_APP_CLUSTER,
	    wsHost: "127.0.0.1",
	    wsPort: 6001,
	    forceTLS: false,
	    disableStats: true,
	});
```

### Now run and compile the views using the command
```
npm run dev
```
### Now we need to copy this part to our create view for the route notifications

### Note: for private channel, make sure you have CSRF linked to your header and your are logged in. means authenticated user.
```
<script>
    Echo.private('testChannelName')
        .listen('SampleBroadcastEvent', (e) => {
            console.log(e);
        });

</script>
```

### Next to the broadcast routes, the BroadcastServiceProvider also activates the routes/channels.php file. Here is where we define who is allowed to access a private channel.
```
Broadcast::channel('testChannelName', function ($user) {
    return true;
});
```
------------------------------------- Now the Notifications Part ---------------------------------------

### to create a notification use artisan command
```
php artisan make:notification RealTimeNotification
```
### Change the via method to
```
return ['broadcast'];
```

### and a method inside the notitification
```
public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'message' => "$this->message (User $notifiable->id)"
        ]);
    }
```

## License

MIT license.
