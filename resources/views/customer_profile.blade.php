@extends(layout())

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('vendor/notyf.min.css')}}">
@endpush

@push('scripts')
    <script src="{{asset('vendor/notyf.min.js')}}" defer></script>
    <script src="{{asset('vendor/mustache.min.js')}}" defer></script>
    <script src="{{asset('vendor/jquery.mask.min.js')}}" defer></script>
    <script src="{{asset('vendor/jquery.validate.min.js')}}" defer></script>
    <script src="{{asset('vendor/messages_pt_BR.min.js')}}" defer></script>
    <script src="{{asset('js/helpers.js')}}" defer></script>
    <script src="{{asset('js/customer.js')}}" defer></script>
    <script>
        window.vehicles = {!! json_encode($vehicles->toArray()) !!}
    </script>
@endpush

@if(isAdmin())
    @section('menu_top')
        <li>
            <a class="btn btn-sm btn-danger" href="{{action('AdminController@index')}}">{{trans('core.back')}}</a>
        </li>
    @endsection
@endif

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><strong>{{trans('core.client')}}</strong></div>
                <div class="card-body">
                    <form id="customer">
                        <input type="hidden" id="id" value="{{$customer->id}}">
                        <div class="form-group">
                            <label for="name">{{trans('core.name')}}</label>
                            <input type="text" class="form-control" id="name" value="{{$customer->name}}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="cpf">{{trans('core.cpf')}}</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" value="{{mask_cpf($customer->cpf)}}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="email">{{trans('core.email')}}</label>
                            <input type="email" class="form-control" id="email" value="{{$customer->email}}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="phone">{{trans('core.phone')}}</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{$customer->phone}}" disabled>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <strong>{{trans('core.vehicles')}}</strong>
                    @if(isAdmin())
                        <button class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#addVehicleModal">{{trans('core.add_vehicle')}}</button>
                    @endif
                </div>
                <div class="card-body">
                    @if($vehicles->isEmpty())
                        <div class="alert alert-light text-center">
                            {{trans('core.no_registered_vehicles')}}
                        </div>
                    @else
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">{{trans('core.plate')}}</th>
                                    <th scope="col">{{trans('core.brand')}}</th>
                                    <th scope="col">{{trans('core.model')}}</th>
                                    @if(isAdmin())
                                        <th scope="col" style="width: 130px"></th>
                                    @else
                                        <th scope="col" style="width: 30px"></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="vehicle_list">
                                @foreach($vehicles as $vehicle)
                                    <tr data-id="{{$vehicle->id}}">
                                        <td class="vehicle-plate">{{$vehicle->plate}}</td>
                                        <td class="vehicle-brand">{{$vehicle->brand}}</td>
                                        <td class="vehicle-model">{{$vehicle->model}}</td>

                                        <td>
                                            <button class="vehicle-view btn btn-sm btn-light"><span class="oi oi-eye"></span></button>
                                            @if(isAdmin())
                                                <button class="vehicle-edit btn btn-sm btn-light"><span class="oi oi-pencil"></span></button>
                                                <button class="vehicle-remove btn btn-sm btn-light"><span class="oi oi-trash"></span></button>
                                            @endif
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


<!-- modal add veículo -->
<div class="modal fade" id="addVehicleModal" tabindex="-1" role="dialog" aria-labelledby="addVehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addVehicleModalLabel">{{trans('core.add_vehicle')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addVehicle" method="post">
                <input type="hidden" name="owner" value="{{$customer->id}}">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="plate">{{trans('core.plate')}}</label>
                            <input type="text" class="form-control plate" id="plate" name="plate" value="" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="renavam">{{trans('core.renavam')}}</label>
                            <input type="text" class="form-control" id="renavam" name="renavam" value="" maxlength="11" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="brand">{{trans('core.brand')}}</label>
                            <input type="text" class="form-control" id="brand" name="brand" value="" maxlength="32" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="model">{{trans('core.model')}}</label>
                            <input type="text" class="form-control" id="model" name="model" value="" maxlength="32" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="year">{{trans('core.year')}}</label>
                            <input type="text" class="form-control year" id="year" name="year" value="" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="color">{{trans('core.color')}}</label>
                            <input type="text" class="form-control" id="color" name="color" value="" maxlength="20" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('core.close')}}</button>
                    <button type="submit" id="submitAddVehicle" class="btn btn-primary">{{trans('core.add')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal add veículo -->

<!-- modal veículo -->
<div class="modal fade" id="VehicleModal" tabindex="-1" role="dialog" aria-labelledby="VehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>
<!-- modal add veículo -->

<!-- templates mustache -->
<script id="vehicle_item_template" type="x-tmpl-mustache">
    <tr data-id="@{{id}}">
        <td class="vehicle-plate">@{{plate}}</td>
        <td class="vehicle-brand">@{{brand}}</td>
        <td class="vehicle-model">@{{model}}</td>
        <td>
            <button class="vehicle-view btn btn-sm btn-light"><span class="oi oi-eye"></span></button>
            <button class="vehicle-edit btn btn-sm btn-light"><span class="oi oi-pencil"></span></button>
            <button class="vehicle-remove btn btn-sm btn-light"><span class="oi oi-trash"></span></button>
        </td>
    </tr>
</script>

<script  id="vehicle_modal_template" type="x-tmpl-mustache">
<div class="modal-header">
    <h5 class="modal-title" id="VehicleModalLabel">@{{title}}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form id="@{{form_id}}" method="post">
    <input type="hidden" id="id" name="id" value="@{{id}}">
    <input type="hidden" id="owner" name="owner" value="@{{owner}}">

    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="plate">{{trans('core.plate')}}</label>
                <input type="text" class="form-control plate" id="plate" name="plate" value="@{{plate}}" required>
            </div>
            <div class="form-group col-md-6">
                <label for="renavam">{{trans('core.renavam')}}</label>
                <input type="text" class="form-control" id="renavam" name="renavam" value="@{{renavam}}" maxlength="11" required>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="brand">{{trans('core.brand')}}</label>
                <input type="text" class="form-control" id="brand" name="brand" value="@{{brand}}" maxlength="32" required>
            </div>
            <div class="form-group col-md-6">
                <label for="model">{{trans('core.model')}}</label>
                <input type="text" class="form-control" id="model" name="model" value="@{{model}}" maxlength="32" required>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="year">{{trans('core.year')}}</label>
                <input type="text" class="form-control year" id="year" name="year" value="@{{year}}" required>
            </div>
            <div class="form-group col-md-6">
                <label for="color">{{trans('core.color')}}</label>
                <input type="text" class="form-control" id="color" name="color" value="@{{color}}" maxlength="20" required>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('core.close')}}</button>
        <button type="submit" id="@{{submit_id}}}" class="btn @{{submit_type}}">@{{submit_text}}</button>
    </div>
</form>
</script>
<!-- templates mustache -->

@endsection
