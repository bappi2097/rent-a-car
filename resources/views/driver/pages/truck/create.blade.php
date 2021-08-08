@extends('driver.layout.master')
@section('content')
    <div class="bg-white p-20 col-md-10 m-t-30">
        <div class="bg-white p-20 col-12 m-t-30">
            <form action="{{ route('driver.car.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <fieldset>
                    <div class="form-group">
                        <label for="car_no">Car No</label>
                        <input type="text" class="form-control" name="car_no" id="car_no" placeholder="">
                        @error('car_no')
                            <span class="text-red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="brand">Car Category</label>
                        <select name="car_category_id" id="car_category_id" class="form-control selectpicker"
                            style="border: 1px solid #ced4da; border-radius: 0.25rem;" data-live-search="true">
                            <option selected>Choose Category</option>
                            @foreach ($carCategories as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->CarSizeCategory->size . ' Feet, ' . $item->CarWeightCategory->weight . ' Ton, ' . $item->CarModelCategory->CarBrandCategory->name . '-' . $item->CarModelCategory->model }}
                                </option>
                            @endforeach
                        </select>
                        @error('car_category_id')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <img id="user-image" src="{{ asset('images/car-placeholder.png') }}" alt="your image"
                                width="118" height="122" /><br>
                            <input type='file' name="image" id="user-user-btn" style="display: none;"
                                onchange="readURL(this);" accept="user/*" />
                            <input type="button" class="btn btn-outline-secondary" value="Car Image"
                                onclick="document.getElementById('user-user-btn').click();" />
                        </div>
                        <div class="col-md-6">
                        <img id="license-image" src="@if (!empty($user->driver)) {{ asset($user->driver->license ?: 'images/id-card.png') }} @else
                            {{ asset('images/id-card.png') }} @endif"
                            alt="your license" width="175" height="100" /><br>
                            <input type='file' name="license" id="user-license-btn" style="display: none;"
                                onchange="readLicenseURL(this);" accept="license/*" />
                            <input type="button" class="btn btn-outline-secondary" value="Update License"
                                style="width: 175px;" onclick="document.getElementById('user-license-btn').click();" />
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary mr-5 my-5">Save</button>
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-danger">Cancel</a>
                </fieldset>
            </form>
        </div>
    </div>
@endsection
@push('script')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#user-image')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function readLicenseURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#license-image')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(function() {
            $('.selectpicker').selectpicker();
        });
    </script>
@endpush
