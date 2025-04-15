<div class="overflow-x-auto mt-6 rounded-t-md rounded-b-md">
    <table class="min-w-max w-full bg-white table-auto">
        <thead>
            <tr class="bg-primary text-white">
                <th class="py-3 px-6 text-left">User Details</th>
                <th class="py-3 px-6 text-left">Branch</th> <!-- New Branch Column -->
                <th class="py-3 px-6 text-left">Capabilities</th>
                <th class="py-3 px-6 text-left">Email</th>
                <th class="py-3 px-6 text-left max-w-xs">Page Access</th>
                <th class="py-3 px-6 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            @foreach($users as $user)
            <tr class="border-b border-gray-200 hover:bg-gray-100">
                <!-- User Details -->
                <td class="py-3 px-6">
                    <div class="flex items-center">
                        <div class="mr-2">
                            <img src="{{ $user->profile_pic ? asset('storage/' . $user->profile_pic) : asset('imgs/default-user.webp') }}"
                                alt="{{ $user->name }}" class="w-10 h-10 rounded-full">
                        </div>
                        <div>
                            <span class="font-medium">{{ $user->name }}</span>
                            <p class="text-xs text-gray-500">{{ $user->role }}</p>
                        </div>
                    </div>
                </td>

                <!-- New Branch Column -->
                <td class="py-3 px-6">
                    {{ $user->branch->name ?? 'N/A' }} <!-- Display Branch Name -->
                </td>

                <!-- Capabilities -->
                <td class="py-3 px-6">
                    <div>
                        @php
                        $capabilities = is_string($user->capabilities) ? json_decode($user->capabilities, true) : $user->capabilities;
                        @endphp
                        @foreach($capabilities as $capability)
                        <span class="text-xs bg-blue-200 text-blue-600 py-1 px-3 rounded-full">{{ $capability }}</span>
                        @endforeach
                    </div>
                </td>

                <!-- Email -->
                <td class="py-3 px-6">
                    {{ $user->email }}
                </td>

                <!-- Page Access -->
                <td class="py-3 px-6 max-w-xs">
                    <div class="truncate">
                        @php
                        $pages = is_string($user->pages) ? json_decode($user->pages, true) : $user->pages;
                        @endphp
                        @foreach($pages as $page)
                        <span class="text-xs bg-green-200 text-green-600 py-1 px-3 rounded-full inline-block truncate">{{ $page }}</span>
                        @endforeach
                    </div>
                </td>

                <!-- Actions -->
                <td class="flex py-6 px-2 border-b space-x-8 justify-center items-center">
                    <div class="flex item-center justify-center gap-3">
                        @if(in_array('edit', $admin_capabilities))
                        <button class="text-blue-600 hover:text-blue-900 text-base hover:text-lg edit-user-btn"
                            data-user-id="{{ $user->id }}"
                            data-modal-toggle="edit-user">
                            <i class="fa-solid fa-pencil"></i>
                        </button>
                        @endif
                        @if(in_array('delete', $admin_capabilities))
                        <button type="button"
                            class="text-red-600 hover:text-red-900 text-lg hover:text-2xl delete-user-btn"
                            data-user-id="{{ $user->id }}"
                            data-modal-toggle="delete-user">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>