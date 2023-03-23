<?php

declare(strict_types=1);

namespace App\Learner\Reservation\Presentation\API;

use App\Learner\Reservation\Application\BookLesson\BookLessonCommand;
use App\Learner\Reservation\Domain\LessonIsNotAvailableException;
use App\Shared\Application\CommandBus;
use App\Shared\Domain\ValueObject\UuidValueObject;
use App\Shared\Infrastructure\Eloquent\EloquentBook;
use App\Shared\Infrastructure\Laravel\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class BookLessonController extends Controller
{
    public function __construct(
        private readonly CommandBus $commandBus
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->json()->all();

        $id = UuidValueObject::random();
        $learnerId = $data['learner_id'] ?? '';
        $lessonId = $data['lesson_id'] ?? '';

        try {
            $command = new BookLessonCommand((string) $id, $learnerId, $lessonId);

            $this->commandBus->handle($command);

            return response()->json(EloquentBook::find((string) $id), Response::HTTP_CREATED);
        } catch (\InvalidArgumentException $exception) {
            return response()->json([self::ERROR => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (LessonIsNotAvailableException $exception) {
            return response()->json([self::ERROR => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
