@extends('partials.master')

@section('style')
    <style>
        /* Chat containers */
        .message {
            border: 2px solid #dedede;
            background-color: #f1f1f1;
            border-radius: 10px;
            padding: 10px;
            margin: 10px;
        }
    </style>
@endsection


@section('content')
    <div class="row justify-content-center m-auto col-8">
        <div class="card w-100">
            <div class="card-header">
                <p>{{ $receive_user->name }}</p>
            </div>

            <div class="card-body">
                <div class="message">
                    @foreach($messages as $message)
                        @if($user->id == $message->user_id)
                            <div class="message bg-primary text-light text-right">
                                <p>{{ $message->message }}</p>
                                <span>{{$message->created_at->format('H:i')}}</span>
                            </div>
                        @else
                            <div class="message bg-light text-left">
                                <p>{{ $message->message }}</p>
                                <span>{{$message->created_at->format('H:i')}}</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="card-footer">
                <form class="form-group">
                    <div class="form-group">
                        <label for="message">Message</label>
                        <input type="text" class="form-control" name="message" id="message">
                    </div>
                    <input type="submit" name="send" id="send" class="form-control btn-success btn-block" value="Send">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>

    </div>
@endsection

