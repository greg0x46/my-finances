<?php

namespace App\Console\Commands;


use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\CDI;

class GetCDI extends Command
{
    protected $signature = 'cdi:get {--start}';
    protected $description = 'Update CDI data.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $endpoint = 'https://api.bcb.gov.br/dados/serie/bcdata.sgs.11/dados?formato=json';

        if (!$this->option('start')) {
            $day = today()->subDay()->format('d/m/Y');
            $endpoint .= "&dataInicial=$day&dataFinal=$day";
        }

        $response = Http::get($endpoint)->json();

        foreach ($response as $item) {
            CDI::updateOrCreate(
                ['day' => Carbon::createFromFormat('d/m/Y', $item['data'])],
                ['value' => $item['valor']]
            );
        }

        return Command::SUCCESS;
    }
}
