<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Bills
 * @package App\Models
 * @version July 8, 2021, 3:39 am UTC
 *
 * @property string $rowguid
 * @property string $AccountNumber
 * @property number $PowerPreviousReading
 * @property number $PowerPresentReading
 * @property number $DemandPreviousReading
 * @property number $DemandPresentReading
 * @property integer $NetMeteringNetAmount
 * @property string $ReferenceNo
 * @property number $DAA_GRAM
 * @property number $DAA_ICERA
 * @property number $ACRM_TAFPPCA
 * @property number $ACRM_TAFxA
 * @property number $DAA_VAT
 * @property number $ACRM_VAT
 * @property number $NetPresReading
 * @property number $NetPowerKWH
 * @property number $NetGenerationAmount
 * @property number $CreditKWH
 * @property number $CreditAmount
 * @property number $NetMeteringSystemAmt
 * @property integer $Item3
 * @property integer $Item4
 * @property integer $SeniorCitizenDiscount
 * @property integer $SeniorCitizenSubsidy
 * @property integer $UCMERefund
 * @property number $NetPrevReading
 * @property integer $CrossSubsidyCreditAmt
 * @property integer $MissionaryElectrificationAmt
 * @property integer $EnvironmentalAmt
 * @property integer $LifelineSubsidyAmt
 * @property integer $Item1
 * @property integer $Item2
 * @property integer $DistributionSystemAmt
 * @property integer $SupplyRetailCustomerAmt
 * @property integer $SupplySystemAmt
 * @property integer $MeteringRetailCustomerAmt
 * @property integer $MeteringSystemAmt
 * @property integer $SystemLossAmt
 * @property integer $FBHCAmt
 * @property integer $FPCAAdjustmentAmt
 * @property integer $ForexAdjustmentAmt
 * @property integer $TransmissionDemandAmt
 * @property integer $TransmissionSystemAmt
 * @property integer $DistributionDemandAmt
 * @property integer $EPAmount
 * @property integer $PCAmount
 * @property integer $LoanCondonation
 * @property string|\Carbon\Carbon $BillingPeriod
 * @property boolean $UnbundledTag
 * @property integer $GenerationSystemAmt
 * @property integer $PPCAAmount
 * @property integer $UCAmount
 * @property string $MeterNumber
 * @property string $ConsumerType
 * @property string $BillType
 * @property integer $QCAmount
 * @property integer $PPA
 * @property integer $PPAAmount
 * @property integer $BasicAmount
 * @property integer $PRADiscount
 * @property integer $PRAAmount
 * @property integer $PPCADiscount
 * @property number $AverageKWDemand
 * @property number $CoreLoss
 * @property integer $Meter
 * @property integer $PR
 * @property integer $SDW
 * @property integer $Others
 * @property string|\Carbon\Carbon $ServiceDateFrom
 * @property string|\Carbon\Carbon $ServiceDateTo
 * @property string|\Carbon\Carbon $DueDate
 * @property string $BillNumber
 * @property string $Remarks
 * @property number $AverageKWH
 * @property integer $Charges
 * @property integer $Deductions
 * @property integer $NetAmount
 * @property integer $PowerRate
 * @property integer $DemandRate
 * @property string|\Carbon\Carbon $BillingDate
 * @property number $AdditionalKWH
 * @property number $AdditionalKWDemand
 * @property number $PowerKWH
 * @property integer $KWHAmount
 * @property number $DemandKW
 * @property integer $KWAmount
 */
class Bills extends Model
{
    // use SoftDeletes;

    use HasFactory;

    public $table = 'Bills';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $connection = "sqlsrv2";

    public $fillable = [
        // 'rowguid',
        // 'AccountNumber',
        // 'PowerPreviousReading',
        // 'PowerPresentReading',
        // 'DemandPreviousReading',
        // 'DemandPresentReading',
        // 'NetMeteringNetAmount',
        // 'ReferenceNo',
        // 'DAA_GRAM',
        // 'DAA_ICERA',
        // 'ACRM_TAFPPCA',
        // 'ACRM_TAFxA',
        // 'DAA_VAT',
        // 'ACRM_VAT',
        // 'NetPresReading',
        // 'NetPowerKWH',
        // 'NetGenerationAmount',
        // 'CreditKWH',
        // 'CreditAmount',
        // 'NetMeteringSystemAmt',
        // 'Item3',
        // 'Item4',
        // 'SeniorCitizenDiscount',
        // 'SeniorCitizenSubsidy',
        // 'UCMERefund',
        // 'NetPrevReading',
        // 'CrossSubsidyCreditAmt',
        // 'MissionaryElectrificationAmt',
        // 'EnvironmentalAmt',
        // 'LifelineSubsidyAmt',
        // 'Item1',
        // 'Item2',
        // 'DistributionSystemAmt',
        // 'SupplyRetailCustomerAmt',
        // 'SupplySystemAmt',
        // 'MeteringRetailCustomerAmt',
        // 'MeteringSystemAmt',
        // 'SystemLossAmt',
        // 'FBHCAmt',
        // 'FPCAAdjustmentAmt',
        // 'ForexAdjustmentAmt',
        // 'TransmissionDemandAmt',
        // 'TransmissionSystemAmt',
        // 'DistributionDemandAmt',
        // 'EPAmount',
        // 'PCAmount',
        // 'LoanCondonation',
        // 'BillingPeriod',
        // 'UnbundledTag',
        // 'GenerationSystemAmt',
        // 'PPCAAmount',
        // 'UCAmount',
        // 'MeterNumber',
        // 'ConsumerType',
        // 'BillType',
        // 'QCAmount',
        // 'PPA',
        // 'PPAAmount',
        // 'BasicAmount',
        // 'PRADiscount',
        // 'PRAAmount',
        // 'PPCADiscount',
        // 'AverageKWDemand',
        // 'CoreLoss',
        // 'Meter',
        // 'PR',
        // 'SDW',
        // 'Others',
        // 'ServiceDateFrom',
        // 'ServiceDateTo',
        // 'DueDate',
        // 'BillNumber',
        // 'Remarks',
        // 'AverageKWH',
        // 'Charges',
        // 'Deductions',
        // 'NetAmount',
        // 'PowerRate',
        // 'DemandRate',
        // 'BillingDate',
        // 'AdditionalKWH',
        // 'AdditionalKWDemand',
        // 'PowerKWH',
        // 'KWHAmount',
        // 'DemandKW',
        // 'KWAmount'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'rowguid' => 'string',
        'ServicePeriodEnd' => 'datetime',
        'AccountNumber' => 'string',
        'PowerPreviousReading' => 'decimal:2',
        'PowerPresentReading' => 'decimal:2',
        'DemandPreviousReading' => 'float',
        'DemandPresentReading' => 'float',
        'NetMeteringNetAmount' => 'decimal:2',
        'ReferenceNo' => 'string',
        'DAA_GRAM' => 'decimal:2',
        'DAA_ICERA' => 'decimal:2',
        'ACRM_TAFPPCA' => 'decimal:2',
        'ACRM_TAFxA' => 'decimal:2',
        'DAA_VAT' => 'decimal:2',
        'ACRM_VAT' => 'decimal:2',
        'NetPresReading' => 'decimal:2',
        'NetPowerKWH' => 'decimal:2',
        'NetGenerationAmount' => 'decimal:2',
        'CreditKWH' => 'decimal:2',
        'CreditAmount' => 'decimal:2',
        'NetMeteringSystemAmt' => 'decimal:2',
        'Item3' => 'decimal:2',
        'Item4' => 'decimal:2',
        'SeniorCitizenDiscount' => 'decimal:2',
        'SeniorCitizenSubsidy' => 'decimal:2',
        'UCMERefund' => 'decimal:2',
        'NetPrevReading' => 'decimal:2',
        'CrossSubsidyCreditAmt' => 'decimal:2',
        'MissionaryElectrificationAmt' => 'decimal:2',
        'EnvironmentalAmt' => 'decimal:2',
        'LifelineSubsidyAmt' => 'decimal:2',
        'Item1' => 'decimal:2',
        'Item2' => 'decimal:2',
        'DistributionSystemAmt' => 'decimal:2',
        'SupplyRetailCustomerAmt' => 'decimal:2',
        'SupplySystemAmt' => 'decimal:2',
        'MeteringRetailCustomerAmt' => 'decimal:2',
        'MeteringSystemAmt' => 'decimal:2',
        'SystemLossAmt' => 'decimal:2',
        'FBHCAmt' => 'decimal:2',
        'FPCAAdjustmentAmt' => 'decimal:2',
        'ForexAdjustmentAmt' => 'decimal:2',
        'TransmissionDemandAmt' => 'decimal:2',
        'TransmissionSystemAmt' => 'decimal:2',
        'DistributionDemandAmt' => 'decimal:2',
        'EPAmount' => 'decimal:2',
        'PCAmount' => 'decimal:2',
        'LoanCondonation' => 'decimal:2',
        'BillingPeriod' => 'datetime',
        'UnbundledTag' => 'boolean',
        'GenerationSystemAmt' => 'decimal:2',
        'PPCAAmount' => 'decimal:2',
        'UCAmount' => 'decimal:2',
        'MeterNumber' => 'string',
        'ConsumerType' => 'string',
        'BillType' => 'string',
        'QCAmount' => 'decimal:2',
        'PPA' => 'decimal:2',
        'PPAAmount' => 'decimal:2',
        'BasicAmount' => 'decimal:2',
        'PRADiscount' => 'decimal:2',
        'PRAAmount' => 'decimal:2',
        'PPCADiscount' => 'decimal:2',
        'AverageKWDemand' => 'float',
        'CoreLoss' => 'float',
        'Meter' => 'decimal:2',
        'PR' => 'decimal:2',
        'SDW' => 'decimal:2',
        'Others' => 'decimal:2',
        'ServiceDateFrom' => 'datetime',
        'ServiceDateTo' => 'datetime',
        'DueDate' => 'datetime',
        'BillNumber' => 'string',
        'Remarks' => 'string',
        'AverageKWH' => 'float',
        'Charges' => 'decimal:2',
        'Deductions' => 'decimal:2',
        'NetAmount' => 'decimal:2',
        'PowerRate' => 'decimal:2',
        'DemandRate' => 'decimal:2',
        'BillingDate' => 'datetime',
        'AdditionalKWH' => 'float',
        'AdditionalKWDemand' => 'float',
        'PowerKWH' => 'decimal:2',
        'KWHAmount' => 'decimal:2',
        'DemandKW' => 'float',
        'KWAmount' => 'decimal:2'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'rowguid' => 'required|string',
        'AccountNumber' => 'required|string|max:20',
        'PowerPreviousReading' => 'nullable|numeric',
        'PowerPresentReading' => 'nullable|numeric',
        'DemandPreviousReading' => 'nullable|numeric',
        'DemandPresentReading' => 'nullable|numeric',
        'NetMeteringNetAmount' => 'nullable|numeric',
        'ReferenceNo' => 'nullable|string|max:30',
        'DAA_GRAM' => 'nullable|numeric',
        'DAA_ICERA' => 'nullable|numeric',
        'ACRM_TAFPPCA' => 'nullable|numeric',
        'ACRM_TAFxA' => 'nullable|numeric',
        'DAA_VAT' => 'nullable|numeric',
        'ACRM_VAT' => 'nullable|numeric',
        'NetPresReading' => 'nullable|numeric',
        'NetPowerKWH' => 'nullable|numeric',
        'NetGenerationAmount' => 'nullable|numeric',
        'CreditKWH' => 'nullable|numeric',
        'CreditAmount' => 'nullable|numeric',
        'NetMeteringSystemAmt' => 'nullable|numeric',
        'Item3' => 'nullable|numeric',
        'Item4' => 'nullable|numeric',
        'SeniorCitizenDiscount' => 'nullable|numeric',
        'SeniorCitizenSubsidy' => 'nullable|numeric',
        'UCMERefund' => 'nullable|numeric',
        'NetPrevReading' => 'nullable|numeric',
        'CrossSubsidyCreditAmt' => 'nullable|numeric',
        'MissionaryElectrificationAmt' => 'nullable|numeric',
        'EnvironmentalAmt' => 'nullable|numeric',
        'LifelineSubsidyAmt' => 'nullable|numeric',
        'Item1' => 'nullable|numeric',
        'Item2' => 'nullable|numeric',
        'DistributionSystemAmt' => 'nullable|numeric',
        'SupplyRetailCustomerAmt' => 'nullable|numeric',
        'SupplySystemAmt' => 'nullable|numeric',
        'MeteringRetailCustomerAmt' => 'nullable|numeric',
        'MeteringSystemAmt' => 'nullable|numeric',
        'SystemLossAmt' => 'nullable|numeric',
        'FBHCAmt' => 'nullable|numeric',
        'FPCAAdjustmentAmt' => 'nullable|numeric',
        'ForexAdjustmentAmt' => 'nullable|numeric',
        'TransmissionDemandAmt' => 'nullable|numeric',
        'TransmissionSystemAmt' => 'nullable|numeric',
        'DistributionDemandAmt' => 'nullable|numeric',
        'EPAmount' => 'nullable|numeric',
        'PCAmount' => 'nullable|numeric',
        'LoanCondonation' => 'nullable|numeric',
        'BillingPeriod' => 'nullable',
        'UnbundledTag' => 'nullable|boolean',
        'GenerationSystemAmt' => 'nullable|numeric',
        'PPCAAmount' => 'nullable|numeric',
        'UCAmount' => 'nullable|numeric',
        'MeterNumber' => 'nullable|string|max:20',
        'ConsumerType' => 'nullable|string|max:20',
        'BillType' => 'nullable|string|max:10',
        'QCAmount' => 'nullable|numeric',
        'PPA' => 'nullable|numeric',
        'PPAAmount' => 'nullable|numeric',
        'BasicAmount' => 'nullable|numeric',
        'PRADiscount' => 'nullable|numeric',
        'PRAAmount' => 'nullable|numeric',
        'PPCADiscount' => 'nullable|numeric',
        'AverageKWDemand' => 'nullable|numeric',
        'CoreLoss' => 'nullable|numeric',
        'Meter' => 'nullable|numeric',
        'PR' => 'nullable|numeric',
        'SDW' => 'nullable|numeric',
        'Others' => 'nullable|numeric',
        'ServiceDateFrom' => 'nullable',
        'ServiceDateTo' => 'nullable',
        'DueDate' => 'nullable',
        'BillNumber' => 'nullable|string|max:10',
        'Remarks' => 'nullable|string|max:128',
        'AverageKWH' => 'nullable|numeric',
        'Charges' => 'nullable|numeric',
        'Deductions' => 'nullable|numeric',
        'NetAmount' => 'nullable|numeric',
        'PowerRate' => 'nullable|numeric',
        'DemandRate' => 'nullable|numeric',
        'BillingDate' => 'nullable',
        'AdditionalKWH' => 'nullable|numeric',
        'AdditionalKWDemand' => 'nullable|numeric',
        'PowerKWH' => 'nullable|numeric',
        'KWHAmount' => 'nullable|numeric',
        'DemandKW' => 'nullable|numeric',
        'KWAmount' => 'nullable|numeric'
    ];

    public static function isNonResidential($consumerType) {
        if ($consumerType == 'CS' || $consumerType == 'CL' || $consumerType == 'I') {
            return true;
        } else {
            return false;
        }
    }

    public static function getSurchargableAmount($bill) {
        $netAmount = $bill->NetAmount != null ? floatval($bill->NetAmount) : 0;
        $excemptions = floatval($bill->ACRM_TAFPPCA != null ? $bill->ACRM_TAFPPCA : '0') +
                        floatval($bill->DAA_GRAM != null ? $bill->DAA_GRAM : '0') +
                        floatval($bill->Others != null ? $bill->Others : '0') +
                        floatval($bill->GenerationVAT != null ? $bill->GenerationVAT : '0') +
                        floatval($bill->TransmissionVAT != null ? $bill->TransmissionVAT : '0') +
                        floatval($bill->SLVAT != null ? $bill->SLVAT : '0') +
                        floatval($bill->DistributionVAT != null ? $bill->DistributionVAT : '0') +
                        floatval($bill->OthersVAT != null ? $bill->OthersVAT : '0') +
                        floatval($bill->DAA_VAT != null ? $bill->DAA_VAT : '0') +
                        floatval($bill->ACRM_VAT != null ? $bill->ACRM_VAT : '0') +
                        floatval($bill->FBHCAmt != null ? $bill->FBHCAmt : '0') +
                        floatval($bill->Item16 != null ? $bill->Item16 : '0') +
                        floatval($bill->Item17 != null ? $bill->Item17 : '0') +
                        floatval($bill->PR);
        return round($netAmount - $excemptions, 2);
    }

    public static function getSurchargableAmountNetMetering($bill) {
        $netAmount = $bill->NetMeteringNetAmount != null ? floatval($bill->NetMeteringNetAmount) : 0;
        $excemptions = floatval($bill->ACRM_TAFPPCA != null ? $bill->ACRM_TAFPPCA : '0') +
                        floatval($bill->DAA_GRAM != null ? $bill->DAA_GRAM : '0') +
                        floatval($bill->Others != null ? $bill->Others : '0') +
                        floatval($bill->GenerationVAT != null ? $bill->GenerationVAT : '0') +
                        floatval($bill->TransmissionVAT != null ? $bill->TransmissionVAT : '0') +
                        floatval($bill->SLVAT != null ? $bill->SLVAT : '0') +
                        floatval($bill->DistributionVAT != null ? $bill->DistributionVAT : '0') +
                        floatval($bill->OthersVAT != null ? $bill->OthersVAT : '0') +
                        floatval($bill->DAA_VAT != null ? $bill->DAA_VAT : '0') +
                        floatval($bill->ACRM_VAT != null ? $bill->ACRM_VAT : '0') +
                        floatval($bill->FBHCAmt != null ? $bill->FBHCAmt : '0') +
                        floatval($bill->Item16 != null ? $bill->Item16 : '0') +
                        floatval($bill->Item17 != null ? $bill->Item17 : '0') +
                        floatval($bill->PR);

        $amnt = round($netAmount - $excemptions, 2);

        if ($amnt < 0) {
            return 0;
        } else {
            return round($netAmount - $excemptions, 2);
        }
    }

    public static function getSurchargableAmountMobApp($bill) {
        $netAmount = $bill->NetAmount != null ? floatval($bill->NetAmount) : 0;
        $excemptions = floatval($bill->ACRM_TAFPPCA != null ? $bill->ACRM_TAFPPCA : '0') +
                        floatval($bill->DAA_GRAM != null ? $bill->DAA_GRAM : '0') +
                        floatval($bill->OtherChargesAmount != null ? $bill->OtherChargesAmount : '0') +
                        floatval($bill->GenerationVAT != null ? $bill->GenerationVAT : '0') +
                        floatval($bill->TransmissionVAT != null ? $bill->TransmissionVAT : '0') +
                        floatval($bill->SLVAT != null ? $bill->SLVAT : '0') +
                        floatval($bill->DistributionVAT != null ? $bill->DistributionVAT : '0') +
                        floatval($bill->OthersVAT != null ? $bill->OthersVAT : '0') +
                        floatval($bill->DaaVatAmount != null ? $bill->DaaVatAmount : '0') +
                        floatval($bill->AcrmVatAmount != null ? $bill->AcrmVatAmount : '0') +
                        floatval($bill->FranchiseTaxAmount != null ? $bill->FranchiseTaxAmount : '0') +
                        floatval($bill->Item16 != null ? $bill->Item16 : '0') +
                        floatval($bill->Item17 != null ? $bill->Item17 : '0') +
                        floatval($bill->TransformerRental);
        return round($netAmount - $excemptions, 2);
    }

    public static function computeSurcharge($bill) {
        if (Bills::isNonResidential($bill->ConsumerType)) {
            // IF CS, CL, I
            if (floatval($bill->PowerKWH) > 1000) {
                // IF MORE THAN 1000 KWH
                
                if (date('Y-m-d') > date('Y-m-d', strtotime($bill->DueDate . ' +30 days'))) {
                    // IF MORE THAN 30 days of due date
                    return (Bills::getSurchargableAmount($bill) * .05) + ((Bills::getSurchargableAmount($bill) * .05) * .12);
                } else {
                    if (date('Y-m-d') > date('Y-m-d', strtotime($bill->DueDate))) {
                        return (Bills::getSurchargableAmount($bill) * .03) + ((Bills::getSurchargableAmount($bill) * .03) * .12);
                    } else {
                        // NO SURCHARGE
                        return 0;
                    }
                }
            } else {
                // IF LESS THAN 1000 KWH
                if (date('Y-m-d') > date('Y-m-d', strtotime($bill->DueDate))) {
                    return (Bills::getSurchargableAmount($bill) * .03) + ((Bills::getSurchargableAmount($bill) * .03) * .12);
                } else {
                    // NO SURCHARGE
                    return 0;
                }
            }
        } else {
            if ($bill->ConsumerType == 'P') {
                // IF PUBLIC BUILDING, NO SURCHARGE
                return 0;
            } else {
                // RESIDENTIALS
                if (date('Y-m-d') > date('Y-m-d', strtotime($bill->DueDate))) {
                    if (floatval($bill->NetAmount) > 1667) {
                        return (Bills::getSurchargableAmount($bill) * .03) + ((Bills::getSurchargableAmount($bill) * .03) * .12);
                    } else {
                        return 56;
                    }
                } else {
                    // NO SURCHARGE
                    return 0;
                }
            }
        }
    }

    public static function computeSurchargeNetMetered($bill) {
        if (Bills::isNonResidential($bill->ConsumerType)) {
            // IF CS, CL, I
            if (floatval($bill->PowerKWH) > 1000) {
                // IF MORE THAN 1000 KWH
                
                if (date('Y-m-d') > date('Y-m-d', strtotime($bill->DueDate . ' +30 days'))) {
                    // IF MORE THAN 30 days of due date
                    return (Bills::getSurchargableAmountNetMetering($bill) * .05) + ((Bills::getSurchargableAmountNetMetering($bill) * .05) * .12);
                } else {
                    if (date('Y-m-d') > date('Y-m-d', strtotime($bill->DueDate))) {
                        return (Bills::getSurchargableAmountNetMetering($bill) * .03) + ((Bills::getSurchargableAmountNetMetering($bill) * .03) * .12);
                    } else {
                        // NO SURCHARGE
                        return 0;
                    }
                }
            } else {
                // IF LESS THAN 1000 KWH
                if (date('Y-m-d') > date('Y-m-d', strtotime($bill->DueDate))) {
                    return (Bills::getSurchargableAmountNetMetering($bill) * .03) + ((Bills::getSurchargableAmountNetMetering($bill) * .03) * .12);
                } else {
                    // NO SURCHARGE
                    return 0;
                }
            }
        } else {
            if ($bill->ConsumerType == 'P') {
                // IF PUBLIC BUILDING, NO SURCHARGE
                return 0;
            } else {
                // RESIDENTIALS
                if (date('Y-m-d') > date('Y-m-d', strtotime($bill->DueDate))) {
                    if (floatval($bill->NetMeteringNetAmount) > 1667) {
                        return (Bills::getSurchargableAmountNetMetering($bill) * .03) + ((Bills::getSurchargableAmountNetMetering($bill) * .03) * .12);
                    } else {
                        return 56;
                    }
                } else {
                    // NO SURCHARGE
                    return 0;
                }
            }
        }
    }

    public static function computeSurchargeMobApp($bill) {
        if (Bills::isNonResidential($bill->ConsumerType)) {
            // IF CS, CL, I
            if (floatval($bill->PowerKWH) > 1000) {
                // IF MORE THAN 1000 KWH
                
                if (date('Y-m-d') > date('Y-m-d', strtotime($bill->DueDate . ' +30 days'))) {
                    // IF MORE THAN 30 days of due date
                    return (Bills::getSurchargableAmountMobApp($bill) * .05) + ((Bills::getSurchargableAmountMobApp($bill) * .05) * .12);
                } else {
                    if (date('Y-m-d') > date('Y-m-d', strtotime($bill->DueDate))) {
                        return (Bills::getSurchargableAmountMobApp($bill) * .03) + ((Bills::getSurchargableAmountMobApp($bill) * .03) * .12);
                    } else {
                        // NO SURCHARGE
                        return 0;
                    }
                }
            } else {
                // IF LESS THAN 1000 KWH
                if (date('Y-m-d') > date('Y-m-d', strtotime($bill->DueDate))) {
                    return (Bills::getSurchargableAmountMobApp($bill) * .03) + ((Bills::getSurchargableAmountMobApp($bill) * .03) * .12);
                } else {
                    // NO SURCHARGE
                    return 0;
                }
            }
        } else {
            if ($bill->ConsumerType == 'P') {
                // IF PUBLIC BUILDING, NO SURCHARGE
                return 0;
            } else {
                // RESIDENTIALS
                if (date('Y-m-d') > date('Y-m-d', strtotime($bill->DueDate))) {
                    if (floatval($bill->NetAmount) > 1667) {
                        return (Bills::getSurchargableAmountMobApp($bill) * .03) + ((Bills::getSurchargableAmountMobApp($bill) * .03) * .12);
                    } else {
                        return 56;
                    }
                } else {
                    // NO SURCHARGE
                    return 0;
                }
            }
        }
    }
    
    public static function getSurcharge($bill) {
        if ($bill->ComputeMode == 'NetMetered') {
            $surcharge = Bills::computeSurchargeNetMetered($bill);

            if ($surcharge == 0) {
                return 0;
            } else {
                if ($surcharge < 56) {
                    return 56;
                } else {
                    return $surcharge;
                }
            }
        } else {
            $surcharge = Bills::computeSurcharge($bill);

            if ($surcharge == 0) {
                return 0;
            } else {
                if ($surcharge < 56) {
                    return 56;
                } else {
                    return $surcharge;
                }
            }
        }
    }

    public static function getSurchargeMobApp($bill) {
        $surcharge = Bills::computeSurchargeMobApp($bill);

        if ($surcharge == 0) {
            return 0;
        } else {
            if ($surcharge < 56) {
                return 56;
            } else {
                return $surcharge;
            }
        }
    }

    /**
     * GET SURCHARGE ONLY WITHOUT VAT
     */
}
