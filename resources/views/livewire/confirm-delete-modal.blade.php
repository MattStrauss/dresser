<div>
    @if($this->isOpen)

        <div wire:transition.fade.400ms class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center z-40">
            <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
            <div class="modal-container bg-gray-200 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
                <div class="bg-white rounded shadow p-8 m-4 max-w-xs max-h-full text-center">
                    <div class="mb-4 text-xl">
                        <p>Confirm Delete</p>
                    </div>
                    <div class="mb-8">
                        <p>Are you sure that you want to delete this {{$this->modelType}} @if($this->modelName) ({{$this->modelName}})@endif? This action cannot be undone. </p>
                    </div>
                    <div class="flex justify-between">
                        <button wire:click="close" class="bg-transparent hover:bg-gray-600 text-gray-600 font-semibold hover:text-white text-sm py-2 px-4 border border-gray-600 hover:border-transparent rounded-full ml-2">Cancel</button>
                        <button wire:click="delete" class="bg-transparent hover:bg-red-500 text-red-500 font-semibold hover:text-white text-sm py-2 px-4 border border-red-700 hover:border-transparent rounded-full ml-2">Confirm</button>
                    </div>
                </div>
            </div>
        </div>

    @endif
</div>
