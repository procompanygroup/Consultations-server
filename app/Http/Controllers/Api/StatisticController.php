<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Selectedservice;

use App\Models\Expert;

use Illuminate\Support\Facades\DB;


use Illuminate\Support\Carbon;

use App\Models\Service;
use App\Http\Controllers\Api\StorageController;

class StatisticController extends Controller
{

    //  public $path = 'images/experts';
    // public $recordpath = 'images/experts/records';
    /**
     * Display a listing of the resource.
     */
    public $id = 0;
    public $pointtransfer_id = 0;
    public $oldestday = 30;


    public function expert_statistics($expert_id)
    {
        $strgCtrlr = new StorageController();
        $iconurl = $strgCtrlr->ServicePath('icon');
        $defaultsvg = $strgCtrlr->DefaultPath('icon');
        $nowsub = Carbon::now()->subDays($this->oldestday);

        //group services
        $serviceIds = Selectedservice::where('expert_id', $expert_id)->
            where(function ($query) {
                $query->where('comment_state', 'agree')
                    ->orWhere('rate', '>', 0);
            })
            ->whereDate('created_at', '>=', $nowsub)
            ->groupBy('service_id')->select('service_id')->get();
        //group service client for comment and rate
        $service_clientIds = Selectedservice::where('expert_id', $expert_id)->
            where(function ($query) {
                $query->where('comment_state', 'agree')
                    ->orWhere('rate', '>', 0);
            })->whereDate('created_at', '>=', $nowsub)
            ->groupBy('service_id', 'client_id')->select('service_id', 'client_id')->get();
        $rate_id_list = [];
        // $admin_rate_id_list = [];
        $comment_id_list = [];
        foreach ($service_clientIds as $service_clint_row) {
            //group service client rate
            //rate 
            $rate_Id = Selectedservice::where('expert_id', $expert_id)->
                where('service_id', $service_clint_row->service_id)->
                where('client_id', $service_clint_row->client_id)->
                where('rate', '>', 0)
                ->whereDate('created_at', '>=', $nowsub)
                ->orderByDesc('rate_date')->select('id')->first();
            if ($rate_Id) {
                $rate_id_list[] = $rate_Id->id;
            }
            //admin rate 
            // $admin_rate_Id = Selectedservice::where('expert_id', $expert_id)->
            //     where('service_id', $service_clint_row->service_id)->
            //     where('client_id', $service_clint_row->client_id)->
            //     where('comment_state', 'agree')->
            //     where('comment_rate', '>', 0)
            //     ->orderByDesc('comment_rate_date')->select('id')->first();
            // if ($admin_rate_Id) {
            //     $admin_rate_id_list[] = $admin_rate_Id->id;
            // }

        }
        $last_service_list = [];
        foreach ($serviceIds as $service_row) {
            //rate
            $rateavg = Selectedservice::where('expert_id', $expert_id)
                ->where('service_id', $service_row->service_id)
                //   ->whereDate('created_at', '>=', $nowsub)
                ->whereIntegerInRaw('id', $rate_id_list)->select('rate')->average('rate');
            //admin rate avg
            // $adminrateavg = Selectedservice::where('expert_id', $expert_id)
            //     ->where('service_id', $service_row->service_id)
            //     ->whereIn('id', $admin_rate_id_list)->select('comment_rate')->average('comment_rate');


            //     $finalrate = 0;
            // if ($rateavg == 0 || $adminrateavg == 0) {
            //     $finalrate = ($rateavg + $adminrateavg);
            // } else {
            //     $finalrate = ($rateavg + $adminrateavg) / 2;
            // }
            //2.1 ->3
            $finalrate = ceil($rateavg);
            //comment
            $commentrow = Selectedservice::where('expert_id', $expert_id)
                ->where('service_id', $service_row->service_id)
                ->where('comment_state', 'agree')
                ->whereDate('created_at', '>=', $nowsub)
                ->orderByDesc('comment_date')->select('comment')->first();
            $finalcomment = '';
            if ($commentrow) {
                $finalcomment = $commentrow->comment;
            }
            $service = Service::select(
                'id',
                'name',
                DB::raw("(CASE 
                    WHEN services.icon is NULL THEN '$defaultsvg'                    
                    ELSE CONCAT('$iconurl',icon)
                    END) AS icon")
            )->find($service_row->service_id);
            $arrayservice = [
                'service_id' => $service->id,
                'name' => $service->name,
                'icon' => $service->icon,
                'rate' => $finalrate,
                'comment' => $finalcomment,
            ];
            $last_service_list[] = $arrayservice;
        }
        $expert = Expert::select('id', 'answer_speed')->find($expert_id);
        $answerspeed = $expert->answer_speed;

        //  return response()->json(['answer_speed' => $answerspeed, 'service_statistics' => $last_service_list]);
        return [
            'answer_speed' => $answerspeed,
            'service_statistics' => $last_service_list
        ];
    }

    public function all_expert_statistics()
    {
        $experts = Expert::get();
        $Arr = [];
        foreach ($experts as $expert) {
            $stsresArr = $this->expert_statistics($expert->id);
            if ($stsresArr) {
                // $newArr=[];          
                foreach ($stsresArr['service_statistics'] as $service_sts) {
                    $newArr = [
                        'answer_speed' => $stsresArr['answer_speed'],
                        'full_name' => $expert->full_name,
                        'expert_id' => $expert->id,
                        "service_id" => $service_sts['service_id'],
                        "service_name" => $service_sts['name'],
                        "icon" => $service_sts['icon'],
                        "rate" => $service_sts['rate'],
                        "comment" => $service_sts['comment'],
                    ];
                    $Arr[] = $newArr;
                }
            }
        }
        return $Arr;
    }

}