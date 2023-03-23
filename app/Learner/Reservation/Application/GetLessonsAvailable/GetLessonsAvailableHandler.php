<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Application\GetLessonsAvailable;

use App\Shared\Application\QueryHandler;

final class GetLessonsAvailableHandler implements QueryHandler
{
    public function __construct(
        private readonly GetLessonsAvailableRepository $getLessonsAvailableRepository,
    ) {
    }

    public function __invoke(GetLessonsAvailableQuery $query): LessonsAvailableResponse
    {
        return $this->getLessonsAvailableRepository->getLessonsAvailable();
    }
}
