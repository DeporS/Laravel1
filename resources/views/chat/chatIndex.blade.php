<html lnag="en">
<head>
    <meta charset="UTF-8"> 
    <title>Chat</title>

    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset('\css\chat.css') }}">
</head>
<body>
    <div class="chat">
        <div class="top">  
            <img src="" alt="Avatar">
            <div>
                <p>Szefito</p>
                <small>Online</small>
            </div>
        </div>
    
        <div class="messages">
            @include('chat.chatReceive', ['message' => "Hey! What's up!"])
        </div>
    
        <div class="bottom">
            <form action="">
                <input type="text" id="message" name="message" placeholder="Enter message..." autocomplete="off">
                <button type="submit"></button>
            </form>
        </div>
    </div>
</body>

<script>
    const pusher = new Pusher('{{config('broadcasing.connections.pusher.key')}}', {cluster: 'eu'});
    const channel = pusher.subscribe('public');

    channel.bind('chat', function (data){
        $.post("/receive", {
            _token: '{{csrf_token()}}',
            message: data.message,
        })
            .done(function (res){
                $(".message > .message").last().after(res);
                $(document).scrollTop($(document).height());
            });
    });

    $("form").submit(function (event){
        event.preventDefault();

        $.ajax({
            url: "chat/broadcast",
            method: "POST",
            headers: {
                'X-Socket-Id' : pusher.connection.socket_id
            },
            data: {
                _token: '{{ csrf_token() }}',
                message: $("form #message").val(),
            }
        }).done(function (res){
            $(".message > .message").last().after(res);
            $("form #message").val('');
            $(document).scrollTop($(document).height());
        });
    });
</script>


</html>