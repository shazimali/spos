import React, {Component} from 'react'
import axios from 'axios'
import SearchResult from './search_result';
class Filter extends Component{

    constructor(props){

        super(props);
        this.state = {

            searchData:'',
            options:{

                customer:false,
                sale:false,
                returnSale:false,
                customerVoucher:false,
                supplier:false,
                purchase:false,
                returnPurchase:false,
                supplierVoucher:false,
                fromDate:'',
                selectAll:'',
                toDate:''

            },
            showSearch:false,
            loaded:true,
            print:false
        }


        this.handleChange= this.handleChange.bind(this);
        this.handleSubmit= this.handleSubmit.bind(this);
        this.handlePrint= this.handlePrint.bind(this);

    }

    handleChange(e){

       if(e.target.id == 'selectAll'){
        $("input[name=selectAll]").is(":checked")?

            this.setState({

                ...this.state,
                options:{
                    ...this.state.options,
                    customer:true,
                    sale:true,
                    returnSale:true,
                    customerVoucher:true,
                    supplier:true,
                    purchase:true,
                    returnPurchase:true,
                    supplierVoucher:true

                }


            })
            :
            this.setState({

                ...this.state,
                options:{
                    ...this.state.options,
                    customer:false,
                    sale:false,
                    returnSale:false,
                    customerVoucher:false,
                    supplier:false,
                    purchase:false,
                    returnPurchase:false,
                    supplierVoucher:false

                }


            })

       }

       if(e.target.id != 'selectAll' && (e.target.id != 'fromDate' || e.target.id != 'toDate')){

            $('input[name='+e.target.id+']').is(':checked')?
                this.setState({
                    ...this.state,
                    options:{
                        ...this.state.options,
                        [e.target.id]:true
                    }
                })
                :
                this.setState({
                    ...this.state,
                    options:{
                        ...this.state.options,
                        [e.target.id]:false

                    }
                })
       }

       if(e.target.id != 'selectAll' && (e.target.id == 'fromDate' || e.target.id == 'toDate')){

            this.setState({

                ...this.state,
                options:{

                    ...this.state.options,
                    [e.target.id]:e.target.value

                }
            })
   }








    }

    handleSubmit(e){

        e.preventDefault()
        if(this.state.options.fromDate != ""){

            this.setState({
                loaded:false,
                print:true,
                searchData:'',
            })

            let url = location.origin;
            let customer = this.state.options.customer == true ? 1 : 0;
            let sale = this.state.options.sale == true ? 1 : 0;
            let returnSale = this.state.options.returnSale == true ? 1 : 0;
            let customerVoucher = this.state.options.customerVoucher == true ? 1 : 0;
            let supplier = this.state.options.supplier == true ? 1 : 0;
            let purchase = this.state.options.purchase == true ? 1 : 0;
            let returnPurchase = this.state.options.returnPurchase == true ? 1 : 0;
            let supplierVoucher = this.state.options.supplierVoucher == true ? 1 : 0;
            e.preventDefault()
            let query = url+'/day-book/search?customer='+customer+'&sale='+sale+'&return_sale='+returnSale+'&customer_voucher='+customerVoucher+'&supplier='+supplier+'&purchase='+purchase+'&return_purchase='+returnPurchase+'&supplier_voucher='+supplierVoucher+'&from_date='+this.state.options.fromDate+'&to_date='+this.state.options.toDate
            axios.get(query)
            .then( (res) => {

                this.setState({
                    loaded:true,
                    searchData:res.data,
                    showSearch:false,
                    showSearch:true
                })

            })
            .catch( (res) => {
                this.setState({
                    loaded:true
                })
            })
        }

        else{

            this.setState({
                print:false
            })

            alert("Please select From date.")
        }
    }

    handlePrint(e){

        if(this.state.selectedCustomer != ""){

            let url = location.origin;

            e.preventDefault()

            // let query = url+'/customer-ledger/show?customer='+this.state.selectedCustomer+'&from_date='+this.state.fromDate+'&to_date='+this.state.toDate
            let query = url+'/day-book/show?customer='+this.state.options.customer+'&sale='+this.state.options.sale+'&return_sale='+this.state.options.returnSale+'&customer_voucher='+this.state.options.customerVoucher+'&supplier='+this.state.options.supplier+'&purchase='+this.state.options.purchase+'&return_purchase='+this.state.options.returnPurchase+'&supplier_voucher='+this.state.options.supplierVoucher+'&from_date='+this.state.options.fromDate+'&to_date='+this.state.options.toDate
            window.open(query,'_blank' ,  'fullscreen=yes')
            location.reload();
        }

        else{

            this.setState({

                print:false
            })

          alert("Please select customer.")
        }

    }

     render(){

        return(

       <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="col-sm-10 box-title m-b-0"><b>Day Book Filter</b>
                    {
                        this.state.print ?
                    <button  onClick={this.handlePrint} class="btn pull-right btn-primary">Print</button>
                    : ''
                    }
                    </h3>
                    <br/>

                    <div class="row">
                        <form  onSubmit={this.handleSubmit}>
                    <div class="form-group col-lg-6">
                            <label>From Date</label>
                            <input type="date" id="fromDate"  onChange={this.handleChange} name="from_date" class="form-control" placeholder="mm/dd/yyyy"/>
                    </div>

                    <div class="form-group col-lg-6">
                            <label>To Date</label>
                            <input type="date" id="toDate" onChange={this.handleChange}  name="to_date" class="form-control" placeholder="mm/dd/yyyy"/>
                    </div>
                    <div class="form-group col-lg-3">
                        <div class="checkbox checkbox-success checkbox-circle">
                            <input id="customer" name="customer" checked={this.state.options.customer}  value={this.state.options.customer} onChange={this.handleChange} type="checkbox"/>
                            <label for="customer">Customer</label>
                        </div>
                    </div>
                    <div class="form-group col-lg-3">
                        <div class="checkbox checkbox-success checkbox-circle">
                            <input id="sale" name="sale"  checked={this.state.options.sale} value={this.state.options.sale} onChange={this.handleChange} type="checkbox"/>
                            <label for="sale">Sales</label>
                        </div>
                    </div>
                    <div class="form-group col-lg-3">
                        <div class="checkbox checkbox-success checkbox-circle">
                            <input id="returnSale"  checked={this.state.options.returnSale} name="returnSale" value={this.state.options.returnSale} onChange={this.handleChange} type="checkbox"/>
                            <label for="returnSale">Return Sales</label>
                        </div>
                    </div>
                    <div class="form-group col-lg-3">
                        <div class="checkbox checkbox-success checkbox-circle">
                            <input id="customerVoucher"  checked={this.state.options.customerVoucher} name="customerVoucher" value={this.state.options.customerVoucher} onChange={this.handleChange} type="checkbox"/>
                            <label for="customerVoucher">Customer Voucher</label>
                        </div>
                    </div>
                    <div class="form-group col-lg-3">
                        <div class="checkbox checkbox-success checkbox-circle">
                            <input id="supplier"  checked={this.state.options.supplier} name="supplier" value={this.state.options.supplier} onChange={this.handleChange} type="checkbox"/>
                            <label for="supplier">Supplier</label>
                        </div>
                    </div>
                    <div class="form-group col-lg-3">
                        <div class="checkbox checkbox-success checkbox-circle">
                            <input id="purchase"  checked={this.state.options.purchase} name="purchase" value={this.state.options.purchase} onChange={this.handleChange} type="checkbox"/>
                            <label for="purchase">Purchase</label>
                        </div>
                    </div>
                    <div class="form-group col-lg-3">
                        <div class="checkbox checkbox-success checkbox-circle">
                            <input id="returnPurchase"  checked={this.state.options.returnPurchase} name="returnPurchase" value={this.state.options.returnPurchase} onChange={this.handleChange} type="checkbox"/>
                            <label for="returnPurchase">Return Purchase</label>
                        </div>
                    </div>
                    <div class="form-group col-lg-3">
                        <div class="checkbox checkbox-success checkbox-circle">
                            <input id="supplierVoucher"   checked={this.state.options.supplierVoucher} name="supplierVoucher" value={this.state.options.supplierVoucher} onChange={this.handleChange} type="checkbox"/>
                            <label for="supplierVoucher">Purchase Voucher</label>
                        </div>
                    </div>
                    <div class="form-group col-lg-3">
                        <div class="checkbox checkbox-success checkbox-circle">
                            <input id="selectAll" name="selectAll" value={this.state.options.selectAll} onChange={this.handleChange} type="checkbox"/>
                            <label for="selectAll">Select All</label>
                        </div>
                    </div>
                    <div class="form-group col-lg-2">
                            <label></label>
                            <input type="submit" class="btn btn-primary" value="search"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {
        this.state.searchData != "" ?
    <SearchResult  results={this.state.searchData}   loaded={this.state.loaded} />
    :''
    }
    </div>

        );
    }
}

export default Filter
