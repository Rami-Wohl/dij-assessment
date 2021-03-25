@extends('layout')

@section('content')
    <div class="row">
        <form action="" method="post">
            @csrf
            @method('delete')
            <div class="row">
                <div class="col">
                    <div class="form-group">
                    <textarea disabled name="message_content" class="form-control" rows="5"
                              placeholder="Plaats hier je bericht*">{{ $message }}</textarea>
                    </div>
                    <button type="" class="btn btn-primary">Verwijder bericht</button>
                </div>
            </div>
        </form>
    </div>
@endsection
