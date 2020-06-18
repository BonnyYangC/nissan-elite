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
            'employee_code'=>'regi#',
            'salutation'=>'n_title',
            'firstname'=>'n_fname_trim',
            'lastname'=>'n_sname_trim',
            'mobile'=>'ph_mobile',
            'email'=>'addr_email',
            'company_code'=>'dcode',
            'position'=>'sp',   
            'dept'=>'dept_code',
            'active'=>'status',
            'registered'=>'registered',
            'member'=>'elite_mbr',//'ac_mbr',
            'dob'=>'date_birth',//'date_of_birth',
            'date_created'=>'date_created',
            'met_criteria' => 'criteria_met_eoy',
            'excellence_eligible' => 'excellence_eligible'
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
            'position'=>'position',
            'alt_position'=>'region',//'region',
            'firstname'=>'first name',//'fname',
            'lastname'=>'last name',//'sname',
            'email'=>'email address',//'email',
            //'mobile'=>'mobile', //tbd
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
            'credit_bf'             =>'points_carried',//'credits_carried_forward',
            'recom_score'           =>'score_ce_sos3', //sales overall satisfaction //'ce_score_osat',
            'recom_credit'          =>'points_ce_sos3', //'credits_ce_osat',
            'fu_score'              =>'score_ce_vfm',// value for money //'ce_score_vfm',
            'fu_credit'             =>'points_ce_vfm',//'credits_ce_vfm',
            'trust_score'           =>'score_ce_ayt',//advice you can trust  //'ce_score_ayct',
            'trust_credit'          =>'points_ce_ayt',//'credits_ce_ayct',
            'cpr'                   =>'percentage_cpro', // custmer paid repair orders //'percentage_cpr',
            'cpr_credit'            =>'points_cpro',//'credits_cpr_order',
            /*'emw_score'             =>'sales_emw_gen',
            'emw_credit'            =>'credits_emw_gen',not using*/
            'training'              =>'points_train_online',//'credits_training_online',
            'training_competency'   =>'points_train_competency',//'credits_training_competency',

            'train_mastery'         =>'points_train_mastery',

            'pathway'               =>'points_train_pathway',//'credits_training_pathway',
            'registration'          =>'points_registration',//'credits_registration',
            'incentive'             =>'points_incentive',//'credits_incentive',
            'adjustment'            =>'points_adjust',//'credits_adjustment',
            'excellence'            =>'points_excellence',//'credits_excellence',
            'credit_mtd'            =>'points_mthly',//'credits_monthly',
            'credit_ytd'            =>'points_ytd',//'credits_ytd',
            'lifetime'              =>'points_ytd_historical',//'credits_ytd_lifetime',
            'indication_credit'     =>'points_ce_iwc3',     // fy2020 new metric #2 indication of work and costs involved nps r3m
            'indication'            =>'score_ce_iwc3', // fy2020 new metric #2 indication of work and costs involved nps r3m
            'ecosts_credit'         =>'points_ce_eoc3',     // fy2020 new metric #3 explanation of costs nps r3m
            'ecosts'                =>'score_ce_eoc3',    // fy2020 new metric #3 explanation of costs nps r3m
            'brakewpr_credit'       =>'points_bwp',   // fy2020 new metric #4 brake and wiper parts sales per cpro
            'brakewpr'              =>'sales_bwp',       // fy2020 new metric #4 brake and wiper parts sales per cpro
            'loyaltyser_credit'     =>'points_loyalty', // fy2020 new metric #5 loyalty per loyalty sales
            'loyaltyser'            =>'sales_loyalty',     // fy2020 new metric #5 loyalty per loyalty sales
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
            'credit_bf'             =>'points_carried',//'credits_carried_forward',
            'stock'                 =>'score_stock', //stock cover //'days_stock',
            'stock_credit'          =>'points_stock',//'credits_stock',
            'ow'                    =>'score_compow', //ow data entry compliance //'ow_data',
            'ow_credit'             =>'points_compow',//'credits_ow_data',     score_matchow_  points_matchow_
            'retail'                =>'ach_forecast', //dealer forecast //'retail_forecast_achieved',   
            'retail_credit'         =>'points_forecast',//'credits_retail_forecast',
            'points_regvret'        =>'points_regvret',
            'percentage_regvret'    =>'pcent_regvret',
            'matched'               =>'score_matchow', //matched ow compliance //'ow_match',
            'matched_credit'        =>'points_matchow',//'credits_ow_match',
            'davo'                  =>'pcent_davo',//davo orders //'percentage_davo',
            'davo_credit'           =>'points_davo',//'credits_davo',
            'training'              =>'points_train_online',//'credits_training_online',
            'training_competency'   =>'points_train_competency',//'credits_training_competency',
            'pathway'               =>'points_train_pathway',//'credits_training_pathway',
            'registration'          =>'points_registration',//'credits_registration',
            'incentive'             =>'points_incentive',//'credits_incentive',
            'adjustment'            =>'points_adjust',//'credits_adjustment',
            'excellence'            =>'points_excellence',//'credits_excellence',
            'credit_mtd'            =>'points_mthly',//'credits_monthly',
            'credit_ytd'            =>'points_ytd',//'credits_ytd',
            'lifetime'              =>'points_ytd_historical',//'credits_ytd_lifetime',
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
            'credit_bf'             =>'points_carried',//'credits_carried_forward',
            'grp'                   =>'pcent_grp', //genuine replacement parts
            'grp_credit'            =>'points_grp', //'credits_grp',
            'gas'                   =>'pcent_acc',//'percentage_gas',
            'gas_credit'            =>'points_acc', //'credits_gas',

            'percent_apnur_n'       => 'pcent_apnur_n',
            'points_apnur_n'        =>'points_apnur_n',
            'percent_apnur_x'       => 'pcent_apnur_x',
            'points_apnur_x'        =>'points_apnur_x',
            'percent_apnur_q'       => 'pcent_apnur_q',
            'points_apnur_q'        =>'points_apnur_q',

            'brakewpr_credit'       => 'points_bwp',
            'brakewpr'              => 'sales_bwp',

            'training'              =>'points_train_online', //'credits_training_online',
            'training_competency'   =>'points_train_competency',//'credits_training_competency',
            'pathway'               =>'points_train_pathway',  //'credits_training_pathway',
            'training_bonus'        =>'points_train_bonus',
            'registration'          =>'points_registration', //'credits_registration',
            'incentive'             =>'points_incentive',   //'credits_incentive',
            'adjustment'            =>'points_adjust',   //'credits_adjustment',
            'excellence'            =>'points_excellence',  //'credits_excellence',
            'credit_mtd'            =>'points_mthly', //'credits_monthly',
            'credit_ytd'            =>'points_ytd',  //'credits_ytd',
            'lifetime'              =>'points_ytd_historical'  //'credits_ytd_lifetime',
        ];
        return $map;
    }

    /**
     * Get the field name map for Parts Representative
     * @return array
     */
    public static function PartsRepTable(){
        $map = [
            'period'                =>'d_statement',
            'member_id'             =>'regi#',//'_amb_id',
            'dealer_code'           =>'dcode',
            'credit_bf'             =>'points_carried', //'credits_carried_forward',
            'grp'                   =>'pcent_grp', //genuine replacement parts
            'grp_credit'            =>'points_grp', //'credits_grp',
            'training'              =>'points_train_online',//'credits_training_online',
            'training_competency'   =>'points_train_competency',//'credits_training_competency',
            'pathway'               =>'points_train_pathway',//'credits_training_pathway',
            'registration'          =>'points_registration',//'credits_registration',
            'incentive'             =>'points_incentive',//'credits_incentive',
            'adjustment'            =>'points_adjust',//'credits_adjustment',
            'excellence'            =>'points_excellence',//'credits_excellence',
            'credit_mtd'            =>'points_mthly',//'credits_monthly',
            'credit_ytd'            =>'points_ytd',//'credits_ytd',
            'lifetime'              =>'points_ytd',//'credits_ytd_lifetime',
            'points_perform_vs_prev_year' => 'points_pvfy19_q',
            'percentage_perform_vs_prev_year' => 'pcent_pvfy19_q',
            'points_performvprev'    => 'pcent_pvlq_q',
            'percentage_performvprev'=> 'points_pvlq_q',


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
            'credit_bf'             =>'points_carried',//'credits_carried_forward',
            'frequency'             =>'bmo_frequency', //dealer financial reporting - submitted
            'frequency_credits'     =>'points_frequency',//'credits_frequency',
            'quality'               =>'bmo_quality',//quality of data submission //'bmo_qlty_sub',
            'quality_credit'        =>'points_quality',//'credits_qlty_sub',
            'checklist'             =>'bmo_checklist', //nissan business mgmt data accuracy
            'checklist_credit'      =>'points_checklist',//'credits_bmo_checklist',
            'meeting'               =>'bmo_meeting', //nissan business mgmt bdg attendance
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
            'credit_mtd'            =>'points_mthly',//'credits_monthly',
            'credit_ytd'            =>'points_ytd',//'credits_ytd',
            'lifetime'              =>'points_ytd_historical',//'credits_ytd_lifetime',
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
            'credit_bf'             =>'points_carried',//'credits_carried_forward',
            'sales_nfsa'            =>'sales_nfsa',//nfsa finance contract //'sales_nfsa_nissan',
            'credit_actual_sales'   =>'points_nfsa',//'credits_actual_sales',
            'sales_nfsa_retention'  =>'sales_nfsa_lrb',//loyalty & retention //'sales_nfsa_retention',
            'credits_nfsa_retention'=>'points_nfsa_lrb',//'credits_nfsa_retention',
            'sales_mvi'             =>'sales_nfsa_mvi', //mvi motor vehicle insurance
            'credits_mvi'           =>'points_nfsa_mvi',//'credits_ins_mvi_cmp',
            'sales_pkg'             =>'sales_nfsa_pkg', //mvi & nfsa finance contract package
            'credits_pkg'           =>'points_nfsa_pkg',//'credits_ins_pkg',
            'sales_emw'             =>'sales_nfsa_emw',//emw sale genuine (naps) //'sales_emw_gen',
            'credits_emw'           =>'points_nfsa_emw',//'credits_emw_gen',
            'penetration'           =>'pcent_nfsa_pen', //dealer sales penetration
            'credits_penetration'   =>'points_nfsa_pen',//'credits_penetration',
            'score_fi'              =>'score_ce_efi3',//customer experience - satisfaction with finance & insurance   //'ce_score_fisat',
            'credits_fi'            =>'points_ce_efi3',//'credits_ce_fisat',
            'registration'          =>'points_registration',//'credits_registration',
            'incentive'             =>'points_incentive',//'credits_incentive',
            'adjustment'            =>'points_adjust',//'credits_adjustment',
            'excellence'            =>'points_excellence',//'credits_excellence',
            'credit_mtd'            =>'points_mthly',//'credits_monthly',
            'credit_ytd'            =>'points_ytd',//'credits_ytd',
            'lifetime'              =>'points_ytd_historical',//'credits_ytd_lifetime',
        ];
        return $map;
    }

    /**
     * Get the field name map for Fleet Sales Executives
     * @return array
     */
    public static function FleetSalesExecutivesTable(){
        $map = [
            'period'                   =>'d_statement',
            'member_id'                =>'regi#', //'_amb_id',
            'dealer_code'              =>'dcode',
            'credit_bf'                =>'points_carried',  //'credits_carried_forward',
            'sales'                    =>'sales_status',  //new vehicle sales //'sales',
            'credit_actual_sales'      =>'points_sales_status', //points for new vehicle sales //'credits_actual_sales',
            'v_fleet_target'           =>'pcent_act_f',//'ce_score_osat', //percentage of fleet sales v fleet target 
            'v_fleet_target_score'     =>'points_act_f',//'credits_ce_osat', //points for fleet sales v fleet target 
            'fleet_volumn_growth'      =>'pcent_act_fv',//'ce_score_fu%', //percentage of fleet volume growth (quarterly)
            'fleet_volumn_growth_score'=>'points_act_fv',//'credits_ce_fu%', //points for fleet volume growth (quarterly)
            'training'                 =>'points_train_online',//'credits_training_online', //training
            'training_competency'      =>'points_train_competency',//'credits_training_competency',  //training
            'pathway'                  =>'points_train_pathway',//'credits_training_pathway',  //training
            'registration'             =>'points_registration',//'credits_registration',
            'incentive'                =>'points_incentive',//'credits_incentive',
            'adjustment'               =>'points_adjust',//'credits_adjustment',
            'excellence'               =>'points_excellence',//'credits_excellence',
            'credit_mtd'               =>'points_mthly',//'credits_monthly',
            'credit_ytd'               =>'points_ytd',//'credits_ytd',
            'lifetime'                 =>'points_ytd_historical',//'credits_ytd_lifetime',
        ];
        return $map;
    }

    /**
     * Get the field name map for Retail Sales Consultant (R)
     * @return array
     */

    public static function RetailSalesConsultantTable(){
        $map = [
            'period'                            =>'d_statement',
            'member_id'                         =>'regi#', //'_amb_id',
            'dealer_code'                       =>'dcode',
            'credit_bf'                         =>'points_carried',  //'credits_carried_forward',
            'sales'                             =>'sales_status',  //new vehicle sales //'sales',
            'credit_actual_sales'               =>'points_sales_status', //points for new vehicle sales //'credits_actual_sales',
            'salesperson_satisfaction'          =>'score_ce_sos3',//percentage of salesperson satisfaction
            'salesperson_satisfaction_score'    =>'points_ce_sos3',//points for salesperson satisfaction
            'points_actual'                     =>'points_nvr',
            'percentage_actual'                 =>'pcent_act_s',
            'kept_informed_delivery_score'      =>'points_ce_kid3', //points for kept informed of delivery
            'kept_informed_delivery'            =>'score_ce_kid3', //kept informed of delivery
            'follow_up_satisfaction'            =>'score_ce_pfu3',//satisfaction follow up
            'follow_up_satisfaction_score'      =>'points_ce_pfu3',//points for satisfaction follow up
            'training'                          =>'points_train_online',//'credits_training_online', //training
            'training_competency'               =>'points_train_competency',//'credits_training_competency',  //training 

            'train_mastery'         =>'points_train_mastery',


            'pathway'                           =>'points_train_pathway',//'credits_training_pathway',  //training
            'registration'                      =>'points_registration',//'credits_registration',
            'incentive'                         =>'points_incentive',//'credits_incentive',
            'adjustment'                        =>'points_adjust',//'credits_adjustment',
            'excellence'                        =>'points_excellence',//'credits_excellence',
            'credit_mtd'                        =>'points_mthly',//'credits_monthly',
            'credit_ytd'                        =>'points_ytd',//'credits_ytd',
            'lifetime'                          =>'points_ytd_historical',//'credits_ytd_lifetime',
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
            'credit_bf'             =>'points_carried',//'credits_carried_forward',
            'recommendation'        =>'score_ce_sos3',//service overall satisfaction  //'ce_score_osat',
            'recommendation_credit' =>'points_ce_sos3',//'credits_ce_osat',
            'vclean'                =>'score_ce_vfm', // value for money //'ce_score_vfm',
            'vclean_credit'         =>'points_ce_vfm',//'credits_ce_vfm',
            'followup'              =>'score_ce_fft3', // f1 fixed it right first time //'ce_score_fft',
            'followup_credit'       =>'points_ce_fft3',//'credits_ce_fft',
            'cpr'                   =>'pcent_cpro',// customer paid repair orders //'percentage_cpr',
            'cpr_credit'            =>'points_cpro',//'credits_cpr_order',
            'training'              =>'points_train_online',//'credits_training_online',
            'training_competency'   =>'points_train_competency',//'credits_training_competency',
            'pathway'               =>'points_train_pathway',//'credits_training_pathway',
            'training_bonus'        =>'points_train_bonus',

            'train_mastery'         =>'points_train_mastery',

            'registration'          =>'points_registration',//'credits_registration',
            'incentive'             =>'points_incentive',//'credits_incentive',
            'adjustment'            =>'points_adjust',//'credits_adjustment',
            'excellence'            =>'points_excellence',//'credits_excellence',
            'credit_mtd'            =>'points_mthly',//'credits_monthly',
            'credit_ytd'            =>'points_ytd',//'credits_ytd',
            'lifetime'              =>'points_ytd_historical',//'credits_ytd_lifetime',
            'ecosts_credit'         =>'points_ce_eoc3',     // fy2020 new metric #3 explanation of costs nps r3m
            'ecosts'                =>'score_ce_eoc3', // fy2020 new metric #3 explanation of costs nps r3m
            'retention_credit'      =>'points_retent',     // fy2020 new metric #5 retention %
            'retention'             =>'pcent_retent', // fy2020 new metric #5 retention %
            'brakewpr_credit'       =>'credit_bwp', // fy2020 new metric #6 brake and wiper parts sales per cpro
            'brakewpr'              =>'sales_bwp',  // fy2020 new metric #6 brake and wiper parts sales per cpro
            'loyaltyser_credit'     =>'points_loyalty', // fy2020 new metric #7 loyalty per loyalty sales
            'loyaltyser'            =>'sales_loyalty',  // fy2020 new metric #7 loyalty per loyalty sales
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
            'credit_bf'             =>'points_carried',//'credits_carried_forward',
            'order_write_credit'    =>'points_matchow',//'credits_ow_match',
            'order_write_variation' =>'score_matchow',//'ow_match',   //score
            'percent'               =>'percentage_actual',
            'actual_sales'          =>'points_sales_status',//'credits_actual_sales',
            'sos'                   =>'score_ce_sos3',//sales overall satisfaction   //'ce_score_osat',
            'sos_credit'            =>'points_ce_sos3',//'credits_ce_osat',
            'kid'                   =>'score_ce_kid3',//kept informed of delivery //'ce_score_fu',
            'kid_credit'            =>'points_ce_kid3',//'credits_ce_fu',
            'retail_percentage'     =>'ach_forecast',// dealer retail forecast //'retail_forecast_achieved',
            'retail_credit'         =>'points_forecast',//'credits_retail_forecast',
            'training'              =>'points_train_online',//'credits_training_online',
            'training_competency'   =>'points_train_competency',//'credits_training_competency',
            'pathway'               =>'points_train_pathway',//'credits_training_pathway',
            'training_bonus'        =>'points_train_bonus',

            'train_mastery'         =>'points_train_mastery',

            'registration'          =>'points_registration',//'credits_registration',
            'incentive'             =>'points_incentive',//'credits_incentive',
            'adjustment'            =>'points_adjust',//'credits_adjustment',
            'excellence'            =>'points_excellence',//'credits_excellence',
            'credit_mtd'            =>'points_mthly',//'credits_monthly',
            'credit_ytd'            =>'points_ytd',//'credits_ytd',
            'lifetime'              =>'points_ytd_lifetime',//'credits_ytd_lifetime',

            'points_apnur_n'        =>'points_apnur_n',
            'points_apnur_q'        =>'points_apnur_q',
            'points_apnur_x'        =>'points_apnur_x',
            'percent_apnur_n'       =>'pcent_apnur_n',
            'percent_apnur_q'       =>'pcent_apnur_q',
            'percent_apnur_x'       =>'pcent_apnur_x',  

            'percent_act_s'         =>'pcent_act_s'
        ];
        return $map;
    }

    /**
     * Get map for region territory reports table
     * @return array
     */
    public static function RegionTerritoryReportTable(){
        $map = [
            'dsm_full_name'         =>'elit~dreg_dcode::n_fullname',//'amba_deal~regi_rcode::n_fullname',
            'region_name'           =>'rname',//'amba_deal~regi_rcode::r_name',
            'region_code'           =>'rcode',//'amba_deal~regi_rcode::r_code',
            'dealer_code'           =>'dcode',//'d_code',
            'dealer_name'           =>'dname',//'d_name',
            'dealer_cat'            =>'dcat',//'d_cat',  // dealer's category, metro or district ...
            'sp_code'               =>'sp_code',
            'employee_code'         =>'regi#',//'_amb_id',
            'n_fullname'            =>'n_fullname',
            'position'              =>'position',
            'registered'            =>'registered',
            'credits_monthly_04'    =>'elit~engi_regi#04mthyrg::points_mthly',//'amba_stat_04_apr::credits_monthly',
            'credits_monthly_05'    =>'elit~engi_regi#05mthyrg::points_mthly',//'amba_stat_05_may::credits_monthly',
            'credits_monthly_06'    =>'elit~engi_regi#06mthyrg::points_mthly',//'amba_stat_06_jun::credits_monthly',
            'credits_monthly_07'    =>'elit~engi_regi#07mthyrg::points_mthly',//'amba_stat_07_jul::credits_monthly',
            'credits_monthly_08'    =>'elit~engi_regi#08mthyrg::points_mthly',//'amba_stat_08_aug::credits_monthly',
            'credits_monthly_09'    =>'elit~engi_regi#09mthyrg::points_mthly',//'amba_stat_09_sep::credits_monthly',
            'credits_monthly_10'    =>'elit~engi_regi#10mthyrg::points_mthly',//'amba_stat_10_oct::credits_monthly',
            'credits_monthly_11'    =>'elit~engi_regi#11mthyrg::points_mthly',//'amba_stat_11_nov::credits_monthly',
            'credits_monthly_12'    =>'elit~engi_regi#12mthyrg::points_mthly',//'amba_stat_12_dec::credits_monthly',
            'credits_monthly_01'    =>'elit~engi_regi#01mthyrg::points_mthly',//'amba_stat_01_jan::credits_monthly',
            'credits_monthly_02'    =>'elit~engi_regi#02mthyrg::points_mthly',//'amba_stat_02_feb::credits_monthly',
            'credits_monthly_03'    =>'elit~engi_regi#03mthyrg::points_mthly',//'amba_stat_03_mar::credits_monthly',
            'cr_ytd'                =>'points_ytd_status',//'amba_stat_ambid_gmthyr::credits_ytd',
            'cr_ytd_platinum'       =>'points_ytd_platinum',
            'cr_ytd_lifetime'       =>'points_ytd_lifetime',
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
            'mtd'           =>'credits_monthly',
            'ytd'           =>'credits_ytd',
        ];
        return $map;
    }

    /**
     * Get map for nissan ranking table
     * @return array
     */
    public static function NissanRankingsTable(){
        $map = [
            'period'        =>'mthyr_g',//'amba_stat_ambid_gmthyr::mth_yr',
            'member_id'     =>'regi#',//'_amb_id',
            'dealer_code'   =>'dcode',//'d_code',
            'category'      =>'dcat',//'d_cat',
            'rank'          =>'rank_status',
            'rank_platinum' =>'rank_platinum',
            'total'         =>'yr_2020_status', //status
            'total_platinum'=>'yr_2020_platinum', //platinum
            'role'          =>'sp',
            'rank_state'    =>'state_rank',
        ];
        $notNecessaryFields = [
            'region_code'           =>'rcode',//'r_code',  //it's in the company table
            'registered'    =>'registered',
            'status'                =>'status', //active
        ];
        return array_merge($map, $notNecessaryFields);
    }
}

