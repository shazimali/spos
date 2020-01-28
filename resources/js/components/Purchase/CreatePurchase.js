import React, { Component } from 'react';
import axios from 'axios';
import Select from 'react-select';
import Switch from 'react-switchery-component';
import {addCommas} from "../helper/common.js";

 class CreatePurchase extends Component {
    constructor(props){
        super(props);

        this.state={
            chequeDetails:false,
            selectedSupplier:null,
            selectedProductHeads:[],
            suppliers:[],
            payment_types:[],
            product_heads:[],
            result:{
                supplier_id:null,
                supplier_balance:0,
                pay_balance:0,
                payment_type_id:null,
                cheque_id:null,
                cheque_bank:null,
                cheque_amount:null,
                cheque_date:null,
                remarks:'',
                date:'',
                time:'',
                currentDateAndTime:true,
                pf:true
            },
            error:[],
            errorVisible:false,
            tableFullView:'table-wrapper-scroll-y',
            isFullViewChecked:false,
        };

    this.handleChange=this.handleChange.bind(this);
    this.handleChangePrint=this.handleChangePrint.bind(this);
    this.selectProductHead=this.selectProductHead.bind(this);
    this.searchProductHead=this.searchProductHead.bind(this);
    this.handleChangeProductQty=this.handleChangeProductQty.bind(this);
    this.handleChangeProductDelete=this.handleChangeProductDelete.bind(this);
    this.handleChangeProductPrice=this.handleChangeProductPrice.bind(this);
    this.handleChangeProductRetail=this.handleChangeProductRetail.bind(this);
    this.selectSupplier=this.selectSupplier.bind(this);
    this.handleSubmit=this.handleSubmit.bind(this);
    this.handlePay=this.handlePay.bind(this);
    this.handleShowDateTime=this.handleShowDateTime.bind(this);
    this.handleChangeFullView = this.handleChangeFullView.bind(this);

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
     handleSubmit(e){

         e.preventDefault();

         let totalPrice=0;
         let totalQty=0;
         this.state.selectedProductHeads.map((sp)=>{

             totalQty += sp.qty;
             totalPrice += sp.price *sp.qty;

         });

        let balance = totalPrice + this.state.result.supplier_balance - this.state.result.pay_balance ;

        let url = location.origin;

         var self=this;
         let data={
             supplier:this.state.result.supplier_id,
             payment_mode:this.state.result.payment_type_id,
             pay_balance:this.state.result.pay_balance,
             products:this.state.selectedProductHeads,
             date:this.state.result.date,
             time:this.state.result.time,
             cheque_id:this.state.result.cheque_id,
             cheque_bank:this.state.result.cheque_bank,
             cheque_amount:this.state.result.cheque_amount,
             cheque_date:this.state.result.cheque_date,
             pf:this.state.result.pf,
             remarks:this.state.result.remarks,
             totalQty,
             totalPrice,
             balance
         };

         axios.post(url+'/purchase',data).then((res)=>{
             if (res.data!='no'){

                 window.open(url+'/purchase/'+res.data+'/show','_blank' ,  'fullscreen=yes')
                 location.reload();
             }else
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
         // window.addEventListener("beforeunload", (ev) =>
         // {
         //     ev.preventDefault();
         //     return ev.returnValue = 'Are you sure you want to close?';
         // },false);
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
        axios.get(url+'/purchase-get-suppliers').then(res=>{

            let suppliers= res.data.suppliers.map((s)=>{
                return ({
                    label:s.name,
                    value:s.id,
                    balance:parseFloat(s.balance)
                })
            });
            let product_heads= res.data.product_heads.map((s)=>{
                return ({
                    label:s.title+"-"+s.brand.title,
                    value:s.id,
                    'price':s.purchase,
                    'retail':s.sale
                })
            });
          self.setState({
              ...self.state,
              suppliers,
               product_heads,
              payment_types:res.data.payment_types,
              result:{
                ...this.state.result,
                date,
                time
            },
          })
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
     selectSupplier(e){

        let url =location.origin;
        var self =this;

        axios.get(url+'/supplier-balance/'+e.value).then((res)=>{

            self.setState({
                ...self.state,
                selectedSupplier:e,
                result:{
                    ...self.state.result,
                    supplier_id:e.value,
                    supplier_balance:res.data
                }
            });

        });


    }
     selectProductHead(e){

              let check =   this.state.selectedProductHeads.find(sph =>
                            sph.id === e.value
                );

            if (check){
            const selectedProductHeads =  this.state.selectedProductHeads.map(sp=>  sp.id == e.value ?
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
                    price:e.price,
                    retail:e.retail,
                    qty:1
                };
                this.setState({

                    selectedProductHeads:[...this.state.selectedProductHeads , productHead]

                });
            }
    }
     searchProductHead(e){
        console.log(e.target.value);
        // this.setState({
        //
        //     selectedProductHeads:[...this.state.selectedProductHeads , e.target.value]
        // });
    }
     handleChangeProductQty(e){
        let qty = parseFloat(e.target.value) ;
        let selectedProductHeads;
        if (qty){
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
     handleChangeProductRetail(e){
        let retail = parseFloat(e.target.value) ;
        let selectedProductHeads;
        if (retail){
            selectedProductHeads =  this.state.selectedProductHeads.map(sp=>  sp.id == e.target.id ?
                {...sp, retail}
                : sp
            );
        }else
        {
            selectedProductHeads =  this.state.selectedProductHeads.map(sp=>  sp.id == e.target.id ?
                {...sp, retail:''}
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
     handleShowDateTime(){
         var today = new Date();
         let month=today.getMonth() + 1;
         if (month <= 9  ){
             month='0'+month
         }
         let date = today.getFullYear()+ '-' + month + '-' + today.getDate() ;
         let time = today.getHours()+':'+today.getMinutes() ;
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

     render() {
        let totalQty=0;
        let totalPrice=0;
         this.state.selectedProductHeads.length ? this.state.selectedProductHeads.map((sp)=>{

             totalQty+=sp.qty;
             totalPrice += sp.price *sp.qty;

            })


             :'';



        return (
            <div className="row">
                <div className="col-sm-12">
                                <div className="white-box">
                                    <h2 className="font-bold text-center">Purchase Invoice</h2>
                                    <div className="row">
                                        <div className="col-sm-9">
                                            <div className="row">
                                                <div className="col-sm-12">
                                                    <div className="checkbox checkbox-primary checkbox-circle">
                                                        <input onChange={this.handleShowDateTime} checked={this.state.result.currentDateAndTime}  id="checkbox-9" type="checkbox"/>
                                                        <label htmlFor="checkbox-9"  > Current Date </label>
                                                    </div>
                                                </div>
                                                <div className="col-sm-6" hidden={this.state.result.currentDateAndTime}>
                                                    <div className="form-group">
                                                        <label id="date" className=" font-bold text-primary">Date:</label>
                                                        <input type="date" onChange={this.handleChange} value={this.state.result.date} name="date" id="date" className="form-control"/>
                                                    </div>
                                                </div>

                                                <div className="col-sm-6" hidden>
                                                    <div className="form-group">
                                                        <label id="time" className=" font-bold text-primary">Time:</label>
                                                        <input type="time" onChange={this.handleChange} value={this.state.result.time} name="time" id="time" className="form-control"/>
                                                    </div>
                                                </div>
                                            </div>
                                        <div className="row">
                                            <div className="col-sm-8">



                                                <div className="form-group">

                                                    <label id="supplier_id" className=" font-bold">Select Supplier:</label>

                                                    {
                                                        this.state.suppliers.length ?


                                                            <Select
                                                                value={this.state.selectedSupplier}
                                                                onChange={this.selectSupplier}
                                                                options={this.state.suppliers}
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
                                                        this.state.result.supplier_balance > 0 ?
                                                    
                                                <b class="text-danger ">CR: {addCommas(this.state.result.supplier_balance)}</b>
                                                    :''}
                                            </div>
                                            <div className="col-sm-4">

                                                <div className="form-group">
                                                    <label htmlFor="payment_type_id" className="font-bold">Payment Mode</label>
                                                    <select onChange={this.handleChange} className="form-control" name="payment_type_id" id="payment_type_id">
                                                        <option value="">Select Payment Mode </option>
                                                        { this.state.payment_types.length

                                                            ?   this.state.payment_types.map((pt)=>{
                                                              return  <option value={pt.id}>{pt.title}</option>
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
                                            <div className="col-sm-12">

                                            <div className="form-group">
                                                <label id="supplier_id" className=" font-bold">Select Product:</label>
                                                <Select
                                                    value={''}
                                                    onChange={this.selectProductHead}
                                                    options={this.state.product_heads}
                                                />
                                            </div>



                                            </div>
                                        </div>
                                        <div className="row">
                                            <div className="col-sm-11">

                                            <div className="form-group">
                                                <label className=" font-bold">Remarks:</label>
                                                <input className="form-control" maxlength="500" type="text" onChange={this.handleChange} id="remarks" placeholder="Remarks"/>
                                            </div>



                                            </div>
                                        </div>
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

                                            <div className="table-responsive">
                                                    <table className="table table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Products</th>
                                                            <th>Unit Price</th>
                                                            <th>Retail Price</th>
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
                                                            <th>Retail Price</th>
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
                                                                        <td><input type="number" value={ph.price} id={ph.id}  onChange={this.handleChangeProductPrice}/></td>
                                                                        <td><input type="number" value={ph.retail} id={ph.id}  onChange={this.handleChangeProductRetail}/></td>
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

                                            <h2 className="font-bold">Total Amount: {addCommas(totalPrice)}</h2>
                                            <h3 className="font-bold">Total Quantity: {addCommas(totalQty)}</h3>

                                            <br/>
                                            <br/>
                                            <hr/>
                                            <h4 className="font-bold">Total Amount: {addCommas(totalPrice)}</h4>
                                            <hr/>
                                            <div className="form-group" hidden={this.state.result.payment_type_id == 1 ? false: true }>
                                                <input type="number"  className="form-control" placeholder="Pay" onChange={this.handlePay} />
                                            </div>
                                            <h4 className="font-bold">Current Balance: {addCommas(totalPrice-this.state.result.pay_balance)}</h4>
                                            {/* <h4 className="font-bold ">Remaining Balance: {addCommas(this.state.result.supplier_balance)}</h4> */}
                                            <h4 className="font-bold ">Total Balance: {addCommas(totalPrice + this.state.result.supplier_balance-this.state.result.pay_balance)}</h4>

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

export default CreatePurchase;
