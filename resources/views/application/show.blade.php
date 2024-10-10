<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Applicaitons Details') }}
            </h2>
            <a href="{{ route('application.index') }}" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if ($application->remarks && $application->status == 'Rejected')
                <div class="p-4 mb-4 text-sm text-white rounded-lg bg-red-400 dark:bg-gray-800 dark:text-green-400" role="alert">
                    <span class="font-medium"><strong>Remarks!</strong> <br>
                        {{ $application->remarks }}</span>
                </div>
            @endif
            @if ($application->item->count() == 0)
            <div class="p-4 mb-4 text-sm text-white rounded-lg bg-red-400 dark:bg-gray-800 dark:text-green-400" role="alert">
                <span class="font-medium">Your application must have at least one item!</span>
            </div>
            @endif
            @if (session('success'))
                <div class="p-4 mb-4 text-sm text-white rounded-lg bg-emerald-400 dark:bg-gray-800 dark:text-green-400"
                    role="alert">
                    <span class="font-medium">{{ session('success') }}!</span>
                </div>
            @elseif(session('error'))
                <div class="p-4 mb-4 text-sm text-white rounded-lg bg-red-400 dark:bg-gray-800 dark:text-green-400"
                    role="alert">
                    <span class="font-medium">{{ session('error') }}!</span>
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                <div class="flex flex-col items-end gap-y-3 mt-4 md:mt-0 md:flex-row md:items-center md:gap-x-3">
                    @role('superadmin|supervisor')
                        @if ($application->status == 'Pending')
                        <form action="{{ route('application.approve', $application) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                class="font-bold py-2 px-4 bg-emerald-600 hover:bg-emerald-400 text-white rounded-full">
                                Approve
                            </button>
                        </form>
                            <a href="{{ route('application.reject', $application) }}" id="openRejectModal"
                                class="font-bold py-2 px-4 bg-red-600 hover:bg-red-400 text-white rounded-full">
                                Reject
                            </a>
                        @endif
                    @endrole
                    @role('superadmin|staff')
                        @if ($application->status == 'Draft' && $application->item->count() > 0)
                            <form action="{{ route('application.pending', $application) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit"
                                    class="font-bold py-2 px-4 border border-indigo-700 bg-white text-blue-500 rounded-full hover:bg-blue-500 hover:text-white">
                                    Set To Pending
                                </button>
                            </form>
                        @endif
                    @endrole
                </div>
                <div class="item-card flex flex-col sm:flex-row gap-y-10 justify-between items-center">
                    <div class="flex flex-col items-start sm:flex-row sm:items-center gap-x-3">
                        <div class="flex flex-col">
                            <h3 class="text-indigo-950 text-xl font-bold">{{ $application->application_no }}</h3>
                            <p class="text-slate-500 text-sm">{{ $application->user->name }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col mt-4 sm:mt-0">
                        <p class="text-slate-500 text-sm">Issued Date</p>
                        <h3 class="text-indigo-950 text-xl font-bold">{{ $application->application_date }}</h3>
                    </div>
                    <div class="flex flex-row items-center gap-x-3">
                    @role('superadmin|staff')
                        @if ($application->status == 'Draft')
                            <button id="openModal"
                                class="font-bold py-2 px-4 bg-indigo-700 hover:bg-blue-500 text-white rounded-full">
                                Edit
                            </button>
                            <form action="{{ route('application.destroy', $application->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="font-bold py-2 px-4 bg-red-700 hover:bg-red-500 text-white rounded-full">
                                    Delete
                                </button>
                            </form>
                        @endif
                    @endrole
                    </div>
                </div>

                <hr class="my-5">

                <div class="flex flex-row justify-between items-center">
                    <div class="flex flex-col">
                        <h3 class="text-indigo-950 text-xl font-bold">Item Taken</h3>
                        <p class="text-slate-500 text-sm">{{ $application->item->count() }} Total Items</p>
                    </div>
                    @role('superadmin|staff')
                        @if ($application->status == 'Draft')
                            <a href="{{ route('application.item.create', $application) }}" class="font-bold py-2 px-4 bg-indigo-700 text-white rounded-full">
                                Add New Item
                            </a>
                        @endif
                    @endrole
                </div>

                @foreach ($application->item as $item)
                    <div class="item-card flex flex-row gap-y-10 justify-between items-center">
                        <div class="flex flex-row items-center gap-x-3">
                            <img width="560" class="rounded-2xl object-cover w-[120px] h-[90px]" height="315"
                                src="{{ Storage::url($item->image) }}" frameborder="0"></img>
                            <div class="flex flex-col">
                                <h3 class="text-indigo-950 text-xl font-bold">{{ $item->name }}</h3>
                                <p class="text-slate-500 text-sm">{{ $item->pivot->quantity }} {{ $item->unit }}</p>
                            </div>
                        </div>


                        <div class="flex flex-row items-center gap-x-3">
                            @role('superadmin|staff')
                                @if ($application->status == 'Draft')
                                    <a href="{{ route('application.item.edit',[$application,$item->pivot]) }}" class="font-bold py-2 px-4 bg-indigo-700 text-white rounded-full">
                                        Edit
                                    </a>
                                    <form action="{{ route('application.item.destroy',[$application,$item->pivot]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="font-bold py-2 px-4 bg-red-700 text-white rounded-full">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M21.0697 5.23C19.4597 5.07 17.8497 4.95 16.2297 4.86V4.85L16.0097 3.55C15.8597 2.63 15.6397 1.25 13.2997 1.25H10.6797C8.34967 1.25 8.12967 2.57 7.96967 3.54L7.75967 4.82C6.82967 4.88 5.89967 4.94 4.96967 5.03L2.92967 5.23C2.50967 5.27 2.20967 5.64 2.24967 6.05C2.28967 6.46 2.64967 6.76 3.06967 6.72L5.10967 6.52C10.3497 6 15.6297 6.2 20.9297 6.73C20.9597 6.73 20.9797 6.73 21.0097 6.73C21.3897 6.73 21.7197 6.44 21.7597 6.05C21.7897 5.64 21.4897 5.27 21.0697 5.23Z"
                                                    fill="white" />
                                                <path
                                                    d="M19.2297 8.14C18.9897 7.89 18.6597 7.75 18.3197 7.75H5.67975C5.33975 7.75 4.99975 7.89 4.76975 8.14C4.53975 8.39 4.40975 8.73 4.42975 9.08L5.04975 19.34C5.15975 20.86 5.29975 22.76 8.78975 22.76H15.2097C18.6997 22.76 18.8397 20.87 18.9497 19.34L19.5697 9.09C19.5897 8.73 19.4597 8.39 19.2297 8.14ZM13.6597 17.75H10.3297C9.91975 17.75 9.57975 17.41 9.57975 17C9.57975 16.59 9.91975 16.25 10.3297 16.25H13.6597C14.0697 16.25 14.4097 16.59 14.4097 17C14.4097 17.41 14.0697 17.75 13.6597 17.75ZM14.4997 13.75H9.49975C9.08975 13.75 8.74975 13.41 8.74975 13C8.74975 12.59 9.08975 12.25 9.49975 12.25H14.4997C14.9097 12.25 15.2497 12.59 15.2497 13C15.2497 13.41 14.9097 13.75 14.4997 13.75Z"
                                                    fill="white" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            @endrole
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div id="modal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur hidden">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Edit Application
                    </h3>
                    <button id="closeModal" type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('application.update', $application) }}" method="POST" class="p-4 md:p-5">
                    @csrf
                    @method('PUT')
                    <div class="mt-4">
                        <x-input-label for="application_date" :value="__('Application Date')" />
                        <x-text-input id="application_date" class="block mt-1 w-full" type="date"
                            name="application_date" value="{{ $application->application_date }}" required autofocus
                            autocomplete="application_date" />
                        <x-input-error :messages="$errors->get('application_date')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <button type="submit"
                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Update Application
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="Rejectmodal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur hidden">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Edit Application
                    </h3>
                    <button id="closeModal" type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('application.update', $application) }}" method="POST" class="p-4 md:p-5">
                    @csrf
                    @method('PUT')
                    <div class="mt-4">
                        <x-input-label for="application_date" :value="__('Application Date')" />
                        <x-text-input id="application_date" class="block mt-1 w-full" type="date"
                            name="application_date" value="{{ $application->application_date }}" required autofocus
                            autocomplete="application_date" />
                        <x-input-error :messages="$errors->get('application_date')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <button type="submit"
                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Update Application
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal untuk Reject -->
    <div id="rejectModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur hidden">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Reject Application
                    </h3>
                    <button id="closeRejectModal" type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('application.reject', $application) }}" method="POST" class="p-4 md:p-5">
                    @csrf
                    @method('PUT')
                    <div class="mt-4">
                        <x-input-label for="remark" :value="__('Remark')" />
                        <textarea id="remark" name="remark" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4"></textarea>
                        <x-input-error :messages="$errors->get('remark')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <button type="submit"
                            class="text-white inline-flex items-center bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-700">
                            Submit Rejection
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const modal = document.getElementById('modal');
        const openModalButton = document.getElementById('openModal');
        const closeModalButton = document.getElementById('closeModal');
        const body = document.body; // Ambil elemen body

        openModalButton.addEventListener('click', () => {
            modal.classList.remove('hidden');
            body.classList.add('backdrop-blur'); // Tambahkan kelas blur
        });

        closeModalButton.addEventListener('click', () => {
            modal.classList.add('hidden');
            body.classList.remove('backdrop-blur'); // Hapus kelas blur
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                body.classList.remove('backdrop-blur'); // Hapus kelas blur
            }
        });
    </script>
    <script>
        const rejectModal = document.getElementById('rejectModal');
        const openRejectModalButton = document.getElementById('openRejectModal');
        const closeRejectModalButton = document.getElementById('closeRejectModal');

        openRejectModalButton.addEventListener('click', (event) => {
            event.preventDefault(); // Mencegah aksi default dari anchor tag
            rejectModal.classList.remove('hidden');
            body.classList.add('backdrop-blur'); // Tambahkan kelas blur
        });

        closeRejectModalButton.addEventListener('click', () => {
            rejectModal.classList.add('hidden');
            body.classList.remove('backdrop-blur'); // Hapus kelas blur

        });

        rejectModal.addEventListener('click', (e) => {
            if (e.target === rejectModal) {
                rejectModal.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
