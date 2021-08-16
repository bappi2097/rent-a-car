@extends('admin.layout.app')
@section('content')
    <a href="{{ route('admin.user.driver.index') }}" class="btn btn-white"> &lt; Back</a>
    <div class="bg-white p-20 col-12 m-t-30">
        <form action="{{ route('admin.user.driver.car.store', $driver->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <fieldset>
                <legend class="m-b-15">Add Car</legend>
                <div class="form-group">
                    <label for="car_no">Car No</label>
                    <input type="text" class="form-control" name="car_no" id="car_no" placeholder="">
                    @error('car_no')
                        <span class="text-red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="brand">Car Category</label>
                    <select name="car_category_id" id="car_category_id" class="form-control">
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
                        <div class="form-group">
                            <label for="license">License</label>
                            <input type="file" class="form-control" name="license" id="license" accept="images/*">
                            @error('license')
                                <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" name="image" id="image" accept="images/*">
                            @error('image')
                                <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-sm btn-primary m-r-5">Save</button>
                <a href="{{ url()->previous() }}" class="btn btn-sm btn-default">Cancel</a>
            </fieldset>
        </form>
    </div>
@endsection
