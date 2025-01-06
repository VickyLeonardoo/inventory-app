<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-3">
                <div class="flex flex-row justify-between items-center">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Manage Application') }}
                    </h2>
                    @role('superadmin|staff')
                        <a href="{{ route('application.create') }}" class="font-bold py-2 px-2 bg-indigo-700 text-white rounded-full">
                            Add New
                        </a>
                    @endrole
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
                            <th class="px-4 py-2 border border-gray-300">Application No</th>
                            <th class="px-4 py-2 border border-gray-300">Issued By</th>
                            <th class="px-4 py-2 border border-gray-300">Issued Date</th>
                            <th class="px-4 py-2 border border-gray-300">Status</th>
                            <th class="px-4 py-2 border border-gray-300">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($applications as $app)
                            <tr class="bg-gray-100">
                                <td class="px-4 py-2 border border-gray-300">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border border-gray-300">{{ $app->application_no }}</td>
                                <td class="px-4 py-2 border border-gray-300">{{ $app->user->name }}</td>
                                <td class="px-4 py-2 border border-gray-300">{{ $app->application_date }}</td>
                                <td class="px-4 py-2 border border-gray-300">
                                    @if ($app->status == 'Draft')
                                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-yellow-700 ring-1 ring-inset ring-yellow-600/20">Draft</span>
                                    @elseif ($app->status == 'Pending')
                                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-cyan-700 ring-1 ring-inset ring-cyan-600/20">Pending</span>
                                    @elseif ($app->status == 'Approved')
                                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Approved</span>
                                    @else
                                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">Rejected</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border border-gray-300">
                                    <div class="flex space-x-2">
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('application.show', $app) }}" 
                                           class="bg-cyan-500 hover:bg-cyan-300 text-white font-bold py-1 px-4 rounded transition duration-200">
                                           Detail
                                        </a>
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
