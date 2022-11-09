<table class="table table-striped ">
    <thead>
        <tr>
            
            <th class="control-label">{{trans('custom.amount')}}</th>
            <th class="control-label">{{trans('custom.date')}}</th>
            <th class="control-label">{{trans('custom.status')}}</th>
        </tr>
    </thead>
    <tbody>
        @if(count($capitalwithdrawlHistory))
        @foreach($capitalwithdrawlHistory as $key => $value)
        <tr>
            <td class="table-data" data-name="{{trans('custom.amount')}}" >${{number_format($value->amount,2)}}</td>
            <td class="table-data" data-name="{{trans('custom.date')}}" >{{date("Y-m-d",strtotime($value->created_at))}}</td>
            <td class="table-data" data-name="{{trans('custom.status')}}">
                
                @if($value->status == 0)
                    <span class="label label-warning">{{trans('custom.pending')}}</span>
                @elseif($value->status == 1)
                    <span class="label label-warning">{{trans('custom.pending')}}</span>
                @elseif($value->status == 2)
                    <span class="label label-success">{{trans('custom.approved')}}</span>
                @elseif($value->status == 3)
                    <span class="label label-danger">{{trans('custom.failed')}}</span>
                @elseif($value->status == 4)
                    <span class="label label-danger">{{trans('custom.declined')}}</span>
                @endif

            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="10" class="no-records text-center">{{trans('custom.no_data_found')}}</td>
        </tr>
        @endif
    </tbody>
</table>
<div class="third-ajax-pag">
    @if(isset($capitalwithdrawlHistory)){{$capitalwithdrawlHistory->render() }}@endif   
</div>