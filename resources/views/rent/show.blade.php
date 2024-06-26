<x-master-layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-block card-stretch">
                    <div class="card-body p-0">
                        <div class="d-flex justify-content-between align-items-center p-3">
                            <h5 class="font-weight-bold">{{ $pageTitle }}</h5>
                            <a href="{{ route('rent.index') }}" class="float-right btn btn-sm btn-primary"><i
                                    class="fa fa-angle-double-left"></i> {{ __('message.back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-block p-card">
                    <div class="profile-box">
                        <div class="profile-card rounded">
                            <img src=" alt="01.jpg" class="avatar-100 rounded d-block mx-auto img-fluid mb-3">
                            <h3 class="font-600 text-white text-center mb-0">{{ $rent->name }}</h3>
                            <p class="text-white text-center mb-5">
                                {{-- <span class="text-capitalize badge bg-{{ $status }} ">{{ $data->status }}</span> --}}
                            </p>
                        </div>
                        <div class="pro-content rounded">
                            <div class="d-flex align-items-center mb-3">
                                <div class="p-icon mr-3">
                                    <i class="fas fa-car"></i>
                                </div>
                                <p class="mb-0 eml">{{ $rent->brand }}</p>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="p-icon mr-3">
                                    <i class="fas fa-palette"></i>
                                </div>
                                <p class="mb-0">{{ $rent->color }}</p>
                            </div>
                            {{-- <div class="d-flex align-items-center mb-3">
                                <div class="p-icon mr-3">
                                    
                                    @if ($data->gender == 'female')
                                        <i class="fas fa-female"></i>
                                    @elseif($data->gender == 'other')
                                        <i class="fas fa-transgender"></i>
                                    @else
                                        <i class="fas fa-male"></i>
                                    @endif
                                </div>
                                <p class="mb-0">{{ $data->gender }}</p>
                            </div> --}}
                            {{-- @php
                                $rating = $data->rating ?? 0;
                            @endphp --}}
                            {{-- @if ($rating > 0)
                                <div class="d-flex justify-content-center">
                                    <div class="social-ic d-inline-flex rounded">
                                        @while ($rating > 0)
                                            @if ($rating > 0.5)
                                                <i class="fas fa-star" style="color: yellow"></i>
                                            @else
                                                <i class="fas fa-star-half" style="color: yellow"></i>
                                            @endif
                                            @php $rating--; @endphp
                                        @endwhile
                                    </div>
                                </div>
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-block">
                            <div class="card-body">
                                <div class="top-block-one">
                                    <p class="mb-1">{{ __('message.plate_number') }}</p>
                                    <p></p>
                                    <h5>{{ $rent->plate_number }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-block">
                            <div class="card-body">
                                <div class="top-block-one">
                                    <p class="mb-1">{{ __('message.production_date') }}</p>
                                    <p></p>
                                    <h5>{{ $rent->production_date }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-block">
                            <div class="card-body">
                                <div class="top-block-one">
                                    <div class="">
                                        <p class="mb-1">{{ __('message.model') }}</p>
                                        <p></p>
                                        <h5>{{ $rent->model }} </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-block">
                            <div class="card-body">
                                <div class="top-block-one">
                                    <div class="">
                                        <p class="mb-1">{{ __('message.type') }}</p>
                                        <p></p>
                                        <h5>{{ $rent->type->name }} </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-block">
                            <div class="card-body">
                                <div class="top-block-one">
                                    <div class="">
                                        <p class="mb-1 ">
                                            {{ __('message.price') }}
                                            @if ($rent->discount !== null)
                                                <span class="badge badge-success">{{ __('message.discount') }}
                                                    {{ $rent->discount }} %</span>
                                            @endif
                                        </p>
                                        <p></p>

                                        @if ($rent->discount !== null)
                                            <h5><s>{{ $rent->price }} </s> </h5>
                                            <h5>{{ $rent->price_after_discount }} </h5>
                                        @else
                                            <h5>{{ $rent->price }}</h5>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="card card-block">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title mb-0">
                                    {{ __('message.list_form_title', ['form' => __('message.riderequest')]) }}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $dataTable->table(['class' => 'table  w-100'], false) }}
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    @section('bottom_script')
        {{-- {{ $dataTable->scripts() }} --}}
    @endsection
</x-master-layout>
