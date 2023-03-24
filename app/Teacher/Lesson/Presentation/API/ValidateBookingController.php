<?php

declare(strict_types=1);

namespace App\Teacher\Lesson\Presentation\API;

use App\Shared\Application\CommandBus;
use App\Shared\Infrastructure\Eloquent\EloquentBook;
use App\Shared\Infrastructure\Laravel\Controller;
use App\Teacher\Lesson\Application\ValidateBooking\BookingNotAwaitValidationException;
use App\Teacher\Lesson\Application\ValidateBooking\BookingNotExistException;
use App\Teacher\Lesson\Application\ValidateBooking\ValidateBookingCommand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class ValidateBookingController extends Controller
{
    public function __construct(
        private readonly CommandBus $commandBus
    ) {
    }

    public function __invoke(Request $request, string $id): JsonResponse
    {
        try {
            $command = new ValidateBookingCommand($id);

            $this->commandBus->handle($command);

            return response()->json(EloquentBook::find((string) $id), Response::HTTP_CREATED);
        } catch (BookingNotExistException $exception) {
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (BookingNotAwaitValidationException $exception) {
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
