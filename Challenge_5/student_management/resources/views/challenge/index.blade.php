@extends('partials.master')

@section('content')
    <div class="card shadow p-3 justify-content-center">
        <div class="card-header text-center">
            <h2 class="card-title card-text">Challenge List</h2>
        </div>

        <div class="card-body">
            @can('create', \App\Models\Challenge::class)
            <div class="row flex-row-reverse mb-3 mr-3">
                <a href="{{ route('challenge.create') }}" class="btn btn-success" role="button">Add challenge</a>
            </div>
            @endcan
            <table class="text-center table table-hover table-bordered mb-0">
                <thead class="thead-light">
                <tr class="">
                    <th>#</th>
                    <th>Name</th>
                    <th>Teacher</th>
                    <th class="w-50">Suggestion</th>
                    <th>Submit</th>
                </tr>
                </thead>
                <tbody>
                @foreach($challenges as $challenge)
                <tr>
                    <td>{{ $challenge->index + 1 }}</td>
                    <td>{{ $challenge->name }}</td>
                    <td>{{ $challenge->user->name }}</td>
                    <td>{{ $challenge->suggestion }}</td>
                    <td>
                        <a href="#submit-modal" data-toggle="modal" data-id="{{ $challenge->id }}"
                           class="btn btn-success btn-sm" role="button">Submit</a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!--Submit Challenge-->

    <div id="submit-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Submit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div id="add-submit-content" class="modal-body">
                    <form id="form-add-submit" data-toggle="modal" method="post" class="form-group align-content-center">
                        <div class="form-group">
                            <label for="answer" class="form-text">Answer</label>
                            <input type="text" id="answer" name="answer" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Submit</button>
                        {{ csrf_field() }}
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <div id="modal-correct" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Submit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div id="" class="modal-body text-center">
                    Correct
                    <hr>
                    <div id="correct-content"></div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <div id="modal-incorrect" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Submit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div id="" class="modal-body">
                    <div class="row justify-content-center">
                        <p>Incorrect</p>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        $("#submit-modal").on("show.bs.modal", function (event) {
            let button = $(event.relatedTarget);
            let id = button.data("id");
            $("#form-add-submit").data("id", id);
        })

        $("#form-add-submit").submit(function (event) {
            event.preventDefault();

            let form = $(this);
            let id = form.data('id');
            let data = form.serializeArray();
            data.push({name: "id", value: id});

            $.ajax({
                type: "POST",
                url: "{{ route('challenge.submit') }}",
                data: data,
                typeType: "json",
                success: function (data) {
                    let response = data;
                    if (response.correct === true) {
                        $("#correct-content").html(response.content).wrap('<pre />');
                        $("#modal-correct").modal('show');
                    }
                    else {
                        $("#modal-incorrect").modal('show');
                    }
                }
            });

            $(this).trigger('reset');
            $("#submit-modal").modal('toggle');
        });
    </script>
@endsection
