<div>
    @if($this->alertMessage && $this->alertNumber == $this->alertActiveNumber)
        <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-900 px-4 py-3 mb-5" role="alert">
            <div wire:click="close" class="cursor-pointer z-50 float-right">
                <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
            </div>
            <p class="font-bold">Alert</p>
            <p class="text-sm">{{$this->alertMessage}}</p>
        </div>
    @endif
</div>
