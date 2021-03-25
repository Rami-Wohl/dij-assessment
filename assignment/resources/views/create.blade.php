@extends('layout')

@section('content')
    <div class="row">
        <form action="" method="post">
            @csrf
            <div class="row">
                <div class="col">
                    @if(session()->has('message'))
                        <div class="form-sent">{{ session()->get('message') }}</div>
                    @endif
                    <div class="form-group">
                        <select name="colleague_email" class="form-control">
                            <option {{ old('colleague_email') ? "" : "selected" }} value="">Selecteer een collega</option>
                            @foreach ($users as $user)
                                <option {{ old('colleague_email') === $user->email ? "selected" : "" }} value="{{ $user->email }}">
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('colleague_email')
                        <div class="form-error">Selecteer een gebruiker</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                    <textarea name="message_content" class="form-control" rows="5"
                              placeholder="Plaats hier je bericht*">{{ old('message_content') }}</textarea>
                    </div>
                    @error('message_content')
                        <div class="form-error">Bericht veld mag niet leeg zijn</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Versleutel bericht</button>
        </form>
    </div>
@endsection
