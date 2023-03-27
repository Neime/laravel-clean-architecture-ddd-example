<?php

declare(strict_types=1);

namespace App\Teacher\Lesson\Presentation\API;

use App\Shared\Application\CommandBus;
use App\Shared\Domain\ValueObject\UuidValueObject;
use App\Shared\Infrastructure\Eloquent\EloquentLesson;
use App\Shared\Infrastructure\Laravel\Controller;
use App\Teacher\Lesson\Application\CreateLesson\CreateLessonCommand;
use App\Teacher\Lesson\Application\CreateLesson\TeacherNotExistException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class CreateLessonController extends Controller
{
    public function __construct(
        private readonly CommandBus $commandBus
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->json()->all();

        $id = UuidValueObject::random();
        $teacherId = $data['teacher_id'] ?? '';
        $startDate = $data['start_date'] ?? '';
        $endDate = $data['end_date'] ?? '';
        $amount = $data['amount'] ?? '';
        $currency = $data['currency'] ?? '';

        try {
            $command = new CreateLessonCommand((string) $id, $teacherId, $startDate, $endDate, $amount, $currency);

            $this->commandBus->handle($command);

            return response()->json(EloquentLesson::find((string) $id), Response::HTTP_CREATED);
        } catch (TeacherNotExistException $exception) {
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\InvalidArgumentException $exception) {
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
