<x-master-layout :assets="$assets ?? []">
    <div>
        <?php $id = $id ?? null; ?>
        @if (isset($id))
            {!! Form::model($data, [
                'route' => ['rider.update', $id],
                'method' => 'patch',
                'enctype' => 'multipart/form-data',
            ]) !!}
        @else
            {!! Form::open(['route' => ['riderequest.booking'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
        @endif
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">{{ $pageTitle }} {{ __('message.information') }}</h4>
                        </div>
                        <div class="card-action">
                            <a href="{{ route('rider.index') }}" class="btn btn-sm btn-primary"
                                role="button">{{ __('message.back') }}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="new-user-info">
                            <div class="row">
                                {{-- rider --}}
                                <div class="form-group col-md-6">
                                    {{ Form::label('rider', __('message.rider') . ' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                    <select class="form-control select2js required " name="rider">
                                        <option value=""></option>
                                        @foreach ($riders as $rider)
                                            <option value="{{ $rider->id }}">{{ $rider->first_name }}
                                                {{ $rider->last_name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                {{-- driver --}}
                                <div class="form-group col-md-6">
                                    {{ Form::label('driver', __('message.driver') . ' <span class="text-danger">*</span>', ['class' => 'form-control-label'], false) }}
                                    <select class="form-control select2js required" name="driver">
                                        <option value=""></option>
                                        @foreach ($drivers as $driver)
                                            <option value="{{ $driver->id }}">{{ $driver->first_name }}
                                                {{ $driver->last_name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                {{-- ride request time --}}
                                <div class="form-group col-md-6">
                                    <label class="form-label">{{ __('message.riderequest') }}</label>
                                    <div class="form-group col-md-12">
                                        <div class="form-check g-col-12">
                                            <input type="radio" class="form-check-input" name="ride_request"
                                                value="0">
                                            <label class="form-check-label">{{ __('message.now') }}</label>
                                        </div>
                                        <div class="form-check g-col-12">
                                            <input type="radio" class="form-check-input" name="ride_request"
                                                value="1">
                                            <label class="form-check-label">{{ __('message.schedule') }}</label>
                                            {{-- Start at --}}
                                            <div class="form-group col-md-12">
                                                <input type="datetime-local" placeholder="{{ __('message.start_at') }}"
                                                    class="form-control " name="start_at">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            {{-- From & to  --}}
                            <div class="form-group col-md-6">
                                <label class="form-label">From & to </label>
                                @include('map.google_api')
                            </div>
                            {{-- info for ride request --}}
                            <div class="form-group col-md-12">
                                <label class="form-label"> Ride info </label>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="code" class="form-control-label">Start Address<span
                                                class="text-danger">*</span></label>
                                        <input placeholder="start address" class="form-control" required=""
                                            name="start_address" type="text">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="code" class="form-control-label">start latitude <span
                                                class="text-danger">*</span></label>
                                        <input placeholder="start latitude" class="form-control" required=""
                                            name="start_latitude" type="text">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="code" class="form-control-label">start longitude <span
                                                class="text-danger">*</span></label>
                                        <input placeholder="start_longitude" class="form-control" required=""
                                            name="start_longitude" type="text">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="code" class="form-control-label">End Address<span
                                                class="text-danger">*</span></label>
                                        <input placeholder="start latitude" class="form-control" required=""
                                            name="end_address" type="text" id="code">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="code" class="form-control-label">End latitude <span
                                                class="text-danger">*</span></label>
                                        <input placeholder="end_latitude" class="form-control" required=""
                                            name="end_latitude" type="text" id="code">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="code" class="form-control-label">End longitude <span
                                                class="text-danger">*</span></label>
                                        <input placeholder="end_longitude" class="form-control" required=""
                                            name="end_longitude" type="text" id="code">
                                    </div>
                                </div>
                            </div>
                            {{-- Copoun --}}
                            <div class="form-group col-md-6">
                                {{ Form::label('coupon', __('message.coupon'), ['class' => 'form-control-label'], false) }}
                                <select class="form-control select2js" name="coupon">
                                    <option value=""></option>
                                    @foreach ($coupons as $coupon)
                                        @if ($coupon->discount_type == 'percentage')
                                            @php $symbol  = "%" @endphp
                                        @else
                                            @php $symbol  = "LE" @endphp
                                        @endif
                                        <option value="{{ $coupon->id }}">
                                            {{ $coupon->title }} : {{ $coupon->code }} =>
                                            {{ $coupon->discount }}{{ $symbol }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                    </div>
                    <hr>
                    {{ Form::submit(__('message.save'), ['class' => 'btn btn-md btn-primary float-right']) }}
                </div>
            </div>
        </div>

        {!! Form::close() !!}
    </div>

</x-master-layout>
