import React, {Component} from 'react'
import Moment from 'react-moment';
import Loader from 'react-loader';
class SearchResult extends Component{

    constructor(props){

        super(props);


    }
    render(){

        let total_qty = 0;
        let sale_total_qty = 0;
        let purchase_total_qty = 0;
        if(this.props.type == 1 || this.props.type == 2){

            return(
                <div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">{this.props.type == 1 ? 'Sale' :''}{this.props.type == 2 ? 'Purchase' :''} Product Ledger List</h3>
            <Loader loaded={this.props.loaded}/>
            <div class="table-responsive">
                <table id="example23" class="display nowrap table table-hover table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Invoice#</th>
                            <th>Product Code</th>
                            <th>Product Title</th>
                            <th>Product Quantity</th>
                            <th>Created</th>
                            <th>Unit Price</th>
                        </tr>
                    </thead>
                    <tbody>
                    {

                        this.props.results.length?

                        this.props.results.map((r) => {

                            total_qty += r.total_qty;
                            return(

                                <tr>
                                    <td>{this.props.type == 1?'sl#'+r.sale_id:''} {this.props.type == 2?"pr#"+r.purchase_id:''}</td>

                                    <td>
                                {r.product_head.code }
                                    </td>
                                    <td>{ r.product_head.title}</td>
                                    <td>{r.total_qty}</td>
                                    <td>{this.props.type == 1?r.sale.date:''} {this.props.type == 2?r.purchase.date:''}</td>
                                    <td>{r.total_price}</td>
                                </tr>

                            );



                        })

                        :''
                    }
                    <h5 className='font-weight-bold'>Total Quantity: {total_qty}</h5>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
    );
        }

        if(this.props.type == 3){


            return(
                        <div class="row">
            <div class="col-sm-12">
                { this.props.saleResults.length?
                <div class="white-box">
                    <h3 class="box-title m-b-0">Sale Product Ledger List</h3>
                    <Loader loaded={this.props.loaded}/>
                    <div class="table-responsive">
                        <table id="example23" class="display nowrap table table-hover table-striped" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Invoice#</th>
                                    <th>Product Code</th>
                                    <th>Product Title</th>
                                    <th>Product Quantity</th>
                                    <th>Created</th>
                                    <th>Unit Price</th>
                                </tr>
                            </thead>
                            <tbody>
                            {
                                this.props.saleResults.map((r) => {

                                        sale_total_qty += r.total_qty
                                    return(

                                        <tr>
                                            <td>{'sl#'+r.sale_id}</td>

                                            <td>
                                        {r.product_head.code }
                                            </td>
                                            <td>{ r.product_head.title}</td>
                                            <td>{r.total_qty}</td>
                                            <td>{r.sale.date}</td>
                                            <td>{r.total_price}</td>
                                        </tr>

                                    );



                                })

                            }
                            <h5 className='font-weight-bold'>Total Quantity: {sale_total_qty}</h5>
                            </tbody>
                        </table>

                    </div>
                </div>
                :''}

                { this.props.purchaseResults.length?
                <div class="white-box">
                    <h3 class="box-title m-b-0">Purchase Product Ledger List</h3>
                    <Loader loaded={this.props.loaded}/>
                    <div class="table-responsive">
                        <table id="example23" class="display nowrap table table-hover table-striped" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Invoice#</th>
                                    <th>Product Code</th>
                                    <th>Product Title</th>
                                    <th>Product Quantity</th>
                                    <th>Created</th>
                                    <th>Unit Price</th>
                                </tr>
                            </thead>
                            <tbody>
                            {



                                this.props.purchaseResults.map((r) => {

                                    purchase_total_qty += r.total_qty
                                    return(

                                        <tr>
                                            <td>{"pr#"+r.purchase_id}</td>

                                            <td>
                                        {r.product_head.code }
                                            </td>
                                            <td>{ r.product_head.title}</td>
                                            <td>{r.total_qty}</td>
                                            <td>{r.purchase.date}</td>
                                            <td>{r.total_price}</td>
                                        </tr>

                                    );



                                })

                            }
                            <h5 className='font-weight-bold'>Total Quantity: {purchase_total_qty}</h5>
                            </tbody>
                        </table>

                    </div>
                </div>
                :''}
            </div>
        </div>
            );
        }

        if(this.props.type == ''){

            return(
                <h1></h1>
            );
        }


    }


}

export default SearchResult
