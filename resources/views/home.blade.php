@extends('layouts.app')

@section('content')
    <div class="flex items-center">
        <div class="md:w-1/2 md:mx-auto">

            <div class="flex flex-col break-words bg-white border border-2 rounded shadow-md">

                <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
                    Dashboard

                    <a href="{{route('closet')}}" type="button" class="float-right bg-transparent hover:bg-blue-900 text-blue-900 font-semibold hover:text-white text-sm py-2 px-4 border border-blue-900 hover:border-transparent rounded-full ml-2">
                        <i class="fas fa-fw fa-tshirt"></i> Review Closet
                    </a>

                    @livewire('add-edit-modal', true)

                </div>

                <div class="w-full p-6">
                    <p class="text-gray-700">
                        Welcome, you're now logged in!
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
