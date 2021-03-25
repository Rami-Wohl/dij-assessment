@extends('layout')

@section('content')
    <div class="row">
        @if($messageExists)
            <form action="" method="post">
                @csrf
                <div class="row">
                    <div class="col">
                        @if(session()->has('message'))
                            <div class="form-sent">{{ session()->get('message') }}</div>
                        @endif
                        <div class="form-group">
                            <label>
                                <input name="decryption_key" class="form-control" type="password"
                                       placeholder="Wachtwoord"/>
                            </label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Ontsleutel bericht</button>
            </form>
        @else
            <div>Het bericht bestaat niet (meer).</div>
        @endif
    </div>
@endsection
