<x-master-layout :assets="$assets ?? []">
    <div>
        <?php $id = $id ?? null; ?>
        @if (isset($id))
            {!! Form::model($data, [
                'route' => ['service.update', $id],
                'method' => 'patch',
                'enctype' => 'multipart/form-data',
            ]) !!}
        @else
            {!! Form::open(['route' => ['rent.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">{{ $pageTitle }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="new-user-info">
                            <div class="row">
                                {{-- types --}}
                                <div class="form-group col-md-4">
                                    {{ Form::label('commission_type', __('message.commission_type'), ['class' => 'form-control-label']) }}
                                    <select class="form-control select2js" onchange="fetch_select(this.value);"
                                        name="type" required>
                                        <option value=""></option>
                                        @foreach ($types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- types of --}}
                                <div class="form-group col-md-4">
                                    <label class="form-control-label"> {{ __('message.type_of') }}
                                        <span id="print-ajax"></span>
                                    </label>
                                    <select class="form-control select2js" id="model_types" name="model"
                                        required></select>
                                </div>
                                <div class="form-group col-md-4">
                                    {{ Form::label('brand', __('message.brand'), ['class' => 'form-control-label']) }}
                                    <select class="form-control select2js" id="brands" name="brand" required>

                                    </select>
                                </div>
                                {{-- <div class="form-group col-md-4">
                                    {{ Form::label('name', __('message.name'), ['class' => 'form-control-label']) }}
                                    <select class="form-control select2js"  required>

                                    </select>
                                </div> --}}
                                <div class="form-group col-md-4">
                                    {{ Form::label('name', __('message.name') . ' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                    {{ Form::text('name', old('name'), ['placeholder' => __('message.name'), 'class' => 'form-control', 'required']) }}
                                </div>
                                <div class="form-group col-md-4">
                                    {{ Form::label('colors', __('message.color'), ['class' => 'form-control-label']) }}
                                    <select class="form-control select2js" name="color" required>
                                        <option value="white">White</option>
                                        <option value="black">Black</option>
                                        <option value="gray">Gray</option>
                                        <option value="silver">Silver</option>
                                        <option value="blue">Blue</option>
                                        <option value="red">Red</option>
                                        <option value="brown"> Brown </option>
                                        <option value="green"> Green </option>
                                        <option value="orange"> Orange</option>
                                        <option value="beige"> Beige</option>
                                        <option value="purple"> Purple </option>
                                        <option value="gold">Gold </option>
                                        <option value="yellow">Yellow</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    {{ Form::label('plate_number', __('message.plate_number') . ' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                    {{ Form::text('plate_number', old('plate_number'), ['placeholder' => __('message.name'), 'class' => 'form-control', 'required']) }}
                                </div>
                                <div class="form-group col-md-4">
                                    {{ Form::label('production_date', __('message.production_date') . ' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                    {{ Form::text('production_date', old('production_date'), ['placeholder' => __('message.name'), 'class' => 'form-control', 'required']) }}
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="form-control-label" for="image">{{ __('message.image') }} </label>
                                    <div class="custom-file">
                                        <input type="file" name="vehcile_image" class="custom-file-input"
                                            accept="image/*">
                                        <label
                                            class="custom-file-label">{{ __('message.choose_file', ['file' => __('message.image')]) }}</label>
                                    </div>
                                    <span class="selected_file"></span>
                                </div>

                                @if (isset($id) && getMediaFileExit($data, 'service_image'))
                                    <div class="col-md-2 mb-2">
                                        <img id="service_image_preview"
                                            src="{{ getSingleMedia($data, 'service_image') }}" alt="service-image"
                                            class="attachment-image mt-1">
                                        <a class="text-danger remove-file"
                                            href="{{ route('remove.file', ['id' => $data->id, 'type' => 'service_image']) }}"
                                            data--submit='confirm_form' data--confirmation='true' data--ajax='true'
                                            data-toggle='tooltip'
                                            title='{{ __('message.remove_file_title', ['name' => __('message.image')]) }}'
                                            data-title='{{ __('message.remove_file_title', ['name' => __('message.image')]) }}'
                                            data-message='{{ __('message.remove_file_msg') }}'>
                                            <i class="ri-close-circle-line"></i>
                                        </a>
                                    </div>
                                @endif
                                <div class="form-group col-md-6">
                                    {{ Form::label('description', __('message.description'), ['class' => 'form-control-label']) }}
                                    {{ Form::textarea('description', null, ['class' => 'form-control textarea', 'rows' => 3, 'placeholder' => __('message.description')]) }}
                                </div>
                            </div>
                            <hr>
                            {{ Form::submit(__('message.save'), ['class' => 'btn btn-md btn-primary float-right']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    @section('bottom_script')
        <script type="text/javascript">
            (function($) {
                "use strict";
                $(document).ready(function() {
                    $(document).on('change', '#region_id', function() {

                        var data = $(this).select2('data')[0];

                        var data_distance_unit = $('#region_id').attr('data-distance-unit', )
                        var distance_unit = data.distance_unit != undefined ? data.distance_unit :
                            data_distance_unit;

                        var text = "{{ __('message.distance_in_km') }}";
                        if (distance_unit == 'mile') {
                            text = "{{ __('message.distance_in_mile') }}";
                        }
                        $('#distance_unit').html("* (<small>" + text + "</small>)");
                    });
                });
            })(jQuery);
        </script>
        <script type="text/javascript">
            function fetch_select(val) {
                $.ajax({
                    type: 'get',
                    url: '{{ route('rent.create') }}',
                    datatype: 'json',
                    data: {
                        option: val
                    },
                    success: function(response) {
                        // $('#print-ajax').html(val); //This will print you result
                        switch (val) {
                            case "1":
                                $('#model_types').empty();
                                $('#brands').empty();
                                $('#print-ajax').html("Car");
                                var data = {
                                    names: ['Sedan', 'SUV', 'Coupe', 'Hatchback', 'Minivan'],
                                    brands: [
                                        "Abarth",
                                        "Acura",
                                        "Alfa Romeo",
                                        "Arcfox",
                                        "Aston Martin",
                                        "Audi",
                                        "Baic",
                                        "Bajaj",
                                        "Benelli",
                                        "Bentley",
                                        "Bestune",
                                        "BMW",
                                        "Borgward",
                                        "Brilliance",
                                        "Bugatti",
                                        "Buick",
                                        "Byd",
                                        "Cadillac",
                                        "Chana",
                                        "Changan",
                                        "Canghe",
                                        "Chery",
                                        "Chevrolet",
                                        "Chrysler",
                                        "Citroën",
                                        "Cupra",
                                        "Daewoo",
                                        "Daihatsu",
                                        "Datsun",
                                        "Dayun",
                                        "DFSK",
                                        "Dodge",
                                        "Domy",
                                        "Dongfeng",
                                        "Dorcen",
                                        "Ds",
                                        "Ducati",
                                        "El Wahab",
                                        "Emgrand",
                                        "Exeed",
                                        "Fahd",
                                        "Faw",
                                        "Ferrari",
                                        "Fiat",
                                        "Ford",
                                        "Forthing",
                                        "Foton",
                                        "Fuso",
                                        "GAC",
                                        "Gaz",
                                        "Geely",
                                        "Genesis",
                                        "Glide",
                                        "Gmc",
                                        "Golden Dragon",
                                        "Great Wall",
                                        "Hafei",
                                        "Haima",
                                        "Halawa",
                                        "Hanteng",
                                        "Haojiang",
                                        "Haojue",
                                        "Harley Davidson",
                                        "Hashim Bus",
                                        "Haval",
                                        "Hawa",
                                        "Hawtai",
                                        "Honda",
                                        "Honda - Wuyang",
                                        "Hongqi",
                                        "Hummer",
                                        "Hyundai",
                                        "Ineos",
                                        "Infiniti",
                                        "Isuzu",
                                        "Jac",
                                        "Jaguar",
                                        "Jeep",
                                        "Jetour",
                                        "Jinbei",
                                        "JMC",
                                        "Jonway",
                                        "Joylong",
                                        "Kaiyi",
                                        "Karry",
                                        "Kawasaki",
                                        "Keeway",
                                        "Kenbo",
                                        "Keyton",
                                        "KGM",
                                        "Khalaf Bus",
                                        "Kia",
                                        "King Long",
                                        "KYC",
                                        "KYMCO",
                                        "Lada",
                                        "Lamborghini",
                                        "Lancia",
                                        "Land Rover",
                                        "Landwind",
                                        "Leapmotor",
                                        "Lexus",
                                        "Lifan",
                                        "Lincoln",
                                        "LML",
                                        "Lotus",
                                        "Lynkco",
                                        "Mahindra",
                                        "Maserati",
                                        "Maxus",
                                        "Mazda",
                                        "McLaren",
                                        "Mercedes",
                                        "Mercury",
                                        "MG",
                                        "Mini",
                                        " Mitsubishi",
                                        "Nissan",
                                        "Opel",
                                        "Perodua",
                                        "Peugeot",
                                        "Polestar",
                                        "Pontiac",
                                        "Porsche",
                                        "Proton",
                                        "Pullman",
                                        "Renault",
                                        "Rolls Royce",
                                        "Saab",
                                        "Saipa",
                                        "Scion",
                                        "Seat",
                                        "Senova",
                                        "Shineray",
                                        "Skoda",
                                        "Skywell",
                                        "Smart",
                                        "Sokon",
                                        "Soueast",
                                        "Speranza",
                                        "Ssang Yong",
                                        "Subaru",
                                        " Suzuki",
                                        "SYM",
                                        "Tank",
                                        "Tata",
                                        "Tesla",
                                        "Toyota",
                                        "TVS",
                                        "Vgv",
                                        "Victory",
                                        "Volkswagen",
                                        "Volvo",
                                        "Wuyang",
                                        "Xpeng",
                                        "Yadea",
                                        "Yamaha",
                                        "Zeekr",
                                        "ZNA",
                                        "Zontes",
                                        "Zotye",
                                    ]
                                }
                                for (var i = 0; i < data.names.length; i++) {
                                    $('#model_types').append($('<option></option>').text(data.names[i]).val(data
                                        .names[i]));
                                }
                                for (var i = 0; i < data.brands.length; i++) {
                                    $('#brands').append($('<option></option>').text(data.brands[i]).val(data.brands[
                                        i]));
                                }

                                break;
                            case "2":

                                $('#model_types').empty();
                                $('#brands').empty();
                                $('#print-ajax').html("Moto");
                                var data = {
                                    names: ['Guzzi', 'Morini', 'Agusta', 'Aprilia']
                                }
                                for (var i = 0; i < data.names.length; i++) {
                                    $('#model_types').append($('<option></option>').text(data.names[i]).val(data
                                        .names[i]));
                                }
                                break;

                            case "3":
                                $('#model_types').empty();
                                $('#brands').empty();
                                $('#model_types').empty();
                                $('#print-ajax').html("Bcycle");
                                var data = {
                                    names: ['Marlin', 'Domane', ' Fuel EX', 'Verve']
                                }
                                for (var i = 0; i < data.names.length; i++) {
                                    $('#model_types').append($('<option></option>').text(data.names[i]).val(data
                                        .names[i]));
                                }
                                break;
                            default:
                                $('#model_types').empty();
                                $('#brands').empty();
                                $('#print-ajax').html("");
                                $('#model_types').html("<option>Select the type first</option>");
                                $('#brands').html("<option>Select the type first</option>");

                        }
                    }
                });
            }
        </script>
    @endsection
</x-master-layout>
