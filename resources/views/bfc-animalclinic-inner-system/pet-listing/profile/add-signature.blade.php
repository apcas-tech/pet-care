<!-- Signature Upload Modal -->
<div id="signatureModal" class="hidden flex overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 min-h-screen bg-cyan-950 bg-opacity-70" onclick="outsideClick(event)">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96" onclick="event.stopPropagation()">
        <h2 class="text-lg font-bold mb-4">Upload Your E-Signature</h2>

        <form id="signatureForm" enctype="multipart/form-data" class="space-y-3">
            @csrf
            <input type="hidden" name="prescription_id" id="prescription_id">
            <input type="file" name="signature" accept="image/png" required class="border p-2 w-full" id="signatureInput">
            <button type="submit" class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded w-full">Upload & Download</button>
        </form>

        <div class="space-y-3 mt-3">
            <button onclick="downloadPrescription()" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded w-full">
                Download Without Signature
            </button>
            <button onclick="closeModal()" class="text-red-500 w-full">Cancel</button>
        </div>
    </div>
</div>


<script>
    function downloadPrescription() {
        let prescriptionId = document.getElementById('prescription_id').value;
        if (!prescriptionId) {
            alert("Prescription ID is missing!");
            return;
        }
        window.location.href = "{{ route('prescription.download', ['id' => 'PRESCRIPTION_ID']) }}".replace('PRESCRIPTION_ID', prescriptionId);
    }

    document.getElementById("signatureForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent default form submission

        let formData = new FormData(this);
        let url = "{{ route('upload.signature') }}"; // Laravel route

        fetch(url, {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector("input[name='_token']").value
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast("Signature uploaded successfully!", 's');
                    closeModal(); // Close modal upon success
                    window.location.href = data.redirect; // Redirect to PDF download
                } else {
                    showToast("Failed to upload signature.", 'error');
                }
            })
            .catch(error => console.error("Error:", error));
    });

    function openSignatureModal(prescriptionId) {
        document.getElementById('prescription_id').value = prescriptionId;
        document.getElementById('signatureModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('signatureModal').classList.add('hidden');
        document.getElementById('signatureInput').value = ""; // Clear file input
    }

    function outsideClick(event) {
        if (event.target.id === "signatureModal") {
            closeModal();
        }
    }

    function showToast(message, type = "success") {
        const toastContainer = document.createElement("div");
        toastContainer.className = `fixed top-5 left-1/2 transform -translate-x-1/2 z-50 flex items-center py-3 px-4 mb-4 border-2 shadow-lg rounded-lg opacity-100 transition-opacity duration-500`;

        if (type === "error") {
            toastContainer.id = "toast-error";
            toastContainer.classList.add("border-red-500", "bg-red-200", "text-black");
            toastContainer.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-times-circle text-red-600 mr-2"></i>
                <span>${message}</span>
            </div>`;
        } else {
            toastContainer.id = "toast-success";
            toastContainer.classList.add("border-green-500", "bg-green-200", "text-black");
            toastContainer.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                <span>${message}</span>
            </div>`;
        }

        document.body.appendChild(toastContainer);

        setTimeout(() => {
            toastContainer.classList.remove("opacity-100");
            toastContainer.classList.add("opacity-0");
            setTimeout(() => {
                toastContainer.remove();
            }, 500);
        }, 4000);
    }
</script>