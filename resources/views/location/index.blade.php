<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-3 -mt-4">
                <div class="flex flex-row justify-between items-center">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Manage Location') }}
                    </h2>
                    <a href="{{ route('location.create') }}" class="font-bold py-2 px-2 bg-indigo-700 text-white rounded-full">
                        Add New
                    </a>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                @if (session('success'))
                    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                        <span class="font-medium">{{ session('success') }}!</span>
                    </div>
                @endif
                {{-- <div class="item-card flex flex-col md:flex-row gap-y-10 justify-between md:items-center">
                    <div class="flex flex-row items-center gap-x-3">
                        <img src="https://images.unsplash.com/photo-1552196563-55cd4e45efb3?q=80&w=3426&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="" class="rounded-2xl object-cover w-[120px] h-[90px]">
                        <div class="flex flex-col">
                            <h3 class="text-indigo-950 text-xl font-bold">Jumping Jack</h3>
                            <p class="text-slate-500 text-sm">Cardio</p>
                        </div>
                    </div>
                    <div class="hidden md:flex flex-col">
                        <p class="text-slate-500 text-sm">Students</p>
                        <h3 class="text-indigo-950 text-xl font-bold">183409</h3>
                    </div>
                    <div class="hidden md:flex flex-col">
                        <p class="text-slate-500 text-sm">Videos</p>
                        <h3 class="text-indigo-950 text-xl font-bold">193</h3>
                    </div>
                    <div class="hidden md:flex flex-col">
                        <p class="text-slate-500 text-sm">Teacher</p>
                        <h3 class="text-indigo-950 text-xl font-bold">Annima Poppo</h3>
                    </div>
                    <div class="hidden md:flex flex-row items-center gap-x-3">
                        <a href="#" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                            Manage
                        </a>
                        <form action="#" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-bold py-4 px-6 bg-red-700 text-white rounded-full">
                                Delete
                            </button>
                        </form>
                    </div>
                </div> --}}
                <table id="example" class="display w-full border-collapse border border-gray-300 mt-4">
                    <thead class="bg-gray-200 text-white">
                        <tr>
                            <th class="px-4 py-2 border border-gray-300">No</th>
                            <th class="px-4 py-2 border border-gray-300">Name</th>
                            <th class="px-4 py-2 border border-gray-300">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($locations as $location)
                            <tr class="bg-gray-100">
                                <td class="px-4 py-2 border border-gray-300">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border border-gray-300">{{ $location->name }}</td>
                                <td class="px-4 py-2 border border-gray-300">
                                    <div class="flex space-x-2">
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('location.edit', $location) }}" 
                                           class="bg-blue-700 hover:bg-blue-300 text-white font-bold py-1 px-4 rounded transition duration-200">
                                            Edit
                                        </a>
                    
                                        <!-- Tombol Delete -->
                                        <form action="{{ route('location.destroy', $location->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
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
