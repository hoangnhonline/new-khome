@if($branchList->count() > 0)
@foreach($branchList as $branch)
<div>
  <label class="checkbox-inline">
  	<input type="radio" value="{!! $branch->id !!}" name="branch_id" class="reqBranchId">
  	<b>{!! $branch->name !!}</b>: {!! $branch->address !!}, {!! $branch->ward->name !!}, {!! $branch->district->name !!}, {!! $branch->city->name !!}
  </label>
</div>
@endforeach
@else
<p style="font-style: italic;font-weight: bold;padding-left: 20px;color:red">Chưa có chi nhánh nào.</p>
@endif