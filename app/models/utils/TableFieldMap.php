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
    const EMPLOYEE_CODE = 'employee_code';
    const COMPANY_CODE  = 'company_code';   // This is for the company table ONLY

    /**
     * Get the user's table map
     * @return array
     */
    public static function UserTable(){
        $map = [
            'employee_code'=>'_amb_id',
            'salutation'=>'n_title',
            'firstname'=>'n_fname_trim',
            'lastname'=>'n_sname_trim',
            'mobile'=>'ph_mobile',
            'email'=>'addr_email',
            'company_code'=>'d_code',
            'position'=>'sp',   // position
            'dept'=>'amba~LMSd_ambidAmthyr::dept_code',
            'active'=>'status',
            'registered'=>'registered',
            'member'=>'ac_mbr',
        ];

        return $map;
    }

    /**
     * Get the field name map for Service Advisors
     * @return array
     */
    public static function ServiceAdvisorsTable(){
        $map = [
            'period'                =>'mth_yr',
//            'period'                =>'d_statement',
            'member_id'             =>'_amb_id',
            'dealer_code'           =>'dcode',
            'credit_bf'             =>'credits_carried_forward',

            'recom_score'           =>'ce_score_OSAT',
            'recom_credit'          =>'credits_ce_OSAT',

            'trust_score'           =>'ce_score_AYCT',
            'trust_credit'          =>'credits_ce_AYCT',

            'fu_score'              =>'ce_score_VFM',
            'fu_credit'             =>'credits_ce_VFM',
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
        return $map;

        /**
        'trust_score'           =>'ce_score_VFM',
        'trust_credit'          =>'credits_ce_VFM',
        'fu_score'              =>'ce_score_AYCT',
        'fu_credit'             =>'credits_ce_AYCT',
         */
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
            'period'                =>'mth_yr',
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
            'period'                =>'mth_yr',
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
            'classroom'             =>'credits_training_classroom',
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

    /**
     * Get map for region territory reports table
     * @return array
     */
    public static function RegionTerritoryReportTable(){
        $map = [
            'dsm_full_name'         =>'amba_deal~REGI_rcode::n_fullname',
            'region_name'           =>'amba_deal~REGI_rcode::r_name',
            'region_code'           =>'amba_deal~REGI_rcode::r_code',
            'dealer_code'           =>'d_code',
            'dealer_name'           =>'d_name',
            'dealer_cat'            =>'d_cat',  // Dealer's category, metro or district ...
            'sp_code'               =>'sp_code',
            'employee_code'         =>'_amb_id',
            'n_fullname'            =>'n_fullname',
            'position'              =>'position',
            'registered'            =>'registered',
            'credits_monthly_04'    =>'amba_STAT_04_apr::CREDITS_MONTHLY',
            'credits_monthly_05'    =>'amba_STAT_05_may::CREDITS_MONTHLY',
            'credits_monthly_06'    =>'amba_STAT_06_jun::CREDITS_MONTHLY',
            'credits_monthly_07'    =>'amba_STAT_07_jul::CREDITS_MONTHLY',
            'credits_monthly_08'    =>'amba_STAT_08_aug::CREDITS_MONTHLY',
            'credits_monthly_09'    =>'amba_STAT_09_sep::CREDITS_MONTHLY',
            'credits_monthly_10'    =>'amba_STAT_10_oct::CREDITS_MONTHLY',
            'credits_monthly_11'    =>'amba_STAT_11_nov::CREDITS_MONTHLY',
            'credits_monthly_12'    =>'amba_STAT_12_dec::CREDITS_MONTHLY',
            'credits_monthly_01'    =>'amba_STAT_01_jan::CREDITS_MONTHLY',
            'credits_monthly_02'    =>'amba_STAT_02_feb::CREDITS_MONTHLY',
            'credits_monthly_03'    =>'amba_STAT_03_mar::CREDITS_MONTHLY',
            'cr_ytd'                =>'amba_STAT_ambid_gmthyr::CREDITS_YTD',
        ];
        return $map;
    }

    /**
     * Get map for nissan credits table
     * @return array
     */
    public static function NissanCreditsTable(){
        $map = [
            'period'        =>'mth_yr',
            'member_id'     =>'_amb_id',
            'mtd'           =>'CREDITS_MONTHLY',
            'ytd'           =>'CREDITS_YTD',
//            'ytd'           =>'CREDITS_ytd_lifetime',
        ];
        return $map;
    }

    /**
     * Get map for nissan ranking table
     * @return array
     */
    public static function NissanRankingsTable(){
        $map = [
            'period'        =>'amba_STAT_ambid_gmthyr::mth_yr',
            'member_id'     =>'_amb_id',
            'dealer_code'   =>'d_code',
            'registered'    =>'registered',
            'category'      =>'d_cat',
            'ranking'       =>'ranking',
            'total'         =>'yr_2018',
            'role'          =>'sp',
        ];
        $newFieldsAddByJustin = [
            'region_code'           =>'r_code',
            'status'                =>'status',
            'dlr_excellence_bonus'  =>'dlr_excellence_bonus',
            'calc_dlr_exc'          =>'calc_dlr_exc',
        ];
        return array_merge($map, $newFieldsAddByJustin);
    }

    /**
     * Get map for nissan ranking table
     * @return array
     */
    public static function NissanDealersTable(){
        $map = [
            'company_name'          =>'d_name',
            'company_code'          =>'d_code',
            'company_address'       =>'addr_street',
            'company_suburb'        =>'addr_city',
            'company_postcode'      =>'addr_pcode',
            'company_state'         =>'addr_state',
            'company_phone'         =>'ph_tel',
            'company_fax'           =>'ph_fax',
            'category'              =>'d_cat',
            'category_code'         =>'d_cat_#',
            'region'                =>'r_name',
            'region_code'           =>'r_code',
        ];
        $newFieldsAddByJustin = [];
        return array_merge($map, $newFieldsAddByJustin);
    }
}