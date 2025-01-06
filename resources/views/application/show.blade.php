<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-3">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ __('Application Details') }}</h2>
                        <p class="mt-1 text-sm text-gray-600">View and manage application information</p>
                    </div>
                    <a href="{{ route('application.index') }}" 
                       class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
            
            {{-- Status Alerts --}}
            @if ($application->remarks && $application->status == 'Rejected')
                <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-400 rounded-r-lg">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-red-400 mr-2" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                            <path d="M12 8v4m0 4h.01" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        <div class="text-sm text-red-700">
                            <span class="font-medium">Rejection Remarks:</span><br>
                            {{ $application->remarks }}
                        </div>
                    </div>
                </div>
            @endif

            @if ($application->item->count() == 0)
                <div class="mb-4 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded-r-lg">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-yellow-400 mr-2" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                            <path d="M12 8v4m0 4h.01" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        <p class="text-sm text-yellow-700">
                            Your application must have at least one item!
                        </p>
                    </div>
                </div>
            @endif

            {{-- Main Content Card --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                {{-- Application Info Header --}}
                <div class="border-b border-gray-200 bg-gray-50 p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Application Number --}}
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-blue-50 rounded-lg">
                                <svg class="w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Application No.</p>
                                <p class="font-semibold text-gray-900">{{ $application->application_no }}</p>
                            </div>
                        </div>

                        {{-- Applicant Info --}}
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-green-50 rounded-lg">
                                <svg class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Applicant</p>
                                <p class="font-semibold text-gray-900">{{ $application->user->name }}</p>
                            </div>
                        </div>

                        {{-- Date Info --}}
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-purple-50 rounded-lg">
                                <svg class="w-6 h-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Issue Date</p>
                                <p class="font-semibold text-gray-900">{{ $application->application_date }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-end gap-3">
                        @role('superadmin|supervisor')
                            @if ($application->status == 'Pending')
                                <form action="{{ route('application.approve', $application) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                                        Approve
                                    </button>
                                </form>
                                <button id="openRejectModal" 
                                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                    Reject
                                </button>
                            @endif
                        @endrole
                        @role('superadmin|staff')
                        @if ($application->status == 'Draft' && $application->item->count() > 0)
                            <form action="{{ route('application.pending', $application) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                    class="font-bold py-2 px-4 border border-indigo-700 bg-white text-blue-500 rounded-lg hover:bg-blue-500 hover:text-white">
                                    Set To Pending
                                </button>
                            </form>
                        @endif
                    @endrole
                        @role('superadmin|staff')
                            @if ($application->status == 'Draft')
                                <button id="openModal" 
                                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                                    Edit Details
                                </button>
                            @endif
                        @endrole
                        
                    </div>
                </div>

                {{-- Items Section --}}
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Items</h3>
                            <p class="text-sm text-gray-500">{{ $application->item->count() }} Total Items</p>
                        </div>
                        @role('superadmin|staff')
                            @if ($application->status == 'Draft')
                                <a href="{{ route('application.item.create', $application) }}" 
                                   class="px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition-colors">
                                    Add New Item
                                </a>
                            @endif
                        @endrole
                    </div>

                    <div class="space-y-4">
                        @foreach ($application->item as $item)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center gap-4">
                                    <img src="{{ Storage::url($item->image) }}" 
                                         alt="{{ $item->name }}"
                                         class="w-[120px] h-[90px] rounded-lg object-cover"/>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900">{{ $item->name }}</h4>
                                        <p class="text-sm text-gray-500">{{ $item->pivot->quantity }} {{ $item->unit }}</p>
                                    </div>
                                    @role('superadmin|staff')
                                        @if ($application->status == 'Draft')
                                            <div class="flex gap-2">
                                                <a href="{{ route('application.item.edit', [$application, $item->pivot]) }}" 
                                                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                                    Edit
                                                </a>
                                                <form action="{{ route('application.item.destroy', [$application, $item->pivot]) }}" 
                                                      method="POST" 
                                                      class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @endrole
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div id="modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-center pb-4 mb-4 border-b">
                        <h3 class="text-lg font-semibold text-gray-900">Edit Application</h3>
                        <button id="closeModal" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <form action="{{ route('application.update', $application) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="application_date" class="block text-sm font-medium text-gray-700">Application Date</label>
                            <input type="date" 
                                   name="application_date" 
                                   id="application_date" 
                                   value="{{ $application->application_date }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                                Update Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Reject Modal --}}
    <div id="rejectModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-center pb-4 mb-4 border-b">
                        <h3 class="text-lg font-semibold text-gray-900">Reject Application</h3>
                        <button id="closeRejectModal" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <form action="{{ route('application.reject', $application) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="remarks" class="block text-sm font-medium text-gray-700">Rejection Remarks</label>
                            <textarea 
                                name="remarks" 
                                id="remarks" 
                                rows="4" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Please provide reason for rejection..."
                            ></textarea>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                Submit Rejection
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Edit Modal Functionality
        const modal = document.getElementById('modal');
        const openModalButton = document.getElementById('openModal');
        const closeModalButton = document.getElementById('closeModal');

        if (openModalButton) {
            openModalButton.addEventListener('click', () => {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });
        }

        if (closeModalButton) {
            closeModalButton.addEventListener('click', () => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            });
        }

        // Close modal when clicking outside
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });

        // Reject Modal Functionality
        const rejectModal = document.getElementById('rejectModal');
        const openRejectModalButton = document.getElementById('openRejectModal');
        const closeRejectModalButton = document.getElementById('closeRejectModal');

        if (openRejectModalButton) {
            openRejectModalButton.addEventListener('click', () => {
                rejectModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });
        }

        if (closeRejectModalButton) {
            closeRejectModalButton.addEventListener('click', () => {
                rejectModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            });
        }

        // Close reject modal when clicking outside
        rejectModal.addEventListener('click', (e) => {
            if (e.target === rejectModal) {
                rejectModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });

        // Escape key handler for both modals
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                modal.classList.add('hidden');
                rejectModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });
    </script>
</x-app-layout>