<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Item') }}
            </h2>
            <a href="{{ route('application.show', $application) }}"
                class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="py-3 w-full rounded-3xl bg-red-500 text-white">
                        {{ $error }}
                    </div>
                @endforeach
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                <form method="POST" action="{{ route('application.item.update', [$application, $item]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div id="item-container" class="col-span-6">
                        <div class="col-span-7">
                            <x-input-label for="item_id" :value="__('Item')" />
                            <select id="item_id" name="item_id"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm item-select"
                                required>
                                <option value="" disabled>-- Select Item --</option>
                                @foreach ($availableItems as $availableItem)
                                    <option value="{{ $availableItem->id }}"
                                        {{ $availableItem->id == $item->item_id ? 'selected' : '' }}
                                        data-stock="{{ $availableItem->current_stock }}">
                                        {{ $availableItem->name }} | Stock: {{ $availableItem->current_stock }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-3">
                            <x-input-label for="quantity" :value="__('Quantity')" />
                            <x-text-input id="quantity" class="block mt-1 w-full" type="number" name="quantity"
                                required min="1" max="{{ $item->item->current_stock }}"
                                value="{{ $item->quantity }}" />
                            <p id="stock-warning" class="text-red-500 text-sm mt-1 hidden">Quantity exceeds available
                                stock!</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" id="submit-button"
                            class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                            Update Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const itemSelect = document.getElementById('item_id');
            const quantityInput = document.getElementById('quantity');
            const stockWarning = document.getElementById('stock-warning');
            const submitButton = document.getElementById('submit-button');

            function updateQuantityMax() {
                const selectedOption = itemSelect.options[itemSelect.selectedIndex];
                const maxStock = parseInt(selectedOption.dataset.stock);
                quantityInput.max = maxStock;
                validateQuantity();
            }

            function validateQuantity() {
                const quantity = parseInt(quantityInput.value);
                const maxStock = parseInt(quantityInput.max);

                if (quantity > maxStock) {
                    stockWarning.classList.remove('hidden');
                    submitButton.disabled = true;
                    submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    stockWarning.classList.add('hidden');
                    submitButton.disabled = false;
                    submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }

            itemSelect.addEventListener('change', updateQuantityMax);
            quantityInput.addEventListener('input', validateQuantity);

            // Initial validation
            updateQuantityMax();
        });
    </script>
</x-app-layout>
