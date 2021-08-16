@extends('layouts.master')
@section('content')
    <div class="custom-contact-map">
        <iframe src="https://maps.google.com/maps?q=Dhaka&t=&z=13&ie=UTF8&iwloc=&output=embed" width="100%" height="100%"
            frameborder="0" style="border: 0" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
    </div>
    <div class="container mt-5">
        <div class="my-5 row">
            <div class="mx-auto text-center text-rtl col-md-8 col-sm-12 d-flex justify-content-center">
                <h5 class="text-purple">
                    {{ __('utility.feel-free-to-message') }}
                </h5>
            </div>
        </div>
        <div class="row text-rtl">
            <div class="mx-auto col-md-6 col-sm-12">
                <form method="POST" action="{{ route('contact-store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">{{ __('utility.full-name') }}</label>
                        <input type="text" class="form-control" name="name" id="name" aria-describedby="emailHelp"
                            required />
                    </div>
                    <div class="form-group">
                        <label for="email">{{ __('utility.email-address') }}</label>
                        <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp"
                            required />
                    </div>
                    <div class="form-group">
                        <label for="subject">{{ __('utility.subject') }}</label>
                        <input type="text" class="form-control" name="subject" id="subject" aria-describedby="emailHelp"
                            required />
                    </div>
                    <div class="form-group">
                        <label for="message">{{ __('utility.message') }}</label>
                        <textarea class="form-control" name="message" id="message" cols="30" rows="5" required></textarea>
                    </div>
                    <div class="form-group d-flex">
                        <button type="submit" class="mx-auto btn btn-outline-indigo">
                            {{ __('utility.send') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
