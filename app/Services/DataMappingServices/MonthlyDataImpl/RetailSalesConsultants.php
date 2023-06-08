<?php

namespace App\Services\DataMappingServices\MonthlyDataImpl;

use App\Services\DataMappingServices\MonthlyDataMapping;

class RetailSalesConsultants extends MonthlyDataMapping {
    /** @var array  */
    public $metricsMappingArray = [
        'new_vehicle' => 'points_SALES_STATUS_',
        'new_vehicle_result' => 'sales_status',
        'new_vehicle_performance' => 'points_NVR',
        'new_vehicle_performance_result' => 'pcent_ACT_S',

        'nfv' => 'points_NFV%',
        'nfv_result' => 'pcent_NFV%',

        'nic_sale' => 'points_NIC',
        'nic_sale_result' => 'sales_NIC',
        'nic_sale_nfsa' => 'points_NIC_Fnfsa',
        'nic_sale_nfsa_result' => 'sales_NIC_fnfsa',

        'pmp' => 'points_PMP',
        'pmp_result' => 'sales_PMP',

        'sos' => 'points_ce_SOS3',
        'sos_result' => 'score_ce_SOS3',

        'kept_informed' => 'points_ce_KID3',
        'kept_informed_result' => 'score_ce_KID3',

        'follow_up' => 'points_ce_FUS3',
        'follow_up_result' => 'score_ce_FUS3',

        'sdr' => 'points_ce_5STAR',
        'sdr_result' => 'score_ce_5STAR',
    ];

  
}
