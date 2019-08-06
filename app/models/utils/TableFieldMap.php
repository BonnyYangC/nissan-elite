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
    const EMAIL         = 'email';  // for users table
    const COMPANY_CODE  = 'company_code';   // This is for the company table ONLY

    /**
     * Get the user's table map
     * @return array
     */
    public static function UserTable(){
        $map = [
            'employee_code'=>'regi#',//'_amb_id',
            'salutation'=>'n_title',
            'firstname'=>'n_fname_trim',
            'lastname'=>'n_sname_trim',
            'mobile'=>'ph_mobile',
            'email'=>'addr_email',
            'company_code'=>'dcode',//'d_code',
            'position'=>'sp',   // ==position
            'dept'=>'dept_code',//'amba~LMSd_ambidAmthyr::dept_code',
            'active'=>'status',
            'registered'=>'registered',
            'member'=>'elite_mbr',//'ac_mbr',
            'dob'=>'date_birth',//'date_of_birth',
            'date_created'=>'date_created',
            'met_criteria' => 'criteria_met_EOY',//'amba_STAT_ambid_gmthyr::eligible_EOY'
        ];

        return $map;
    }

    /**
     * Get map for nissan dealer(company) table
     * @return array
     */
    public static function NissanDealersTable(){
        $map = [
            'company_name'          =>'dname',//'d_name',
            'company_code'          =>'dcode',//'d_code',
            'company_address'       =>'addr_street',
            'company_suburb'        =>'addr_city',
            'company_postcode'      =>'addr_pcode',
            'company_state'         =>'addr_state',
            'company_phone'         =>'ph_tel',
            'company_fax'           =>'ph_fax',
            'category'              =>'dcat',//'d_cat',
            'category_code'         =>'dcat#',//'d_cat_#',
            'region'                =>'rname',//'r_name',
            'region_code'           =>'rcode',//'r_code',
        ];
        $newFieldsAddByJustin = [];
        return array_merge($map, $newFieldsAddByJustin);
    }

    /**
     * Get the user's table map
     * @return array
     */
    public static function RegionStaffTable(){
        $map = [
            'position'=>'Position',
            'alt_position'=>'region',//'Region',
            'firstname'=>'first name',//'fname',
            'lastname'=>'last name',//'sname',
            'email'=>'Email Address',//'email',
            //'mobile'=>'mobile', //TBD
            'active' => 'active'
        ];
        return $map;
    }

    /**
     * Get the field name map for Service Advisors
     * @return array
     */
    public static function ServiceAdvisorsTable(){
        $map = [
            'period'                =>'mthyrg',//'mth_yr',
            'member_id'             =>'regi#',//'_amb_id',
            'dealer_code'           =>'dcode',
            'credit_bf'             =>'points_CARRIED',//'credits_carried_forward',
            'recom_score'           =>'score_ce_SOS', //sales overall satisfaction //'ce_score_OSAT',
            'recom_credit'          =>'points_ce_SOS', //'credits_ce_OSAT',
            'fu_score'              =>'score_ce_VFM',// value for money //'ce_score_VFM',
            'fu_credit'             =>'points_ce_VFM',//'credits_ce_VFM',
            'trust_score'           =>'score_ce_AYT',//advice you can trust  //'ce_score_AYCT',
            'trust_credit'          =>'points_ce_AYT',//'credits_ce_AYCT',
            'cpr'                   =>'percentage_CPRO', // custmer paid repair orders //'percentage_CPR_',
            'cpr_credit'            =>'points_CPRO',//'credits_CPR_order',
            /*'emw_score'             =>'sales_emw_gen',
            'emw_credit'            =>'credits_emw_gen',not using*/
            'training'              =>'points_train_online',//'credits_training_online',
            'training_competency'   =>'points_train_competency',//'credits_training_competency',
            'pathway'               =>'points_train_pathway',//'credits_training_pathway',
            'registration'          =>'points_registration',//'credits_registration',
            'incentive'             =>'points_incentive',//'credits_incentive',
            'adjustment'            =>'points_adjust',//'credits_adjustment',
            'excellence'            =>'points_excellence',//'credits_excellence',
            'credit_mtd'            =>'POINTS_MTHLY',//'CREDITS_MONTHLY',
            'credit_ytd'            =>'POINTS_YTD',//'CREDITS_YTD',
            'lifetime'              =>'POINTS_ytd_lifetime',//'CREDITS_ytd_lifetime',
        ];
        return $map;
    }

    /**
     * Get the field name map for Stock Controller
     * @return array
     */
    public static function StockControllerTable(){
        $map = [
            'period'                =>'d_statement',
            'member_id'             =>'regi#',//'_amb_id',
            'dealer_code'           =>'dcode',
            'credit_bf'             =>'points_CARRIED',//'credits_carried_forward',
            'stock'                 =>'stock_cover', //stock cover //'days_stock',
            'stock_credit'          =>'points_stock',//'credits_stock',
            'ow'                    =>'compliance_ow', //ow data entry compliance //'ow_data',
            'ow_credit'             =>'points_compliance',//'credits_ow_data',
            'retail'                =>'achieved_forecast', //dealer forecast //'retail_forecast_achieved',
            'retail_credit'         =>'points_forecast',//'credits_retail_forecast',
            'matched'               =>'matchOW', //matched ow compliance //'ow_match',
            'matched_credit'        =>'points_matchOW',//'credits_ow_match',
            'davo'                  =>'percentage_davo',//DAVO Orders //'percentage_davo',
            'davo_credit'           =>'points_davo',//'credits_davo',
            'training'              =>'points_train_online',//'credits_training_online',
            'training_competency'   =>'points_train_competency',//'credits_training_competency',
            'pathway'               =>'points_train_pathway',//'credits_training_pathway',
            'registration'          =>'points_registration',//'credits_registration',
            'incentive'             =>'points_incentive',//'credits_incentive',
            'adjustment'            =>'points_adjust',//'credits_adjustment',
            'excellence'            =>'points_excellence',//'credits_excellence',
            'credit_mtd'            =>'POINTS_MTHLY',//'CREDITS_MONTHLY',
            'credit_ytd'            =>'POINTS_YTD',//'CREDITS_YTD',
            'lifetime'              =>'POINTS_ytd_lifetime',//'CREDITS_ytd_lifetime',
        ];
        return $map;
    }

    /**
     * Get the field name map for Parts Manager
     * @return array
     */
    public static function PartsManagerTable(){
        $map = [
            'period'                =>'d_statement',
            'member_id'             =>'regi#', //'_amb_id',
            'dealer_code'           =>'dcode',
            'credit_bf'             =>'points_CARRIED',//'credits_carried_forward',
            'grp'                   =>'percentage_grp', //genuine replacement parts
            'grp_credit'            =>'points_GRP', //'credits_GRP',
            'gas'                   =>'percentage_acces',//'percentage_gas',
            'gas_credit'            =>'points_acces', //'credits_GAS',
            'training'              =>'points_train_online', //'credits_training_online',
            'training_competency'   =>'points_train_competency',//'credits_training_competency',
            'pathway'               =>'points_train_pathway',  //'credits_training_pathway',
            'registration'          =>'points_registration', //'credits_registration',
            'incentive'             =>'points_incentive',   //'credits_incentive',
            'adjustment'            =>'points_adjust',   //'credits_adjustment',
            'excellence'            =>'points_excellence',  //'credits_excellence',
            'credit_mtd'            =>'POINTS_MTHLY', //'CREDITS_MONTHLY',
            'credit_ytd'            =>'POINTS_YTD',  //'CREDITS_YTD',
            'lifetime'              =>'POINTS_ytd_lifetime'  //'CREDITS_ytd_lifetime',
        ];
        return $map;
    }

    /**
     * Get the field name map for Parts & Sales Representative
     * @return array
     */
    public static function PartnerRepresentativeTable(){
        $map = [
            'period'                =>'d_statement',
            'member_id'             =>'regi#',//'_amb_id',
            'dealer_code'           =>'dcode',
            'credit_bf'             =>'points_CARRIED', //'credits_carried_forward',
            'grp'                   =>'percentage_grp', //genuine replacement parts
            'grp_credit'            =>'points_GRP', //'credits_GRP',
            'genuine_acc'                   =>'percentage_acces',
            'genuine_acc_credit'            =>'points_acces', 
            'training'              =>'points_train_online',//'credits_training_online',
            'training_competency'   =>'points_train_competency',//'credits_training_competency',
            'pathway'               =>'points_train_pathway',//'credits_training_pathway',
            'training_bonus'               =>'points_train_bonus',
            'registration'          =>'points_registration',//'credits_registration',
            'incentive'             =>'points_incentive',//'credits_incentive',
            'adjustment'            =>'points_adjust',//'credits_adjustment',
            'excellence'            =>'points_excellence',//'credits_excellence',
            'credit_mtd'            =>'POINTS_MTHLY',//'CREDITS_MONTHLY',
            'credit_ytd'            =>'POINTS_YTD',//'CREDITS_YTD',
            'lifetime'              =>'POINTS_ytd_lifetime',//'CREDITS_ytd_lifetime',
        ];
        return $map;
    }

    /**
     * Get the field name map for Finance Controller
     * @return array
     */
    public static function FinanceControllerTable(){
        $map = [
            'period'                =>'mthyrg',//'mth_yr',
            'member_id'             =>'regi#',//'_amb_id',
            'dealer_code'           =>'dcode',
            'credit_bf'             =>'points_CARRIED',//'credits_carried_forward',
            'frequency'             =>'bmo_frequency', //dealer financial reporting - submitted
            'frequency_credits'     =>'points_frequency',//'credits_frequency',
            'quality'               =>'bmo_quality',//Quality of data submission //'bmo_qlty_sub',
            'quality_credit'        =>'points_quality',//'credits_qlty_sub',
            'checklist'             =>'bmo_checklist', //nissan business mgmt data accuracy
            'checklist_credit'      =>'points_checklist',//'credits_bmo_checklist',
            'meeting'               =>'bmo_meeting', //nissan business mgmt BDG attendance
            'meeting_credit'        =>'points_meetings',//'credits_bmo_meetings',
            /*'ontime'                =>'bmo_ontime',
            'ontime_credits'        =>'credits_ontime',
            'balance'               =>'bmo_balance',
            'balance_credit'        =>'credits_balance',*/
            'training'              =>'points_train_online',//'credits_training_online',
            'training_competency'   =>'points_train_competency',//'credits_training_competency',
            'pathway'               =>'points_train_pathway',//'credits_training_pathway',
            'registration'          =>'points_registration',//'credits_registration',
            'incentive'             =>'points_incentive',//'credits_incentive',
            'adjustment'            =>'points_adjust',//'credits_adjustment',
            'excellence'            =>'points_excellence',//'credits_excellence',
            'credit_mtd'            =>'POINTS_MTHLY',//'CREDITS_MONTHLY',
            'credit_ytd'            =>'POINTS_YTD',//'CREDITS_YTD',
            'lifetime'              =>'POINTS_ytd_lifetime',//'CREDITS_ytd_lifetime',
        ];
        return $map;
    }

    /**
     * Get the field name map for FI Administration
     * @return array
     */
    public static function FiAdministrationTable(){
        $map = [
            'period'                =>'mthyrg',//'mth_yr',
            'member_id'             =>'regi#',//'_amb_id',
            'dealer_code'           =>'dcode',
            'credit_bf'             =>'points_CARRIED',//'credits_carried_forward',
            'sales_nfsa'            =>'sales_nfsa',//nfsa finance contract //'sales_nfsa_nissan',
            'credit_actual_sales'   =>'points_nfsa',//'credits_actual_sales',
            'sales_nfsa_retention'    =>'sales_nfsa_bonus',//loyalty & retention //'sales_nfsa_retention',
            'credits_nfsa_retention'  =>'points_nfsa_bonus',//'credits_nfsa_retention',
            'sales_mvi'             =>'sales_ins_MVI', //MVI Motor Vehicle Insurance
            'credits_mvi'           =>'points_ins_MVI',//'credits_ins_MVI_CMP',
            /*'sales_vpi'             =>'sales_ins_VPI',
            'credits_vpi'           =>'credits_ins_VPI',*/
            'sales_pkg'             =>'sales_ins_pkg', //MVI & NFSA finance contract package
            'credits_pkg'           =>'points_ins_pkg',//'credits_ins_pkg',
            'sales_emw'             =>'sales_emw',//EMW sale Genuine (NAPS) //'sales_emw_gen',
            'credits_emw'           =>'points_emw',//'credits_emw_gen',
            /*'sales_mmu'             =>'sales_ins_MMU_ext',
            'credits_mmu'           =>'credits_ins_MMU_ext',*/
            'penetration'           =>'percentage_penetration', //dealer sales penetration
            'credits_penetration'   =>'points_penetration',//'credits_penetration',
            'score_fi'              =>'score_ce_FISAT1',//customer experience - satisfaction with finance & insurance   //'ce_score_FISAT',
            'credits_fi'            =>'points_ce_FISAT',//'credits_ce_FISAT',
            'registration'          =>'points_registration',//'credits_registration',
            'incentive'             =>'points_incentive',//'credits_incentive',
            'adjustment'            =>'points_adjust',//'credits_adjustment',
            'excellence'            =>'points_excellence',//'credits_excellence',
            'credit_mtd'            =>'POINTS_MTHLY',//'CREDITS_MONTHLY',
            'credit_ytd'            =>'POINTS_YTD',//'CREDITS_YTD',
            'lifetime'              =>'POINTS_ytd_lifetime',//'CREDITS_ytd_lifetime',
        ];
        return $map;
    }

    /**
     * Get the field name map for Fleet Sales Executives
     * @return array
     */
    public static function FleetSalesExecutivesTable(){
        $map = [
            'period'                =>'d_statement',
            'member_id'             =>'regi#', //'_amb_id',
            'dealer_code'           =>'dcode',
            'credit_bf'             =>'points_CARRIED',  //'credits_carried_forward',
            'sales'                 =>'sales_status',  //new vehicle sales //'sales',
            'credit_actual_sales'   =>'points_sales_status', //points for new vehicle sales //'credits_actual_sales',
            'v_fleet_target'  =>'percentage_actF',//'ce_score_OSAT', //percentage of fleet sales v fleet target 
            'v_fleet_target_score'     =>'points_actF',//'credits_ce_OSAT', //points for fleet sales v fleet target 
            'fleet_volumn_growth'       =>'percentage_actFV',//'ce_score_FU%', //percentage of fleet volume growth (quarterly)
            'fleet_volumn_growth_score'      =>'points_actFV',//'credits_ce_FU%', //points for fleet volume growth (quarterly)
            'training'              =>'points_train_online',//'credits_training_online', //training
            'training_competency'   =>'points_train_competency',//'credits_training_competency',  //training
            'pathway'               =>'points_train_pathway',//'credits_training_pathway',  //training
            'registration'          =>'points_registration',//'credits_registration',
            'incentive'             =>'points_incentive',//'credits_incentive',
            'adjustment'            =>'points_adjust',//'credits_adjustment',
            'excellence'            =>'points_excellence',//'credits_excellence',
            'credit_mtd'            =>'POINTS_MTHLY',//'CREDITS_MONTHLY',
            'credit_ytd'            =>'POINTS_YTD',//'CREDITS_YTD',
            'lifetime'              =>'POINTS_ytd_lifetime',//'CREDITS_ytd_lifetime',
        ];
        return $map;
    }

    /**
     * Get the field name map for Consultant Sales
     * @return array
     */
    public static function ConsultantSalesTable(){
        $map = [
            'period'                =>'d_statement',
            'member_id'             =>'regi#', //'_amb_id',
            'dealer_code'           =>'dcode',
            'credit_bf'             =>'points_CARRIED',  //'credits_carried_forward',
            'sales'                 =>'sales_status',  //new vehicle sales //'sales',
            'credit_actual_sales'   =>'points_sales_status', //points for new vehicle sales //'credits_actual_sales',
            'salesperson_satisfaction'  =>'score_ce_SOS',//percentage of salesperson satisfaction
            'salesperson_satisfaction_score'     =>'points_ce_SOS',//points for salesperson satisfaction
            'kept_informed_delivery_score'   =>'points_ce_KID', //points for kept informed of delivery
            'kept_informed_delivery'  =>'score_ce_KID', //kept informed of delivery
            'follow_up_satisfaction'       =>'score_ce_SFU',//satisfaction follow up
            'follow_up_satisfaction_score'      =>'points_ce_SFU',//points for satisfaction follow up
            'training'              =>'points_train_online',//'credits_training_online', //training
            'training_competency'   =>'points_train_competency',//'credits_training_competency',  //training
            'pathway'               =>'points_train_pathway',//'credits_training_pathway',  //training
            'registration'          =>'points_registration',//'credits_registration',
            'incentive'             =>'points_incentive',//'credits_incentive',
            'adjustment'            =>'points_adjust',//'credits_adjustment',
            'excellence'            =>'points_excellence',//'credits_excellence',
            'credit_mtd'            =>'POINTS_MTHLY',//'CREDITS_MONTHLY',
            'credit_ytd'            =>'POINTS_YTD',//'CREDITS_YTD',
            'lifetime'              =>'POINTS_ytd_lifetime',//'CREDITS_ytd_lifetime',
        ];
        return $map;
    }

    /**
     * Get the field name map for services manager
     * @return array
     */
    public static function ServiceManagerTable(){
        $map = [
            'period'                =>'d_statement',
            'member_id'             =>'regi#',//'_amb_id',
            'dealer_code'           =>'dcode',
            'credit_bf'             =>'points_CARRIED',//'credits_carried_forward',
            'recommendation'        =>'score_ce_SOS',//service overall satisfaction  //'ce_score_OSAT',
            'recommendation_credit' =>'points_ce_SOS',//'credits_ce_OSAT',
            'vclean'                =>'score_ce_VFM', // value for money //'ce_score_VFM',
            'vclean_credit'         =>'points_ce_VFM',//'credits_ce_VFM',
            'followup'              =>'score_ce_FFT', // f1 fixed it right first time //'ce_score_FFT',
            'followup_credit'       =>'points_ce_FFT',//'credits_ce_FFT',
            'cpr'                   =>'percentage_CPRO',// customer paid repair orders //'percentage_CPR_',
            'cpr_credit'            =>'points_CPRO',//'credits_CPR_order',
            'training'              =>'points_train_online',//'credits_training_online',
            'training_competency'   =>'points_train_competency',//'credits_training_competency',
            'pathway'               =>'points_train_pathway',//'credits_training_pathway',
            'training_bonus'               =>'points_train_bonus',
            'registration'          =>'points_registration',//'credits_registration',
            'incentive'             =>'points_incentive',//'credits_incentive',
            'adjustment'            =>'points_adjust',//'credits_adjustment',
            'excellence'            =>'points_excellence',//'credits_excellence',
            'credit_mtd'            =>'POINTS_MTHLY',//'CREDITS_MONTHLY',
            'credit_ytd'            =>'POINTS_YTD',//'CREDITS_YTD',
            'lifetime'              =>'POINTS_ytd_lifetime',//'CREDITS_ytd_lifetime',
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
            'member_id'             =>'regi#',//'_amb_id',
            'dealer_code'           =>'dcode',
            'credit_bf'             =>'points_CARRIED',//'credits_carried_forward',
            'order_write_credit'    =>'points_matchOW',//'credits_ow_match',
            'order_write_variation' =>'matchOW',//'ow_match',
            'percent'               =>'percentage_actual',
            'actual_sales'          =>'points_sales_status',//'credits_actual_sales',
            'sos'  =>'score_ce_SOS',//Sales overall satisfaction   //'ce_score_OSAT',
            'sos_credit'      =>'points_ce_SOS',//'credits_ce_OSAT',
            'kid'       =>'score_ce_KID',//Kept informed of delivery //'ce_score_FU',
            'kid_credit'          =>'points_ce_KID',//'credits_ce_FU',
            'retail_percentage'     =>'achieved_forecast',// DEALER RETAIL FORECAST //'retail_forecast_achieved',
            'retail_credit'         =>'points_forecast',//'credits_retail_forecast',
            'training'              =>'points_train_online',//'credits_training_online',
            'training_competency'   =>'points_train_competency',//'credits_training_competency',
            'pathway'               =>'points_train_pathway',//'credits_training_pathway',
            'registration'          =>'points_registration',//'credits_registration',
            'incentive'             =>'points_incentive',//'credits_incentive',
            'adjustment'            =>'points_adjust',//'credits_adjustment',
            'excellence'            =>'points_excellence',//'credits_excellence',
            'credit_mtd'            =>'POINTS_MTHLY',//'CREDITS_MONTHLY',
            'credit_ytd'            =>'POINTS_YTD',//'CREDITS_YTD',
            'lifetime'              =>'POINTS_ytd_lifetime',//'CREDITS_ytd_lifetime',
        ];
        return $map;
    }

    /**
     * Get map for region territory reports table
     * @return array
     */
    public static function RegionTerritoryReportTable(){
        $map = [
            'dsm_full_name'         =>'elit~dREG_dcode::n_fullname',//'amba_deal~REGI_rcode::n_fullname',
            'region_name'           =>'rname',//'amba_deal~REGI_rcode::r_name',
            'region_code'           =>'rcode',//'amba_deal~REGI_rcode::r_code',
            'dealer_code'           =>'dcode',//'d_code',
            'dealer_name'           =>'dname',//'d_name',
            'dealer_cat'            =>'dcat',//'d_cat',  // Dealer's category, metro or district ...
            'sp_code'               =>'sp_code',
            'employee_code'         =>'regi#',//'_amb_id',
            'n_fullname'            =>'n_fullname',
            'position'              =>'position',
            'registered'            =>'registered',
            'credits_monthly_04'    =>'elit~engi_regi#04mthyrg::POINTS_MTHLY',//'amba_STAT_04_apr::CREDITS_MONTHLY',
            'credits_monthly_05'    =>'elit~engi_regi#05mthyrg::POINTS_MTHLY',//'amba_STAT_05_may::CREDITS_MONTHLY',
            'credits_monthly_06'    =>'elit~engi_regi#06mthyrg::POINTS_MTHLY',//'amba_STAT_06_jun::CREDITS_MONTHLY',
            'credits_monthly_07'    =>'elit~engi_regi#07mthyrg::POINTS_MTHLY',//'amba_STAT_07_jul::CREDITS_MONTHLY',
            'credits_monthly_08'    =>'elit~engi_regi#08mthyrg::POINTS_MTHLY',//'amba_STAT_08_aug::CREDITS_MONTHLY',
            'credits_monthly_09'    =>'elit~engi_regi#09mthyrg::POINTS_MTHLY',//'amba_STAT_09_sep::CREDITS_MONTHLY',
            'credits_monthly_10'    =>'elit~engi_regi#10mthyrg::POINTS_MTHLY',//'amba_STAT_10_oct::CREDITS_MONTHLY',
            'credits_monthly_11'    =>'elit~engi_regi#11mthyrg::POINTS_MTHLY',//'amba_STAT_11_nov::CREDITS_MONTHLY',
            'credits_monthly_12'    =>'elit~engi_regi#12mthyrg::POINTS_MTHLY',//'amba_STAT_12_dec::CREDITS_MONTHLY',
            'credits_monthly_01'    =>'elit~engi_regi#01mthyrg::POINTS_MTHLY',//'amba_STAT_01_jan::CREDITS_MONTHLY',
            'credits_monthly_02'    =>'elit~engi_regi#02mthyrg::POINTS_MTHLY',//'amba_STAT_02_feb::CREDITS_MONTHLY',
            'credits_monthly_03'    =>'elit~engi_regi#03mthyrg::POINTS_MTHLY',//'amba_STAT_03_mar::CREDITS_MONTHLY',
            'cr_ytd'                =>'points_ytd_status',//'amba_STAT_ambid_gmthyr::CREDITS_YTD',
            'cr_ytd_platinum'                =>'points_ytd_platinum',
            'cr_ytd_lifetime'                =>'points_ytd_lifetime',
        ];
        return $map;
    }

    /**
     * Get map for nissan credits table -- not using now
     * @return array
     */
    public static function NissanCreditsTable(){
        $map = [
            'period'        =>'mth_yr',
            'member_id'     =>'_amb_id',
            'mtd'           =>'CREDITS_MONTHLY',
            'ytd'           =>'CREDITS_YTD',
        ];
        return $map;
    }

    /**
     * Get map for nissan ranking table
     * @return array
     */
    public static function NissanRankingsTable(){
        $map = [
            'period'        =>'mthyr_g',//'amba_STAT_ambid_gmthyr::mth_yr',
            'member_id'     =>'regi#',//'_amb_id',
            'dealer_code'   =>'dcode',//'d_code',
            'category'      =>'dcat',//'d_cat',
            'rank'       =>'rank_STATUS',
            'rank_platinum'       =>'rank_PLATINUM',
            'total'         =>'yr_2019_status', //status
            'total_platinum'=>'yr_2019_platinum', //platinum
            'role'          =>'sp',
            'rank_state'    =>'state_rank',
        ];
        $notNecessaryFields = [
            'region_code'           =>'rcode',//'r_code',
            'registered'    =>'registered',
            'status'                =>'status', //active
        ];
        return array_merge($map, $notNecessaryFields);
    }

}