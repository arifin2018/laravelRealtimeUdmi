@extends('layouts.app')
@push('styles')

<style>

@keyframes rotate{
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
.refresh{
    animation: rotate 1.5s linear infinite;
}

</style>


@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Users</div>

                <div class="card-body">
                    <div class="text-center">
                        <img id="circle" class="" height="250" width="250" src="{{ asset('assets/images/circle.png') }}" alt="circle.png">
                        <p id="winner" class="display-1 d-none text-primary">You winner</p>
                    </div>

                    <div class="text-center">
                        <label class="fw-bold h5">Your Bet</label>
                        <select name="" id="bet" class="d-flex flex-column w-100 text-center">
                            <option selected >Not in</option>
                            @foreach (range(1,12) as $number)
                                <option value="" >{{ $number }}</option>
                            @endforeach
                        </select>
                        <hr>
                        <p class="fw-bold h5">Remaining Time</p>
                        <p id="timer" class="h5 text-danger">Waiting to start</p>
                        <hr>
                        <p id="result" class="h1"></p>
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
    const circleElement = document.getElementById('circle');
    const timerElement = document.getElementById('timer');
    const winnerElement = document.getElementById('winner');
    const betElement = document.getElementById('bet');
    const resultElement = document.getElementById('result');

    Echo.channel('game')
    .listen('RemainingTimeChanged', (e)=>{
        timerElement.innerText = e.time;
        circleElement.classList.add('refresh');
        winnerElement.classList.add('d-none');

        resultElement.innerText = '';
        resultElement.classList.remove('text-success');
        resultElement.classList.remove('text-danger');
    })
    .listen('WinnerNumberGenerated', function(e){
        circleElement.classList.remove('refresh');
        winnerElement.innerText = e.number;
        winnerElement.classList.remove('text-danger');

        const bet = betElement[betElement.selectedIndex].innerText;

        if (bet == winner) {
            resultElement.innerText = "You win";
            resultElement.classList.add('text-success');
            }
        else{
            resultElement.innerText = "You lose";
            resultElement.classList.add('text-danger');
        }
    });
</script>

@endpush
