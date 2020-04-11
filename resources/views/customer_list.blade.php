@extends(layout())

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{trans('core.clients')}}</div>
                <div class="card-body">
                    @if(empty($customers))
                        <div class="alert alert-light text-center">
                            {{trans('core.no_registered_customers')}}
                        </div>
                    @else
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>{{trans('core.name')}}</th>
                                    <th>{{trans('core.phone')}}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $customer)
                                    <tr data-id="{{$customer->id}}}">
                                        <td> {{$customer->name}} </td>
                                        <td> {{$customer->phone}} </td>
                                        <td>
                                            <a class="btn btn-sm btn-primary" href="{{action('AdminController@customer', $customer->id)}}">
                                                {{trans('core.manage_vehicles')}}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
