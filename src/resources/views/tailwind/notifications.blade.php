@if (count($errors) > 0)
<div x-data="{ show: true }" 
     x-show="show"
     x-transition:leave="transition duration-350 transform"
     x-transition:leave-end="opacity-0 scale-75"
     class="flex justify-between items-center bg-red-500 relative text-white py-2 px-3 mt-5 mb-5 rounded"
>
    <div>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    <div>
        <button type="button" @click="show = false" class="text-white rounded-full hover:bg-white hover:text-red-500 px-2 hover:border-red-700 focus:outline-none">
            <span class="text-2xl">&times;</span>
        </button>
    </div>
</div>
@endif

@if(session()->has('message'))
<div x-data="{ show: true }" 
     x-show="show"
     x-transition:leave="transition duration-350 transform"
     x-transition:leave-end="opacity-0 scale-75"
     class="flex justify-between items-center bg-green-500 relative text-white py-2 px-3 mt-5 mb-5 rounded"
>
    <div>
        {{ session('message') }}
    </div>
    <div>
        <button type="button" @click="show = false" class="text-white rounded-full hover:bg-white hover:text-green-500 px-2 hover:border-green-700 focus:outline-none">
            <span class="text-2xl">&times;</span>
        </button>
    </div>
</div>
@endif