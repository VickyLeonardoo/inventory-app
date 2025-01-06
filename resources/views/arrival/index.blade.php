<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-3 -mt-4">
                <div class="flex flex-row justify-between items-center">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Manage Supplier') }}
                    </h2>
                    <a href="{{ route('arrival.create') }}"
                        class="font-bold py-2 px-2 bg-indigo-700 text-white rounded-lg">
                        Add New
                    </a>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                @if (session('success'))
                    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                        role="alert">
                        <span class="font-medium">{{ session('success') }}!</span>
                    </div>
                @endif
                <table id="example" class="display w-full border-collapse border border-gray-300 mt-4">
                    <thead class="bg-gray-200 text-white">
                        <tr>
                            <th class="px-4 py-2 border border-gray-300">No</th>
                            <th class="px-4 py-2 border border-gray-300">Item</th>
                            <th class="px-4 py-2 border border-gray-300">Supplier</th>
                            <th class="px-4 py-2 border border-gray-300">Quantity</th>
                            <th class="px-4 py-2 border border-gray-300">Arrival Date</th>
                            <th class="px-4 py-2 border border-gray-300">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($arrivals as $arrival)
                            <tr class="bg-gray-100">
                                <td class="px-4 py-2 border border-gray-300">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border border-gray-300">{{ $arrival->item->name }}</td>
                                <td class="px-4 py-2 border border-gray-300">{{ $arrival->supplier->name }}</td>
                                <td class="px-4 py-2 border border-gray-300">{{ $arrival->quantity }}</td>
                                <td class="px-4 py-2 border border-gray-300">{{ $arrival->arrival_date }}</td>
                                <td class="px-4 py-2 border border-gray-300">
                                    <div class="flex space-x-2">
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('arrival.edit', $arrival) }}"
                                            class="bg-blue-700 hover:bg-blue-300 text-white font-bold py-1 px-4 rounded transition duration-200">
                                            Edit
                                        </a>

                                        <!-- Tombol Delete -->
                                        <form action="{{ route('arrival.destroy', $arrival->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-700 hover:bg-red-300 text-white font-bold py-1 px-4 rounded transition duration-200">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

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
