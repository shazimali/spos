import React, {Component} from 'react'
import Moment from 'react-moment';
import Loader from 'react-loader';
import {addCommas,round} from "../helper/common.js";
class SearchResult extends Component{

    constructor(props){

        super(props);
        

    }
    render(){

        let prev_balance = this.props.balance;
        let voucher_count = 0;
        let voucher_num = 0;
        let sale_count = 0;
        let sale_num = 0;
        return(

                    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">Customer Ledger List</h3>
                <Loader loaded={this.props.loaded}/>
                <div class="table-responsive">
                    <table id="example23" class="display nowrap table table-hover table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>VchNo</th>
                                <th>Description</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                        {

                            this.props.results.length?

                            this.props.results.map((r) => {

                                let debit=r.net_total ? parseFloat(r.net_total):0  ;
                                let credit=r.pay ? parseFloat(r.pay):0  + r.amount? parseFloat(r.amount):0;
                                voucher_num = r.id;
                                let balance=debit-credit;
                                if(r.amount){
                                    debit= prev_balance;
                                    voucher_count++
                                    voucher_num = voucher_count;
                                    
                                 }
                                 if(r.invoice_type_id==2){
                                     debit=parseFloat(r.total_price);
                                    balance=debit-credit;
                                    credit=debit
                                    debit=prev_balance;
                                    prev_balance-=balance;

                                 }else{

                                    prev_balance+=balance;
                                    sale_num = r.customer_id+''+sale_count;

                                 }

                                return(
                                        <tr>
                                            <td><Moment format="D MMM YYYY" withTitle>{r.date}</Moment></td>
                                            <td> { r.invoice_type_id==1 ? sale_num  :''  } { r.invoice_type_id==2 ? r.id :''  } { r.amount ? voucher_count  :''  }</td>  
                                            <td> { r.invoice_type_id==1 ? 'Sale Invoice#'+sale_num  :''  } { r.invoice_type_id==2 ? 'Return Invoice#'+r.id :''  } { r.amount ? 'Voucher#'+voucher_count  :''  }</td>
                                            <td>{addCommas((credit).toFixed(2))}</td>
                                            <td>{addCommas((debit).toFixed(2))}</td>
                                            <td>{addCommas((prev_balance).toFixed(2))}</td>
                                <td className="hidden">{sale_count++}</td>
                                        </tr>
                                        
                                        );

                                        
                            })
                            :''
                        }
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
        );


    }


}

export default SearchResult
