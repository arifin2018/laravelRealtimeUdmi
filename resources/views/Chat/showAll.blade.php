@extends('layouts.app')
@push('styles')

<style>
#users > li{
    cursor: pointer;
}
</style>


@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Chat</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-10">
                            <div class="row">
                                <div class="col-12 border rounded-lg p-3">
                                    <ul id="messages" class="list-unstyled overflow-auto" style="height: 45vh;">
                                    </ul>
                                </div>
                                <form action="" class="row py-3">
                                    <div class="col-10">
                                        <input type="text" id="message" type="text">
                                    </div>
                                    <div class="col-2">
                                        <button type="submit" id="send" class="btn btn-primary btn-block">Send</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-2">
                            <p><strong>Online now</strong></p>
                            <p id ="typing"></p>
                            <ul id="users" class="list-unstyled overflow-auto text-info" style="height: 45vh;">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script src={{ asset('js/app.js')}}></script>
<script>
    const usersElement = document.getElementById('users');
    const usersElementMessages = document.getElementById('messages');
    Echo.join('chat')
    .here((users)=>{
        users.forEach((user, index) => {
            let element = document.createElement('li');
            element.setAttribute('id',user.id);
            element.setAttribute('ondblclick', 'greetUser('+user.id+')');
            element.setAttribute('onclick', 'notifications('+user.id+')');
            element.innerText = user.name;

            usersElement.appendChild(element);
        });
    })
    .joining((user)=>{
        let element = document.createElement('li');
        element.setAttribute('id',user.id);
        element.setAttribute('ondblclick', 'greetUser('+user.id+')');
        element.setAttribute('onclick', 'notifications('+user.id+')');
        element.innerText = user.name;

        usersElement.appendChild(element);
    })
    .leaving((user)=>{
        let element = document.getElementById(user.id);
        element.remove();
    }).listen('MessageSent',function(e){
        let element = document.createElement('li');
        element.setAttribute('id','message'+e.user.id);
        element.innerText = e.user.name+":"+e.message;

        usersElementMessages.appendChild(element);
    }).listen('GreatingChat', function (e) {
        let element = document.createElement('li');
        element.setAttribute('id','message'+e.user.id);
        element.innerText = e.user.name+":"+e.message;

        usersElementMessages.appendChild(element);
    });
</script>
<script>
    const meessageElement = document.getElementById('message');
    const sendElement = document.getElementById('send');

    sendElement.addEventListener('click', (e)=>{
        e.preventDefault();

        try {
            window.axios.post('/chats/store', {
                message:meessageElement.value
            });
        } catch (error) {
            window.axios.get('/login');
        }
        meessageElement.value = ''
    })
</script>
<script>
    function greetUser(id){
        console.log('hai' + id);
        window.axios.post('/chats/greet/' + id);
    };

    function notifications(id){
        window.axios.post('/chats/alert/'+id);
    }
</script>

<script>

    Echo.private('notif.{{ auth()->user()->id }}').listen('NotificationChat',(e)=>{
        alert(e.alert);
    });

</script>

<script>
    Echo.private('chat.{{ auth()->user()->id }}').listen('GreatingChat',(e)=>{
        let element = document.createElement('li');
        element.setAttribute('id','message'+e.user.id);
        element.innerText = e.user.name+":"+e.message;

        usersElementMessages.appendChild(element);
    });
</script>


<script>

    const inputElement = document.getElementById('message');
    const typingElement = document.getElementById('typing');
    let typing = null;
    inputElement.addEventListener("keydown", handleSubmit);

    function handleSubmit(event) {
        if (event.keyCode === 13) {
            typingElement.innerText = '';
            return;
        }
        typingElement.innerText = 'typing...';

        setTimeout(function () {
            typingElement.innerText = '';
        }, 1500);

    }

</script>
@endpush
