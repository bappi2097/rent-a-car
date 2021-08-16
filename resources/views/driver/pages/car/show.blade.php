@extends('driver.layout.master')
@section('content')
    <div class="bg-white p-20 col-md-10 m-t-30">
        <div class="bg-white p-20 col-12 m-t-30">
            <div class="row mt-4">
                <div class="col-md-12 mb-4">
                    <div class="row justify-content-center">
                        <span
                            class="badge badge-{{ carValid($car->is_valid)[1] }} text-uppercase p-2">{{ carValid($car->is_valid)[0] }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <img id="user-image" src="{{ asset($car->image ?: 'images/user2-160x160.jpg') }}" alt="your image"
                        width="118" height="122" /><br>
                </div>
                <div class="col-md-6 mt-2">
                    <img id="license-image" src="{{ asset($car->license ?: 'images/user2-160x160.jpg') }}"
                        alt="your license" width="220" height="90" /><br>
                </div>
                <div class="col-md-4 offset-md-4 mt-2">
                    <p>Car No: {{ $car->car_no }}</p>
                    <p>
                        {{ $car->carCategory->CarModelCategory->CarBrandCategory->name . '-' . $car->carCategory->CarModelCategory->model }}
                    </p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div>
                    <a href="{{ route('driver.car.edit', $car->id) }}" class="btn btn-outline-indigo my-3">Edit</a>
                </div>
            </div>
        </div>
    </div>
@endsection
