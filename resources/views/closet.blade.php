@extends('layouts.app')

@section('content')
    <div class="flex items-center">
        <div class="md:w-1/2 md:mx-auto">

            <div class="flex flex-col break-words bg-white border border-2 rounded shadow-md">

                <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
                    Closet

                    @livewire('add-edit-modal', true)
                </div>
                @livewire('alert-message')

                <div class="w-full p-6">

                    @livewire('article-table')

                </div>
            </div>
        </div>
    </div>
@endsection
