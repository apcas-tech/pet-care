<?php

namespace App\Http\Controllers\SSE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AppointmentSseController extends Controller
{
    private const STATUS_COLORS = [
        'Pending' => 'text-gray-500',
        'Scheduled' => 'text-orange-500',
        'Completed' => 'text-green-500',
        'default' => 'text-red-500',
    ];

    public function stream(Request $request)
    {
        $headers = [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
        ];

        $response = Response::stream(function () use ($request) {
            while (true) {
                $page = $request->get('page', 1);
                $perPage = $request->get('per_page', 30);

                $adminCapabilities = $this->getAdminCapabilities();
                $appointments = $this->getLatestAppointments($adminCapabilities, $page, $perPage);

                echo "data: " . json_encode($appointments->items()) . "\n\n";
                ob_flush();
                flush();

                sleep(30); // Refresh interval

                if (connection_aborted()) {
                    break;
                }
            }
        }, 200, $headers);

        return $response;
    }

    private function getAdminCapabilities()
    {
        $admin = Auth::guard('admins')->user();
        $capabilities = $admin->capabilities;

        return is_string($capabilities) ? json_decode($capabilities, true) : $capabilities;
    }

    private function getLatestAppointments(array $adminCapabilities, $page, $perPage)
    {
        $admin = Auth::guard('admins')->user();

        $query = Appointment::with(['pet', 'pet.owner', 'service', 'branch'])->latest();

        // Filter by branch for non-Super Admins
        if ($admin->role !== 'Super Admin') {
            $query->where('appointments.branch_id', $admin->branch_id);
        }

        $paginatedAppointments = $query->paginate($perPage, ['*'], 'page', $page);

        // Convert items to a collection and map them
        $modifiedAppointments = collect($paginatedAppointments->items())->map(function ($appointment) use ($adminCapabilities) {
            return [
                'id' => $appointment->id,
                'petName' => $appointment->pet->name,
                'ownerName' => $this->formatOwnerName($appointment->pet->owner),
                'service' => $appointment->service->service,
                'branchName' => $appointment->branch->name ?? 'N/A',
                'appointmentDateTime' => $this->formatAppointmentDateTime($appointment),
                'profile_pic' => $appointment->profile_pic,
                'status' => $appointment->status,
                'statusColor' => self::STATUS_COLORS[$appointment->status] ?? self::STATUS_COLORS['default'],
                'canEdit' => in_array('edit', $adminCapabilities),
                'canDelete' => in_array('delete', $adminCapabilities),
            ];
        });

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $modifiedAppointments,
            $paginatedAppointments->total(),
            $paginatedAppointments->perPage(),
            $paginatedAppointments->currentPage(),
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }

    private function formatOwnerName($owner)
    {
        if (!$owner) {
            return 'No Owner';
        }

        return trim("{$owner->Fname} " .
            ($owner->Mname ? "{$owner->Mname}. " : "") .
            "{$owner->Lname}");
    }

    private function formatAppointmentDateTime($appointment)
    {
        return \Carbon\Carbon::parse($appointment->appt_date)->format('Y-m-d') .
            " - " . \Carbon\Carbon::parse($appointment->appt_time)->format('H:i');
    }
}
