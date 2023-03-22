<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Application\GetBookings;

use App\Shared\Application\QueryHandler;

final class GetBookingsHandler implements QueryHandler
{
    public function __construct(
        private readonly GetBookingsRepository $getBookingsRepository,
    ) {
    }

    public function __invoke(GetBookingsQuery $query): BookingsResponse
    {
        $bookings = array_map(
            fn (array $booking) => new BookingResponse($booking['id']),
            $this->getBookingsRepository->getBookings($query->learnerId)
        );

        return new BookingsResponse(...$bookings);
    }
}
