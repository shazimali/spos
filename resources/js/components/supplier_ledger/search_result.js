import React, {Component} from 'react'
import Moment from 'react-moment';
import Loader from 'react-loader';
class SearchResult extends Component{

    constructor(props){

        super(props);


    }
    render(){

        let prev_balance = this.props.balance;
        return(

                    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">Supplier Ledger List</h3>
                <Loader loaded={this.props.loaded}/>
                <div class="table-responsive">
                    <table id="example23" class="display nowrap table table-hover table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>VchNo</th>
                                <th>Description</th>
                                <th>Credit</th>
                                <th>Debit</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                        {

                            this.props.results.length?

                            this.props.results.map((r) => {

                                let debit=r.total_price ? parseFloat(r.total_price):0  ;
                                let credit=r.pay ? parseFloat(r.pay):0  + r.amount? parseFloat(r.amount):0;
                                let balance=debit-credit;
                                if(r.amount){
                                    debit= prev_balance
                                 }


                                 if(r.invoice_type_id==2){
                                    balance=debit-credit;
                                    credit=debit
                                    debit=prev_balance;
                                    prev_balance-=balance;

                                 }else{

                                    prev_balance+=balance;

                                 }


                                return(
                                        <tr>
                                            <td><Moment format="D MMM YYYY" withTitle>{r.date}</Moment></td>

                                            <td>
                                           {r.id }
                                            </td>
                                            <td> { r.invoice_type_id==1 ? 'Purchase Invoice' :''  } { r.invoice_type_id==2 ? 'Return Invoice' :''  } { r.amount ? 'Voucher' :''  } : #{r.id}</td>
                                            <td>{credit}</td>
                                            <td>{debit}</td>
                                            <td>{prev_balance}</td>
                                        </tr>

                                        );
                            {/* if(first){

                                    if(result.payment_type_id < 4){

                                            if(result.invoice_type_id == 1){


                                            first= false
                                            prev_balance = parseFloat(result.total_price) -  parseFloat(result.pay)
                                            return(

                                            <tr>
                                                <td><Moment format="D MMM YYYY" withTitle>{result.date}</Moment></td>

                                                <td>
                                                <u>{result.id}</u>-
                                                {result.payment_type_id == 1 ? 'Cash' : ''}
                                                {result.payment_type_id == 2 ? 'Credit' : ''}
                                                {result.payment_type_id == 3 ? 'Check' : ''}

                                                </td>
                                                <td>Sale Invoice: #{result.id}</td>
                                                <td>{result.total_price}</td>
                                                <td>{result.pay}</td>
                                                <td>{parseFloat(result.total_price - result.pay)}</td>
                                            </tr>

                                            );

                                            }
                                            if(result.invoice_type_id == 2){

                                                first= false
                                                prev_balance = [parseFloat(result.closing_balance) + parseFloat(result.total_price)] - parseFloat(result.total_price)
                                            return(

                                                <tr>
                                                <td><Moment format="D MMM YYYY" withTitle>{result.date}</Moment></td>

                                                <td>
                                                <u>{result.id}</u>-Return
                                                </td>
                                                <td>Return sale invoice: #{result.id}</td>
                                                <td>0.00</td>
                                                <td>{result.total_price}</td>
                                                <td>{prev_balance}</td>
                                            </tr>


                                            );

                                            }



                                    }

                                    if(result.payment_type_id == 4){
                                            first= false
                                            prev_balance =  parseFloat(result.amount) - parseFloat(result.amount)
                                        return(

                                            <tr>
                                                <td><Moment format="D MMM YYYY" withTitle>{result.date}</Moment></td>
                                                <td><u>{result.id}</u>- Voucher</td>
                                                <td>Customer Voucher : #{result.id} </td>
                                                <td>{parseFloat(result.closing_balance) + parseFloat(result.amount) }</td>
                                                <td>{result.amount}</td>
                                                <td>{prev_balance}</td>
                                            </tr>

                                        );
                                    }


                            }
                            if(!first){

                                if(result.payment_type_id < 4){

                                    if(result.invoice_type_id == 1){

                                        return(

                                            <tr>
                                                <td><Moment format="D MMM YYYY" withTitle>{result.date}</Moment></td>

                                                <td>
                                                <u>{result.id}</u>-
                                                {result.payment_type_id == 1 ? 'Cash' : ''}
                                                {result.payment_type_id == 2 ? 'Credit' : ''}
                                                {result.payment_type_id == 3 ? 'Check' : ''}

                                                </td>
                                                <td>Sale Invoice: #{result.id}</td>
                                                <td>{result.total_price}</td>
                                                <td>{result.pay}</td>
                                                <td>{parseFloat(result.total_price - result.pay) + parseFloat(prev_balance) }</td>
                                                <td hidden>{prev_balance = parseFloat(result.total_price - result.pay)  + parseFloat(prev_balance)}</td>
                                            </tr>

                                        );

                                    }
                                    if(result.invoice_type_id == 2){

                                            return(

                                            <tr>
                                                <td><Moment format="D MMM YYYY" withTitle>{result.date}</Moment></td>

                                                <td>
                                                <u>{result.id}</u>-Return
                                                </td>
                                                <td>Return sale invoice: #{result.id}</td>
                                                <td>0.00</td>
                                                <td>{result.total_price}</td>
                                                <td>{prev_balance - result.total_price}</td>
                                                <td hidden>{prev_balance = prev_balance - result.total_price}</td>
                                            </tr>

                                            );
                                    }

                                }

                                if(result.payment_type_id == 4){

                                    return(

                                        <tr>
                                            <td><Moment format="D MMM YYYY" withTitle>{result.date}</Moment></td>
                                            <td><u>{result.id}</u>- Voucher</td>
                                            <td>Customer Voucher : #{result.id} </td>
                                            <td>0.00</td>
                                            <td>{result.amount}</td>
                                            <td>{prev_balance - result.amount}</td>
                                            <td hidden>{prev_balance = prev_balance - result.amount}</td>
                                        </tr>

                                    );
                                }


                            } */}

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
