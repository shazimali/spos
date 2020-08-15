<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerVoucher;
use App\Models\SupplierVoucher;
use App\Models\Supplier;
use App\Models\SaleDetail;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\ProductHead;
use Excel;
class LedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function customer()
    {
        return view('ledgers.customer_ledger');
    }

    public function customerSearch(Request $request)
    {

        $customer = $request->customer;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if ($from_date) {


            $balance= Customer::whereId($customer)
            ->with(
                ['sale' => function ($q) use($from_date) {
                $q->when($from_date,function($q,$from_date){

                    $q->where('date','<', $from_date);
                });
            },
            'customer_vouchers' => function ($q) use($from_date) {
                $q->when($from_date,function($q,$from_date){

                    $q->where('date','<', $from_date);
                });

            }])->first();

            $balance = $balance->cBalance();
            }else {
                $balance=0;
            }
        $results =  Customer::when($customer,function ($query,$customer){

           return $query->whereId($customer);

            })

        ->with(
            ['sale' => function ($q) use($from_date,$to_date) {
            $q->when($from_date,function($q,$from_date){

                $q->where('date','>=', $from_date);
            });
            $q->when($to_date,function($q,$to_date){

                $q->where('date','<=', $to_date);
            });

        },
        'customer_vouchers' => function ($q) use($from_date,$to_date) {
            $q->when($from_date,function($q,$from_date){

                $q->where('date','>=', $from_date);
            });
            $q->when($to_date,function($q,$to_date){

                $q->where('date','<=', $to_date);
            });

        }])
        ->get();

            $final_collecttion = null;
            foreach($results as $rs){

                $final_collection = array_merge($rs->sale->toArray(),$rs->customer_vouchers->toArray());

                array_multisort(array_column($final_collection, 'date'), SORT_ASC,
                array_column($final_collection, 'time'),      SORT_ASC,
                $final_collection);
            }
           return [
                'balance'=>$balance,
                'final_collection'=>$final_collection
            ];
    }

    public function customerShow(Request $request)
    {
        $customer = $request->customer;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if ($from_date) {


            $balance= Customer::whereId($customer)
            ->with(
                ['sale' => function ($q) use($from_date) {
                $q->when($from_date,function($q,$from_date){

                    $q->where('date','<', $from_date);
                });
            },
            'customer_vouchers' => function ($q) use($from_date) {
                $q->when($from_date,function($q,$from_date){

                    $q->where('date','<', $from_date);
                });

            }])->first();

            $balance = $balance->cBalance();
            }else {
                $balance=0;
            }
        $results =  Customer::when($customer,function ($query,$customer){

           return $query->whereId($customer);

            })

        ->with(
            ['sale' => function ($q) use($from_date,$to_date) {
            $q->when($from_date,function($q,$from_date){

                $q->where('date','>=', $from_date);
            });
            $q->when($to_date,function($q,$to_date){

                $q->where('date','<=', $to_date);
            });

        },
        'customer_vouchers' => function ($q) use($from_date,$to_date) {
            $q->when($from_date,function($q,$from_date){

                $q->where('date','>=', $from_date);
            });
            $q->when($to_date,function($q,$to_date){

                $q->where('date','<=', $to_date);
            });

        }])
        ->get();

            $final_collecttion = null;
            foreach($results as $rs){

                $final_collection = array_merge($rs->sale->toArray(),$rs->customer_vouchers->toArray());

                array_multisort(array_column($final_collection, 'date'), SORT_ASC,
                array_column($final_collection, 'time'),      SORT_ASC,
                $final_collection);
            }
            return view('ledgers.customer_show',[

                'customer' => Customer::whereId($customer)->first(),
                'results' => $final_collection,
                'from_date' => $from_date,
                'to_date' => $to_date,
                'balance'=>$balance
            ]);
    }

    public function supplier()
    {
        return view('ledgers.supplier_ledger');
    }

    public function supplierSearch(Request $request)
    {

        $supplier = $request->supplier;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if ($from_date) {


        $balance= Supplier::whereId($supplier)
        ->with(
            ['purchase' => function ($q) use($from_date) {
            $q->when($from_date,function($q,$from_date){

                $q->where('date','<', $from_date);
            });
        },
        'supplier_voucher' => function ($q) use($from_date) {
            $q->when($from_date,function($q,$from_date){

                $q->where('date','<', $from_date);
            });

        }])->first();

        $balance = $balance->cBalance();
        }else {
            $balance=0;
        }

        $results =  Supplier::when($supplier,function ($query,$supplier){

           return $query->whereId($supplier);

            })

        ->with(
            ['purchase' => function ($q) use($from_date,$to_date) {
            $q->when($from_date,function($q,$from_date){

                $q->where('date','>=', $from_date);
            });
            $q->when($to_date,function($q,$to_date){

                $q->where('date','<=', $to_date);
            });

        },
        'supplier_voucher' => function ($q) use($from_date,$to_date) {
            $q->when($from_date,function($q,$from_date){

                $q->where('date','>=', $from_date);
            });
            $q->when($to_date,function($q,$to_date){

                $q->where('date','<=', $to_date);
            });

        }])
        ->get();

            $final_collecttion = null;
            foreach($results as $rs){

                $final_collection = array_merge($rs->purchase->toArray(),$rs->supplier_voucher->toArray());
                usort($final_collection, function($a, $b) {
                    return $a['date'] <=> $b['date'];
                });
            }
            return [
                'balance'=>$balance,
                'final_collection'=>$final_collection
            ];

    }

    public function supplierShow(Request $request)
    {

        $supplier = $request->supplier;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if ($from_date) {


            $balance= Supplier::whereId($supplier)
            ->with(
                ['purchase' => function ($q) use($from_date) {
                $q->when($from_date,function($q,$from_date){

                    $q->where('date','<', $from_date);
                });
            },
            'supplier_voucher' => function ($q) use($from_date) {
                $q->when($from_date,function($q,$from_date){

                    $q->where('date','<', $from_date);
                });

            }])->first();

            $balance = $balance->cBalance();
            }else {
                $balance=0;
            }
        $results =  Supplier::when($supplier,function ($query,$supplier){

           return $query->whereId($supplier);

            })

        ->with(
            ['purchase' => function ($q) use($from_date,$to_date) {
            $q->when($from_date,function($q,$from_date){

                $q->where('date','>=', $from_date);
            });
            $q->when($to_date,function($q,$to_date){

                $q->where('date','<=', $to_date);
            });

        },
        'supplier_voucher' => function ($q) use($from_date,$to_date) {
            $q->when($from_date,function($q,$from_date){

                $q->where('date','>=', $from_date);
            });
            $q->when($to_date,function($q,$to_date){

                $q->where('date','<=', $to_date);
            });

        }])
        ->get();

            $final_collecttion = null;
            foreach($results as $rs){

                $final_collection = array_merge($rs->purchase->toArray(),$rs->supplier_voucher->toArray());

                usort($final_collection, function($a, $b) {
                    return $a['date'] <=> $b['date'];
                });
            }
            return view('ledgers.supplier_show',[

                'customer' => Supplier::whereId($supplier)->first(),
                'results' => $final_collection,
                'from_date' => $from_date,
                'to_date' => $to_date,
                'balance'=>$balance
            ]);
    }

    public function product(){

        return view('ledgers.product_ledger');
    }
    public function productSearch(Request $request){

        $product = $request->product;
        $product_type = $request->product_type;
        $from_date = $request->from_date;
        $to_date = $request->to_date;

       if($product_type == 'sale'){

         $results = SaleDetail::when($product,function($q) use($product){

           return $q->where('product_head_id',$product);
        })


        ->when($from_date,function($q) use($from_date){

            $q->whereHas('sale',function($q) use($from_date){

                return $q->where('date','>=',$from_date);
            });
        })

        ->when($to_date,function($q) use($to_date){

            $q->whereHas('sale',function($q) use($to_date){

                return $q->where('date','<=',$to_date);
            });
        })->with('productHead','sale')
        ->get();

        return ['results' => $results,'type' => 1];
        }

        if($product_type == 'purchase'){

            $results = PurchaseDetail::when($product,function($q) use($product){

                return $q->where('product_head_id',$product);
             })


             ->when($from_date,function($q) use($from_date){

                 $q->whereHas('purchase',function($q) use($from_date){

                     return $q->where('date','>=',$from_date);
                 });
             })

             ->when($to_date,function($q) use($to_date){

                 $q->whereHas('purchase',function($q) use($to_date){

                     return $q->where('date','<=',$to_date);
                 });
             })->with('productHead','purchase')
             ->get();

             return ['results' => $results,'type' => 2];
        }

        if($product_type == ''){

            $purchase = PurchaseDetail::when($product,function($q) use($product){

                    return $q->where('product_head_id',$product);
                 })


                 ->when($from_date,function($q) use($from_date){

                     $q->whereHas('purchase',function($q) use($from_date){

                         return $q->where('date','>=',$from_date);
                     });
                 })

                 ->when($to_date,function($q) use($to_date){

                     $q->whereHas('purchase',function($q) use($to_date){

                         return $q->where('date','<=',$to_date);
                     });
                 })->with('productHead','purchase')
                 ->get();

             $sale = SaleDetail::when($product,function($q) use($product){

                    return $q->where('product_head_id',$product);
                 })


                 ->when($from_date,function($q) use($from_date){

                     $q->whereHas('sale',function($q) use($from_date){

                         return $q->where('date','>=',$from_date);
                     });
                 })

                 ->when($to_date,function($q) use($to_date){

                     $q->whereHas('sale',function($q) use($to_date){

                         return $q->where('date','<=',$to_date);
                     });
                 })->with('productHead','sale')
                 ->get();

                 return ['sale' => $sale,'purchase' => $purchase,'type' => 3];
            }




    }
    public function productShow(Request $request){
        $product = $request->product;
        $product_type = $request->product_type;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $sale = null;
        $purchase = null;
        $results= null;
        $type= null;

       if($product_type == 'sale'){

         $results = SaleDetail::when($product,function($q) use($product){

           return $q->where('product_head_id',$product);
        })


        ->when($from_date,function($q) use($from_date){

            $q->whereHas('sale',function($q) use($from_date){

                return $q->where('date','>=',$from_date);
            });
        })

        ->when($to_date,function($q) use($to_date){

            $q->whereHas('sale',function($q) use($to_date){

                return $q->where('date','<=',$to_date);
            });
        })->with('productHead','sale')
        ->get();
        $type = 1;
        }

        if($product_type == 'purchase'){

            $results = PurchaseDetail::when($product,function($q) use($product){

                return $q->where('product_head_id',$product);
             })


             ->when($from_date,function($q) use($from_date){

                 $q->whereHas('purchase',function($q) use($from_date){

                     return $q->where('date','>=',$from_date);
                 });
             })

             ->when($to_date,function($q) use($to_date){

                 $q->whereHas('purchase',function($q) use($to_date){

                     return $q->where('date','<=',$to_date);
                 });
             })->with('productHead','purchase')
             ->get();
             $type = 2;

        }

        if($product_type == ''){

            $purchase = PurchaseDetail::when($product,function($q) use($product){

                    return $q->where('product_head_id',$product);
                 })


                 ->when($from_date,function($q) use($from_date){

                     $q->whereHas('purchase',function($q) use($from_date){

                         return $q->where('date','>=',$from_date);
                     });
                 })

                 ->when($to_date,function($q) use($to_date){

                     $q->whereHas('purchase',function($q) use($to_date){

                         return $q->where('date','<=',$to_date);
                     });
                 })->with('productHead','purchase')
                 ->get();

             $sale = SaleDetail::when($product,function($q) use($product){

                    return $q->where('product_head_id',$product);
                 })


                 ->when($from_date,function($q) use($from_date){

                     $q->whereHas('sale',function($q) use($from_date){

                         return $q->where('date','>=',$from_date);
                     });
                 })

                 ->when($to_date,function($q) use($to_date){

                     $q->whereHas('sale',function($q) use($to_date){

                         return $q->where('date','<=',$to_date);
                     });
                 })->with('productHead','sale')
                 ->get();
                 $type = 3;

            }


            return view('ledgers.product_show',[

                'product' => $product?ProductHead::where('id',$product)->first():'' ,
                'sales' => $sale,
                'purchases' => $purchase,
                'from_date' => $from_date,
                'to_date' => $to_date,
                'type' => $type,
                'results'=> $results
            ]);

    }

    public function dayBook(){

        return view('ledgers.daybook');
    }

    public function dayBookSearch(Request $request){

        $customer = $request->customer ;
        $sale = $request->sale;
        $return_sale = $request->return_sale;
        $customer_voucher = $request->customer_voucher;
        $supplier = $request->supplier;
        $purchase = $request->purchase;
        $return_purchase = $request->return_purchase;
        $supplier_voucher = $request->supplier_voucher;
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        //sales reatlated queries
        $customer = Customer::where('created_at','>=',$from_date)
        ->when($to_date,function($q) use($to_date){
            return $q->where('created_at','<=',$to_date);
        })
        ->when($customer,function($q){
            return $q->get();
         });


         $sale = Sale::where('invoice_type_id',1)->with('saleDetails','customer','paymentType')->where('date','>=',$from_date)

         ->when($to_date,function($q) use($to_date){

            return $q->where('date','<=',$to_date);
         })
         ->when($sale,function($q){

            return $q->get();
         });

         $return_sale = Sale::where('invoice_type_id',2)->with('saleDetails','customer','paymentType')->where('date','>=',$from_date)

         ->when($to_date,function($q) use($to_date){

            return $q->where('date','<=',$to_date);
         })
         ->when($return_sale,function($q){

            return $q->get();
         });

         $customer_voucher = CustomerVoucher::with('customer')->where('date','>=',$from_date)

         ->when($to_date,function($q) use($to_date){

            return $q->where('date','<=',$to_date);
         })
         ->when($customer_voucher,function($q){

            return $q->get();
         });

         //purchase reatlated queries
        $supplier = Supplier::where('created_at','>=',$from_date)

        ->when($to_date,function($q) use($to_date){

            return $q->where('created_at','<=',$to_date);

        })

        ->when($supplier,function($q){

            return $q->get();
         });


         $purchase = Purchase::where('invoice_type_id',1)->with('purchaseDetails','supplier','paymentType')->where('date','>=',$from_date)

         ->when($to_date,function($q) use($to_date){

            return $q->where('date','<=',$to_date);
         })
         ->when($purchase,function($q){

            return $q->get();
         });

         $return_purchase = Purchase::where('invoice_type_id',2)->with('purchaseDetails','supplier','paymentType')->where('date','>=',$from_date)

         ->when($to_date,function($q) use($to_date){

            return $q->where('date','<=',$to_date);
         })
         ->when($return_purchase,function($q){

            return $q->get();
         });

         $supplier_voucher = SupplierVoucher::with('supplier')->where('date','>=',$from_date)

         ->when($to_date,function($q) use($to_date){

            return $q->where('date','<=',$to_date);
         })
         ->when($supplier_voucher,function($q){

            return $q->get();
         });
        return [

            'customers'=>  $request->customer  ? $customer: [] ,
            'sales' => $request->sale ?  $sale: [],
            'return_sales' => $request->return_sale  ?  $return_sale: [],
            'customer_vouchers' => $request->customer_voucher ? $customer_voucher: [],
            'suppliers'=> $request->supplier ? $supplier : [],
            'purchases' =>  $request->purchase ? $purchase : [],
            'return_purchases' => $request->return_purchase ? $return_purchase : [] ,
            'supplier_vouchers' => $request->supplier_voucher ? $supplier_voucher : []
        ];
    }

    public function dayBookShow(Request $request){

        $customer = $request->customer;
        $sale = $request->sale;
        $return_sale = $request->return_sale;
        $customer_voucher = $request->customer_voucher;
        $supplier = $request->supplier;
        $purchase = $request->purchase;
        $return_purchase = $request->return_purchase;
        $supplier_voucher = $request->supplier_voucher;
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        //sales reatlated queries
        $customer = Customer::where('created_at','>=',$from_date)

        ->when($to_date,function($q) use($to_date){

            return $q->where('created_at','<=',$to_date);

        })

        ->when($customer,function($q){

            return $q->get();
         });


         $sale = Sale::where('invoice_type_id',1)->with('saleDetails','customer','paymentType')->where('date','>=',$from_date)

         ->when($to_date,function($q) use($to_date){

            return $q->where('date','<=',$to_date);
         })
         ->when($sale,function($q){

            return $q->get();
         });

         $return_sale = Sale::where('invoice_type_id',2)->with('saleDetails','customer','paymentType')->where('date','>=',$from_date)

         ->when($to_date,function($q) use($to_date){

            return $q->where('date','<=',$to_date);
         })
         ->when($return_sale,function($q){

            return $q->get();
         });

         $customer_voucher = CustomerVoucher::with('customer')->where('date','>=',$from_date)

         ->when($to_date,function($q) use($to_date){

            return $q->where('date','<=',$to_date);
         })
         ->when($customer_voucher,function($q){

            return $q->get();
         });

         //purchase reatlated queries
        $supplier = Supplier::where('created_at','>=',$from_date)

        ->when($to_date,function($q) use($to_date){

            return $q->where('created_at','<=',$to_date);

        })

        ->when($supplier,function($q){

            return $q->get();
         });


         $purchase = Purchase::where('invoice_type_id',1)->with('purchaseDetails','supplier','paymentType')->where('date','>=',$from_date)

         ->when($to_date,function($q) use($to_date){

            return $q->where('date','<=',$to_date);
         })
         ->when($purchase,function($q){

            return $q->get();
         });

         $return_purchase = Purchase::where('invoice_type_id',2)->with('purchaseDetails','supplier','paymentType')->where('date','>=',$from_date)

         ->when($to_date,function($q) use($to_date){

            return $q->where('date','<=',$to_date);
         })
         ->when($return_purchase,function($q){

            return $q->get();
         });

         $supplier_voucher = SupplierVoucher::with('supplier')->where('date','>=',$from_date)

         ->when($to_date,function($q) use($to_date){

            return $q->where('date','<=',$to_date);
         })
         ->when($supplier_voucher,function($q){

            return $q->get();
         });
        return view('ledgers.daybook_show',[

            'customers'=> $customer,
            'sales' =>  $sale,
            'return_sales' => $return_sale,
            'customer_vouchers' => $customer_voucher,
            'suppliers'=> $supplier,
            'purchases' =>  $purchase,
            'return_purchases' => $return_purchase,
            'supplier_vouchers' => $supplier_voucher,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'chk_customer'=> $request->customer,
            'chk_sale' =>  $request->sale,
            'chk_return_sale' => $request->return_sale,
            'chk_customer_voucher' => $request->customer_voucher,
            'chk_supplier'=> $request->supplier,
            'chk_purchase' =>  $request->purchase,
            'chk_return_purchase' => $request->return_purchase,
            'chk_supplier_voucher' => $request->supplier_voucher,
            'from_date' => $from_date,
            'to_date' => $to_date,
        ]);
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx'
        ]);
        $errors = [];
        $path = $request->file('file')->getRealPath();
        $data = Excel::load($path)->get();  
        foreach ($date[0] as $dt) {
            
            return $dt;
            $duplicate = Ledger::where('code',$dt)->first();
            if(Ledger::where('code',$dt)->first()){


            }

        }  
      
    }
}
