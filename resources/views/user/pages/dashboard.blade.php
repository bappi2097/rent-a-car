@extends('user.layout.master')
@push('style')
    <style>
        .product-list {
            display: flex;
            justify-content: space-between;
            padding: 6px 10px;
            align-items: center;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
        }

        .product-list>p {
            margin-bottom: 0 !important;
        }

    </style>
@endpush
@section('content')
    <div class="p-0 col-md-9 col-sm-12">
        <div class="p-2 shadow-lg">
            <div class="row justify-content-center my-4">
                <div class="col-md-5">
                    <form method="POST" action="{{ route('customer.make-trip.store') }}">
                        @csrf
                        <div id="location-div" class="">
                            <h2 class="p-5 text-center">Set Location For Trip</h2>
                            <div class="form-group">
                                <label for="load">Arraival Location</label>
                                <input class="form-control" type="text" name="load_location" id="load"
                                    placeholder="221B Baker Street" required>
                            </div>
                            <div class="form-group">
                                <label for="unload">Departure Location</label>
                                <input class="form-control" type="text" name="unload_location" id="unload"
                                    placeholder="Albert House, 256-260 Old St, Old Street" required>
                            </div>
                            <button class="btn btn-outline-indigo float-right" type="button"
                                onclick="next('location-div', 'category-div')">Next</button>
                        </div>
                        <div id="category-div" class="d-none">
                            <h2 class="p-5 text-center">Select Category</h2>
                            <input type="hidden" name="car_category_id" id="car_category_id" required>
                            @foreach ($categories as $category)
                                <div class="card p-3 bid-item" onclick="setCategory({{ $category->id }}, this);">
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <img class="img-fluid" src="{{ asset($category->image ?: 'images/car.png') }}"
                                                alt="">
                                        </div>
                                        <div class="col-md-8">
                                            <h5 class="font-weight-bold">{{ $category->carModelCategory->model }}</h5>
                                            <h6 class="font-weight-bold">
                                                {{ $category->carModelCategory->carBrandCategory->name }}</h6>
                                        </div>
                                        <div class="col-md-2">
                                            <h5 class="font-weight-bold">BID</h5>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-outline-indigo mt-3" type="button"
                                    onclick="next('category-div', 'location-div')">Back</button>
                                <button class="btn btn-outline-indigo mt-3" type="button"
                                    onclick="next('category-div', 'time-div')">Next</button>
                            </div>
                        </div>
                        <div id="time-div" class="d-none">
                            <h2 class="p-5 text-center">Arraival Time</h2>
                            <div class="form-group">
                                <label for="load_time">Arraival TIme</label>
                                <input class="form-control timepicker" type="datetime-local" name="load_time" id="load_time"
                                    required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-outline-indigo mt-3" type="button"
                                    onclick="next('time-div', 'category-div')">Back</button>
                                <button class="btn btn-success mt-3" type="submit">Make Trip</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function setCategory(id, e) {
            document.querySelectorAll('.bid-item').forEach(function(e) {
                e.classList.remove('selected');
            });
            e.classList.add("selected");
            document.querySelector("#car_category_id").value = id;
        }

        function next(current, next) {
            document.getElementById(current).classList.toggle('d-none');
            document.getElementById(next).classList.toggle('d-none');
        }
    </script>
@endpush
