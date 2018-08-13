<?php
namespace App\models\utils;
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 16/7/18
 * Time: 1:29 PM
 */
class TableFieldMap{
    const MEMBER_ID     = 'member_id';
    const DEALER_CODE   = 'dealer_code';
    const PERIOD        = 'period';

    /**
     * Get the field name map for Service Advisors
     * @return array
     */
    public static function ServiceAdvisorsTable(){
        $map = [
            'period'                =>'d_statement',
            'member_id'             =>'_amb_id',
            'dealer_code'           =>'dcode',
            'credit_bf'             =>'credits_carried_forward',

            'recom_score'           =>'ce_score_OSAT',
            'recom_credit'          =>'credits_ce_OSAT',
            'trust_score'           =>'ce_score_VFM',
            'trust_credit'          =>'credits_ce_VFM',
            'fu_score'              =>'ce_score_AYCT',
            'fu_credit'             =>'credits_ce_AYCT',
            'emw_score'             =>'sales_emw_gen',
            'emw_credit'            =>'credits_emw_gen',

            'training'              =>'credits_training_online',
            'pathway'               =>'credits_training_pathway',
            'registration'          =>'credits_registration',
            'incentive'             =>'credits_incentive',
            'adjustment'            =>'credits_adjustment',
            'excellence'            =>'credits_excellence',
            'credit_mtd'            =>'CREDITS_MONTHLY',
            'credit_ytd'            =>'CREDITS_YTD',
            'lifetime'              =>'CREDITS_ytd_lifetime',
            'cpr'                   =>'percentage_CPR_',
            'cpr_credit'            =>'credits_CPR_order',
        ];

        $newFieldsNeedToBeCreated = [];
        return $map;
    }

    /**
     * Get the field name map for Stock Controller
     * @return array
     */
    public static function StockControllerTable(){
        $map = [
            'period'                =>'d_statement',
            'member_id'             =>'_amb_id',
            'dealer_code'           =>'dcode',
            'credit_bf'             =>'credits_carried_forward',

            'stock'                 =>'days_stock',
            'stock_credit'          =>'credits_stock',
            'ow'                    =>'ow_data',
            'ow_credit'             =>'credits_ow_data',
            'retail'                =>'retail_forecast_achieved',
            'retail_credit'         =>'credits_retail_forecast',
            'matched'               =>'ow_match',
            'matched_credit'        =>'credits_ow_match',
            'davo'                  =>'percentage_davo',
            'davo_credit'           =>'credits_davo',

            'training'              =>'credits_training_online',
            'pathway'               =>'credits_training_pathway',
            'registration'          =>'credits_registration',
            'incentive'             =>'credits_incentive',
            'adjustment'            =>'credits_adjustment',
            'excellence'            =>'credits_excellence',
            'credit_mtd'            =>'CREDITS_MONTHLY',
            'credit_ytd'            =>'CREDITS_YTD',
            'lifetime'              =>'CREDITS_ytd_lifetime',
        ];

        $newFieldsNeedToBeCreated = [];
        return $map;
    }

    /**
     * Get the field name map for Parts Manager
     * @return array
     */
    public static function PartsManagerTable(){
        $map = [
            'period'                =>'d_statement',
            'member_id'             =>'_amb_id',
            'dealer_code'           =>'dcode',
            'credit_bf'             =>'credits_carried_forward',

            'grp'                   =>'percentage_grp',
            'grp_credit'            =>'credits_GRP',
            'gas'                   =>'percentage_gas',
            'gas_credit'            =>'credits_GAS',

            'training'              =>'credits_training_online',
            'pathway'               =>'credits_training_pathway',
            'registration'          =>'credits_registration',
            'incentive'             =>'credits_incentive',
            'adjustment'            =>'credits_adjustment',
            'excellence'            =>'credits_excellence',
            'credit_mtd'            =>'CREDITS_MONTHLY',
            'credit_ytd'            =>'CREDITS_YTD',
            'lifetime'              =>'CREDITS_ytd_lifetime',
        ];

        $newFieldsNeedToBeCreated = [];
        return $map;
    }

    /**
     * Get the field name map for Finance Controller
     * @return array
     */
    public static function FinanceControllerTable(){
        $map = [
            'period'                =>'d_statement',
            'member_id'             =>'_amb_id',
            'dealer_code'           =>'dcode',
            'credit_bf'             =>'credits_carried_forward',
            'frequency'             =>'bmo_frequency',
            'frequency_credits'     =>'credits_frequency',
            'ontime'                =>'bmo_ontime',
            'ontime_credits'        =>'credits_ontime',
            'balance'               =>'bmo_balance',
            'balance_credit'        =>'credits_balance',
            'quality'               =>'bmo_qlty_sub',
            'quality_credit'        =>'credits_qlty_sub',
            'checklist'             =>'bmo_checklist',
            'checklist_credit'      =>'credits_bmo_checklist',
            'meeting'               =>'bmo_meeting',
            'meeting_credit'        =>'credits_bmo_meetings',

            'training'              =>'credits_training_online',
            'pathway'               =>'credits_training_pathway',
            'registration'          =>'credits_registration',
            'incentive'             =>'credits_incentive',
            'adjustment'            =>'credits_adjustment',
            'excellence'            =>'credits_excellence',
            'credit_mtd'            =>'CREDITS_MONTHLY',
            'credit_ytd'            =>'CREDITS_YTD',
            'lifetime'              =>'CREDITS_ytd_lifetime',
        ];

        $newFieldsNeedToBeCreated = [];
        return $map;
    }

    /**
     * Get the field name map for FI Administration
     * @return array
     */
    public static function FiAdministrationTable(){
        $map = [
            'period'                =>'d_statement',
            'member_id'             =>'_amb_id',
            'dealer_code'           =>'dcode',
            'credit_bf'             =>'credits_carried_forward',

            'sales_nfsa'            =>'sales_nfsa_nissan',
            'credit_actual_sales'   =>'credits_actual_sales',
            'sales_mvi'             =>'sales_ins_MVI',
            'credits_mvi'           =>'credits_ins_MVI_CMP',
            'sales_vpi'             =>'sales_ins_VPI',
            'credits_vpi'           =>'credits_ins_VPI',
            'sales_pkg'             =>'sales_ins_pkg',
            'credits_pkg'           =>'credits_ins_pkg',
            'sales_emw'             =>'sales_emw_gen',
            'credits_emw'           =>'credits_emw_gen',
            'sales_mmu'             =>'sales_ins_MMU_ext',
            'credits_mmu'           =>'credits_ins_MMU_ext',
            'penetration'           =>'percentage_penetration',
            'credits_penetration'   =>'credits_penetration',
            'score_fi'              =>'ce_score_FISAT',
            'credits_fi'            =>'credits_ce_FISAT',
            'registration'          =>'credits_registration',
            'incentive'             =>'credits_incentive',
            'adjustment'            =>'credits_adjustment',
            'excellence'            =>'credits_excellence',
            'credit_mtd'            =>'CREDITS_MONTHLY',
            'credit_ytd'            =>'CREDITS_YTD',
            'lifetime'              =>'CREDITS_ytd_lifetime',
            'sales_nfsa_retention'    =>'sales_nfsa_retention',
            'credits_nfsa_retention'  =>'credits_nfsa_retention',
        ];

        $newFieldsNeedToBeCreated = [];
        return $map;
    }

    /**
     * Get the field name map for Consultant Sales
     * @return array
     */
    public static function ConsultantSalesTable(){
        $map = [
            'period'                =>'d_statement',
            'member_id'             =>'_amb_id',
            'dealer_code'           =>'dcode',
            'credit_bf'             =>'credits_carried_forward',
            'sales'                 =>'sales',
            'credit_actual_sales'   =>'credits_actual_sales',
            'score_recommendation'  =>'ce_score_OSAT',
            'ce_recommendation'     =>'credits_ce_OSAT',
            'follow_up_score'       =>'ce_score_FU',
            'follow_up_credit'      =>'credits_ce_FU',
            'training'              =>'credits_training_online',
            'pathway'               =>'credits_training_pathway',
            'registration'          =>'credits_registration',
            'incentive'             =>'credits_incentive',
            'adjustment'            =>'credits_adjustment',
            'excellence'            =>'credits_excellence',
            'credit_mtd'            =>'CREDITS_MONTHLY',
            'credit_ytd'            =>'CREDITS_YTD',
            'lifetime'              =>'CREDITS_ytd_lifetime',
        ];

        $newFieldsNeedToBeCreated = [];
        return $map;
    }

    /**
     * Get the field name map for services manager
     * @return array
     */
    public static function ServiceManagerTable(){
        $map = [
            'period'                =>'d_statement',
            'member_id'             =>'_amb_id',
            'dealer_code'           =>'dcode',
            'credit_bf'             =>'credits_carried_forward',
            'recommendation'        =>'ce_score_OSAT',
            'recommendation_credit' =>'credits_ce_OSAT',
            'vclean'                =>'ce_score_VFM',
            'vclean_credit'         =>'credits_ce_VFM',
            'followup'              =>'ce_score_FFT',
            'followup_credit'       =>'credits_ce_FFT',
            'emw'                   =>'sales_emw_gen',
            'emw_credit'            =>'credits_emw_gen',
            'training'              =>'credits_training_online',
            'pathway'               =>'credits_training_pathway',
            'registration'          =>'credits_registration',
            'incentive'             =>'credits_incentive',
            'adjustment'            =>'credits_adjustment',
            'excellence'            =>'credits_excellence',
            'credit_mtd'            =>'CREDITS_MONTHLY',
            'credit_ytd'            =>'CREDITS_YTD',
            'lifetime'              =>'CREDITS_ytd_lifetime',
            // New fields, added on July/2018
            'cpr'                   =>'percentage_CPR_',
            'cpr_credit'            =>'credits_CPR_order',
        ];
        return $map;
    }

    /**
     * Get the field name map for services manager
     * @return array
     */
    public static function SalesManagerTable(){
        $map = [
            'period'                =>'d_statement',
            'member_id'             =>'_amb_id',
            'dealer_code'           =>'dcode',
            'credit_bf'             =>'credits_carried_forward',
            'percent'               =>'percentage_actual',
            'actual_sales'          =>'credits_actual_sales',
            'score_recommendation'  =>'ce_score_OSAT',
            'ce_recomendation'      =>'credits_ce_OSAT',
            'follow_up_score'       =>'ce_score_FU',
            'follow_up_ce'          =>'credits_ce_FU',
            'training'              =>'credits_training_online',
            'pathway'               =>'credits_training_pathway',
            'registration'          =>'credits_registration',
            'incentive'             =>'credits_incentive',
            'adjustment'            =>'credits_adjustment',
            'excellence'            =>'credits_excellence',
            'credit_mtd'            =>'CREDITS_MONTHLY',
            'credit_ytd'            =>'CREDITS_YTD',
            'lifetime'              =>'CREDITS_ytd_lifetime',
            'retail_percentage'     =>'retail_forecast_achieved',
            'retail_midmth'         =>'credits_retail_forecast',
            'order_write_credit'    =>'credits_ow_match',
            'order_write_variation' =>'ow_match',
//            'de_bonus'              =>'CREDITS_ytd_lifetime',
//            'additional'              =>'CREDITS_ytd_lifetime',
//            'retail_percentage'            =>'credits_ce_FU',
//            'retail_midmth'            =>'credits_ce_FU',
        ];

        $newFieldsNeedToBeCreated = [];
        return $map;
    }

    /**
     * Get the field name map for services manager
     * @return array
     */
    public static function PartnerRepresentativeTable(){
        $map = [
            'period'                =>'d_statement',
            'member_id'             =>'_amb_id',
            'dealer_code'           =>'dcode',

            'credit_bf'             =>'credits_carried_forward',
            'grp'                   =>'percentage_grp',
            'grp_credit'            =>'credits_GRP',
            'training'              =>'credits_training_online',
            'pathway'               =>'credits_training_pathway',
//            'classroom'             =>'ignore',   // Just ignore this
            'registration'          =>'credits_registration',
            'incentive'             =>'credits_incentive',
            'adjustment'            =>'credits_adjustment',
            'excellence'            =>'credits_excellence',
            'credit_mtd'            =>'CREDITS_MONTHLY',
            'credit_ytd'            =>'CREDITS_YTD',
            'lifetime'              =>'CREDITS_ytd_lifetime',
        ];

        $newFieldsNeedToBeCreated = [];
        return $map;
    }
}