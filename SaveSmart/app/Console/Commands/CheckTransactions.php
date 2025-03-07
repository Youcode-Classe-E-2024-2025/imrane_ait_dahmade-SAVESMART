<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use Carbon\Carbon;

class CheckTransactions extends Command
{
    protected $signature = 'transactions:check';
    protected $description = 'Vérifier les transactions du mois en cours';

    public function handle()
    {
        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');

        $transactions = Transaction::whereDate('date', '>=', $startOfMonth)
            ->whereDate('date', '<=', $endOfMonth)
            ->get();

        $this->info('Période : ' . $startOfMonth . ' à ' . $endOfMonth);
        $this->info('Nombre de transactions : ' . $transactions->count());

        foreach ($transactions as $transaction) {
            $this->line(sprintf(
                "ID: %d, Date: %s, Type: %s, Montant: %.2f€",
                $transaction->id,
                $transaction->date->format('Y-m-d'),
                $transaction->type,
                $transaction->amount
            ));
        }

        $income = $transactions->where('type', 'income')->sum('amount');
        $expenses = $transactions->where('type', 'expense')->sum('amount');

        $this->info('Total revenus : ' . $income . '€');
        $this->info('Total dépenses : ' . $expenses . '€');
    }
}

