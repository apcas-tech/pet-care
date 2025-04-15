@extends('bfc-animalclinic-inner-system.layouts.layout')

@section('content')

<h1 class="text-3xl font-bold mb-5">Dashboard</h1>
<div class="flex flex-col md:flex-row gap-6 mb-8">
    <!-- Block for Metric Boxes and Calendar -->
    <div class="flex-1 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <a href="https://app.philsms.com/dashboard" target="_blank">
                <x-metric-box
                    iconClass="fas fa-sms text-purple-500"
                    title="PhilSMS Balance"
                    value="{{ $philsmsBalance }}" />
            </a>
            <x-metric-box
                iconClass="fas fa-user-friends text-blue-500"
                title="Total Pet Owners"
                value="{{ $totalPetOwners }}" />
            <x-metric-box
                iconClass="fas fa-paw text-green-500"
                title="Total Pets"
                value="{{ $totalPets }}" />
            <x-metric-box
                iconClass="fas fa-stethoscope text-red-500"
                title="Total Services"
                value="{{ $totalServices }}" />
            <x-metric-box
                iconClass="fas fa-calendar-week text-gray-500"
                title="Pending Appointments"
                value="{{ $pendingAppointments }}" />
            <x-metric-box
                iconClass="fas fa-clock text-yellow-500"
                title="Scheduled Appointments"
                value="{{ $scheduledAppointments }}" />
            <x-metric-box
                iconClass="fas fa-calendar-check text-teal-500"
                title="Completed Appointments"
                value="{{ $confirmedAppointments }}" />
            <x-metric-box
                iconClass="fas fa-calendar-times text-red-500"
                title="Cancelled Appointments"
                value="{{ $cancelledAppointments }}" />
        </div>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <!-- FullCalendar Container -->
            <div id="calendar"></div>

            <!-- Appointment Details Modal -->
            <div id="appointmentModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
                <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                    <h2 id="modal-title" class="text-xl font-bold mb-4">Appointment Details</h2>
                    <div id="modal-details" class="mb-4">
                        <!-- Event details will be dynamically injected here -->
                    </div>
                    <button id="closeModal" class="bg-blue-500 text-white px-4 py-2 rounded">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Clock Component -->
    <div>
        <x-clock />
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/analog-clock.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Backup Modal
        const backupModal = document.getElementById('backupModal');
        const backupBtn = document.getElementById('backupBtn');
        const closeBackupModal = document.getElementById('closeBModal');

        if (backupBtn) {
            backupBtn.addEventListener('click', function() {
                backupModal.classList.remove('hidden');
            });
        }

        if (closeBackupModal) {
            closeBackupModal.addEventListener('click', function() {
                backupModal.classList.add('hidden');
            });
        }

        backupModal.addEventListener('click', function(event) {
            if (event.target === backupModal) {
                backupModal.classList.add('hidden');
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: @json($appointments),
            eventColor: '#007bff',
            height: 'auto',
            dayMaxEvents: 3,
            eventClick: function(info) {
                showAppointmentModal(info.event);
            },
        });
        calendar.render();
    });

    function showAppointmentModal(event) {
        // Populate modal content with event details
        document.getElementById('modal-title').innerText = event.title;
        document.getElementById('modal-details').innerHTML = `
            <p><strong>Date:</strong> ${event.start.toLocaleDateString()}</p>
            <p><strong>Time:</strong> ${event.start.toLocaleTimeString()}</p>
            <p><strong>Notes:</strong> ${event.extendedProps.notes || 'No notes provided'}</p>
        `;

        // Show the modal
        const modal = document.getElementById('appointmentModal');
        modal.style.display = 'block';
    }

    // Close the modal when the "Close" button is clicked
    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('appointmentModal').style.display = 'none';
    });

    // Close the modal when clicking outside of it
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('appointmentModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
</script>
@endpush