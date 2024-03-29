import React, { Component } from 'react';
import axios from 'axios';
import Select from 'react-select';
import Switch from 'react-switchery-component';
import 'react-switchery-component/react-switchery-component.css';
import SweetAlert from 'sweetalert-react';
import 'sweetalert/dist/sweetalert.css';
import {addCommas,round} from "../helper/common.js";
import { parse } from 'path';
 class CreateSale extends Component {
    constructor(props){
        super(props);

        this.state={
            searchKey:'',
            chequeDetails:false,
            selectedCustomer:null,
            selectedProductHeads:[],
            customers:[],
            payment_types:[],
            product_heads:[],
            allTaxes:[],
            selectedTaxes:[],
            isChecked:[],
            invoiceId:'',
            result:{
                customer_id:1000,
                customer_balance:0,
                pay_balance:0,
                payment_type_id:1,
                cheque_id:'',
                cheque_bank:'',
                cheque_amount:'',
                cheque_date:'',
                remarks:'',
                date:'',
                time:'',
                currentDateAndTime:true,
                discount:0,
                percentage_discount:0,
                pf:true
            },
            error:[],
            errorVisible:false,
            productsDropdown:true,
            tableFullView:'table-wrapper-scroll-y',
            isFullViewChecked:false,
            show:false,

        };

    this.handleChange=this.handleChange.bind(this);
    this.selectProductHead=this.selectProductHead.bind(this);
    this.handleChangeProductQty=this.handleChangeProductQty.bind(this);
    this.handleChangeProductDelete=this.handleChangeProductDelete.bind(this);
    this.handleChangeProductPrice=this.handleChangeProductPrice.bind(this);
    this.selectCustomer=this.selectCustomer.bind(this);
    this.handleKepUpSearchProduct=this.handleKepUpSearchProduct.bind(this);
    this.handleChangeSearchKey=this.handleChangeSearchKey.bind(this);
    this.handleSubmit=this.handleSubmit.bind(this);
    this.handlePay=this.handlePay.bind(this);
    this.handleDiscount=this.handleDiscount.bind(this);
    this.handlePercentageDiscount=this.handlePercentageDiscount.bind(this);
    this.handleChangePrint=this.handleChangePrint.bind(this);
    this.handleClick = this.handleClick.bind(this);
    this.handleShowDateTime = this.handleShowDateTime.bind(this);
    this.handleChangeTax = this.handleChangeTax.bind(this);
    this.handleChangeFullView = this.handleChangeFullView.bind(this);
    this.handleChangeNetDiscount = this.handleChangeNetDiscount.bind(this);
    this.handleChangeNetDiscountPercentage = this.handleChangeNetDiscountPercentage.bind(this);
    }

     handleSubmit(e){
         e.preventDefault();
         let totalQty=0;
         let totalPrice=0;
         let netTotal = 0;            
         let extTax = 0;
         let addExtTax = 0;
         let addTax = 0;
         let tax = 0;
         let tax_ids = [];
          this.state.selectedProductHeads.length ? this.state.selectedProductHeads.map((sp)=>{
              totalQty+=sp.qty;
             if(this.state.selectedTaxes.length){
                 this.state.selectedTaxes.sort((a,b) =>a.order-b.order).map((tx) => {
                     tax = parseFloat(sp.qty*sp.price/100*tx.value);
                     if(tx.order == 1){
                         extTax = parseFloat(sp.qty*sp.price) + parseFloat(sp.qty*sp.price/100*tx.value)
                         addTax = parseFloat(sp.qty*sp.price/100*tx.value);
                     }    
                     if(tx.order == 2){
                         tax = extTax/100*tx.value;
                         addExtTax = extTax/100*tx.value; 
                     }
                     tax_ids.push(tx.id);
                 })
                 totalPrice += sp.price *sp.qty + parseFloat(addTax) + parseFloat(addExtTax);
             }
             else{
                 totalPrice +=  sp.price *sp.qty - (sp.price *sp.qty/100 * sp.netDiscPr) - sp.netDisc;
              }
              netTotal = (totalPrice - this.state.result.discount) - (totalPrice/100 *this.state.result.percentage_discount);
         }):'';

        let balance = netTotal + this.state.result.customer_balance - this.state.result.pay_balance;
       let  pay_balance = this.state.result.pay_balance;
       if(this.state.result.payment_type_id == 1){

        pay_balance = netTotal
        balance = this.state.result.customer_balance
       }

        let url = location.origin;

         var self=this;
         let data={
             customer:this.state.result.customer_id,
             payment_mode:this.state.result.payment_type_id,
             products:this.state.selectedProductHeads,
             date:this.state.result.date,
             time:this.state.result.time,
             cheque_id:this.state.result.cheque_id,
             cheque_bank:this.state.result.cheque_bank,
             cheque_amount:this.state.result.cheque_amount,
             cheque_date:this.state.result.cheque_date,
             discount:this.state.result.discount,
             pr_disc:this.state.result.percentage_discount,
             pf:this.state.result.pf,
             remarks:this.state.result.remarks,
             tax_ids,
             pay_balance,
             totalQty,
             totalPrice,
             netTotal,
             balance
         };

         axios.post(url+'/sales',data).then((res)=>{
            if (res.data!='no'){
                window.open(url+'/sale/'+res.data+'/show','_blank' ,  'fullscreen=yes')
                location.reload();
            }
            else
            {
                location.reload()
            }
         }).catch((error)=>{

                let errors=error.response.data.errors;
                var errorsList=[];
                if (errors){

                    Object.keys(errors).map(function(key) {

                        var value = errors[key][0];
                        errorsList.push(value)

                        self.setState({
                            ...self.state,
                            errorVisible:true,
                            error:errorsList
                        });
                    });
                }

         })

         }
     componentDidMount() {

         var today = new Date();

         let month=today.getMonth() + 1;

         if (month <= 9  ){
             month='0'+month
         }

         let day=today.getDate();

         if (day <= 9  ){
             day='0'+day
         }

         let date = today.getFullYear()+ '-' + month + '-' + day ;
         let hours= today.getHours();

         if (hours<=9){
             hours='0'+hours;
         }

         let minutes= today.getMinutes();

         if (minutes<=9){
             minutes='0'+minutes;
         }

         let seconds= today.getSeconds();

         if (seconds<=9){
            seconds='0'+seconds;
         }


         let time = hours+':'+minutes+':'+seconds;
         let url =location.origin;
        var self=this;
        axios.get(url+'/sales-get-customers').then(res=>{
            let allTaxes = res.data.all_taxes.map((s)=>{
                return ({
                    label:s.title,
                    id:s.id,
                    value:parseFloat(s.value),
                    order:s.order
                })
            });
            let customers= res.data.customers.map((s)=>{
                return ({
                    label:s.name,
                    value:s.id,
                    balance:parseFloat(s.balance)
                })
            });
         let selectedCustomer= res.data.customers.find(s=> s.id ==1000);
            let product_heads= res.data.product_heads.map((s)=>{
                return  ({
                    label:s.title+"-"+s.brand.title,
                    value:s.id,
                    price:parseFloat(s.stock.price),
                    availableQty:parseFloat(s.stock.total_qty) - parseFloat(s.stock.out_qty)
                })
            });
          self.setState({
              ...self.state,
              customers,
              allTaxes,
              selectedCustomer:{
                  label:selectedCustomer.name,
                  value:selectedCustomer.id,
                  balance:0
              },
              product_heads,
              payment_types:res.data.payment_types,
              result:{
                  ...this.state.result,
                  date,
                  time
              },
          })
        })

         document.addEventListener('mousedown',this.handleClick,false)
     }
     componentWillMount() {
         document.addEventListener('mousedown',this.handleClick,false)
     }

    handleChangeNetDiscount(e){
        let netDisc = parseFloat(e.target.value);
        let  selectedProductHeads; 
        if (netDisc>0){
           selectedProductHeads =  this.state.selectedProductHeads.map(sp=>  sp.id == e.target.id  ?
                {...sp, netDisc}
                : sp
            );
        }
        else{
                selectedProductHeads =  this.state.selectedProductHeads.map(sp=>  sp.id == e.target.id  ?
                    {...sp, netDisc:''}
                    : sp
                );
             }
        this.setState({
            ...this.state,
            selectedProductHeads
        })
     }

    handleChangeNetDiscountPercentage(e){

    let netDiscPr = parseFloat(e.target.value);
    let  selectedProductHeads; 
    if (netDiscPr>0){
       selectedProductHeads =  this.state.selectedProductHeads.map(sp=>  sp.id == e.target.id  ?
            {...sp, netDiscPr}
            : sp
        );
    }
    else
         {
            selectedProductHeads =  this.state.selectedProductHeads.map(sp=>  sp.id == e.target.id  ?
                {...sp, netDiscPr:''}
                : sp
            );
         }
    this.setState({
        ...this.state,
        selectedProductHeads
    })
         
    }

     handleChange(e){

        e.preventDefault();

        this.setState({
            result:{
            ...this.state.result,
                [e.target.id]: e.target.value
            }
        });

         if (e.target.id==='payment_type_id' ){

             if (e.target.value === '3'){

             this.setState({
                 ...this.state,
                 chequeDetails: true,
                 result:{
                     ...this.state.result,
                     [e.target.id]: e.target.value
                 }

             })
             }else {
                 this.setState({
                     ...this.state,
                     chequeDetails: false,
                     result:{
                         ...this.state.result,
                         [e.target.id]: e.target.value
                     }
                 })
             }

         }



    }

     selectCustomer(e){
        let url =location.origin;
        var self =this;
        axios.get(url+'/customer-balance/'+e.value).then((res)=>{
            
            self.setState({
                ...self.state,
                selectedCustomer:e,
                result:{
                    ...self.state.result,
                    customer_id:e.value,
                    customer_balance:res.data
                }
            });

        });

    }
     selectProductHead(e){

        let product = this.state.product_heads.find(ph =>

            ph.value === e.value

        );
        if(product.availableQty > 0){

                let check =   this.state.selectedProductHeads.find(sph =>

                    sph.id === e.value

                );
                    if (check){

                        if(product.availableQty > check.qty){

                            const selectedProductHeads =  this.state.selectedProductHeads.map(sp=>  sp.id == e.value  ?
                                {...sp, qty:sp.qty+1}
                                : sp

                           );
                           this.setState({
                                ...this.state,
                                selectedProductHeads
                           });

                        }
                        else{

                            this.setState({
                                ...this.state,
                                show:true
                            })
                        }


                     }

                     else {

                        let productHead= {

                             id:e.value,
                             title:e.label,
                             price:parseFloat(e.price),
                             qty:1,
                             netDisc:'',
                             netDiscPr:'',


                        };

                        this.setState({
                             ...this.state,
                             selectedProductHeads:[...this.state.selectedProductHeads , productHead]
                        });
                     }

        }

        else{

            this.setState({
                ...this.state,
                show:true
            })
        }

     }
     handleChangeProductQty(e){

         let qty = parseFloat(e.target.value);

         let product = this.state.product_heads.find(ph =>

            ph.value == e.target.id

        );

        if(qty <= product.availableQty){

            let selectedProductHeads;

         if (qty>0){
             selectedProductHeads =  this.state.selectedProductHeads.map(sp=>  sp.id == e.target.id  ?
                 {...sp, qty}
                 : sp
             );
         }else
         {
             selectedProductHeads =  this.state.selectedProductHeads.map(sp=>  sp.id == e.target.id ?
                 {...sp, qty:1}
                 : sp
             );

         }

         this.setState({
             ...this.state,
             selectedProductHeads
         })

        }

        else {

            this.setState({

                ...this.state,
                show:true

            })
        }


     }
     handleChangeProductPrice(e){
         let price = parseFloat(e.target.value) ;
         let selectedProductHeads;
         if (price){
              selectedProductHeads =  this.state.selectedProductHeads.map(sp=>  sp.id == e.target.id ?
                 {...sp, price}
                 : sp
             );
         }else
         {
              selectedProductHeads =  this.state.selectedProductHeads.map(sp=>  sp.id == e.target.id ?
                 {...sp, price:''}
                 : sp
             );

         }


         this.setState({
             ...this.state,
             selectedProductHeads
         })

    }

     handleChangeProductDelete(id){

       const selectedProductHeads=  this.state.selectedProductHeads.filter(ph=> ph.id != id)
       this.setState({
           ...this.state,
           selectedProductHeads
       })
    }
     handlePay(e){
         let pay_balance = parseFloat(e.target.value) ;
         if (pay_balance){
             this.setState({

                 result:{
                     ...this.state.result,
                     pay_balance
                 }
             });
         }else
         {
             this.setState({

                 result:{
                     ...this.state.result,
                     pay_balance:0
                 }
             });

         }


    }

    handleDiscount(e){

        let discount = parseFloat(e.target.value);
        if (discount){
            this.setState({

                result:{
                    ...this.state.result,
                    discount
                }
            });
        }else
        {
            this.setState({

                result:{
                    ...this.state.result,
                    discount:0
                }
            });

        }

    }
    handlePercentageDiscount(e){

        let percentage_discount = parseFloat(e.target.value);
        if (percentage_discount){
            this.setState({

                result:{
                    ...this.state.result,
                    percentage_discount
                }
            });
        }else
        {
            this.setState({

                result:{
                    ...this.state.result,
                    percentage_discount:0
                }
            });

        }

    }
     handleChangeSearchKey(e) {

         this.setState({
             ...this.state,
             searchKey: e.target.value
         });
     }
     handleKepUpSearchProduct(e){

        this.setState({
            ...this.state,
            productsDropdown:false,
            searchKey:e.target.value
        });

         let url =location.origin;
         var self=this;
        if (e.target.value){

         axios.post(url+'/sales-get-products',{key:e.target.value }).then(res=>{

            if (res.data.length){

             let product_heads= res.data.map((s)=>{
                 return ({
                     label:s.title,
                     stock:s.stock,
                     value:s.id
                 })
             });
             self.setState({
                 ...self.state,
                 product_heads,
             })
            }else{
                self.setState({
                    ...self.state,
                    product_heads:[{label:'No Record Found'}],
                })
            }
         })
        }else{
            self.setState({
                ...self.state,
                product_heads:[],
            })
        }


     }

     handleClick(e) {

        if(this.node.contains(e.target)){
            return ;
        }

        this.closeSearchMenu();

     }

     closeSearchMenu(){


         this.setState( {
             ...this.state,
             productsDropdown:true,
             searchKey:'',
         });

     }

     handleShowDateTime(){
         var today = new Date();
         let month=today.getMonth() + 1;
         if (month <= 9  ){
             month='0'+month
         }

         let day=today.getDate();

         if (day <= 9  ){
             day='0'+day
         }

         let date = today.getFullYear()+ '-' + month + '-' + day ;

         let hours= today.getHours();

         if (hours<=9){
             hours='0'+hours;
         }

         let minutes= today.getMinutes();

         if (minutes<=9){
             minutes='0'+minutes;
         }


         let time = hours+':'+minutes;
         this.setState({
             result:{
                 ...this.state.result,
                 currentDateAndTime:!this.state.result.currentDateAndTime,
                 time,
                 date
             }
         })
     }
     handleChangePrint(){

        this.setState({
            result:{
                ...this.state.result,
                pf:!this.state.result.pf
            }
        })
    }
     handleChangeFullView(e){
        this.state.isFullViewChecked?

            this.setState({

                isFullViewChecked:false,
                tableFullView:'table-wrapper-scroll-y'
            })
        :
        this.setState({

            isFullViewChecked:true,
            tableFullView:''
        })

    }
    handleChangeTax(e){
        if(e.target.checked){

            this.state.allTaxes.map((tx) => {
                if(tx.id == e.target.id){
                    let selectedTax = {
                        label:tx.label,
                        id:tx.id,
                        value:parseFloat(tx.value),
                        order:tx.order
                    }

                    this.setState({
                        ...this.state,
                        selectedTaxes:[...this.state.selectedTaxes,selectedTax]
                    })
                }
            });
            
        }
        else{            
            const selectedTaxes=  this.state.selectedTaxes.filter(tx=> tx.id != e.target.id)
            this.setState({
                ...this.state,
                selectedTaxes
            })
        }
    }
     render() {

        let totalQty=0;
        let totalPrice=0;
        let netTotal = 0;            
        let extTax = 0;
        let addExtTax = 0;
        let addTax = 0;
        let tax = 0;
         this.state.selectedProductHeads.length ? this.state.selectedProductHeads.map((sp)=>{
             totalQty+=sp.qty;
            if(this.state.selectedTaxes.length){
                this.state.selectedTaxes.sort((a,b) =>a.order-b.order).map((tx) => {
                    tax = parseFloat(sp.qty*sp.price/100*tx.value);
                    if(tx.order == 1){
                        extTax = parseFloat(sp.qty*sp.price) + parseFloat(sp.qty*sp.price/100*tx.value)
                        addTax = parseFloat(sp.qty*sp.price/100*tx.value);
                    }    
                    if(tx.order == 2){
                        tax = extTax/100*tx.value;
                        addExtTax = extTax/100*tx.value; 
                    }
                })
                totalPrice += sp.price *sp.qty + parseFloat(addTax) + parseFloat(addExtTax);
            }
            else{
                totalPrice +=  sp.price *sp.qty - (sp.price *sp.qty/100 * sp.netDiscPr) - sp.netDisc;
             }
             netTotal = (totalPrice - this.state.result.discount) - (totalPrice/100 *this.state.result.percentage_discount);
        }):'';


        return (
            
            <div className="row">
                <header className="col-md-12">

                </header>
            {/* <SweetAlert
                                show={this.state.show}
                                title="Out of stock"
                                onConfirm={() => this.setState({ show: false })}
                            /> */}

                <div className="col-sm-12">
                                <div className="white-box">
                                    <h2 className="font-bold text-center">Sale Invoice</h2>
                                    <div className="row">
                                        <div className="col-sm-12">
                                            <div className="row">
                                                <div className="col-sm-4">
                                                    <div className="checkbox checkbox-primary checkbox-circle">
                                                        <input onChange={this.handleShowDateTime} checked={this.state.result.currentDateAndTime}  id="checkbox-9" type="checkbox"/>
                                                        <label htmlFor="checkbox-9"  > Current Date </label>
                                                    </div>
                                                </div>

                                                {
                                                    this.state.allTaxes.map((tx)=>{
                                                    return  <div className="col-sm-4">
                                                        <div className="checkbox checkbox-primary checkbox-circle">
                                                            <input key={tx.id} value={tx.value}  onChange={this.handleChangeTax} id={tx.id} type="checkbox"/>
                                                            <label htmlFor={this.id}  >{tx.label}</label>
                                                        </div>
                                                    </div>
                                                    })
                                                    
                                                }
                                                <div className="col-sm-6" hidden={this.state.result.currentDateAndTime}>
                                                    <div className="form-group">
                                                        <label id="date" className=" font-bold text-primary">Date:</label>
                                                        <input type="date" onChange={this.handleChange} value={this.state.result.date} name="date" id="date" className="form-control"/>
                                                    </div>
                                                </div>
                                                <div className="col-sm-6" hidden={this.state.result.currentDateAndTime}>
                                                    <div className="form-group">
                                                        <label id="time" className=" font-bold text-primary">Time:</label>
                                                        <input type="time" onChange={this.handleChange} value={this.state.result.time} name="time" id="time" className="form-control"/>
                                                    </div>
                                                </div>
                                            </div>
                                        <div className="row">
                                            <div className="col-sm-8">


                                            <div className="form-group">
                                                <label id="supplier_id" className=" font-bold">Select Customer:</label>
                                              {
                                                        this.state.customers.length ?


                                                            <Select
                                                                value={this.state.selectedCustomer}
                                                                onChange={this.selectCustomer}
                                                                options={this.state.customers}
                                                                tabIndex="1"
                                                            />


                                                            :
                                                            <Select
                                                                value={''}
                                                                onChange={''}
                                                                options={[]}
                                                            />

                                                    }


                                            </div>
                                             {
                                                        this.state.result.customer_balance > 0 ?
                                                <b class="text-danger ">CR: {addCommas(this.state.result.customer_balance)}</b>
                                                    :''}
                                             {
                                                        this.state.result.customer_balance < 0 ?
                                                <b class="text-success ">DR: {addCommas(this.state.result.customer_balance)}</b>
                                                    :''}
                                            </div>
                                            <div className="col-sm-4">

                                                <div className="form-group">
                                                    <label htmlFor="payment_type_id" className="font-bold">Payment Mode</label>
                                                    <select onChange={this.handleChange} className="form-control" name="payment_type_id" id="payment_type_id" tabIndex="2">
                                                        <option value="">Select Payment Mode </option>
                                                        { this.state.payment_types.length

                                                            ?   this.state.payment_types.map((pt)=>{
                                                              return  <option selected={pt.id==1 ? true: false}  value={pt.id}>{pt.title}</option>
                                                            })
                                                            :
                                                            <option value="">No record Found</option>

                                                        }

                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                        <div className="row" hidden={!this.state.chequeDetails}>

                                                <div className="col-sm-6">
                                                    <div  className="form-group">
                                                        <label id="cheque_bank" className=" font-bold text-primary">Bank Detail:</label>
                                                        <input type="text" value={this.state.result.cheque_bank} className="form-control" onChange={this.handleChange} name="cheque_bank" id="cheque_bank"/>
                                                    </div>
                                                </div>

                                                <div className="col-sm-6">
                                                    <div  className="form-group">
                                                        <label id="cheque_id" className=" font-bold text-primary">Cheque ID:</label>
                                                        <input type="text" value={this.state.result.cheque_id} onChange={this.handleChange} className="form-control" name="cheque_id" id="cheque_id"/>
                                                    </div>
                                                </div>

                                                <div className="col-sm-6">
                                                    <div  className="form-group">
                                                        <label id="cheque_amount" className=" font-bold text-primary">Cheque Amount:</label>
                                                        <input type="number" value={this.state.result.cheque_amount} onChange={this.handleChange} className="form-control" name="cheque_amount" id="cheque_amount"/>
                                                    </div>
                                                </div>
                                                <div className="col-sm-6">
                                                    <div  className="form-group">
                                                        <label id="cheque_date" className=" font-bold text-primary">Cheque Date:</label>
                                                        <input type="date" value={this.state.result.cheque_date} onChange={this.handleChange} className="form-control" name="cheque_date" id="cheque_date"/>
                                                    </div>
                                                </div>
                                            </div>
                                        <div className="row">
                                            <div className="col-sm-11">

                                            <div className="form-group">
                                                <label id="supplier_id" className=" font-bold">Select Product:</label>
                                                <Select
                                                    value={''}
                                                    onChange={this.selectProductHead}
                                                    options={this.state.product_heads}
                                                    tabIndex="3"
                                                />
                                            </div>



                                            </div>
                                        </div>
                                        <div className="row">
                                            <div className="col-sm-11">

                                            <div className="form-group">
                                                <label className=" font-bold">Remarks:</label>
                                                <input className="form-control" maxlength="500" type="text" onKeyUp={this.handleChange} id="remarks" placeholder="Remarks"/>
                                            </div>



                                            </div>
                                        </div>

                {/* <p>
                    <label htmlFor="size-example">Full View</label>
                    <Switch id="size-example"
                            size="small"
                            checked={this.state.isFullViewChecked}
                            onChange={(e) => this.handleChangeFullView(e)} />
                </p> */}

                                        </div>

                                        

                                    </div>
                                    <hr/>
                                         <div className="row">

                                            <div className="col-sm-12">

                                                <div className="table-responsive ">

                                                    <table className="table table-hover">
                                                        <thead>
                                                            {
                                                                 this.state.selectedTaxes.length == 0?
                                                                 <tr>
                                                            <th>#</th>
                                                            <th>Products</th>
                                                            <th>Unit Price</th>
                                                            <th>Quantity</th>
                                                            <th>Disc %</th>
                                                            <th>Amount</th>
                                                            <th>Disc</th>
                                                            <th>Total Price</th>
                                                            <th>Actions</th>
                                                        </tr>:
                                                        <tr>
                                                        <th>#</th>
                                                        <th>Products</th>
                                                        <th>Unit Price</th>
                                                        <th>Quantity</th>
                                                        {
                                                        this.state.selectedTaxes.length > 0? this.state.selectedTaxes.sort((a, b) =>a.order-b.order).map((tx) => {

                                                        return <th>{tx.label+'('+tx.value+'%)'}</th>
                                                        }):''
                                                        
                                                        }
                                                        <th>Total Price</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                            }
                                                        
                                                        </thead>
                                                        <tfoot>
                                                        {
                                                                this.state.selectedTaxes.length == 0?
                                                                <tr>
                                                            
                                                            <th></th>
                                                            <th></th>
                                                            <th>Unit Price</th>
                                                            <th>Total: {totalQty}</th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th>Total: {(totalPrice).toFixed(2)}</th>
                                                            <th></th>
                                                        </tr>:
                                                        <tr>
                                                            
                                                        <th></th>
                                                        <th></th>
                                                        <th>Unit Price</th>
                                                        <th>Total: {totalQty}</th>
                                                        {
                                                        this.state.selectedTaxes.length > 0? this.state.selectedTaxes.map((tx) => {

                                                        return <th></th>
                                                        }):''
                                                        
                                                        }
                                                        <th>Total: {(totalPrice).toFixed(2)}</th>
                                                        <th></th>
                                                    </tr>
                                                            }
                                                        
                                                        </tfoot>
                                                        <tbody>

                                                        {
                                                            
                                                            this.state.selectedTaxes.length > 0?
                                                            
                                                            this.state.selectedProductHeads.length > 0 ?
                                                                this.state.selectedProductHeads.map( (ph,index)=>{
                                                                   return  <tr key={ph.id}>
                                                                        <td>{index+1}</td>
                                                                        <th>{ph.title}</th>
                                                                        <td><input type="number" value={ph.price} id={ph.id} onChange={this.handleChangeProductPrice} /></td>
                                                                        <td><input type="number" value={ph.qty} id={ph.id} onChange={this.handleChangeProductQty} /></td>
                                                                        {
                                                                        this.state.selectedTaxes.length > 0? this.state.selectedTaxes.sort((a, b) =>a.order-b.order).map((tx) => {
                                                                            tax = parseFloat(ph.qty*ph.price/100*tx.value);
                                                                            if(tx.order == 1){
                                                                                extTax = parseFloat(ph.qty*ph.price) + parseFloat(ph.qty*ph.price/100*tx.value)
                                                                                addTax = parseFloat(ph.qty*ph.price/100*tx.value);
                                                                            }    
                                                                            if(tx.order == 2){
                                                                                tax = extTax/100*tx.value
                                                                                addExtTax = extTax/100*tx.value 
                                                                            }
                                                                                                                                                    
                                                                        return <th>{(tax).toFixed(2)}</th>
                                                                        }):''
                                                                        
                                                                        }
                                                                        
                                                                        <th>{(ph.qty*ph.price + parseFloat(addTax) + parseFloat(addExtTax)).toFixed(2)}</th>
                                                                        <td>
                                                                            <button className="btn btn-danger "
                                                                                    onClick={()=>this.handleChangeProductDelete(ph.id)}
                                                                                    ><span
                                                                                className="glyphicon glyphicon-remove"></span>
                                                                            </button>

                                                                        </td>
                                                                    </tr>
                                                                } ):
                                                                <tr>
                                                                    <td>No Product Selected</td>

                                                                </tr>
                                                                :
                                                                this.state.selectedProductHeads.length > 0 ?
                                                                this.state.selectedProductHeads.map( (ph,index)=>{
                                                                    
                                                                   return  <tr key={ph.id}>
                                                                        <td>{index+1}</td>
                                                                        <th>{ph.title}</th>
                                                                        <td><input type="number" value={ph.price} id={ph.id} onChange={this.handleChangeProductPrice} /></td>
                                                                        <td><input type="number" value={ph.qty} id={ph.id} onChange={this.handleChangeProductQty} /></td>
                                                                        <td><input type="number" value={ph.netDiscPr} id={ph.id} onChange={this.handleChangeNetDiscountPercentage} /></td>
                                                                        <th>{(ph.qty*ph.price/100*ph.netDiscPr).toFixed(2)}</th>
                                                                        <td><input type="number" value={ph.netDisc} id={ph.id} onChange={this.handleChangeNetDiscount} /></td>
                                                                        <th>{(ph.qty*ph.price - ph.qty*ph.price/100*ph.netDiscPr - ph.netDisc).toFixed(2)}</th>
                                                                        <td>
                                                                            <button className="btn btn-danger "
                                                                                    onClick={()=>this.handleChangeProductDelete(ph.id)}
                                                                                    ><span
                                                                                className="glyphicon glyphicon-remove"></span>
                                                                            </button>

                                                                        </td>
                                                                    </tr>
                                                                } ):
                                                                <tr>
                                                                    <td>No Product Selected</td>

                                                                </tr>

                                                        }


                                                        </tbody>

                                                    </table>
                                                </div>

                                            </div>
                                            <div className="col-sm-3 pull-right">

                                            <h3 className="font-bold text-primary">TOTAL AMOUNT: {addCommas((totalPrice).toFixed(2))}</h3>
                                            <h4 className="font-bold text-warning">Total Quantity: {addCommas(totalQty)}</h4>
                                            {
                                                this.state.result.discount > 0 ?
                                            <h4 className="font-bold text-success">Discount: {this.state.result.discount} </h4>
                                            :''
                                            }
                                            {
                                                this.state.result.percentage_discount > 0 ?
                                            <h4 className="font-bold text-default">Discount %: {this.state.result.percentage_discount} </h4>
                                            :''
                                            }
                                            <h4 className="font-bold text-danger">Net Total: {addCommas((netTotal).toFixed(2))}</h4>
                                            <div className="form-group" hidden={this.state.result.payment_type_id == 2 ? false: true }>
                                                <input type="number"  className="form-control" placeholder="Pay" onChange={this.handlePay} />
                                            </div>
                                            <div className="form-group">
                                                <input type="number" disabled={this.state.selectedProductHeads.length? false : true}  className="form-control" placeholder="Discount" onChange={this.handleDiscount} />
                                            </div>
                                            <div className="form-group">
                                                <input type="number" disabled={this.state.selectedProductHeads.length? false : true}  className="form-control" placeholder="Discount %" onChange={this.handlePercentageDiscount} />
                                            </div>
                                           <div>
                                               <h4 hidden={this.state.result.payment_type_id == 1 ? true: false} className="font-bold">Current Balance: {addCommas((netTotal-this.state.result.pay_balance).toFixed(2))}</h4>
                                               <h4 className="font-bold text-danger">Remaining Balance: {addCommas(this.state.result.customer_balance)}</h4>
                                               <h4 hidden={this.state.result.payment_type_id == 1 ? true: false} className="font-bold text-success">Total Balance: {addCommas(round(netTotal + this.state.result.customer_balance-this.state.result.pay_balance))}</h4>
                                           </div>

                                             <div >
                                                 {
                                                     this.state.error.length ?
                                                         this.state.error.map(e=> <h5 className="text-danger font-bold">* {e}</h5>)
                                                         :''
                                                 }
                                             </div>
                                             <div className="checkbox checkbox-primary checkbox-circle">
                                                <input onChange={this.handleChangePrint} checked={this.state.result.pf} name="pf"  id="pf" type="checkbox"/>
                                                <label htmlFor="pf"  > Print </label>
                                            </div>
                                            <button onClick={ this.handleSubmit} disabled={this.state.selectedProductHeads.length? false : true} className="btn btn-success btn-lg">Confirm Order</button>

                                        </div>
                                        </div>

                                </div>
                </div>
            </div>
        );
    }
}

export default CreateSale;
