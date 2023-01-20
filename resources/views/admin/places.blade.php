@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1>{{ __('Places') }}</h1>

                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col" class="col-md-1">{{ __('ID') }}</th>
                        <th scope="col" class="col-md-4">{{ __('Name') }}</th>
                        <th scope="col" class="col-md-4">{{ __('Address') }}</th>
                        <th scope="col" class="col-md-2">{{ __('Google Maps') }}</th>
                        @if (Auth::user()->role === \App\Models\User::ROLE_ADMIN)
                        <th scope="col" class="col-md-1">{{ __('Delete') }}</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($places as $place)
                        <tr>
                            <td>{{ $place->id }}</td>
                            <td>{{ $place->name }}</td>
                            <td>
                                {{ $place->address }}<br/>
                                {{ $place->city }}, {{ $place->province }}, {{ $place->zipcode }}
                                @if ($place->country !== 'CA')
                                    <br/>{{ $place->country }}
                                @endif
                            </td>
                            <td>
                                <a href="https://www.google.com/maps?q={{ $place->address }} {{ $place->address }} {{ $place->address }} {{ $place->address }}"
                                   target="_blank">Google Maps</a>
                            </td>
                            @if (Auth::user()->role === \App\Models\User::ROLE_ADMIN)
                            <td>
                                <form method="POST" action="{{ route('admin.places.delete', ['id' => $place->id]) }}">
                                    <input type="hidden" name="_method" value="DELETE" />
                                    <input type="submit" class="btn btn-danger" value="{{ __('Delete') }}">
                                    @csrf
                                </form>
                            </td>
                            @endif
                        </tr>
                    @endforeach

                    @if (Auth::user()->role === \App\Models\User::ROLE_ADMIN)
                    <tr>
                        <form method="POST" action="{{ route('admin.places.add') }}">
                            <td></td>
                            <td>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="{{ __('Name') }}" class="form-control @error('name') is-invalid @enderror"/>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col col-12">
                                        <input type="text" name="address" value="{{ old('address') }}" placeholder="{{ __('Address') }}" class="form-control @error('address') is-invalid @enderror"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-12">
                                        <input type="text" name="city" value="{{ old('city') }}" placeholder="{{ __('City') }}" class="form-control @error('city') is-invalid @enderror"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-6">
                                        <input type="text" name="zipcode" value="{{ old('zipcode') }}" placeholder="{{ __('Zip code') }}" class="form-control @error('zipcode') is-invalid @enderror"/>
                                    </div>
                                    <div class="col col-3">
                                        <input type="text" name="province" value="{{ old('province', 'MB') }}" placeholder="{{ __('Province') }}" class="form-control @error('province') is-invalid @enderror"/>
                                    </div>
                                    <div class="col col-3">
                                        <input type="text" name="country" value="{{ old('country', 'CA') }}" placeholder="{{ __('Country') }}" class="form-control @error('country') is-invalid @enderror"/>
                                    </div>
                                </div>
                            </td>
                            <td></td>
                            <td>
                                <input type="submit" name="submit" value="{{ __('Add') }}" class="btn btn-success" />
                            </td>
                            @csrf
                        </form>
                    </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
