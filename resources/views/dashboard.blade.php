<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ Auth::user()->hasRole('superadmin') ? __('Superadmin Dashboard') : __('Dashboard') }}
            </h2>
        </div>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                @role('superadmin|admin')
                <div class="item-card flex flex-col gap-y-10 md:flex-row justify-between items-center">
                    <div class="flex flex-col gap-y-3">
                        <img src="{{ asset('custom/img/boxes-stacked-solid.svg') }}" alt="Deskripsi Gambar" class="w-12 h-12 mr-2" />
                        <div>
                            <p class="text-slate-500 text-sm">Item</p>
                            <h3 class="text-indigo-950 text-xl font-bold">{{ $items }}</h3>
                        </div>
                    </div>
                    <div class="flex flex-col gap-y-3">
                        <img src="{{ asset('custom/img/warehouse-solid.svg') }}" alt="Deskripsi Gambar" class="w-12 h-12 mr-2" />
                        <div>
                            <p class="text-slate-500 text-sm">Location</p>
                            <h3 class="text-indigo-950 text-xl font-bold">{{ $locations }}</h3>
                        </div>
                    </div>
                    <div class="flex flex-col gap-y-3">
                        <img src="{{ asset('custom/img/building-solid.svg') }}" alt="Deskripsi Gambar" class="w-12 h-12 mr-2" />
                        <div>
                            <p class="text-slate-500 text-sm">Supplier</p>
                            <h3 class="text-indigo-950 text-xl font-bold">{{ $suppliers }}</h3>
                        </div>
                    </div>
                    <div class="flex flex-col gap-y-3">
                        <img src="{{ asset('custom/img/users-solid.svg') }}" alt="Deskripsi Gambar" class="w-12 h-12 mr-2" />
                        <div>
                            <p class="text-slate-500 text-sm">User</p>
                            <h3 class="text-indigo-950 text-xl font-bold">{{ $users }}</h3>
                        </div>
                    </div>
                </div>
                @endrole
                @role('staff|superadmin')
                <div class="item-card flex flex-col gap-y-10 md:flex-row justify-between items-center">
                    <div class="flex flex-col gap-y-3">
                        <svg width="46" height="46" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.4" d="M22 7.81V16.19C22 19.83 19.83 22 16.19 22H7.81C4.17 22 2 19.83 2 16.19V7.81C2 7.3 2.04 6.81 2.13 6.36C2.64 3.61 4.67 2.01 7.77 2H16.23C19.33 2.01 21.36 3.61 21.87 6.36C21.96 6.81 22 7.3 22 7.81Z" fill="#292D32"/>
                            <path d="M22 7.81V7.86H2V7.81C2 7.3 2.04 6.81 2.13 6.36H7.77V2H9.27V6.36H14.73V2H16.23V6.36H21.87C21.96 6.81 22 7.3 22 7.81Z" fill="#292D32"/>
                            <path d="M14.4391 12.7198L12.3591 11.5198C11.5891 11.0798 10.8491 11.0198 10.2691 11.3498C9.68914 11.6798 9.36914 12.3598 9.36914 13.2398V15.6398C9.36914 16.5198 9.68914 17.1998 10.2691 17.5298C10.5191 17.6698 10.7991 17.7398 11.0891 17.7398C11.4891 17.7398 11.9191 17.6098 12.3591 17.3598L14.4391 16.1598C15.2091 15.7198 15.6291 15.0998 15.6291 14.4298C15.6291 13.7598 15.1991 13.1698 14.4391 12.7198Z" fill="#292D32"/>
                            </svg>
                            
                        <div>
                            <p class="text-slate-500 text-sm">Courses</p>
                            <h3 class="text-indigo-950 text-xl font-bold">11</h3>
                            {{-- <h3 class="text-indigo-950 text-xl font-bold">{{$courses}}</h3> --}}
                        </div>
                    </div>
                    <a href="" class="w-fit font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                        Create New Course
                    </a>
                </div>
                @endrole
            </div>
        </div>
    </div>
</x-app-layout>