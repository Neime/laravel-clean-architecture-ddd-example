<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Presentation\API;

use App\Learner\Reservation\Application\GetLessonsAvailable\GetLessonsAvailableQuery;
use App\Shared\Application\QueryBus;
use App\Shared\Infrastructure\Laravel\Controller;
use Illuminate\Http\JsonResponse;

final class GetLessonsAvailableController extends Controller
{
    public function __construct(
        private readonly QueryBus $queryBus
    ) {
    }

    public function __invoke(): JsonResponse
    {
        $lessonsAvailableResponse = $this->queryBus->handle(new GetLessonsAvailableQuery());

        return response()->json($lessonsAvailableResponse->toArray());
    }
}
