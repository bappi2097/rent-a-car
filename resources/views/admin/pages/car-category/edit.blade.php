@extends('admin.layout.app')
@section('content')
    <a href="{{ route('admin.car-category.index') }}" class="btn btn-white"> &lt; Back</a>
    <div class="bg-white p-20 col-12 m-t-30">
        <form action="{{ route('admin.car-category.update', $carCategory->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <fieldset>
                <legend class="m-b-15">Edit Car Category</legend>
                <div class="form-group">
                    <label for="model">Model</label>
                    <select name="car_model_category_id" id="model" class="form-control">
                        <option selected>Choose Model</option>
                        @foreach ($carModelCategories as $item)
                            <option value="{{ $item->id }}"
                                {{ selected($item->id, $carCategory->carModelCategory->id) }}>
                                {{ $item->model }}</option>
                        @endforeach
                    </select>
                    @error('car_model_category_id')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="weight">Weight</label>
                    <select name="car_weight_category_id" id="weight" class="form-control">
                        <option selected>Choose Weight</option>
                        @foreach ($carWeightCategories as $item)
                            <option value="{{ $item->id }}"
                                {{ selected($item->id, $carCategory->carWeightCategory->id) }}>
                                {{ $item->weight }} Ton</option>
                        @endforeach
                    </select>
                    @error('car_weight_category_id')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="size">Size</label>
                    <select name="car_size_category_id" id="size" class="form-control">
                        <option selected>Choose Size</option>
                        @foreach ($carSizeCategories as $item)
                            <option value="{{ $item->id }}"
                                {{ selected($item->id, $carCategory->carSizeCategory->id) }}>
                                {{ $item->size }} Feet</option>
                        @endforeach
                    </select>
                    @error('car_size_category_id')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="covered">Covered</label>
                    <select name="car_covered_category_id" id="covered" class="form-control">
                        <option selected>Choose Covered</option>
                        @foreach ($carCoveredCategories as $item)
                            <option value="{{ $item->id }}"
                                {{ selected($item->id, $carCategory->carCoveredCategory->id) }}>
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('car_covered_category_id')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="trip">Trip</label>
                    <select name="car_trip_category_id[]" id="trip" class="form-control" multiple>
                        @foreach ($carTripCategories as $item)
                            <option value="{{ $item->id }}"
                                {{ selected($item->id, $carCategory->carTripCategories->pluck('id')->all()) }}>
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('car_trip_category_id')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">Description (<span class="text-warning">Optional</span>)</label>
                    <textarea name="description" id="description" cols="30" rows="5"
                        class="form-control">{{ $carCategory->description }}</textarea>
                    @error('description')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <img id="user-image" style="width: 180px; height: 180px;"
                        src="{{ asset(!empty($carCategory->image) ? $carCategory->image : 'images/car-placeholder.png') }}"
                        alt="your image" /><br>
                    <input type='file' name="image" id="user-image-btn" style="display: none;" onchange="readURL(this);"
                        accept="images/*" />
                    <input type="button" class="btn btn-outline-secondary" style="width: 180px;" value="Update Image"
                        onclick="document.getElementById('user-image-btn').click();" />
                    @error('image')
                        <span class="text-red">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-sm btn-primary m-r-5">Save</button>
                <a href="{{ url()->previous() }}" class="btn btn-sm btn-default">Cancel</a>
            </fieldset>
        </form>
    </div>
@endsection
