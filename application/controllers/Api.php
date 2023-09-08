<?php 
class Api extends CI_Controller{
    protected $sysdate;
		protected $kms_year;
    public function __construct() {
        parent::__construct();
        $this->load->model('Rent_calculation_model');

        $this->load->model('HTransportC_model');
    }
    function get_api_cancel(){
        $irn = $this->input->post('irn');
        $CnlRsn = $this->input->post('CnlRsn');
        $CnlRem = $this->input->post('remarks');
        // echo $this->db->last_query();
        // exit;
        //var_dump($_POST);exit;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            /************************for test server*********** */
        //CURLOPT_URL => 'https://einvoicing.internal.cleartax.co/v1/govt/api/Cancel',
        CURLOPT_URL => 'https://api-einv.cleartax.in/v1/govt/api/Cancel',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
        "irn": "' . $irn . '",
        "CnlRsn": "'. $CnlRsn .'" ,
        "CnlRem": "'. $CnlRem .'"
        }',
        /*************for test server******************* */
        /*CURLOPT_HTTPHEADER => array(
            'x-cleartax-auth-token: 1.d88fc2d8-64eb-40a2-96f0-16f6e7cdd286_8d583da35687c440a8ebb2f67591923df276a8b9df462fc6eb0b033c51fbe385',
            'x-cleartax-product: EInvoice',
            'owner_id: d5c19ef6-b179-45a9-b661-f15c507a1aa9',
            'gstin: 19AABAT0010H2ZY',
            'Content-Type: application/json'
        ),*/
        CURLOPT_HTTPHEADER => array(
            'x-cleartax-auth-token: ' . AUTHKOKEN,
            'x-cleartax-product: ' . PRODUCT,
            'owner_id: ' . OWNERID,
            'gstin: ' . SALLERGSTIN,
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $data = json_decode($response);
        $success = $data->Success;
        $msg = '';
        if($success != 'Y'){
            $msg = $data->ErrorDetails[0]->error_message;
            $this->session->set_flashdata('msg', $msg);
            echo $response;
            redirect('irncan');
        }else{
            $this->irncancelmodel->get_irn_details($irn);
            redirect('irncan'); 
        }
        // var_dump($msg);exit;
        // echo $response;
    }

    /*****************IRN Generate*********** */
    public function api_call($trans_do)
    {
        // $trans_do = $this->input->get('trans_do');
        $api_query= $this->Rent_calculation_model->f_get_api_data($trans_do);
    //    print_r($api_query);
    //    exit();
        return $api_query;
    }

    function get_api_res(){
        $trans_do = $this->input->get('trans_do');
        $data = $this->api_call($trans_do);
        $dt = $data ? $data[0] : $data;
        $HsnCd = strlen($dt->sac_code)==4 ? $dt->sac_code . '00' : $dt->sac_code;
        // echo '<pre>';
        $str_arr = explode('-', $dt->invoice_no);
        $suf = substr($str_arr[1],2);

     
        $doc_no = $str_arr[0].'/'. $suf .$str_arr[2]. '/' .$str_arr[3] ;

        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt_array($curl, array(
           // CURLOPT_URL => 'https://einvoicing.internal.cleartax.co/v1/govt/api/Invoice',
            CURLOPT_URL => 'https://api-einv.cleartax.in/v1/govt/api/Invoice',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
            "Version": "'.Version.'",
            "TranDtls": {
                "TaxSch": "'.TAX_SCH.'",
                "SupTyp": "'.SupTyp.'",
                "RegRev": "'.$dt->pay_flag.'",
                "EcmGstin": null,
                "IgstOnIntra": "N"
            },
            "DocDtls": {
                "Typ": "'.Typ.'",

                "No": "'.$doc_no.'",

                "Dt": "'.CURRDT.'"
            },
            "SellerDtls": {
                "Gstin": "'.SALLERGSTIN.'",
                "LglNm": "'.LG_LNM.'",
                "TrdNm": "'.TRQ_NM.'",
                "Addr1": "'.$dt->sellet_addr.'",
                "Addr2": "'.$dt->sellet_addr.'",

                "Loc": "'.$dt->seller_district.'",

                "Pin": '.$dt->sellet_pin.',
                "Stcd": "'.SALLERSTCD.'",
                "Ph": "'.SALLERPH.'",
                "Em": "'.SALLEREM.'"
            },
            "BuyerDtls": {
                "Gstin": "'.$dt->gst_no.'",

                "LglNm": "'.$dt->cust_name.'",
                "TrdNm": "'.$dt->cust_name.'",
                "Pos": "19",

                "Addr1": "'.$dt->cust_addr.'",
                
                "Addr2": "'.$dt->cust_addr.'",
                "Loc": "'.$dt->buyer_district.'",
                "Pin": '.$dt->pin_code.',
                "Stcd": "19",
                "Ph": "",
                "Em": "'.$dt->email_id.'"
            },
            "DispDtls": {
                "Nm": "'.LG_LNM.'",
                "Addr1": "'.$dt->sellet_addr.'",
                "Addr2": "'.$dt->sellet_addr.'",
                "Loc": "'.$dt->seller_district.'",
                "Pin": '.$dt->sellet_pin.',
                "Stcd": "'.SALLERSTCD.'"
            },

            "ShipDtls": {
                "Gstin": "'.$dt->gst_no.'",
                "LglNm": "'.$dt->cust_name.'",
                "TrdNm": "'.$dt->cust_name.'",
                "Addr1": "'.$dt->cust_addr.'",
                "Addr2": "",
                "Loc": "'.$dt->buyer_district.'",
                "Pin": '.$dt->pin_code.',
                "Stcd": "19"
            },
            "ItemList": [
                {
                "SlNo": "1",
                "PrdDesc": "'.$dt->product_desc.'",
                "IsServc": "Y",

                "HsnCd": "'.$dt->sac_code.'",
                "Barcde": "",
                "Qty": '.$dt->qty.',
                
                "FreeQty": "0",
                "Unit": "UNT",
                "UnitPrice": '.$dt->taxable_amt.',
                "TotAmt": '.$dt->taxable_amt.',
                "Discount": "",
                "PreTaxVal": 0,
                "AssAmt": '.$dt->taxable_amt.',
                "GstRt": '.($dt->cgst_rt+$dt->sgst_rt).',
                "IgstAmt": 0,

                "CgstAmt":'.$dt->cgst_amt.',
                "SgstAmt":'.$dt->sgst_amt.',

                "CesRt": 0,
                "CesAmt": 0,
                "CesNonAdvlAmt": 0,
                "StateCesRt": 0,
                "StateCesAmt": 0,
                "StateCesNonAdvlAmt":0,
                "OthChrg": 0,
                "TotItemVal": '.($dt->taxable_amt+$dt->cgst_amt+$dt->sgst_amt).',
                "OrdLineRef": 0,
                "OrgCntry": "IN",
                "PrdSlNo": 0,
                "BchDtls": {
                    "Nm": "",
                    "ExpDt": null,
                    "WrDt": null
                },
                "AttribDtls": [
                    {
                    "Nm": "",
                    "Val": 0
                    }
                ]
                }
            ],
            "ValDtls": {
                "AssVal": '.$dt->taxable_amt.',
                "CgstVal": '.$dt->cgst_amt.',
                "SgstVal": '.$dt->sgst_amt.',
                "IgstVal": 0,
                "CesVal": 0,
                "StCesVal": 0,
                "Discount": 0,
                "OthChrg": 0,
                "RndOffAmt": 0,
                "TotInvVal": '.($dt->taxable_amt+$dt->cgst_amt+$dt->sgst_amt).',
                "TotInvValFc": 0
            },
            "PayDtls": {
                "Nm": "",
                "AccDet": "098301002773",
                "Mode": "NEFT/RTGS/EPAY",
                "FinInsBr": "ICIC0000983",
                "PayTerm": "NA",
                "PayInstr": "",
                "CrTrn": "",
                "DirDr": "",
                "CrDay": 0,
                "PaidAmt": 0,
                "PaymtDue": 0
            },
            "RefDtls": {
                "InvRm": "'.$dt->remarks.'",
                "DocPerdDtls": {
                    "InvStDt": null,
                    "InvEndDt": null
                    },
                "PrecDocDtls": [
                {
                    "InvNo": "",
                    "InvDt": null,
                    "OthRefNo": ""
                }
                ],
                "ContrDtls": [
                {
                    "RecAdvRef": "",
                    "RecAdvDt": null,
                    "TendRefr": "",
                    "ContrRefr": "",
                    "ExtRefr": "",
                    "ProjRefr": "",
                    "PORefr": null,
                    "PORefDt": null
                }
                ]
            },
            "AddlDocDtls": [
                {
                "Url": "",
                "Docs": "",
                "Info": ""
                }
            ],
            "ExpDtls": {
                "ShipBNo": "",
                "ShipBDt": null,
                "Port": null,
                "RefClm": "",
                "ForCur":null,
                "CntCode": null
            }
            }',
            CURLOPT_HTTPHEADER => array(
                'x-cleartax-auth-token: ' . AUTHKOKEN,
                'x-cleartax-product: ' . PRODUCT,
                'Content-Type: application/json',
                'owner_id: ' . OWNERID,
                'gstin: ' . SALLERGSTIN
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            echo $response;
    }

    function save_irn(){
        $data = $this->input->get();
        $res = $this->Rent_calculation_model->save_irn($data);
        echo $res;
    }

    function print_irn(){
        $this->load->helper('download');
        $irns = $this->input->get('irn');
        // echo $irns;
        // exit;
        $file_name = $irns . '.pdf';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            /*****************for test server ******************* */
       // CURLOPT_URL => 'https://einvoicing.internal.cleartax.co/v2/eInvoice/download?template=62cfd0a9-d1ed-47b0-b260-fe21f57e9c5e&format=PDF&irns=' . $irns,
        
        CURLOPT_URL => 'https://api-einv.cleartax.in/v2/eInvoice/download?template=6b15ec40-2f53-4c18-a6e5-d8d53a2487bb&format=PDF&irns=' . $irns,
        
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'x-cleartax-auth-token: ' . AUTHKOKEN,
            'x-cleartax-product: ' . PRODUCT,
            'owner_id: ' . OWNERID,
            'gstin: ' . SALLERGSTIN
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        force_download($file_name, $response);
        // echo $response;
    }
public function api_callcr($trans_do)
    {
        // $trans_do = $this->input->get('trans_do');
        $api_query= $this->SaleModel->f_get_api_datacr($trans_do);
        return $api_query;
    }
function get_api_res_cr(){
// echo 'hi';
// exit;
$trans_do = $this->input->post('trans_do');

$data = $this->api_callcr($trans_do);
// echo '<pre>';
$dt = $data ? $data[0] : $data;

$HsnCd = strlen($dt->HsnCd)==4 ? $dt->HsnCd . '00' : $dt->HsnCd;
// echo '<pre>';
$str_arr = explode('/', $dt->No);
$suf = substr($str_arr[1], 0, 4);
$send_str = str_replace('-', '',substr($str_arr[4], 0,5));
$send_str1 = str_replace('_', '-',substr($str_arr[5], 0,10));
// $doc_no = $suf . '/' . substr(str_replace('_', '-', $->No), 15, 11);
// $doc_no = $suf . '/' .$send_str. substr(str_replace('_', '-', $dt->No), 20,6);
$doc_no = $suf . '/' .$send_str. '/'  .$send_str1 ;

//     $result = '{
//         "Version": "'.$dt->Version.'",
//         "TranDtls": {
//             "TaxSch": "'.$dt->TaxSch.'",
//             "SupTyp": "'.$dt->SupTyp.'",
//             "RegRev": "'.$dt->RegRev.'",
//             "EcmGstin": null,
//             "IgstOnIntra": "N"
//         },
//         "DocDtls": {
//             "Typ": "'.$dt->Typ.'",
//             "No": "'.$doc_no.'",
//             "Dt": "'.CURRDT.'"
//         },
//         "SellerDtls": {
//             "Gstin": "'.SALLERGSTIN.'",
//             "LglNm": "'.$dt->LglNm.'",
//             "TrdNm": "'.$dt->TrdNm.'",
//             "Addr1": "'.$dt->Addr1.'",
//             "Addr2": "'.$dt->Addr2.'",
//             "Loc": "'.$dt->Loc.'",
//             "Pin": '.$dt->Pin.',
//             "Stcd": "'.SALLERSTCD.'",
//             "Ph": "'.SALLERPH.'",
//             "Em": "'.SALLEREM.'"
//         },
//         "BuyerDtls": {
//             "Gstin": "'.$dt->Gstin1.'",
//             "LglNm": "'.$dt->LglNm1.'",
//             "TrdNm": "'.$dt->TrdNm1.'",
//             "Pos": "'.$dt->Pos.'",
//             "Addr1": "'.$dt->Addr1_1.'",
//             "Addr2": "'.$dt->Addr2_1.'",
//             "Loc": "'.$dt->Loc1.'",
//             "Pin": '.$dt->Pin1.',
//             "Stcd": "'.$dt->Stcd1.'",
//             "Ph": "'.$dt->Ph1.'",
//             "Em": "'.$dt->Em1.'"
//         },
//         "DispDtls": {
//             "Nm": "'.$dt->Nm2.'",
//             "Addr1": "'.$dt->Addr1_2.'",
//             "Addr2": "'.$dt->Addr2_2.'",
//             "Loc": "'.$dt->Loc2.'",
//             "Pin": '.$dt->Pin2.',
//             "Stcd": "'.$dt->Stcd2.'"
//         },
//         "ShipDtls": {
//             "Gstin": "'.$dt->Gstin2.'",
//             "LglNm": "'.$dt->LglNm2.'",
//             "TrdNm": "'.$dt->TrdNm2.'",
//             "Addr1": "'.$dt->Addr1_3.'",
//             "Addr2": "'.$dt->Addr2_3.'",
//             "Loc": "'.$dt->Loc3.'",
//             "Pin": '.$dt->Pin3.',
//             "Stcd": "'.$dt->Stcd3.'"
//         },
//         "ItemList": [
//             {
//             "SlNo": "1",
//             "PrdDesc": "'.$dt->PrdDesc.'",
//             "IsServc": "'.$dt->IsServc.'",
//             "HsnCd": "'.$HsnCd.'",
//             "Barcde": "'.$dt->Barcde.'",
//             "Qty": '.$dt->Qty.',
//             "FreeQty": '.$dt->FreeQty.',
//             "Unit": "'.$dt->Unit.'",
//             "UnitPrice": '.$dt->UnitPrice.',
//             "TotAmt": '.$dt->TotAmt.',
//             "Discount": '.$dt->Discount.',
//             "PreTaxVal": '.$dt->PreTaxVal.',
//             "AssAmt": '.$dt->AssAmt.',
//             "GstRt": '.$dt->GstRt.',
//             "IgstAmt": '.$dt->IgstAmt.',
//             "CgstAmt":'.$dt->CgstAmt.',
//             "SgstAmt":'.$dt->SgstAmt.',
//             "CesRt": '.$dt->CesRt.',
//             "CesAmt": '.$dt->CesAmt.',
//             "CesNonAdvlAmt": '.$dt->CesNonAdvlAmt.',
//             "StateCesRt": '.$dt->StateCesRt.',
//             "StateCesAmt": '.$dt->StateCesAmt.',
//             "StateCesNonAdvlAmt":'.$dt->StateCesNonAdvlAmt.',
//             "OthChrg": '.$dt->OthChrg.',
//             "TotItemVal": '.$dt->TotItemVal.',
//             "OrdLineRef": "'.$dt->OrdLineRef.'",
//             "OrgCntry": "'.$dt->OrgCntry.'",
//             "PrdSlNo": "'.$dt->PrdSlNo.'",
//             "BchDtls": {
//                 "Nm": "",
//                 "ExpDt": null,
//                 "WrDt": null
//             },
//             "AttribDtls": [
//                 {
//                 "Nm": "'.$dt->Nm5.'",
//                 "Val": "'.$dt->Val.'"
//                 }
//             ]
//             }
//         ],
//         "ValDtls": {
//             "AssVal": '.$dt->AssVal.',
//             "CgstVal": '.$dt->CgstVal.',
//             "SgstVal": '.$dt->SgstVal.',
//             "IgstVal": 0,
//             "CesVal": '.$dt->CesVal.',
//             "StCesVal": '.$dt->StCesVal.',
//             "Discount": '.$dt->Discount.',
//             "OthChrg": '.$dt->OthChrg.',
//             "RndOffAmt": '.$dt->RndOffAmt.',
//             "TotInvVal": '.$dt->TotInvVal.',
//             "TotInvValFc": '.$dt->TotInvValFc.'
//         },
//         "PayDtls": {
//             "Nm": "",
//             "AccDet": "",
//             "Mode": "",
//             "FinInsBr": "",
//             "PayTerm": "",
//             "PayInstr": "",
//             "CrTrn": "",
//             "DirDr": "",
//             "CrDay": 0,
//             "PaidAmt": 0,
//             "PaymtDue": 0
//         },
//         "RefDtls": {
//             "InvRm": "",
//             "DocPerdDtls": {
//             "InvStDt": null,
//             "InvEndDt": null
//             },
//             "PrecDocDtls": [
//             {
//                 "InvNo": "",
//                 "InvDt": null,
//                 "OthRefNo": ""
//             }
//             ],
//             "ContrDtls": [
//             {
//                 "RecAdvRef": "",
//                 "RecAdvDt": null,
//                 "TendRefr": "",
//                 "ContrRefr": "",
//                 "ExtRefr": "",
//                 "ProjRefr": "",
//                 "PORefr": "",
//                 "PORefDt": null
//             }
//             ]
//         },
//         "AddlDocDtls": [
//             {
//             "Url": "",
//             "Docs": "",
//             "Info": ""
//             }
//         ],
//         "ExpDtls": {
//             "ShipBNo": "",
//             "ShipBDt": null,
//             "Port": null,
//             "RefClm": "",
//             "ForCur":null,
//             "CntCode": null
//         },
//         "EwbDtls": {
//             "TransId": "",
//             "TransName": "",
//             "Distance": 0,
//             "TransDocNo": "",
//             "TransDocDt": null,
//             "VehNo": "",
//             "VehType": "",
//             "TransMode": ""
//         }
//         }';
//         echo $result;exit;
//     var_dump($data); exit;
//      echo ( $doc_no);exit;
//    echo ( $doc_no);exit;
$curl = curl_init();
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt_array($curl, array(
    //CURLOPT_URL => 'https://einvoicing.internal.cleartax.co/v1/govt/api/Invoice',
    /****************for production server */
    CURLOPT_URL => 'https://api-einv.cleartax.in/v1/govt/api/Invoice',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
    "Version": "'.$dt->Version.'",
    "TranDtls": {
        "TaxSch": "'.$dt->TaxSch.'",
        "SupTyp": "'.$dt->SupTyp.'",
        "RegRev": "",
        "EcmGstin": null,
        "IgstOnIntra": "N"
    },
    "DocDtls": {
        "Typ": "CRN",
        "No": "'.$doc_no.'",
        "Dt": "'.CURRDT.'"
    },
    "SellerDtls": {
        "Gstin": "'.SALLERGSTIN.'",
        "LglNm": "'.$dt->LglNm.'",
        "TrdNm": "'.$dt->TrdNm.'",
        "Addr1": "'.$dt->Addr1.'",
        "Addr2": "'.$dt->Addr2.'",
        "Loc": "'.$dt->Loc.'",
        "Pin": '.$dt->Pin2.',
        "Stcd": "'.SALLERSTCD.'",
        "Ph": "'.SALLERPH.'",
        "Em": "'.SALLEREM.'"
    },
    "BuyerDtls": {
        "Gstin": "'.$dt->Gstin1.'",
        "LglNm": "'.$dt->LglNm1.'",
        "TrdNm": "'.$dt->TrdNm1.'",
        "Pos": "'.$dt->Pos.'",
        "Addr1": "'.$dt->Addr1_1.'",
        "Addr2": "'.$dt->Addr2_1.'",
        "Loc": "'.$dt->Loc1.'",
        "Pin": '.$dt->Pin1.',
        "Stcd": "'.$dt->Stcd1.'",
        "Ph": "'.$dt->Ph1.'",
        "Em": "'.$dt->Em1.'"
    },
    "DispDtls": {
        "Nm": "'.$dt->Nm2.'",
        "Addr1": "'.$dt->Addr1_2.'",
        "Addr2": "'.$dt->Addr2_2.'",
        "Loc": "'.$dt->Loc2.'",
        "Pin": '.$dt->Pin2.',
        "Stcd": "'.$dt->Stcd2.'"
    },
    "ShipDtls": {
        "Gstin": "'.$dt->Gstin2.'",
        "LglNm": "'.$dt->LglNm2.'",
        "TrdNm": "'.$dt->TrdNm2.'",
        "Addr1": "'.$dt->Addr1_3.'",
        "Addr2": "'.$dt->Addr2_3.'",
        "Loc": "'.$dt->Loc3.'",
        "Pin": '.$dt->Pin3.',
        "Stcd": "'.$dt->Stcd3.'"
    },
    "ItemList": [
        {
        "SlNo": "1",
        "PrdDesc": "'.$dt->PrdDesc.'",
        "IsServc": "'.$dt->IsServc.'",
        "HsnCd": "'.$HsnCd.'",
        "Barcde": "'.$dt->Barcde.'",
        "Qty": '.$dt->Qty.',
        "FreeQty": '.$dt->FreeQty.',
        "Unit": "'.$dt->Unit.'",
        "UnitPrice": '.$dt->UnitPrice.',
        "TotAmt": '.$dt->TotAmt.',
        "Discount": '.$dt->Discount.',
        "PreTaxVal": '.$dt->PreTaxVal.',
        "AssAmt": '.$dt->AssAmt.',
        "GstRt": '.$dt->GstRt.',
        "IgstAmt": '.$dt->IgstAmt.',
        "CgstAmt":'.$dt->CgstAmt.',
        "SgstAmt":'.$dt->SgstAmt.',
        "CesRt": '.$dt->CesRt.',
        "CesAmt": '.$dt->CesAmt.',
        "CesNonAdvlAmt": '.$dt->CesNonAdvlAmt.',
        "StateCesRt": '.$dt->StateCesRt.',
        "StateCesAmt": '.$dt->StateCesAmt.',
        "StateCesNonAdvlAmt":'.$dt->StateCesNonAdvlAmt.',
        "OthChrg": '.$dt->OthChrg.',
        "TotItemVal": '.$dt->TotItemVal.',
        "OrdLineRef": "'.$dt->OrdLineRef.'",
        "OrgCntry": "'.$dt->OrgCntry.'",
        "PrdSlNo": "'.$dt->PrdSlNo.'",
        "BchDtls": {
            "Nm": "",
            "ExpDt": null,
            "WrDt": null
        },
        "AttribDtls": [
            {
            "Nm": "'.$dt->Nm5.'",
            "Val": "'.$dt->Val.'"
            }
        ]
        }
    ],
    "ValDtls": {
        "AssVal": '.$dt->AssVal.',
        "CgstVal": '.$dt->CgstVal.',
        "SgstVal": '.$dt->SgstVal.',
        "IgstVal": 0,
        "CesVal": '.$dt->CesVal.',
        "StCesVal": '.$dt->StCesVal.',
        "Discount": '.$dt->Discount.',
        "OthChrg": '.$dt->OthChrg.',
        "RndOffAmt": '.$dt->RndOffAmt.',
        "TotInvVal": '.$dt->TotInvVal.',
        "TotInvValFc": '.$dt->TotInvValFc.'
    },
    "PayDtls": {
        "Nm": "",
        "AccDet": "",
        "Mode": "",
        "FinInsBr": "",
        "PayTerm": "",
        "PayInstr": "",
        "CrTrn": "",
        "DirDr": "",
        "CrDay": 0,
        "PaidAmt": 0,
        "PaymtDue": 0
    },
    "RefDtls": {
        "InvRm": "",
        "DocPerdDtls": {
        "InvStDt": null,
        "InvEndDt": null
        },
        "PrecDocDtls": [
        {
            "InvNo": "",
            "InvDt": null,
            "OthRefNo": ""
        }
        ],
        "ContrDtls": [
        {
            "RecAdvRef": "",
            "RecAdvDt": null,
            "TendRefr": "",
            "ContrRefr": "",
            "ExtRefr": "",
            "ProjRefr": "",
             "PORefr": "'.$dt->PORefr.'",
             "PORefDt": "'.$dt->PORefDt.'"
        }
        ]
    },
    "AddlDocDtls": [
        {
        "Url": "",
        "Docs": "",
        "Info": ""
        }
    ],
    "ExpDtls": {
        "ShipBNo": "",
        "ShipBDt": null,
        "Port": null,
        "RefClm": "",
        "ForCur":null,
        "CntCode": null
    }
    
    }',
    CURLOPT_HTTPHEADER => array(
        'x-cleartax-auth-token: ' . AUTHKOKEN,
        'x-cleartax-product: ' . PRODUCT,
        'Content-Type: application/json',
        'owner_id: ' . OWNERID,
        'gstin: ' . SALLERGSTIN
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    // echo $response;
    $res = json_decode($response);
    if($res->Success == 'Y'){
        $this->save_irncr($this->input->post(), $res->Irn, $res->AckNo,$res->AckDt);
    }else{
        echo $response;
    }
   
}


function save_irncr($data, $irn, $ackno ,$AckDt){
// var_dump($data);
// $data = $this->input->post();
$res = $this->SaleModel->save_irncr($data, $irn,$ackno,$AckDt);
echo $res;
}



public function api_call_htc($trans_do)
    {
        // $trans_do = $this->input->get('trans_do');
        $api_query= $this->HTransportC_model->f_get_api_data($trans_do);

        // echo $this->db->last_query();
    //    print_r($api_query);
    //    exit();
        return $api_query;
    }



function get_api_htc(){
    $trans_do = $this->input->get('trans_do');
    $data = $this->api_call_htc($trans_do);

    // print_r($data);
    // exit();




    $dt = $data ? $data[0] : $data;
    $HsnCd = strlen($dt->sac_code)==4 ? $dt->sac_code . '00' : $dt->sac_code;
    // echo '<pre>';
    $str_arr = explode('-', $dt->invoice_no);
    $suf = substr($str_arr[1],2);

 
    $doc_no = $str_arr[0].'/'. $suf .$str_arr[2]. '/' .$str_arr[3] ;
    


    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
       // CURLOPT_URL => 'https://einvoicing.internal.cleartax.co/v1/govt/api/Invoice',
       CURLOPT_URL => 'https://api-einv.cleartax.in/v1/govt/api/Invoice',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
        "Version": "'.Version.'",
        "TranDtls": {
            "TaxSch": "'.TAX_SCH.'",
            "SupTyp": "'.SupTyp.'",
            "RegRev": "'.$dt->pay_flag.'",
            "EcmGstin": null,
            "IgstOnIntra": "N"
        },
        "DocDtls": {
            "Typ": "'.Typ.'",

            "No": "'.$doc_no.'",

            "Dt": "'.CURRDT.'"
        },
        "SellerDtls": {
            "Gstin": "'.SALLERGSTIN.'",
            "LglNm": "'.LG_LNM.'",
            "TrdNm": "'.TRQ_NM.'",
            "Addr1": "'.$dt->sellet_addr.'",
            "Addr2": "'.$dt->sellet_addr.'",

            "Loc": "'.$dt->seller_district.'",

            "Pin": '.$dt->sellet_pin.',
            "Stcd": "'.SALLERSTCD.'",
            "Ph": "'.SALLERPH.'",
            "Em": "'.SALLEREM.'"
        },
        "BuyerDtls": {
            "Gstin": "'.$dt->gst_no.'",

            "LglNm": "'.$dt->cust_name.'",
            "TrdNm": "'.$dt->cust_name.'",
            "Pos": "19",

            "Addr1": "'.$dt->cust_addr.'",
            
            "Addr2": "'.$dt->cust_addr.'",
            "Loc": "'.$dt->buyer_district.'",
            "Pin": '.$dt->pin_code.',
            "Stcd": "19",
            "Ph": "",
            "Em": "'.$dt->email_id.'"
        },
        "DispDtls": {
            "Nm": "'.LG_LNM.'",
            "Addr1": "'.$dt->sellet_addr.'",
            "Addr2": "'.$dt->sellet_addr.'",
            "Loc": "'.$dt->seller_district.'",
            "Pin": '.$dt->sellet_pin.',
            "Stcd": "'.SALLERSTCD.'"
        },

        "ShipDtls": {
            "Gstin": "'.$dt->gst_no.'",
            "LglNm": "'.$dt->cust_name.'",
            "TrdNm": "'.$dt->cust_name.'",
            "Addr1": "'.$dt->cust_addr.'",
            "Addr2": "",
            "Loc": "'.$dt->buyer_district.'",
            "Pin": '.$dt->pin_code.',
            "Stcd": "19"
        },
        "ItemList": [
            {
            "SlNo": "1",
            "PrdDesc": "'.$dt->product_desc.'",
            "IsServc": "Y",

            "HsnCd": "'.$dt->sac_code.'",
            "Barcde": "",
            "Qty": '.$dt->qty.',
            
            "FreeQty": "0",
            "Unit": "UNT",
            "UnitPrice": '.$dt->taxable_amt.',
            "TotAmt": '.$dt->taxable_amt.',
            "Discount": "",
            "PreTaxVal": 0,
            "AssAmt": '.$dt->taxable_amt.',
            "GstRt": '.($dt->cgst_rt+$dt->sgst_rt).',
            "IgstAmt": 0,

            "CgstAmt":'.$dt->cgst_amt.',
            "SgstAmt":'.$dt->sgst_amt.',

            "CesRt": 0,
            "CesAmt": 0,
            "CesNonAdvlAmt": 0,
            "StateCesRt": 0,
            "StateCesAmt": 0,
            "StateCesNonAdvlAmt":0,
            "OthChrg": 0,
            "TotItemVal": '.($dt->taxable_amt+$dt->cgst_amt+$dt->sgst_amt).',
            "OrdLineRef": 0,
            "OrgCntry": "IN",
            "PrdSlNo": 0,
            "BchDtls": {
                "Nm": "",
                "ExpDt": null,
                "WrDt": null
            },
            "AttribDtls": [
                {
                "Nm": "",
                "Val": 0
                }
            ]
            }
        ],
        "ValDtls": {
            "AssVal": '.$dt->taxable_amt.',
            "CgstVal": '.$dt->cgst_amt.',
            "SgstVal": '.$dt->sgst_amt.',
            "IgstVal": 0,
            "CesVal": 0,
            "StCesVal": 0,
            "Discount": 0,
            "OthChrg": 0,
            "RndOffAmt": 0,
            "TotInvVal": '.($dt->taxable_amt+$dt->cgst_amt+$dt->sgst_amt).',
            "TotInvValFc": 0
        },
        "PayDtls": {
            "Nm": "",
            "AccDet": "",
            "Mode": "",
            "FinInsBr": "",
            "PayTerm": "",
            "PayInstr": "",
            "CrTrn": "",
            "DirDr": "",
            "CrDay": 0,
            "PaidAmt": 0,
            "PaymtDue": 0
        },
        "RefDtls": {
            "InvRm": "'.$dt->remarks.'",
            "DocPerdDtls": {
            "InvStDt": null,
            "InvEndDt": null
            },
            "PrecDocDtls": [
            {
                "InvNo": "",
                "InvDt": null,
                "OthRefNo": ""
            }
            ],
            "ContrDtls": [
            {
                "RecAdvRef": "",
                "RecAdvDt": null,
                "TendRefr": "",
                "ContrRefr": "",
                "ExtRefr": "",
                "ProjRefr": "",
                "PORefr": null,
                "PORefDt": null
            }
            ]
        },
        "AddlDocDtls": [
            {
            "Url": "",
            "Docs": "",
            "Info": ""
            }
        ],
        "ExpDtls": {
            "ShipBNo": "",
            "ShipBDt": null,
            "Port": null,
            "RefClm": "",
            "ForCur":null,
            "CntCode": null
        }
        }',
        CURLOPT_HTTPHEADER => array(
            'x-cleartax-auth-token: ' . AUTHKOKEN,
            'x-cleartax-product: ' . PRODUCT,
            'Content-Type: application/json',
            'owner_id: ' . OWNERID,
            'gstin: ' . SALLERGSTIN
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
}

function save_htc_irn(){
    $data = $this->input->get();
    $res = $this->HTransportC_model->save_irn($data);
    echo $res;
}    
   //   Api call for service information
    public function api_call_service($trans_do)
    {
        $api_query= $this->HTransportC_model->f_get_api_service_data($trans_do);
        return $api_query;
    }
    function get_api_service(){
        $trans_do = $this->input->get('trans_do');
        $data = $this->api_call_service($trans_do);
    
        $dt = $data ? $data[0] : $data;
        $HsnCd = strlen($dt->sac_code)==4 ? $dt->sac_code . '00' : $dt->sac_code;
        // echo '<pre>';
        $str_arr = explode('-', $dt->invoice_no);
        $suf = substr($str_arr[1],2);
    
        $doc_no = $str_arr[0].'/'. $suf .$str_arr[2]. '/' .$str_arr[3] ;


        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt_array($curl, array(
        // CURLOPT_URL => 'https://einvoicing.internal.cleartax.co/v1/govt/api/Invoice',
            CURLOPT_URL => 'https://api-einv.cleartax.in/v1/govt/api/Invoice',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
            "Version": "'.Version.'",
            "TranDtls": {
                "TaxSch": "'.TAX_SCH.'",
                "SupTyp": "'.SupTyp.'",
                "RegRev": "'.$dt->pay_flag.'",
                "EcmGstin": null,
                "IgstOnIntra": "N"
            },
            "DocDtls": {
                "Typ": "'.Typ.'",

                "No": "'.$doc_no.'",

                "Dt": "'.CURRDT.'"
            },
            "SellerDtls": {
                "Gstin": "'.SALLERGSTIN.'",
                "LglNm": "'.LG_LNM.'",
                "TrdNm": "'.TRQ_NM.'",
                "Addr1": "'.$dt->sellet_addr.'",
                "Addr2": "'.$dt->sellet_addr.'",

                "Loc": "'.$dt->seller_district.'",

                "Pin": '.$dt->sellet_pin.',
                "Stcd": "'.SALLERSTCD.'",
                "Ph": "'.SALLERPH.'",
                "Em": "'.SALLEREM.'"
            },
            "BuyerDtls": {
                "Gstin": "'.$dt->gst_no.'",

                "LglNm": "'.$dt->cust_name.'",
                "TrdNm": "'.$dt->cust_name.'",
                "Pos": "19",

                "Addr1": "'.$dt->cust_addr.'",
                
                "Addr2": "'.$dt->cust_addr.'",
                "Loc": "'.$dt->buyer_district.'",
                "Pin": '.$dt->pin.',
                "Stcd": "19",
                "Ph": "",
                "Em": "'.$dt->email.'"
            },
            "DispDtls": {
                "Nm": "'.LG_LNM.'",
                "Addr1": "'.$dt->sellet_addr.'",
                "Addr2": "'.$dt->sellet_addr.'",
                "Loc": "'.$dt->seller_district.'",
                "Pin": '.$dt->sellet_pin.',
                "Stcd": "'.SALLERSTCD.'"
            },

            "ShipDtls": {
                "Gstin": "'.$dt->gst_no.'",
                "LglNm": "'.$dt->cust_name.'",
                "TrdNm": "'.$dt->cust_name.'",
                "Addr1": "'.$dt->cust_addr.'",
                "Addr2": "",
                "Loc": "'.$dt->buyer_district.'",
                "Pin": '.$dt->pin.',
                "Stcd": "19"
            },
            "ItemList": [
                {
                "SlNo": "1",
                "PrdDesc": "'.$dt->product_desc.'",
                "IsServc": "Y",

                "HsnCd": "'.$dt->sac_code.'",
                "Barcde": "",
                "Qty": '.$dt->qty.',
                
                "FreeQty": "0",
                "Unit": "UNT",
                "UnitPrice": '.$dt->taxable_amt.',
                "TotAmt": '.$dt->taxable_amt.',
                "Discount": "",
                "PreTaxVal": 0,
                "AssAmt": '.$dt->taxable_amt.',
                "GstRt": '.($dt->cgst_rt+$dt->sgst_rt).',
                "IgstAmt": 0,

                "CgstAmt":'.$dt->cgst_amt.',
                "SgstAmt":'.$dt->sgst_amt.',

                "CesRt": 0,
                "CesAmt": 0,
                "CesNonAdvlAmt": 0,
                "StateCesRt": 0,
                "StateCesAmt": 0,
                "StateCesNonAdvlAmt":0,
                "OthChrg": 0,
                "TotItemVal": '.($dt->taxable_amt+$dt->cgst_amt+$dt->sgst_amt).',
                "OrdLineRef": 0,
                "OrgCntry": "IN",
                "PrdSlNo": 0,
                "BchDtls": {
                    "Nm": "",
                    "ExpDt": null,
                    "WrDt": null
                },
                "AttribDtls": [
                    {
                    "Nm": "",
                    "Val": 0
                    }
                ]
                }
            ],
            "ValDtls": {
                "AssVal": '.$dt->taxable_amt.',
                "CgstVal": '.$dt->cgst_amt.',
                "SgstVal": '.$dt->sgst_amt.',
                "IgstVal": 0,
                "CesVal": 0,
                "StCesVal": 0,
                "Discount": 0,
                "OthChrg": 0,
                "RndOffAmt": 0,
                "TotInvVal": '.($dt->taxable_amt+$dt->cgst_amt+$dt->sgst_amt).',
                "TotInvValFc": 0
            },
            "PayDtls": {
                "Nm": "",
                "AccDet": "",
                "Mode": "",
                "FinInsBr": "",
                "PayTerm": "",
                "PayInstr": "",
                "CrTrn": "",
                "DirDr": "",
                "CrDay": 0,
                "PaidAmt": 0,
                "PaymtDue": 0
            },
            "RefDtls": {
                "InvRm": "'.$dt->remarks.'",
                "DocPerdDtls": {
                "InvStDt": null,
                "InvEndDt": null
                },
                "PrecDocDtls": [
                {
                    "InvNo": "",
                    "InvDt": null,
                    "OthRefNo": ""
                }
                ],
                "ContrDtls": [
                {
                    "RecAdvRef": "",
                    "RecAdvDt": null,
                    "TendRefr": "",
                    "ContrRefr": "",
                    "ExtRefr": "",
                    "ProjRefr": "",
                    "PORefr": null,
                    "PORefDt": null
                }
                ]
            },
            "AddlDocDtls": [
                {
                "Url": "",
                "Docs": "",
                "Info": ""
                }
            ],
            "ExpDtls": {
                "ShipBNo": "",
                "ShipBDt": null,
                "Port": null,
                "RefClm": "",
                "ForCur":null,
                "CntCode": null
            }
            }',
            CURLOPT_HTTPHEADER => array(
                'x-cleartax-auth-token: ' . AUTHKOKEN,
                'x-cleartax-product: ' . PRODUCT,
                'Content-Type: application/json',
                'owner_id: ' . OWNERID,
                'gstin: ' . SALLERGSTIN
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            echo $response;
    }

function save_service_irn(){
    $data = $this->input->get();
    $input = array(
        'irn' => $data['irn'],
        'ack_no' => $data['ack'],
        'ack_dt' => $data['ack_dt'],
        'pay_flag'=>$data['trn_type']
    );
    $this->db->where(array('invoice_no' => $data['trans_do']));
    if($this->db->update('td_service_charge', $input)){
        return 1;
    }else{
        return 0;
    }
  
}


}

?>