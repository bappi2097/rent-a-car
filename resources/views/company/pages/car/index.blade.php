@extends('company.layout.master')
@push('style')
    <style>
        .height-30 {
            height: 30px !important;
        }

        .height-40 {
            height: 40px !important;
        }

        .img-rounded {
            border-radius: .375rem;
        }

        img {
            vertical-align: middle;
            border-style: none;
        }

    </style>
@endpush
@section('content')
    <div class="bg-white p-20 col-md-10 m-t-30">
        <a class="btn btn-outline-indigo mb-3" href="{{ route('company.car.create') }}">Add Car</a>
        <div class="table-responsive">
            <table class="table table-striped m-b-0" id="myTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Car No</th>
                        <th>Category</th>
                        <th>License</th>
                        <th>Image</th>
                        <th>Valid</th>
                        <th width="1%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($company->cars as $index => $car)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $car->car_no }}</td>
                            <td>
                                {{ $car->carCategory->CarSizeCategory->size . ' Feet, ' . $car->carCategory->CarWeightCategory->weight . ' Ton, ' . $car->carCategory->CarModelCategory->CarBrandCategory->name . '-' . $car->carCategory->CarModelCategory->model }}
                            </td>
                            <td class="with-img">
                                <img src="{{ asset($car->license) }}" class="img-rounded height-40">
                            </td>
                            <td class="with-img">
                                <img src="{{ asset($car->image) }}" class="img-rounded height-40">
                            </td>
                            <td>
                                <span
                                    class="badge badge-{{ carValid($car->is_valid)[1] }} text-uppercase">{{ carValid($car->is_valid)[0] }}</span>
                            </td>
                            <td class="with-btn" nowrap="">
                                <a href="{{ route('company.car.edit', $car->id) }}"
                                    class="btn btn-sm btn-primary width-60 m-r-2">Edit</a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-danger width-60"
                                    onclick="event.preventDefault(); document.getElementById('language{{ $index }}').submit();">
                                    Delete
                                </a>
                                <form id="language{{ $index }}"
                                    action="{{ route('company.car.destroy', ['car' => $car->id]) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
