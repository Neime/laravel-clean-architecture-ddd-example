<?php

declare(strict_types=1);

namespace App\Teacher\Lesson\Presentation\API;

use App\Shared\Application\CommandBus;
use App\Shared\Infrastructure\Eloquent\EloquentBook;
use App\Shared\Infrastructure\Laravel\Controller;
use App\Teacher\Lesson\Application\AccepteBooking\AccepteBookingCommand;
use App\Teacher\Lesson\Application\AccepteBooking\BookingNotAwaitAccepteException;
use App\Teacher\Lesson\Application\RefuseBooking\BookingNotAwaitRefuseException;
use App\Teacher\Lesson\Application\RefuseBooking\RefuseBookingCommand;
use App\Teacher\Lesson\Application\Shared\BookingNotExistException;
use App\Teacher\Lesson\Domain\ValidationState;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class ValidateBookingController extends Controller
{
    private const NO_VALIDATION_FOUNDED = 'No validation state founded';

    public function __construct(
        private readonly CommandBus $commandBus
    ) {
    }

    public function __invoke(Request $request, string $id): JsonResponse
    {
        $data = $request->json()->all();
        $status = $data['status'] ?? '';

        try {
            $command = match ($status) {
                ValidationState::ACCEPTED->value => new AccepteBookingCommand($id, $status),
                ValidationState::REFUSED->value => new RefuseBookingCommand($id, $status),
                default => null,
            };

            if (null === $command) {
                return response()->json(['error' => self::NO_VALIDATION_FOUNDED], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $this->commandBus->handle($command);

            return response()->json(EloquentBook::find((string) $id), Response::HTTP_CREATED);
        } catch (BookingNotExistException $exception) {
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (BookingNotAwaitAccepteException $exception) {
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (BookingNotAwaitRefuseException $exception) {
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
