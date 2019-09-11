import React, {Component} from 'react'
import Moment from 'react-moment';
import Loader from 'react-loader';
class SearchResult extends Component{

    constructor(props){

        super(props);
    }
    render(){

        return(

                    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">Customer Profit Loss List</h3>
                <Loader loaded={this.props.loaded}/>
                <div class="table-responsive">
                    <table id="example23" class="display nowrap table table-hover table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Customer Name</th>
                                <th>Total Amount</th>
                                <th>Created</th>
                                <th>Quantity</th>
                                <th>Profit/Loss</th>
                            </tr>
                        </thead>
                        <tbody>

                        {

                            this.props.results.length?

                            this.props.results.map( (result) => {

                                let sale = 0
                                result.sale_detail.map((sl) => {

                                    sale += parseFloat(sl.total_price)  * parseFloat(sl.total_qty)
                                })

                                let purchase = 0
                                result.sale_detail.map((rt) => {

                                    purchase += parseFloat(rt.purchase_rate.total_price) * parseFloat(rt.total_qty)
                                })

                                let profit = sale - purchase
                                return(
                                    <tr>
                                        <td>Sl#{result.id}</td>
                                        <td>{result.customer.name}</td>
                                        <td>{result.total_price}</td>
                                        <td><Moment format="D MMM YYYY" withTitle>{result.date}</Moment></td>
                                        <td>{result.total_qty}</td>
                                        <td>{profit}</td>
                                </tr>

                                );

                            })
                            :''}
                        </tbody>
                    </table>
                    {this.props.totalSale != 0?
                            <h1>Total Sale: {this.props.totalSale}</h1>
                            :''
                    }
                    {this.props.totalProfit != 0?
                            <h1>Total Profit: {this.props.totalProfit}</h1>
                            :''
                    }
                </div>
            </div>
        </div>
    </div>
        );


    }


}

export default SearchResult
