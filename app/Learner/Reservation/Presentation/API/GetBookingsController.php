<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Presentation\API;

use App\Learner\Reservation\Application\GetBookings\GetBookingsQuery;
use App\Shared\Application\QueryBus;
use App\Shared\Infrastructure\Laravel\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class GetBookingsController extends Controller
{
    public function __construct(
        private readonly QueryBus $queryBus
    ) {
    }

    public function __invoke(Request $request, string $learnerId): JsonResponse
    {
        $bookingsResponse = $this->queryBus->handle(new GetBookingsQuery($learnerId));

        return response()->json($bookingsResponse->bookings);
    }
}
