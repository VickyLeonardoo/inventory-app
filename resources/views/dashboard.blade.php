<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Item Card -->
                <div class="bg-white overflow-hidden rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-6">
                    <div class="flex items-start justify-between">
                        <div class="p-3 bg-indigo-100 rounded-lg">
                            <img src="{{ asset('custom/img/boxes-stacked-solid.svg') }}" 
                                alt="Items" 
                                class="w-6 h-6 text-indigo-600" />
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm text-slate-500">Total Items</p>
                        <h3 class="text-2xl font-bold text-indigo-950 mt-1">{{ number_format($items) }}</h3>
                    </div>
                </div>

                <!-- Location Card -->
                <div class="bg-white overflow-hidden rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-6">
                    <div class="flex items-start justify-between">
                        <div class="p-3 bg-orange-100 rounded-lg">
                            <img src="{{ asset('custom/img/warehouse-solid.svg') }}" 
                                alt="Locations" 
                                class="w-6 h-6 text-orange-600" />
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm text-slate-500">Total Locations</p>
                        <h3 class="text-2xl font-bold text-indigo-950 mt-1">{{ number_format($locations) }}</h3>
                    </div>
                </div>

                <!-- Supplier Card -->
                <div class="bg-white overflow-hidden rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-6">
                    <div class="flex items-start justify-between">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <img src="{{ asset('custom/img/building-solid.svg') }}" 
                                alt="Suppliers" 
                                class="w-6 h-6 text-blue-600" />
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm text-slate-500">Total Suppliers</p>
                        <h3 class="text-2xl font-bold text-indigo-950 mt-1">{{ number_format($suppliers) }}</h3>
                    </div>
                </div>

                <!-- Users Card -->
                <div class="bg-white overflow-hidden rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-6">
                    <div class="flex items-start justify-between">
                        <div class="p-3 bg-purple-100 rounded-lg">
                            <img src="{{ asset('custom/img/users-solid.svg') }}" 
                                alt="Users" 
                                class="w-6 h-6 text-purple-600" />
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm text-slate-500">Total Users</p>
                        <h3 class="text-2xl font-bold text-indigo-950 mt-1">{{ number_format($users) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>