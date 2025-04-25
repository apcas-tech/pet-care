<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-white leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div>
        <div class="mt-6">
            <div id="calendar" class="bg-white dark:bg-gray-800 p-4 rounded shadow" style="min-height: 600px;"></div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            themeSystem: 'standard',
            height: 'auto',
            eventColor: '#2563eb',
            eventTextColor: 'white',
            eventDisplay: 'block',

            // Temporary events
            events: [{
                    title: 'Vet Check-up - Max',
                    start: '2025-04-26T10:00:00',
                    end: '2025-04-26T11:00:00',
                    color: '#10b981' // green for vet
                },
                {
                    title: 'Grooming - Bella',
                    start: '2025-04-27T14:00:00',
                    end: '2025-04-27T15:00:00',
                    color: '#f59e0b' // amber for grooming
                },
                {
                    title: 'Vaccination - Coco',
                    start: '2025-04-30',
                    color: '#3b82f6' // blue
                }
            ],
        });

        calendar.render();
    });
</script>