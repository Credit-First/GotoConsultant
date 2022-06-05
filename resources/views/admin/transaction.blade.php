@extends('layout.private')
@section('title', $title)
@section('description', $description)
@section('content')
<div class="member-wrapper">
  @include('elements.admin_sidebar')
  <div class="content-wrapper adminprof">
    <div class="single-page">
      <div class="pages-heading">
        <h2>@lang('admin_sidebar.transactions')</h2>
      </div>

      <div class="pages-top-sec"> <!-- Filters Block Start -->
        <div class="sort-section">

          <div class="dropdown-box">
            <label for="consultant">@lang('member.consultant'): </label>
            <select id="consultant" name="consultant" class="consultant form-control">
              <option value="All" {{$search['consultant'] == 'All' ? 'selected' : ''}}>@lang('member.all')</option>
              @foreach($consultants as $consultant)
              <option value="{{$consultant->id}}" {{$consultant->id == $search['consultant'] ? 'selected' : ''}}>
                  {{$consultant->user->first_name}} {{$consultant->user->last_name}}
              </option>
              @endforeach
            </select>
          </div>

          <div class="dropdown-box">
            <label for="date">@lang('member.date'): </label>
            <input type="text" class="form-control date-picker" id="desktop_date" readonly>
          </div>

          <div class="ml-auto">
            <button id="desktop_filter" class="filter_btn">@lang('member.filter')</button>
          </div>

        </div>
      </div> <!-- Filters Block End -->

      <div class="status-section admin-page">
          <table class="table table-borderless responsive" id="transaction">
          <thead class="table-header">
            <th>@lang('admin.payer')</th>
            <th>@lang('admin.receiver')</th>
            <th>ID NR</th>
             <th>@lang('admin.amount_excl_vat')</th>
            <th>@lang('member.vat_amount')</th>
            <th>@lang('admin.tax_percent')</th>
            <th>@lang('admin.vat_percentage')</th>
            <th>@lang('admin.subtotal_incl_vat')</th>
            <th>@lang('admin.gtc_fee_incl_vat')({{$settingsFee}} %)</th>
            <th>@lang('admin.status')</th>
            <th></th>
          </thead>
          <tbody>

          @foreach ($transactions as $transaction)
            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <div class="avatar"></div>
                  <span>{{$transaction->payer_name}}</span>
                </div>
              </td>
              <td>
                <div class="d-flex align-items-center">
                  <div class="avatar"></div>
                  <span>{{$transaction->receiver_name}}</span>
                </div>
              </td>
              <td>№:{{$transaction->id}}:{{$transaction->transaction_id}}</td>
              <td>{{$transaction->amount}} kr</td>
              <td>{{$transaction->vat_amount}} kr</td>
              <td>{{$tax_percent}} %</td>
              <td>{{$transaction->vat_amount / $transaction->total_amount * 100}} %</td>
              <td>{{ $transaction->total_amount / 100 * $settingsFee}} kr</td>
              <td>{{$transaction->total_amount - ( $transaction->total_amount / 100 * $settingsFee ) }} kr</td>
              <td>{{$transaction->status_label}} </td>
              <td>
                <a href="#" onclick="javascript:deleteTransaction({{$transaction->id}})"><i class="fa fa-remove a_link"></i></a>
              </td>
            </tr>
            @endforeach

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/MonthPicker.min.js') }}"></script>
<script>
  const data = @json($transactions);
  const search = @json($search);
	transactions(data, search);

    $(".dataTables_filter > label").css("display", "none")

  function deleteTransaction(transaction_id) {
    if(!confirm('Do you want to delete selected transaction ?')) return;

    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/admin-delete-transaction/' + transaction_id,
      data: {},
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e) {
          document.location.reload()
        } else {
          alert("Error occured deleting transaction !");
        }
      }
    });

  }
</script>
@endsection
