$(function () {
    $(document).on("focus", ".plate", function() {
        $(this).mask('AAA-0000');
    });
    $(document).on("focus", ".renavam", function() {
        $(this).mask('00000000000');
    });
    $(document).on("focus", ".year", function() {
        $(this).mask('0000');
    });

    // envia formulario do modal adicionar veículo
    $("form#addVehicle").submit(function (event) {
        event.preventDefault();
        button("button#submitAddVehicle").disabled();
        $("form#addVehicle input").prop("disabled", true);

        var vehicle = {};
        vehicle.plate = $("form#addVehicle input#plate").val();
        vehicle.renavam = $("form#addVehicle input#renavam").val();
        vehicle.brand = $("form#addVehicle input#brand").val();
        vehicle.model = $("form#addVehicle input#model").val();
        vehicle.year  = $("form#addVehicle input#year").val();
        vehicle.color = $("form#addVehicle input#color").val();
        vehicle.owner = $("form#customer > input#id").val();

        $.ajax({
            url: base_url('admin/vehicle/add'),
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: vehicle,
            dataType: 'json',
            success: function (data) {
                if(data.status) {
                    vehicle_list.add(JSON.parse(data.vehicle));
                    $("#addVehicleModal").modal('hide');
                    notyf.success({
                        message: data.messages,
                        duration: 5000,
                        icon: false
                    });
                }
                else{
                    $.each(data.messages, function (i, message) {
                        notyf.error({
                            message: message,
                            duration: 5000,
                            icon: false
                        });
                    });
                }
            },
            error: function () {
                notyf.error({
                    message: "An error occurred on the server! :(",
                    duration: 5000,
                    icon: false
                });
            }
        });
    });
    // reseta formulário do modal adicionar veículo
    $("#addVehicleModal").on('hidden.bs.modal',function () {
        $("#addVehicle")[0].reset();
        $("form#addVehicle input").prop("disabled", false);
        button("#submitAddVehicle").enabled();
    });

    // mostrar modal visualizar veículo
    $(document).on('click','#vehicle_list .vehicle-view', function () {
        var vehicle_id = $(this).parents('tr').attr('data-id');
        var data = vehicle_list.get(vehicle_id);

        // set modal
        data.title = `Veículo: ${data.brand} - ${data.model}`;

        var template = $("#vehicle_modal_template").html();
        var vehicle = Mustache.render(template,data);

        $("#VehicleModal .modal-content").html(vehicle);
        $("#VehicleModal form input").prop("disabled", true);
        $("#VehicleModal form button[type=submit]").hide();

        $("#VehicleModal").modal('show');
    });

    // mostrar modal editar veículo
    $(document).on('click','#vehicle_list .vehicle-edit', function () {
        var vehicle_id = $(this).parents('tr').attr('data-id');
        var data = vehicle_list.get(vehicle_id);

        // set modal
        data.title = "Editar Veículo";
        data.form_id = 'EditVehicle';
        data.submit_id = 'submitEditVehicle';
        data.submit_type = 'btn-primary';
        data.submit_text = 'Salvar';

        var template = $("#vehicle_modal_template").html();
        var vehicle = Mustache.render(template,data);

        $("#VehicleModal .modal-content").html(vehicle);
        $("#VehicleModal").modal('show');
    });
    $(document).on('submit','#EditVehicle',function () {
        event.preventDefault();
        button("#VehicleModal button#submitEditVehicle").disabled();
        $("#VehicleModal form input").prop("disabled", true);

        var vehicle = {};
        vehicle.id = $("#VehicleModal form input#id").val();
        vehicle.plate = $("#VehicleModal form input#plate").val();
        vehicle.renavam = $("#VehicleModal form input#renavam").val();
        vehicle.brand = $("#VehicleModal form input#brand").val();
        vehicle.model = $("#VehicleModal form input#model").val();
        vehicle.year  = $("#VehicleModal form input#year").val();
        vehicle.color = $("#VehicleModal form input#color").val();
        vehicle.owner = $("form#customer > input#id").val();

        $.ajax({
            url: base_url('admin/vehicle/update'),
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: vehicle,
            dataType: 'json',
            success: function (data) {
                if(data.status) {
                    console.log(vehicle);
                    vehicle_list.update(vehicle.id,vehicle);

                    $("#VehicleModal").modal('hide');

                    notyf.success({
                        message: data.messages,
                        duration: 5000,
                        icon: false
                    });
                }
                else{
                    $.each(data.messages, function (i, message) {
                        notyf.error({
                            message: message,
                            duration: 5000,
                            icon: false
                        });
                    });
                }

                button("#VehicleModal button#submitEditVehicle").enabled();
                $("#VehicleModal form input").prop("disabled", false);
            },
            error: function () {
                notyf.error({
                    message: "An error occurred on the server! :(",
                    duration: 5000,
                    icon: false
                });

                button("#VehicleModal button#submitEditVehicle").enabled();
                $("#VehicleModal form input").prop("disabled", false);
            }
        });
    });

    // mostrar modal remover veículo
    $(document).on('click','#vehicle_list .vehicle-remove', function () {
        var vehicle_id = $(this).parents('tr').attr('data-id');
        var data = vehicle_list.get(vehicle_id);

        // set modal
        data.title = "Tem Certeza que desja remover esté veículo";
        data.form_id = "RemoveVehicle";
        data.submit_type = 'btn-danger';
        data.submit_text = 'Remover';

        var template = $("#vehicle_modal_template").html();
        var vehicle = Mustache.render(template,data);

        $("#VehicleModal .modal-content").html(vehicle);
        $("#VehicleModal form input").prop("disabled", true);

        $("#VehicleModal").modal('show');
    });
    $(document).on('submit','#RemoveVehicle',function () {
        event.preventDefault();
        var vehicle_id = $("#VehicleModal form input#id").val();

        $.ajax({
            url: base_url('admin/vehicle/remove'),
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {'vehicle_id': vehicle_id},
            dataType: 'json',
            success: function (data) {
                if(data.status) {
                    vehicle_list.del(vehicle_id);

                    $("#VehicleModal").modal('hide');

                    notyf.success({
                        message: data.messages,
                        duration: 5000,
                        icon: false
                    });
                }
                else{
                    $.each(data.messages, function (i, message) {
                        notyf.error({
                            message: message,
                            duration: 5000,
                            icon: false
                        });
                    });
                }
            },
            error: function () {
                notyf.error({
                    message: "An error occurred on the server! :(",
                    duration: 5000,
                    icon: false
                });
            }
        });
    });
});

vehicle_list = {
  get: function(id) {
      var o = null;

      $.each(window.vehicles,function (i,vehicle) {
         if(vehicle.id == id) {
             o = vehicle;
             return;
         }
      });

      return o;
  },
  add: function (data) {
      window.vehicles.push(data);

      var template = $("#vehicle_item_template").html();
      var vehicle = Mustache.render(template,data);

      $("#vehicle_list").append(vehicle);
  },
  update: function(id,data){

      var $vehicle = $("#vehicle_list tr[data-id="+id+"]");
      $vehicle.children('td.vehicle-plate').text(data.plate);
      $vehicle.children('td.vehicle-brand').text(data.brand);
      $vehicle.children('td.vehicle-model').text(data.model);

      var index = null;
      $.each(window.vehicles,function (i,vehicle) {
          if(vehicle.id == id) {
              index = i;
              return;
          }
      });

      window.vehicles[index] = data;
  },
  del: function (id) {
      // remove da veículo da tabela
      $("#vehicle_list tr[data-id="+id+"]").remove();

      // remove veículo da lista global
      var index = null;
      $.each(window.vehicles,function (i,vehicle) {
          if(vehicle.id == id) {
              index = i;
              return;
          }
      });
      window.vehicles.splice(index,1);
  }
};

