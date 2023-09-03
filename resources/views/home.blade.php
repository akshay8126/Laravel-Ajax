@extends('layouts.app')

@section('content')
    <h1>user login successfully</h1>
    {{-- {{ Auth::user() }} --}}
    <div id="errors-list"></div>

    <form action="{{ route('logout') }}" method="POST" id="logout">
        @csrf
        <button type="submit" class="btn btn-primary">Logout</button>
    </form>
    <script>
        $(document).ready(function() {
            $("#logout").on("submit", function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(data) {
                        $("#errors-list").append(
                            "<div class='alert alert-success'>" + data.message +
                            "</div>");
                        window.location.replace(data.data)
                    },
                    error: function(data) {
                        console.log(data)

                    }

                });



            });

        })
    </script>
@endsection
