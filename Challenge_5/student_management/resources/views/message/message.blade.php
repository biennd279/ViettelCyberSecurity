@extends('partials.master')

@section('style')
    <style>
        /* Chat containers */
        .message {
            border: 2px solid #dedede;
            background-color: #f1f1f1;
            border-radius: 10px;
            padding: 5px;
            margin: 5px;
        }
    </style>
@endsection


@section('content')
    <div class="row justify-content-center m-auto col-10">
        <div class="card w-100 h-100">
            <div class="card-header">
                <p>{{ $receive_user->name }}</p>
            </div>

            <div class="card-body">
                <div class="message">
                    @foreach($messages as $message)
                    @can('view', $message)
                    @if($user->id == $message->user_id)
                    <div class="d-flex justify-content-end align-items-center">
                        <div class="dropdown">
                            <a href="#" class="text-muted mr-3" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false"><i>...</i></a>
                            <div class="dropdown-menu">
                                @can('update', $message)
                                <a href="" class="dropdown-item d-flex align-items-center" data-toggle="collapse"
                                   role="button" data-target="#collapse-message-{{ $message->id }}" aria-expanded="false"
                                   aria-controls="collapse-message-{{ $message->id }}">Edit</a>
                                @endcan
                                @can('delete', $message)
                                <a href="{{ route('message.destroy', ['id' => $message->id]) }}"
                                   class="dropdown-item d-flex align-items-center">Delete</a>
                                @endcan
                            </div>
                        </div>
                        <div class="col-5 message bg-primary text-white">
                            <div>{{ $message->message }}</div>
                            <small>{{$message->created_at->format('H:i')}}</small>
                        </div>
                    </div>
                    <div id="collapse-message-{{ $message->id }}" class="collapse">
                        <form class="d-flex justify-content-end" method="post"
                              action="{{ route('message.update', ['id' => $message->id]) }}">
                            <div class="form-row">
                                <div class="col-auto">
                                    <label>
                                        <input type="text" class="form-control" placeholder="message" name="message"
                                               value="{{ $message->message }}">
                                    </label>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-sm btn-success">Edit</button>
                                </div>
                                {{ csrf_field() }}
                            </div>
                        </form>
                    </div>
                    @else
                    <div class="d-flex align-items-center">
                        <div class="col-5 message bg-light">
                            <div>{{ $message->message }}</div>
                            <small>{{$message->created_at->format('H:i')}}</small>
                        </div>
                    </div>
                    @endif
                    @endcan
                    @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    <form class="form-group" method="post" action="{{ route('message.store', ['id' => $receive_user->id]) }}">
                        <div class="form-group">
                            <label for="message">Message</label>
                            <input type="text" class="form-control" name="message" id="message">
                        </div>
                        <input type="submit" class="form-control btn-success btn-block" value="Send">
                        <input type="hidden" name="receive_user_id" value="{{ $receive_user->id }}">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
@endsection
