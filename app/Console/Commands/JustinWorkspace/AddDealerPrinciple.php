<?php

namespace App\Console\Commands\JustinWorkspace;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class AddDealerPrinciple extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:dp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update nissan dp staff';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dpCsvFile = __DIR__ . '/dp2024.csv';

        $fd = fopen($dpCsvFile, 'r');

        $notFound = [];

        while (($buffer = fgets($fd)) !== false){
            $row = explode(",",$buffer);
            $dealerCode = $row[0];
            $dpEmail = $row[3];

            $staff = User::where('dealer_code', $dealerCode)->where('email',$dpEmail)->first();

            if ($staff){
                $staff->position_code = 'D';
                $staff->save();
            }
            else{
                $notFound[] = $row;
            }
        }

        fclose($fd);

        if (count($notFound) > 0){
            $dpNotFoundFile = __DIR__ . '/dp_not_found.csv';
            $content = '';
            foreach ($notFound as $item) {
                $item[] = strtoupper($item[2]).'1';
                $item[5] = str_replace("\n",'',$item[5]);
                $this->createNewDpAndReturnPassword($item);
                $content .= implode(',',$item) . "\n";
            }

//            file_put_contents($dpNotFoundFile, $content);
        }

        return 0;
    }

    private function createNewDpAndReturnPassword($row)
    {
        $userData = [
            'employee_code'=>null,
            'salutation'=>null,
            'firstname'=>$row[1],
            'lastname'=>$row[2],
            'email'=>$row[3],
            'mobile'=>null,
            'date_birth'=>null,
            'password' => Hash::make($row[6]),
            'dealer_code'=>$row[0],
            'position_code'=> 'D',
            'dept'=>null,
            'active'=>1,
            'region_code'=>substr($row[5],0,1),
            'admin'=>0,
        ];
        User::create($userData);
    }
}
