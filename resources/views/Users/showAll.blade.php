@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Users</div>

                <div class="card-body">
                    <ul id="users">

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script src={{ asset('js/app.js')}}></script>
<script>
    axios.get('/api/user').then((response)=>{
        console.log(response.data.data);
        const usersElement = document.getElementById('users');

        let users = response.data.data;

        users.forEach((user, index) => {
            let element = document.createElement('li');
            element.setAttribute('id',user.id);
            element.innerText = user.name;

            usersElement.appendChild(element);
        });

    });
</script>

<script>
    Echo.channel('users')
    .listen('UserCreated', (e)=>{
        console.log("UserCreated => " + JSON.stringify(e));
        const usersElement = document.getElementById('users');
        let users = e.user;
        let element = document.createElement('li');
        element.setAttribute('id',users.id);
        element.innerText = users.name;
        usersElement.appendChild(element);
    })
    .listen('UserDeleted', (e)=>{
        let users = e.user;
        const usersElement = document.getElementById(users.id);
        usersElement.parentNode.removeChild(usersElement);
    })
    .listen('UserUpdated', (e)=>{
        let users = e.user;
        console.log("UserUpdated => " + JSON.stringify(users.name));
        const usersElement = document.getElementById(users.id);
        usersElement.innerText = users.name;
    });
</script>

@endpush
