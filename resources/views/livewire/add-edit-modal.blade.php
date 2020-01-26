<span>

    @if ($this->showButton)
        <button wire:click="open" class="float-right bg-transparent hover:bg-blue-900 text-blue-900 font-semibold hover:text-white text-sm py-2 px-4 border border-blue-900 hover:border-transparent rounded-full">
            <i class="fas fa-fw fa-plus"></i> Add Article
        </button>
    @endif


    @if($this->isOpen)

        <div wire:transition.fade.400ms class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center z-40">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">


          <div class="modal-content py-4 text-left px-6">
            <!--Title-->
            <div class="flex justify-between items-center pb-3">
              <p class="text-2xl font-bold">{{$this->addOrEdit}} Article</p>
              <div wire:click="close()" class="cursor-pointer z-50">
                <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                  <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
              </div>
            </div>

              @livewire('alert-message', 2)

            <form wire:submit.prevent="submit" id="modal-form @if($this->showButton)-new @endif ">
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">

                    <div class="-mx-3 md:flex mb-6">

                    <div class="md:w-full px-3">
                      <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-name @if($this->showButton)-new @endif ">
                        Name
                      </label>
                      <input wire:model.lazy="article.name" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3" id="grid-name @if($this->showButton)-new @endif " type="text" placeholder="My Faded Gap Black Jeans... ">
                        @error('article.name') <span class="text-red-600 text-sm px-1 error">{{ $message }}</span> @enderror
                    </div>

                  </div>

                  <div class="-mx-3 md:flex mb-6">

                        <div class="md:w-full px-3">
                          <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-type @if($this->showButton)-new @endif ">
                            Type
                          </label>
                          <div class="relative">
                            <select wire:model="article.type" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded" id="grid-type @if($this->showButton)-new @endif ">
                                @foreach($types as $type)
                                    <option value="{{$type}}">{{$type}}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute bottom-0 top-0 right-0 flex items-center px-2 text-grey-darker">
                              <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                          </div>
                        </div>

                  </div>

                  <div class="-mx-3 md:flex mb-6">

                      <div class="md:w-1/2 px-3">
                      <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-color @if($this->showButton)-new @endif ">
                        Color
                      </label>
                      <div class="relative">
                        <select wire:model="article.color" name="color" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded" id="grid-color @if($this->showButton)-new @endif ">
                          @foreach($colors as $color)
                                <option value="{{$color}}">{{$color}}</option>
                          @endforeach
                        </select>
                        <div class="pointer-events-none absolute bottom-0 top-0 right-0 flex items-center px-2 text-grey-darker">
                          <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                      </div>
                    </div>

                    <div class="md:w-1/2 px-3">
                      <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-size @if($this->showButton)-new @endif ">
                        Size
                      </label>
                      <div class="relative">
                        <select wire:model="article.size" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded" id="grid-size @if($this->showButton)-new @endif ">
                          @foreach($sizes as $size)
                              <option value="{{$size}}">{{$size}}</option>
                          @endforeach
                        </select>
                        <div class="pointer-events-none absolute bottom-0 top-0 right-0 flex items-center px-2 text-grey-darker">
                          <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                      </div>
                    </div>

                  </div>

                </div>
            </form>

              <!--Footer-->
            <div class="flex justify-between pt-2">
                <button wire:click="close" class="bg-transparent hover:bg-blue-900 text-blue-900 font-semibold hover:text-white text-sm py-2 px-4 border border-blue-900 hover:border-transparent rounded-full ml-2"><i class="fas fa-fw fa-times"></i> Close</button>
                <button wire:click="submit" class="bg-transparent hover:bg-blue-900 text-blue-900 font-semibold hover:text-white text-sm py-2 px-4 border border-blue-900 hover:border-transparent rounded-full ml-2"><i class="fas fa-fw fa-save"></i> Save</button>
            </div>

            </div>
          </div>
        </div>

    @endif
</span>
