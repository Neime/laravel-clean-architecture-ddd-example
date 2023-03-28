<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Presentation\API;

use App\Bank\Wallet\Application\CreateWallet\CreateWalletCommand;
use App\Bank\Wallet\Application\CreateWallet\UserNotExistException;
use App\Bank\Wallet\Application\CreateWallet\WalletAlreadyExistException;
use App\Bank\Wallet\Infrastructure\Laravel\EloquentTransaction;
use App\Shared\Application\CommandBus;
use App\Shared\Domain\ValueObject\UuidValueObject;
use App\Shared\Infrastructure\Laravel\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class CreateWalletController extends Controller
{
    public function __construct(private readonly CommandBus $commandBus)
    {
    }

    public function __invoke(Request $request)
    {
        $data = $request->json()->all();

        $id = UuidValueObject::random();
        $userId = $data['user_id'] ?? '';
        $currency = $data['currency'] ?? '';

        try {
            $command = new CreateWalletCommand(
                (string) $id,
                $userId,
                $currency
            );

            $this->commandBus->handle($command);

            return response()->json(EloquentTransaction::find((string) $id), Response::HTTP_CREATED);
        } catch (UserNotExistException $exception) {
            return response()->json([self::ERROR => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (WalletAlreadyExistException $exception) {
            return response()->json([self::ERROR => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
