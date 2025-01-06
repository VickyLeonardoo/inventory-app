<x-app-layout>
   <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-3 -mt-4">
                <div class="flex flex-row justify-between items-center">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Add Item') }}
                    </h2>
                    <a href="{{ route('item.index') }}" class="font-bold py-2 px-2 bg-indigo-700 text-white rounded-lg">
                        Back to List
                    </a>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
 <!-- Name -->
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="py-3 w-full rounded-2xl bg-red-500 text-white">
                            {{$error}}
                        </div>
                    @endforeach
                @endif
                <form method="POST" action="{{ route('item.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <x-input-label for="code" :value="__('Code')" />
                        <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" :value="old('code')" required autofocus autocomplete="code" />
                        <x-input-error :messages="$errors->get('code')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                   <div class="mt-4">
                        <x-input-label for="unit" :value="__('Unit')" />
                        <select id="unit" name="unit" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="" selected disabled>-- Select Unit --</option>
                            <option value="Pcs" {{ old('unit') === 'Pcs' ? 'selected' : '' }}>Pcs</option>
                            <option value="Gram" {{ old('unit') === 'Gram' ? 'selected' : '' }}>Gram</option>
                            <option value="Kg" {{ old('unit') === 'Kg' ? 'selected' : '' }}>Kg</option>
                            <option value="Meter" {{ old('unit') === 'Meter' ? 'selected' : '' }}>Meter</option>
                            <option value="Dozen" {{ old('unit') === 'Dozen' ? 'selected' : '' }}>Dozen</option>
                        </select>
                        <x-input-error :messages="$errors->get('unit')" class="mt-2" />
                    </div>

                   <div class="mt-4">
                        <x-input-label for="category" :value="__('Category')" />
                        <select id="category" name="category" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="" selected disabled>-- Select Category --</option>
                            <option value="Raw Materials" {{ old('category') === 'Raw Materials' ? 'selected' : '' }}>Raw Materials</option>
                            <option value="Finish Material" {{ old('category') === 'Finish Material' ? 'selected' : '' }}>Finish Material</option>

                        </select>
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4" required>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum accusamus ullam delectus maiores, quisquam earum perferendis ipsa quo necessitatibus a voluptates veniam neque ut perspiciatis facilis excepturi ratione placeat qui.</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                   <div class="mt-4">
                        <x-input-label for="initial_stock" :value="__('Initial Stock')" />
                        <x-text-input id="initial_stock" class="block mt-1 w-full" type="number" name="initial_stock" :value="old('initial_stock')" required autofocus autocomplete="initial_stock" />
                        <x-input-error :messages="$errors->get('initial_stock')" class="mt-2" />
                    </div>

                   <div class="mt-4">
                        <x-input-label for="current_stock" :value="__('Current Stock')" />
                        <x-text-input id="current_stock" class="block mt-1 w-full" type="number" name="current_stock" :value="old('current_stock')" required autofocus autocomplete="current_stock" />
                        <x-input-error :messages="$errors->get('current_stock')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="location_id" :value="__('Location')" />
                        <select id="location_id" name="location_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="" selected disabled>-- Select Location --</option>
                            @foreach ($locations as $location)
                                <option value="{{$location->id}}" {{ old('location_id') === $location->id ? 'selected' : '' }}>{{$location->name}}</option>
                            @endforeach

                        </select>
                        <x-input-error :messages="$errors->get('location_id')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="image" :value="__('Image')" />
                        <x-text-input id="image" class="block mt-1 w-full border-2 border-gray-300 rounded-md focus:border-indigo-500 focus:ring focus:ring-indigo-200" type="file" name="image" required autofocus autocomplete="image" />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>
                    
                    <div class="flex items-center justify-end mt-4">
            
                        <button type="submit" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                            Add New Item
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: '<"top flex justify-between"<f>l>rt<"bottom"ip><"clear">',
                // Opsi lainnya sesuai kebutuhan
            });
        });
    </script>
</x-app-layout>
