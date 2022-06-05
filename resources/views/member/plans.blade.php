@extends('layout.member')
@section('title', $title)
@section('description', $description)



@section('content')
    <div class="member-wrapper">
        @include('elements.member_sidebar')
        <div class="content-wrapper">
            <div class="single-page">
                <div class="pages-heading">
                    <h2>@lang('member.my-plan')</h2>
                </div>
                <div class="prepaid-card-full">
                    <div class="pay-method table">
                        <div class="status-section">
                            <button id="btn-new-plan" class="btn btn-new mb-4" data-toggle='modal' data-target='#modal-new-plan'>+ Create New Plan</button>
                            <div class="modal fade" id="modal-new-plan" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3>New Plan</h3>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="frm-plan" method="POST" action="{{ route('plan.create') }}">
                                            <div class="modal-body">                                            
                                                @csrf
                                                <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input type="text" class="form-control" name="title" required/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="category">Category</label>
                                                    <input type="text" class="form-control" name="category" required/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea class="form-control" rows="5" name="description" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-save">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <table id="plan-table" class="table table-striped table-bordered"
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Session</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($plans as $plan)
                                        <tr>
                                            <td>{{ $plan->title }}</td>
                                            <td>{{ $plan->category }}</td>
                                            <td>{{ $plan->description }}</td>
                                            <td>
                                                <a class="btn-view-sessions" data-toggle='modal' data-target='#modal-session-view-{{ $plan->id }}'><span id="plan-session-badge-{{$plan->id}}">{{ $plan->sessions->count() > 1 ? $plan->sessions->count() . ' sessions' : $plan->sessions->count() . ' session' }}</span></a>
                                                <div class="modal fade" id="modal-session-view-{{ $plan->id }}" tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h3>Sessions - {{ $plan->title }}</h3>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table id="session-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                                    <thead>
                                                                      <tr>
                                                                        <th scope="col">#</th>
                                                                        <th scope="col">Title</th>
                                                                        <th scope="col">Duration</th>
                                                                        <th scope="col">Price</th>
                                                                        <th scope="col">Action</th>
                                                                      </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @forelse($plan->sessions as $index => $session)
                                                                        <tr id="tr-session-{{ $session->id }}">
                                                                            <td scope="row">{{ $index + 1 }}</td>
                                                                            <td>{{ $session->title }}</td>
                                                                            <td>{{ $session->duration }} mins</td>
                                                                            <td>{{ $session->currency_type }} {{ (float)$session->price }}</td>
                                                                            <td><a class="btn-icon btn-del-session" data-id="{{$session->id}}" data-plan-id="{{$plan->id}}"><i class="fa fa-trash-o red"></i></a></td>
                                                                        </tr>
                                                                        @empty
                                                                        <tr>
                                                                            <td colspan="5">
                                                                                This plan has no sessions.
                                                                            </td>
                                                                        </tr>
                                                                        @endforelse
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ date('Y-m-d', strtotime($plan->updated_at)) }}</td>
                                            <td>
                                                <a class="btn-icon" data-toggle='modal' data-target='#modal-new-session-{{ $plan->id }}'><i class="fa fa-plus green mr-2"></i></a>
                                                <div class="modal fade" id="modal-new-session-{{ $plan->id }}" tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h3>New Session - {{ $plan->title }}</h3>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form id="frm-plan-{{ $plan->id }}" method="POST" action="{{ route('plan.session.create', $plan->id) }}">
                                                                <div class="modal-body">                                            
                                                                    @csrf
                                                                    <div class="form-group">
                                                                        <label for="title">Title</label>
                                                                        <input type="text" class="form-control" name="title" required/>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="category">Duration (minutes)</label>
                                                                        <input type="number" class="form-control" name="duration" min="0" value="0" required/>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="category">Price ({{ $user_detail->currency }})</label>
                                                                        <input type="number" class="form-control" name="price" min="0" value="0" required/>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-save">Save</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a class="btn-icon btn-plan-trash" data-plan-id="{{ $plan->id }}"><i class="fa fa-trash-o red"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">You have no any plans. Please create a plan by clicking the button above.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="trash-modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-flex flex-column items:center justify-content-center text-center">
                    <div class="d-flex justify-content-center text-center w-100 mb-4">
                        <img src="{{asset('images/question-mark.png')}}" width="100" />
                    </div>
                    <h3>Are you sure?</h3>
                    <p>Once deleted it will be gone forever.</p>
                    <input type="hidden" name="planId" />
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center modal-footer">
              <button type="button" id="btn-del" class="btn btn-del w-25">Delete</button>
              <button type="button" class="btn btn-del-cancel w-25" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>
    <div id="trash-session-modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-flex flex-column items:center justify-content-center text-center">
                    <div class="d-flex justify-content-center text-center w-100 mb-4">
                        <img src="{{asset('images/question-mark.png')}}" width="100" />
                    </div>
                    <h3>Are you sure?</h3>
                    <p>Once deleted it will be gone forever.</p>
                    <input type="hidden" name="planId" />
                    <input type="hidden" name="sessionId" />
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center modal-footer">
              <button type="button" id="btn-session-del" class="btn btn-del w-25">Delete</button>
              <button type="button" class="btn btn-del-cancel w-25" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('#plan-table').DataTable({
                rowReorder: true,
                responsive: true,
                searching: false,
                "aaSorting": [],
                "initComplete": function(settings, json) {
                    $(this).removeClass("no-footer");
                }
            });
            $('#session-table').DataTable({
                rowReorder: true,
                responsive: true,
                searching: false,
                "aaSorting": [],
                "initComplete": function(settings, json) {
                    $(this).removeClass("no-footer");
                }
            });
            $('.btn-plan-trash').on('click', function() {
                var planId = $(this).attr('data-plan-id');
                $("#btn-del input[name='planId']").val(planId);
                $("#trash-modal").modal("show");
            });
            $('.btn-del').on('click', function() {
                var planId = $("#btn-del input[name='planId']").val();
                $.ajax({
                    url: "/plan/" + planId,
                    type: "GET",
                    dataType: "JSON",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    }
                });
                window.location.reload();
            });

            $("#btn-session-del").on('click', function() {
                var planId = $("#btn-session-del input[name='planId']").val();
                var sessionId = $("#btn-session-del input[name='sessionId']").val();
                $.ajax({
                    url: "/api/delete-plan-session/" + sessionId,
                    type: "GET",
                    dataType: "JSON",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function(data) {
                        $('#tr-session-' + sessionId).remove();
                        var lenSessions = $('table#session-table > tbody > tr').length;
                        if(lenSessions === 0){
                            var defaultEmptyTr = '<tr><td colspan="5">This plan has no any sessions</td></tr>';
                            $('table#session-table > tbody').html(defaultEmptyTr);
                        }

                        $("#plan-session-badge-" + planId).html(lenSessions);
                    }
                });
            });

            $('.btn-del-session').on('click', function(){
                selectedSessionId = $(this).attr('data-id');
                selectedPlanId = $(this).attr('data-plan-id');
                $("#btn-session-del input[name='planId']").val(selectedPlanId);
                $("#btn-session-del input[name='sessionId']").val(selectedSessionId);
                $("#trash-modal").modal("show");
            });
        });
    </script>
@endsection
