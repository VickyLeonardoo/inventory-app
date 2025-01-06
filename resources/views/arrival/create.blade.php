<x-app-layout> <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-3 -mt-4">
                <div class="flex flex-row justify-between items-center">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('New Arrival') }}
                    </h2>
                    <a href="{{ route('arrival.index') }}" class="font-bold py-2 px-2 bg-indigo-700 text-white rounded-lg">
                        Back to List
                    </a>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
 <!-- Name -->
                <form method="POST" action="{{ route('arrival.store') }}" enctype="multipart/form-data">
                    @csrf
                    {{-- item_id,supplier_id,quantity,arrival_date --}}
                    

                    <div class="mt-4">
                        <x-input-label for="item_id" :value="__('Item')" />
                        <select id="item_id" name="item_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="" selected disabled>-- Select Location --</option>
                            @foreach ($items as $item)
                                <option value="{{$item->id}}" {{ old('item_id') === $item->id ? 'selected' : '' }}>{{$item->name}} | Stock: {{ $item->current_stock }}</option>
                            @endforeach

                        </select>
                        <x-input-error :messages="$errors->get('item_id')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="supplier_id" :value="__('Supplier')" />
                        <select id="supplier_id" name="supplier_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="" selected disabled>-- Select Location --</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{$supplier->id}}" {{ old('supplier_id') === $supplier->id ? 'selected' : '' }}>{{$supplier->name}}</option>
                            @endforeach

                        </select>
                        <x-input-error :messages="$errors->get('supplier_id')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="quantity" :value="__('Quantity')" />
                        <x-text-input id="quantity" class="block mt-1 w-full" type="number" name="quantity" :value="old('quantity')" required autofocus autocomplete="quantity" />
                        <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="arrival_date" :value="__('Arrival Date')" />
                        <x-text-input id="arrival_date" class="block mt-1 w-full" type="date" name="arrival_date" :value="old('arrival_date')" required autofocus autocomplete="arrival_date" />
                        <x-input-error :messages="$errors->get('arrival_date')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
            
                        <button type="submit" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                            Add New Arrival Item
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
