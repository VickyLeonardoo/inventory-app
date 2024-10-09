<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add Item') }}
            </h2>
            <a href="{{ route('application.show', $application) }}"
                class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                <!-- Name -->
                <form method="POST" action="{{ route('application.item.store',$application) }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Form untuk Item dan Stock -->
                    <div id="item-container" class="col-span-6">
                        <!-- Item rows will be dynamically added here -->
                    </div>

                    <button type="button" id="add-item"class="mt-4 bg-indigo-700 text-white py-2 px-4 rounded shadow">Add Item</button>



                    <div class="flex items-center justify-end mt-4">

                        <button type="submit" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                            Add New Application
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const itemContainer = document.getElementById('item-container');
            const addItemButton = document.getElementById('add-item');
            let itemCount = 0;

            function createItemRow() {
                itemCount++;
                const row = document.createElement('div');
                row.className = 'grid grid-cols-12 gap-4 mt-4 items-end';
                row.innerHTML = `
            <div class="col-span-7">
                <x-input-label for="item_id_${itemCount}" :value="__('Item')" />
                <select id="item_id_${itemCount}" name="items[${itemCount}][item_id]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm item-select" required>
                    <option value="" selected disabled>-- Select Item --</option>
                    @foreach ($items as $item)
                        <option value="{{ $item->id }}" data-stock="{{ $item->current_stock }}">{{ $item->name }} | Stock: {{ $item->current_stock }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-3">
                <x-input-label for="quantity_${itemCount}" :value="__('Quantity')" />
                <x-text-input id="quantity_${itemCount}" class="block mt-1 w-full" type="number" name="items[${itemCount}][quantity]" required min="1" />
            </div>
            <div class="col-span-2">
                <button type="button" class="remove-item mt-4 bg-red-600 text-white py-2 px-4 rounded shadow">Remove</button>
            </div>
        `;
                itemContainer.appendChild(row);

                const select = row.querySelector(`#item_id_${itemCount}`);
                const quantityInput = row.querySelector(`#quantity_${itemCount}`);
                const removeButton = row.querySelector('.remove-item');

                select.addEventListener('change', function() {
                    updateAvailableItems();
                    const maxStock = parseInt(this.options[this.selectedIndex].dataset.stock);
                    quantityInput.max = maxStock;
                });

                quantityInput.addEventListener('input', function() {
                    const maxStock = parseInt(this.max);
                    if (parseInt(this.value) > maxStock) {
                        this.value = maxStock;
                    }
                });

                removeButton.addEventListener('click', function() {
                    row.remove();
                    updateAvailableItems();
                    updateRemoveButtons();
                });

                updateRemoveButtons();
                updateAvailableItems();
            }

            function updateAvailableItems() {
                const allSelects = itemContainer.querySelectorAll('.item-select');
                const selectedItems = new Set();

                allSelects.forEach(select => {
                    if (select.value) {
                        selectedItems.add(select.value);
                    }
                });

                allSelects.forEach(select => {
                    const currentValue = select.value;

                    // Reset options visibility
                    Array.from(select.options).forEach(option => {
                        option.style.display = '';
                    });

                    // Hide selected options in other selects
                    selectedItems.forEach(itemId => {
                        if (itemId !== currentValue) {
                            const option = select.querySelector(`option[value="${itemId}"]`);
                            if (option) {
                                option.style.display = 'none';
                            }
                        }
                    });

                    // If current selection is not valid, reset it
                    if (currentValue && !Array.from(select.options).some(option => option.value ===
                            currentValue && option.style.display !== 'none')) {
                        select.value = '';
                    }
                });
            }

            function updateRemoveButtons() {
                const removeButtons = itemContainer.querySelectorAll('.remove-item');
                const shouldShow = removeButtons.length > 1;
                removeButtons.forEach(button => {
                    button.classList.toggle('hidden', !shouldShow);
                });
            }

            addItemButton.addEventListener('click', createItemRow);

            // Create the first item row
            createItemRow();
        });
    </script>
</x-app-layout>
