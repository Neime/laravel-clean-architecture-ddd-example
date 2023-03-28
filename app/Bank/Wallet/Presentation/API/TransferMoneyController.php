<?php

declare(strict_types=1);

namespace App\Bank\Wallet\Presentation\API;

use App\Bank\Wallet\Application\Shared\CurrencyMismatchException;
use App\Bank\Wallet\Application\Shared\WalletNotExistException;
use App\Bank\Wallet\Application\TransferMoney\TransferMoneyCommand;
use App\Shared\Application\CommandBus;
use App\Shared\Infrastructure\Laravel\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class TransferMoneyController extends Controller
{
    public function __construct(private readonly CommandBus $commandBus)
    {
    }

    public function __invoke(Request $request, string $walletId, string $toWalletId)
    {
        $data = $request->json()->all();

        $amount = $data['amount'] ?? '';
        $currency = $data['currency'] ?? '';

        try {
            $command = new TransferMoneyCommand(
                $walletId,
                $toWalletId,
                $amount,
                $currency
            );

            $this->commandBus->handle($command);

            return response()->json([], Response::HTTP_CREATED);
        } catch (\InvalidArgumentException $exception) {
            return response()->json([self::ERROR => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (WalletNotExistException $exception) {
            return response()->json([self::ERROR => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (CurrencyMismatchException $exception) {
            return response()->json([self::ERROR => $exception->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
