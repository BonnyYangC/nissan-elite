<?php

namespace App\Services\DataMappingServices;


class FI extends MonthlyDataMapping {

    /**
     * @param $row
     * @return array
     */
    protected function metricsMapping($row): array {
        return [
            'nfsa' => $row['points_nfsa'] !== '' ? intval($row['points_nfsa']) : 0,
            'nfsa_result' => $row['sales_nfsa_'] !== '' ? intval($row['sales_nfsa_']) : 0,

            'lrb' => $row['points_nfsa_LRB_'] !== '' ? intval($row['points_nfsa_LRB_']) : 0,
            'lrb_result' => $row['sales_nfsa_LRB_'] !== '' ? intval($row['sales_nfsa_LRB_']) : 0,

            'insurance_mvi' => $row['points_nfsa_MVI_'] !== '' ? intval($row['points_nfsa_MVI_']) : 0,
            'insurance_mvi_result' => $row['sales_nfsa_MVI_'] !== '' ? intval($row['sales_nfsa_MVI_']) : 0,
            'insurance_pkg' => $row['points_nfsa_PKG_'] !== '' ? intval($row['points_nfsa_PKG_']) : 0,
            'insurance_pkg_result' => $row['sales_nfsa_PKG_'] !== '' ? intval($row['sales_nfsa_PKG_']) : 0,

            'penetration' => $row['points_nfsa_PEN_'] !== '' ? intval($row['points_nfsa_PEN_']) : 0,
            'penetration_result' => ($row['pcent_nfsa_PEN_'] !== '' ? number_format(floatval($row['pcent_nfsa_PEN_'])*100) : '0') . '%',

            'pmp' => $row['points_PMP'] !== '' ? intval($row['points_PMP']) : 0,
            'pmp_result' => $row['sales_PMP'] !== '' ? intval($row['sales_PMP']) : 0,

            'nfv' => $row['points_NFV'] !== '' ? intval($row['points_NFV']) : 0,
            'nfv_result' => $row['sales_NFV'] !== '' ? intval($row['sales_NFV']) : 0,
            'nfv_nfsa' => $row['points_NFV%'] !== '' ? intval($row['points_NFV%']) : 0,
            'nfv_nfsa_result' => ($row['pcent_NFV%'] !== '' ? number_format(floatval($row['pcent_NFV%'])*100) : '0') . '%',

            'nic_sale_nfsa' => $row['points_NIC_Fnfsa'] !== '' ? intval($row['points_NIC_Fnfsa']) : 0,
            'nic_sale_nfsa_result' => $row['sales_NIC_Fnfsa'] !== '' ? intval($row['sales_NIC_Fnfsa']) : 0,

            'satisfaction' => $row['points_ce_EFI3_'] !== '' ? intval($row['points_ce_EFI3_']) : 0,
            'satisfaction_result' => $row['score_ce_EFI3_'] !== '' ? floatval($row['score_ce_EFI3_']) : 0.0,
        ];
    }
}
