<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Presentation\API;

use App\Bank\Wallet\Application\CreateTransaction\CreateTransactionCommand;
use App\Bank\Wallet\Application\CreateTransaction\WalletNotExistException;
use App\Bank\Wallet\Infrastructure\Laravel\EloquentTransaction;
use App\Shared\Application\CommandBus;
use App\Shared\Domain\ValueObject\UuidValueObject;
use App\Shared\Infrastructure\Laravel\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class CreateTransactionController extends Controller
{
    public function __construct(private readonly CommandBus $commandBus)
    {
    }

    public function __invoke(Request $request)
    {
        $data = $request->json()->all();

        $id = UuidValueObject::random();
        $walletId = $data['wallet_id'] ?? '';
        $amount = $data['amount'] ?? '';
        $currency = $data['currency'] ?? '';

        try {
            $command = new CreateTransactionCommand(
                (string) $id,
                $walletId,
                $amount,
                $currency
            );

            $this->commandBus->handle($command);

            return response()->json(EloquentTransaction::find((string) $id), Response::HTTP_CREATED);
        } catch (\InvalidArgumentException $exception) {
            return response()->json([self::ERROR => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (WalletNotExistException $exception) {
            return response()->json([self::ERROR => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
