<?php

declare(strict_types=1);

namespace App\Teacher\User\Presentation\API;

use App\Shared\Application\CommandBus;
use App\Shared\Domain\ValueObject\UuidValueObject;
use App\Shared\Infrastructure\Eloquent\EloquentUser;
use App\Shared\Infrastructure\Laravel\Controller;
use App\Teacher\User\Application\CreateTeacher\CreateTeacherCommand;
use App\Teacher\User\Application\CreateTeacher\TeacherAlreadyExistException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class CreateTeacherController extends Controller
{
    public function __construct(
        private readonly CommandBus $commandBus
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->json()->all();

        $id = UuidValueObject::random();
        $email = $data['email'] ?? '';
        $plainPassword = $data['password'] ?? '';
        $companyName = $data['company_name'] ?? '';
        $firstname = $data['firstname'] ?? '';
        $lastname = $data['lastname'] ?? '';

        try {
            $command = new CreateTeacherCommand((string) $id, $email, $plainPassword, $companyName, $firstname, $lastname);

            $this->commandBus->handle($command);

            return response()->json(EloquentUser::find((string) $id), Response::HTTP_CREATED);
        } catch (\InvalidArgumentException $exception) {
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (TeacherAlreadyExistException $exception) {
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
