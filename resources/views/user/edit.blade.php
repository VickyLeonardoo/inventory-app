<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-3 -mt-4">
                <div class="flex flex-row justify-between items-center">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Edit User') }}
                    </h2>
                    <a href="{{ route('user.index') }}" class="font-bold py-2 px-2 bg-indigo-700 text-white rounded-lg">
                        Back to List
                    </a>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
 <!-- Name -->
                <form method="POST" action="{{ route('user.update',$user) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    {{-- item_id,role,quantity,email --}}
                    <div class="mt-4">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $user->name }}" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ $user->email }}" required autofocus autocomplete="email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="role" :value="__('Role')" />
                        <select id="role" name="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="" selected disabled>-- Select Role --</option>
                            @if ($user->roles->pluck('name')->implode(', ') == 'superadmin')
                            <option value="superadmin" {{ $user->roles->pluck('name')->implode(', ') == 'superadmin' ? 'selected':''}}>Superadmin</option>
                            @endif
                            <option value="admin" {{ $user->roles->pluck('name')->implode(', ') == 'admin' ? 'selected':''}}>Admin</option>
                            <option value="staff" {{ $user->roles->pluck('name')->implode(', ') == 'staff' ? 'selected':''}}>Staff</option>
                            <option value="supervisor" {{ $user->roles->pluck('name')->implode(', ') == 'supervisor' ? 'selected':''}}>Supervisor</option>
                            
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
            
                        <button type="submit" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                            Update User
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
