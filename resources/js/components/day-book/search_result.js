import React, {Component} from 'react'
import Moment from 'react-moment';
import Loader from 'react-loader';
class SearchResult extends Component{

    constructor(props){

        super(props);


    }
    render(){

        let total_sale = 0;
        let total_sale_qty = 0;
        let total_return_sale_qty = 0;
        let total_return_sale = 0;
        let total_customer_voucher = 0;
        let total_purchase = 0;
        let total_purchase_qty = 0;
        let total_return_purchase_qty = 0;
        let total_return_purchase = 0;
        let total_supplier_voucher = 0;
        return(

                    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                {   this.props.results && this.props.results.customers.length ?

                 <div>
                <h3 class="box-title m-b-0">Customers</h3>
                <Loader loaded={this.props.loaded}/>
                <div class="table-responsive">
                    <table id="example23" class="display nowrap table table-hover table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Cutomer#</th>
                                <th>Name</th>
                                <th>company</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody>

                           {this.props.results.customers.map((cs) => {

                                return(
                                        <tr>
                                            <td>cus#{cs.id}</td>

                                            <td>
                                           {cs.name}
                                            </td>
                                            <td> { cs.company}</td>
                                            <td>{cs.email}</td>
                                            <td>{cs.phone}</td>
                                            <td>{cs.address}</td>
                                        </tr>

                                        );


                            })
                           }
                        </tbody>
                    </table>
                    </div>
                    </div>
                :''
                }







                { this.props.results && this.props.results.sales.length ?


                <div>
                <h3 class="box-title m-b-0">Sales</h3>
                <Loader loaded={this.props.loaded}/>
                <div class="table-responsive">
                    <table id="example23" class="display nowrap table table-hover table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Invoice#</th>
                                <th>Csutomer Name</th>
                                <th>Payment Mode</th>
                                <th>Total Qty</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                        {

                            this.props.results.sales.map((cs) => {

                                return(

                                        <tr>
                                            <td>sl#{cs.id}</td>
                                            <td>{cs.customer.name}</td>
                                            <td> { cs.payment_type.title}</td>
                                            <td>{cs.total_qty}</td>
                                            <td>{cs.net_total}</td>
                                            <td hidden>{total_sale += parseFloat(cs.net_total)}</td>
                                            <td hidden>{total_sale_qty += parseFloat(cs.total_qty)}</td>
                                        </tr>

                                        );


                            })
                        }
                        <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td className="font-bold">{total_sale_qty}</td>
                                <td className="font-bold">{total_sale}</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
                </div>
                        :''
                }

                {this.props.results && this.props.results.return_sales.length ?


                <div>
                <h3 class="box-title m-b-0">Return Sales</h3>
                <Loader loaded={this.props.loaded}/>
                <div class="table-responsive">
                    <table id="example23" class="display nowrap table table-hover table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Invoice#</th>
                                <th>Csutomer Name</th>
                                <th>Total Qty</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                        {
                            this.props.results.return_sales.map((cs) => {

                                return(

                                        <tr>
                                            <td>rs#{cs.id}</td>
                                            <td>{cs.customer.name}</td>
                                            <td>{cs.total_qty}</td>
                                            <td>{cs.total_price}</td>
                                            <td hidden>{total_return_sale += parseFloat(cs.total_price)}</td>
                                            <td hidden>{total_return_sale_qty += parseFloat(cs.total_qty)}</td>
                                        </tr>

                                        );


                            })

                        }
                        <tr>
                                <td></td>
                                <td></td>
                                <td className="font-bold">{total_return_sale_qty}</td>
                                <td className="font-bold">{total_return_sale}</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
                </div>
                        :''
                }

                { this.props.results && this.props.results.customer_vouchers.length ?


                    <div>
                    <h3 class="box-title m-b-0">Customer Vouchers</h3>
                    <Loader loaded={this.props.loaded}/>
                    <div class="table-responsive">
                        <table id="example23" class="display nowrap table table-hover table-striped" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Vch#</th>
                                    <th>Csutomer#</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            {
                                this.props.results.customer_vouchers.map((cs) => {

                                    return(

                                            <tr>
                                                <td>cv#{cs.id}</td>
                                                <td>cs#{cs.customer_id}</td>
                                                <td> { cs.customer.name}</td>
                                                <td>{cs.amount}</td>
                                                <td hidden>{total_customer_voucher += parseFloat(cs.amount)}</td>
                                            </tr>

                                            );


                                })

                            }
                            <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td className="font-bold">{total_customer_voucher}</td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                    </div>
                            :''

                    }


                    { this.props.results && this.props.results.suppliers.length ?

                    <div>
                    <h3 class="box-title m-b-0">Suppliers</h3>
                    <Loader loaded={this.props.loaded}/>
                    <div class="table-responsive">
                        <table id="example23" class="display nowrap table table-hover table-striped" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Supplier#</th>
                                    <th>Name</th>
                                    <th>company</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody>
                            {

                                this.props.results.suppliers.map((cs) => {

                                    return(
                                            <tr>
                                                <td>sp#{cs.id}</td>

                                                <td>
                                            {cs.name}
                                                </td>
                                                <td> { cs.company}</td>
                                                <td>{cs.email}</td>
                                                <td>{cs.phone}</td>
                                                <td>{cs.address}</td>
                                            </tr>

                                            );


                                })

                            }
                            </tbody>
                        </table>

                    </div>
                    </div>
                            :''
                    }

                {  this.props.results && this.props.results.purchases.length ?


                <div>
                <h3 class="box-title m-b-0">Purchases</h3>
                <Loader loaded={this.props.loaded}/>
                <div class="table-responsive">
                    <table id="example23" class="display nowrap table table-hover table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Invoice#</th>
                                <th>Supplier Name</th>
                                <th>Payment Mode</th>
                                <th>Total Qty</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                        {

                            this.props.results.purchases.map((cs) => {

                                return(

                                        <tr>
                                            <td>pr#{cs.id}</td>
                                            <td>{cs.supplier.name}</td>
                                            <td>{cs.payment_type.title}</td>
                                            <td>{cs.total_qty}</td>
                                            <td>{cs.total_price}</td>
                                            <td hidden>{total_purchase += parseFloat(cs.total_price)}</td>
                                            <td hidden>{total_purchase_qty += parseFloat(cs.total_qty)}</td>
                                        </tr>

                                        );


                            })
                        }
                        <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td className="font-bold">{total_purchase_qty}</td>
                                <td className="font-bold">{total_purchase}</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
                </div>
                        :''
                }

            {  this.props.results && this.props.results.return_purchases.length ?


            <div>
            <h3 class="box-title m-b-0">Return Purchase</h3>
            <Loader loaded={this.props.loaded}/>
            <div class="table-responsive">
                <table id="example23" class="display nowrap table table-hover table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Invoice#</th>
                            <th>Supplier Name</th>
                            <th>Total Qty</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                    {

                        this.props.results.return_purchases.map((cs) => {

                            return(

                                    <tr>
                                        <td>rp#{cs.id}</td>
                                        <td>{cs.supplier.name}</td>
                                        <td>{cs.total_qty}</td>
                                        <td>{cs.total_price}</td>
                                        <td hidden>{total_return_purchase += parseFloat(cs.total_price)}</td>
                                        <td hidden>{total_return_purchase_qty += parseFloat(cs.total_qty)}</td>
                                    </tr>

                                    );


                        })
                    }
                    <tr>
                            <td></td>
                            <td></td>
                            <td className="font-bold">{total_return_purchase_qty}</td>
                            <td className="font-bold">{total_return_purchase}</td>
                    </tr>
                    </tbody>
                </table>

            </div>
            </div>

                    :''
            }

            { this.props.results && this.props.results.supplier_vouchers.length ?


                <div>
                <h3 class="box-title m-b-0">Supplier Vouchers</h3>
                <Loader loaded={this.props.loaded}/>
                <div class="table-responsive">
                    <table id="example23" class="display nowrap table table-hover table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Vch#</th>
                                <th>Supplier#</th>
                                <th>Name</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                        {

                            this.props.results.supplier_vouchers.map((cs) => {

                                return(

                                        <tr>
                                            <td>sv#{cs.id}</td>
                                            <td>cs#{cs.supplier_id}</td>
                                            <td> { cs.supplier.name}</td>
                                            <td>{cs.amount}</td>
                                            <td hidden>{total_supplier_voucher += parseFloat(cs.amount)}</td>
                                        </tr>

                                        );


                            })
                        }
                        <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td className="font-bold">{total_supplier_voucher}</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
                </div>
                        :''

                }

            </div>
        </div>
    </div>
        );


    }


}

export default SearchResult
