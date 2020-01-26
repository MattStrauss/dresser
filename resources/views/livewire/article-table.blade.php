<div>
    <div class="relative text-gray-600 mb-5 flex">
        <div class="relative w-1/3 z-20">
            <select wire:model="perPage" class="block appearance-none w-full bg-gray-100 h-10 px-5 pr-10 rounded-full text-sm focus:outline-none">
                <option value="5">Five Per Page</option>
                <option value="10">Ten Per Page</option>
                <option value="20">Twenty Per Page</option>
            </select>
            <div class="pointer-events-none absolute bottom-0 top-0 right-0 flex items-center px-2 text-grey-darker">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>
        <input wire:model="search" type="search" placeholder="Search Name" class="w-2/3 bg-gray-100 h-10 px-5 pr-10 ml-4 rounded-full text-sm focus:outline-none">
        <span class="pointer-events-none absolute right-0 top-0 mt-3 mr-4">
            <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
              <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z"/>
            </svg>
        </span>
    </div>

    <div class="px-3 py-0 flex justify-center text-sm mb-2">
        <table class="w-full text-md bg-white shadow-md rounded mb-4">
            <tbody>
            <tr class="border-b">
                <th class="text-left p-3 px-5"><a href="#" role="button" wire:click.prevent="sortBy('name')">
                        Name
                        @include('includes.sort-icon', ['field' => 'name'])
                    </a>
                </th>
                <th class="text-left p-3 px-5"><a href="#" role="button" wire:click.prevent="sortBy('type')">
                        Type
                        @include('includes.sort-icon', ['field' => 'type'])
                    </a>
                </th>
                <th class="text-left p-3 px-5"><a href="#" role="button" wire:click.prevent="sortBy('color')">
                        Color
                        @include('includes.sort-icon', ['field' => 'color'])
                    </a>
                </th>
                <th class="text-left p-3 px-5"><a href="#" role="button" wire:click.prevent="sortBy('size')">
                        Size
                        @include('includes.sort-icon', ['field' => 'size'])
                    </a>
                </th>
                <th class="text-left p-3 px-5">Action</th>
            </tr>
            @foreach($articles as $article)
                <tr class="border-b hover:bg-orange-100 @if($loop->index % 2 === 0) bg-gray-100 @endif">
                    <td class="p-1 px-5">{{$article['name']}}</td>
                    <td class="p-1 px-5">{{$article['type']}}</td>
                    <td class="p-1 px-5">{{$article['color']}}</td>
                    <td class="p-1 px-5">{{$article['size']}}</td>
                    <td class="p-1 px-5 flex justify-left">
                        <button wire:click="$emit('showModal', '{{json_encode($article)}}')" type="button" class="bg-transparent hover:bg-blue-900 text-blue-900 font-semibold hover:text-white text-sm py-2 px-4 border border-blue-900 hover:border-transparent rounded-full mr-2">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button wire:click="promptDeleteConfirm({{$article->id}}, '{{$article->name}}')" type="button" class="bg-transparent hover:bg-red-600 text-red-600 font-semibold hover:text-white text-sm py-2 px-4 border border-red-600 hover:border-transparent rounded-full">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @livewire('confirm-delete-modal')
    </div>


    <div class="block w-full text-xs flex justify-between">
        <div class="">
            {{$articles->links('vendor.pagination.default')}}
        </div>
        <div>
            <p class="text-gray-600">Displaying {{$articles->firstItem()}} - {{$articles->lastItem()}} of {{$articles->total()}}</p>
        </div>

    </div>

</div>
