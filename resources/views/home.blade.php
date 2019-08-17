@extends('layouts.app')

@section('content') 
<style>

    .app-loading .loading-bar
    {
        display: block;
        -webkit-animation: shift-rightwards 1s ease-in-out infinite;
        -moz-animation: shift-rightwards 1s ease-in-out infinite;
        -ms-animation: shift-rightwards 1s ease-in-out infinite;
        -o-animation: shift-rightwards 1s ease-in-out infinite;
        animation: shift-rightwards 1s ease-in-out infinite;
        -webkit-animation-delay: .4s;
        -moz-animation-delay: .4s;
        -o-animation-delay: .4s;
        animation-delay: .4s;
    }
    .loading-bar
    {
        position: fixed;
        display: none;
        top: 0;
        left: 0;
        right: 0;
        height: 10px;
        z-index: 800;
        background: #60d778;
        -webkit-transform: translateX(100%);
        -moz-transform: translateX(100%);
        -o-transform: translateX(100%);
        transform: translateX(100%);
        z-index: 9999;
    }

    @-webkit-keyframes shift-rightwards
    {
        0%
        {
            -webkit-transform:translateX(-100%);
            -moz-transform:translateX(-100%);
            -o-transform:translateX(-100%);
            transform:translateX(-100%);
        }

        40%
        {
            -webkit-transform:translateX(0%);
            -moz-transform:translateX(0%);
            -o-transform:translateX(0%);
            transform:translateX(0%);
        }

        60%
        {
            -webkit-transform:translateX(0%);
            -moz-transform:translateX(0%);
            -o-transform:translateX(0%);
            transform:translateX(0%);
        }

        100%
        {
            -webkit-transform:translateX(100%);
            -moz-transform:translateX(100%);
            -o-transform:translateX(100%);
            transform:translateX(100%);
        }

    }
    @-moz-keyframes shift-rightwards
    {
        0%
        {
            -webkit-transform:translateX(-100%);
            -moz-transform:translateX(-100%);
            -o-transform:translateX(-100%);
            transform:translateX(-100%);
        }

        40%
        {
            -webkit-transform:translateX(0%);
            -moz-transform:translateX(0%);
            -o-transform:translateX(0%);
            transform:translateX(0%);
        }

        60%
        {
            -webkit-transform:translateX(0%);
            -moz-transform:translateX(0%);
            -o-transform:translateX(0%);
            transform:translateX(0%);
        }

        100%
        {
            -webkit-transform:translateX(100%);
            -moz-transform:translateX(100%);
            -o-transform:translateX(100%);
            transform:translateX(100%);
        }

    }
    @-o-keyframes shift-rightwards
    {
        0%
        {
            -webkit-transform:translateX(-100%);
            -moz-transform:translateX(-100%);
            -o-transform:translateX(-100%);
            transform:translateX(-100%);
        }

        40%
        {
            -webkit-transform:translateX(0%);
            -moz-transform:translateX(0%);
            -o-transform:translateX(0%);
            transform:translateX(0%);
        }

        60%
        {
            -webkit-transform:translateX(0%);
            -moz-transform:translateX(0%);
            -o-transform:translateX(0%);
            transform:translateX(0%);
        }

        100%
        {
            -webkit-transform:translateX(100%);
            -moz-transform:translateX(100%);
            -o-transform:translateX(100%);
            transform:translateX(100%);
        }

    }
    @keyframes shift-rightwards
    {
        0%
        {
            -webkit-transform:translateX(-100%);
            -moz-transform:translateX(-100%);
            -o-transform:translateX(-100%);
            transform:translateX(-100%);
        }

        40%
        {
            -webkit-transform:translateX(0%);
            -moz-transform:translateX(0%);
            -o-transform:translateX(0%);
            transform:translateX(0%);
        }

        60%
        {
            -webkit-transform:translateX(0%);
            -moz-transform:translateX(0%);
            -o-transform:translateX(0%);
            transform:translateX(0%);
        }

        100%
        {
            -webkit-transform:translateX(100%);
            -moz-transform:translateX(100%);
            -o-transform:translateX(100%);
            transform:translateX(100%);
        }
    }

</style>
<div class="loading-bar"></div>

<div class="container">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Create a Diary Entry
    </button>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create a Diary Entry</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            
            <form action='/entry/store' method='POST' id='createEntryForm' class="form">
                @csrf
                <textarea id='body_textarea' name="body" rows="5" class="form-control"></textarea>
                <br>
                <button   class="btn btn-primary w-100">Save</button>

            </form>

        </div>
        </div>
    </div>
    </div>
    <hr>
</div>


<div id='entries_container' class="container">
    
</div>


<script>
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    function loadData(){
        $.ajax({
            type:'GET',
            url:"{{route('entry.get')}}",
            success: function(data){
                let entries = JSON.parse(data);
                console.log(entries)
                let entries_string = "";

                entries.forEach((e)=>{
                    entries_string += "<div style='border:none' class='card shadow card-body'>"+e.body+"</div><br>"
                })

                $('#entries_container').html(entries_string);
                $("body").removeClass("app-loading");
            }
        })
    }

    
</script>
<script> 
    // Load the initial data from the database
    loadData();
    $("body").addClass("app-loading");

    $('#createEntryForm').submit(function(e){
        e.preventDefault();
        $("body").addClass("app-loading");


        $.ajax({
            type:'POST',
            url:"{{route('entry.store')}}",
            data: $('#createEntryForm').serialize(),
            success: function(data){
                $('#exampleModal').modal('toggle');
                $('#body_textarea').val('');
                loadData();
                $("body").removeClass("app-loading");
            }
        })
    });
    
</script>

@endsection
