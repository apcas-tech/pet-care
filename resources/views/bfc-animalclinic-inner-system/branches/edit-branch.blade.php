<!-- Edit Branch Modal -->
<div id="edit-branch" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="bg-white rounded-lg p-6 shadow-lg w-96">
        <h3 class="text-lg font-bold">Edit Branch</h3>
        <form id="edit-branch-form" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit-branch-id">

            <div class="mt-4">
                <label for="edit-branch-name" class="block font-semibold">Branch Name</label>
                <input type="text" id="edit-branch-name" name="name" class="w-full border rounded-md px-3 py-2">
            </div>

            <div class="mt-4">
                <label for="edit-branch-phone" class="block font-semibold">Phone Number</label>
                <input type="text" id="edit-branch-phone" name="phone_number" class="w-full border rounded-md px-3 py-2">
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" id="cancel-edit-branch" class="bg-gray-300 px-4 py-2 rounded-md">Cancel</button>
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md ml-2">Save Changes</button>
            </div>
        </form>
    </div>
</div>