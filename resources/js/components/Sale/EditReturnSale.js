import React, { Component } from 'react';
import axios from 'axios';
import Select from 'react-select';
import SweetAlert from 'sweetalert-react';
import 'react-switchery-component/react-switchery-component.css';
import 'sweetalert/dist/sweetalert.css';
import {addCommas,round} from "../helper/common.js";
import Switch from 'react-switchery-component';
 class EditReturnSale extends Component {
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
            result:{
                sale_id:null,
                customer_id:null,
                customer_balance:0,
                pay_balance:'',
                payment_type_id:1,
                cheque_id:null,
                cheque_bank:null,
                cheque_amount:null,
                cheque_date:null,
                sale:[],
                old_discount:0,
                pf:true,
                date:'',
                remarks:'',
                time:'',
                discount:0,
                balance_difference:'',
                old_total_price:''
            },
            error:[],
            errorVisible:false,
            productsDropdown:true,
            tableFullView:'table-wrapper-scroll-y',
            isFullViewChecked:false,
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
    this.handleClick = this.handleClick.bind(this);
    this.handleChangeFullView = this.handleChangeFullView.bind(this);
    this.handleChangePrint=this.handleChangePrint.bind(this);
    this.handleShowDateTime = this.handleShowDateTime.bind(this);
    this.handleDiscount=this.handleDiscount.bind(this);
    }

    handleChangePrint(){

        this.setState({
            result:{
                ...this.state.result,
                pf:!this.state.result.pf
            }
        })
    }
     handleSubmit(e){
         e.preventDefault();
         let totalPrice=0;
         let totalQty=0;
         this.state.selectedProductHeads.map((sp)=>{

             totalQty += sp.qty;
             totalPrice += sp.price *sp.qty;

         });
         totalPrice -= this.state.result.discount;
        let currentBalance = totalPrice-this.state.result.pay_balance - this.state.result.old_total_price -this.state.result.old_discount;
        
        let balance = 9;

         if (this.state.result.sale.customer_id === this.state.result.customer_id){

             balance= this.state.result.customer_balance + (this.state.result.sale.total_price - this.state.result.sale.pay - currentBalance)

         }
         else {
             balance=   this.state.result.customer_balance - totalPrice

         }


         // totalPrice + this.state.result.customer_balance - this.state.result.pay_balance ;

         let url = location.origin;
         let id=this.state.result.sale.id;

         var self=this;
         let data={
             customer:this.state.result.customer_id,
             payment_mode:this.state.result.payment_type_id,
             pay_balance:this.state.result.pay_balance,
             products:this.state.selectedProductHeads,
             pf:this.state.result.pf,
             date:this.state.result.date,
             time:this.state.result.time,
             remarks:this.state.result.remarks,
             balance_difference: parseFloat(totalPrice) - parseFloat(this.state.result.old_total_price),
             totalQty,
             discount:this.state.result.discount,
             totalPrice,
             balance,

         };

         axios.put(url+'/sales-return/'+id,data).then((res)=>{


             if (res.data!='no'){
               window.open(url+'/sale/'+res.data+'/show','_blank' ,  'fullscreen=yes')

               location.href=url+'/sales-return-list'
            }
            else
            {
               location.href=url+'/sales-return-list'
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
        //  window.addEventListener("beforeunload", (ev) =>
        //  {
        //      ev.preventDefault();
        //      return ev.returnValue = 'Are you sure you want to close?';
        //  });
        let url =location.origin;
        let id=location.pathname.slice(14,-5);

          var self=this;

        axios.get(url+'/sales-get-customers/'+id+'/edit').then(res=>{

            let sale = res.data.sale;
            let old_discount = sale.discount; 
            let customers= res.data.customers.map((s)=>{
                return ({
                    label:s.name,
                    value:s.id,
                    balance:parseFloat(s.balance)
                })
            });
            let product_heads= res.data.product_heads.map((s)=>{
                return  ({
                    label:s.title,
                    value:s.id,
                    price:parseFloat(s.sale)
                })
            });
            let selectedProductHeads= sale.sale_details.map((ph)=>{
                return ({
                    id:ph.product_head_id,
                    title:ph.product_head.title,
                    price:parseFloat(ph.product_head.stock.price),
                    stock:parseFloat(ph.product_head.stock.total_qty-ph.product_head.stock.out_qty),
                    qty:ph.total_qty
                })
            });
          self.setState({
              ...self.state,
              customers,
              payment_types:res.data.payment_types,
              selectedCustomer:{
                  label:sale.customer.name,
                  value:sale.customer.id,
                  balance:parseFloat(res.data.cBalance)
                },
                result:{
                  ...self.state.result,
                  sale_id:sale.id,
                  customer_id:sale.customer.id,
                  customer_balance:parseFloat(res.data.cBalance),
                  payment_type_id:sale.payment_type.id,
                  pay_balance:parseFloat(sale.pay),
                  sale,
                  discount:parseFloat(sale.discount),
                  date:sale.date,
                  time:sale.time,
                  old_total_price:sale.total_price,
                  remarks:sale.remarks,
                  old_discount

              },
              selectedProductHeads,
              product_heads,
          })
        });

         document.addEventListener('mousedown',this.handleClick,false)
     }
     componentWillMount() {
         document.addEventListener('mousedown',this.handleClick,false)
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



         let check =   this.state.selectedProductHeads.find(sph =>
             sph.id === e.value
         );

         if (check){
             const selectedProductHeads =  this.state.selectedProductHeads.map(sp=>  sp.id == e.value  ?
                 {...sp, qty:sp.qty+1}
                 : sp

             );
             this.setState({
                 ...this.state,
                 selectedProductHeads
             });
         }else{
             let productHead= {
                 id:e.value,
                 title:e.label,
                 price:parseFloat(e.price),
                 qty:1
             };

             this.setState({
                 ...this.state,
                 selectedProductHeads:[...this.state.selectedProductHeads , productHead]
             });
         }

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
                time,
                date
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
     handleChangeProductQty(e){
        let qty = parseFloat(e.target.value) ;
        let selectedProductHeads;
        if (qty>0){
            selectedProductHeads =  this.state.selectedProductHeads.map(sp=>  sp.id == e.target.id ?
                {...sp, qty}
                : sp
            );
        }else
        {
            selectedProductHeads =  this.state.selectedProductHeads.map(sp=>  sp.id == e.target.id ?
                {...sp, qty:''}
                : sp
            );

        }

        this.setState({
            ...this.state,
            selectedProductHeads
        })
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
        console.log(selectedProductHeads);
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
                     pay_balance:''
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




     render() {

        let totalQty=0;
        let totalPrice=0;
         this.state.selectedProductHeads.length ? this.state.selectedProductHeads.map((sp)=>{
             totalQty+=sp.qty;
             totalPrice += sp.price *sp.qty;
            })
             :'';
        let currentBalance = totalPrice -this.state.result.pay_balance - this.state.result.discount;

        return (
            <div className="row">
            <SweetAlert
                                show={this.state.show}
                                title="Out of stock"
                                onConfirm={() => this.setState({ show: false })}
                            />
                <div className="col-sm-12">
                                <div className="white-box">
                                    <h2 className="font-bold text-center">Update Return Sale Invoice # { this.state.result.sale && this.state.result.sale.id  }</h2>
                                    <div className="row">
                                        <div className="col-sm-9">
                                        <div className="row">
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
                                                            />


                                                            :
                                                            <Select
                                                                value={''}
                                                                onChange={''}
                                                                options={[]}
                                                            />

                                                    }


                                            </div>

                                                    <div hidden={!this.state.chequeDetails} className="form-group">

                                                        <label id="cheque_bank" className=" font-bold">Bank Detail:</label>

                                                        <input type="text" className="form-control" name="cheque_bank" id="cheque_bank"/>

                                                    </div>


                                            </div>
                                            <div className="col-sm-4">

                                                <div hidden className="form-group">
                                                    <label htmlFor="payment_type_id" className="font-bold">Payment Mode</label>
                                                    <select onChange={this.handleChange} className="form-control" name="payment_type_id" id="payment_type_id">
                                                        <option value="">Select Payment Mode </option>
                                                        { this.state.payment_types.length

                                                            ?   this.state.payment_types.map((pt)=>{
                                                              return  <option selected={pt.id==this.state.result.payment_type_id ? true : false } value={pt.id}>{pt.title}</option>
                                                            })
                                                            :
                                                            <option value="">No record Found</option>

                                                        }

                                                    </select>
                                                </div>

                                                <div hidden={!this.state.chequeDetails} className="form-group">

                                                    <label id="cheque_id" className=" font-bold">Cheque ID:</label>

                                                    <input type="text"  className="form-control" name="cheque_id" id="cheque_id"/>

                                                </div>

                                            </div>
                                        </div>
                                            <div className="row">
                                                <div className="col-sm-12">
                                                    <label id="product" className=" font-bold">Select Product:</label>
                                                    <Select
                                                        value={''}
                                                        onChange={this.selectProductHead}
                                                        options={this.state.product_heads}
                                                    />
                                                </div>
                                            </div>
                                            <br/>
                                            <div className="row">
                                            <div className="col-sm-11">

                                            <div className="form-group">
                                                <label className=" font-bold">Remarks:</label>
                                                <input className="form-control" maxlength="500" value={this.state.result.remarks} type="text" onChange={this.handleChange} id="remarks" placeholder="Remarks"/>
                                            </div>



                                            </div>
                                        </div>
                                            <br/>
                                            <p>
                    <label htmlFor="size-example">Full View</label>
                    <Switch id="size-example"
                            size="small"
                            checked={this.state.isFullViewChecked}
                            onChange={(e) => this.handleChangeFullView(e)} />
                </p>
                                            <hr/>
                                         <div className="row">
                                            <div className="col-sm-12">

                                            <div className={"table-responsive " + this.state.tableFullView}>


                                                    <table className="table table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Products</th>
                                                            <th>Unit Price</th>
                                                            <th>Quantity</th>
                                                            <th>Total Price</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                        </thead>
                                                        <tfoot>
                                                        <tr>
                                                            <th></th>
                                                            <th></th>
                                                            <th>Unit Price</th>
                                                            <th>Total: {totalQty}</th>
                                                            <th>Total: {totalPrice}</th>
                                                            <th></th>
                                                        </tr>
                                                        </tfoot>
                                                        <tbody>

                                                        {
                                                            this.state.selectedProductHeads.length ?
                                                                this.state.selectedProductHeads.map( (ph,index)=>{
                                                                   return  <tr key={ph.id}>
                                                                        <td>{index+1}</td>
                                                                        <th>{ph.title}</th>
                                                                        <td><input type="number" value={ph.price} id={ph.id} onChange={this.handleChangeProductPrice} /></td>
                                                                        <td><input type="number" value={ph.qty} id={ph.id} onChange={this.handleChangeProductQty} /></td>
                                                                       <th>{ph.qty*ph.price}</th>
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
                                        </div>

                                        </div>

                                        <div className="col-sm-3">

                                            <h2 className="font-bold">Total Amount: {totalPrice}</h2>
                                            <h3 className="font-bold">Total Quantity: {totalQty}</h3>

                                            <br/>
                                            <br/>
                                            <hr/>
                                            <h4 className="font-bold">Total Amount: {totalPrice}</h4>
                                            <div className="form-group">
                                                <input type="number" disabled={this.state.selectedProductHeads.length? false : true}  className="form-control" placeholder="Discount"  value={this.state.result.discount} onChange={this.handleDiscount} />
                                            </div>
                                            <hr/>
                                            <h4 className="font-bold">Current Balance: { addCommas(totalPrice - this.state.result.discount) }</h4>
                                            <h4 className="font-bold ">Remaining Balance:{ 
                                            this.state.result.discount == this.state.result.old_discount ?
                                             addCommas(this.state.result.customer_balance)
                                            : addCommas((this.state.result.customer_balance - this.state.result.old_discount) + this.state.result.discount  ) }</h4>
                                            {/* <h4 className="font-bold ">Total Balance: {  this.state.result.sale &&  this.state.result.sale.customer_id === this.state.result.customer_id
                                                ? addCommas( this.state.result.customer_balance +(this.state.result.sale.total_price - this.state.result.sale.pay - currentBalance))

                                                : addCommas(this.state.result.customer_balance -totalPrice ) }</h4> */}

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

export default EditReturnSale;
