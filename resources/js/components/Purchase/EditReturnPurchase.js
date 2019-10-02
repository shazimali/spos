import React, { Component } from 'react';
import axios from 'axios';
import Select from 'react-select';
import Switch from 'react-switchery-component';
class EditReturnPurchase extends Component {
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
                purchase_id:null,
                supplier_id:null,
                supplier_balance:0,
                pay_balance:'',
                payment_type_id:1,
                cheque_id:null,
                cheque_bank:null,
                cheque_amount:null,
                remarks:null,
                cheque_date:null,
                purchase:[],
                pf:true
            },
            error:[],
            errorVisible:false,
            tableFullView:'table-wrapper-scroll-y',
            isFullViewChecked:false,
        };

        this.handleChange=this.handleChange.bind(this);
        this.selectProductHead=this.selectProductHead.bind(this);
        this.handleChangeProductQty=this.handleChangeProductQty.bind(this);
        this.handleChangeProductDelete=this.handleChangeProductDelete.bind(this);
        this.handleChangeProductPrice=this.handleChangeProductPrice.bind(this);
        this.handleChangeProductRetail=this.handleChangeProductRetail.bind(this);
        this.selectSupplier=this.selectSupplier.bind(this);
        this.handleSubmit=this.handleSubmit.bind(this);
        this.handlePay=this.handlePay.bind(this);
        this.handleChangeFullView = this.handleChangeFullView.bind(this);
        this.handleChangePrint=this.handleChangePrint.bind(this);

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
    handleSubmit(e){
        e.preventDefault();
        let totalPrice=0;
        let totalQty=0;
        this.state.selectedProductHeads.map((sp)=>{

            totalQty += sp.qty;
            totalPrice += sp.price *sp.qty;

        });


        let currentBalance=totalPrice-this.state.result.pay_balance;

        // let balance = this.state.result.supplier_balance -this.state.result.purchase.total_price - this.state.result.purchase.pay - currentBalance;
        let balance=0;

        if (this.state.result.purchase.supplier_id === this.state.result.supplier_id){

            balance= this.state.result.supplier_balance +(this.state.result.purchase.total_price - this.state.result.purchase.pay - currentBalance)

        }
        else {
            balance=  this.state.result.supplier_balance - totalPrice - this.state.result.pay_balance

        }


        let url = location.origin;
        let id=location.pathname.slice(17,-5);
        var self=this;
        let data={
            supplier:this.state.result.supplier_id,
            payment_mode:this.state.result.payment_type_id,
            pay_balance:this.state.result.pay_balance,
            products:this.state.selectedProductHeads,
            date:this.state.result.date,
            time:this.state.result.time,
            pf:this.state.result.pf,
            remarks:this.state.result.remarks,
            totalQty,
            totalPrice,
            balance
        };

        axios.put(url+'/purchase-return/'+id,data).then((res)=>{

            location.href=url+'/purchase-return-list'

            if (res.data!='no'){

                window.open(url+'/purchase/'+res.data+'/show','_blank' ,  'fullscreen=yes')
                location.href=url+'/purchase-return-list'
            }else
            {
                location.href=url+'/purchase-return-list'
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

        let url =location.origin;
        let id=location.pathname.slice(17,-5);
        var self=this;


        axios.get(url+'/purchase-get-suppliers/'+id +'/edit').then(res=>{
            let purchase=res.data.purchase;

            let suppliers= res.data.suppliers.map((s)=>{
                return ({
                    label:s.name,
                    value:s.id,
                    balance:parseFloat(s.balance)
                })
            });


            let product_heads= res.data.product_heads.map((s)=>{
                return ({
                    label:s.title,
                    value:s.id
                })
            });

            let selectedProductHeads= res.data.purchase.purchase_details.map((ph)=>{
                return ({
                    id:ph.product_head_id,
                    title:ph.product_head.title,
                    price:ph.total_price,
                    qty:ph.total_qty
                })
            });


            self.setState({
                ...self.state,

                suppliers,
                product_heads,
                payment_types:res.data.payment_types,
                selectedSupplier:{
                    label:purchase.supplier.name,
                    value:purchase.supplier.id,
                    balance:parseFloat(res.data.cBalance)
                },
                result:{
                    ...self.state.result,
                    purchase_id:purchase.id,
                    supplier_id:purchase.supplier.id,
                    supplier_balance:parseFloat(res.data.cBalance),
                    payment_type_id:purchase.payment_type.id,
                    pay_balance:parseFloat(purchase.pay),
                    date:purchase.date,
                    time:purchase.time,
                    remarks:purchase.remarks,
                    purchase
                },
                selectedProductHeads
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
                price:0,
                qty:1
            };

            this.setState({
                selectedProductHeads:[...this.state.selectedProductHeads , productHead]
            });
        }
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

    render() {
        let totalQty=0;
        let totalPrice=0;
        this.state.selectedProductHeads.length ? this.state.selectedProductHeads.map((sp)=>{

                totalQty+=sp.qty;
                totalPrice += sp.price *sp.qty;

            })
            :'';

        let currentBalance = totalPrice-this.state.result.pay_balance;

        return (
            <div className="row">
                <div className="col-sm-12">
                    <div className="white-box">
                        <h2 className="font-bold text-center">Update Return Purchase Invoice # { this.state.result.purchase && this.state.result.purchase.id  } </h2>
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

                                        <div hidden={!this.state.chequeDetails} className="form-group">

                                            <label id="cheque_bank" className=" font-bold">Bank Detail:</label>

                                            <input type="text" className="form-control" name="cheque_bank" id="cheque_bank"/>

                                        </div>


                                    </div>
                                    <div hidden className="col-sm-4">

                                        <div className="form-group">
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
                                                <input className="form-control" maxlength="500" value={this.state.result.remarks} type="text" onChange={this.handleChange} id="remarks" placeholder="Remarks"/>
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
                                                                <td><input type="number" value={ph.price} id={ph.id}  onChange={this.handleChangeProductPrice}/></td>
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
                                <hr/>
                                {/*<div  className="form-group" hidden={this.state.result.payment_type_id == 1 ? false: true }>*/}
                                <div  className="form-group" hidden={ true }>
                                    <input type="number" value={this.state.result.pay_balance} className="form-control" placeholder="Pay" onChange={this.handlePay} />
                                </div>
                                <h4 className="font-bold">Current Balance: {currentBalance}</h4>
                                <h4 className="font-bold">Remaining Balance: {this.state.result.supplier_balance}</h4>
                                <h4 className="font-bold">Total Balance: {  this.state.result.purchase &&  this.state.result.purchase.supplier_id === this.state.result.supplier_id
                                    ? this.state.result.supplier_balance + (this.state.result.purchase.total_price - this.state.result.purchase.pay - currentBalance)

                                    :  this.state.result.supplier_balance -totalPrice - this.state.result.pay_balance }</h4>

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

export default EditReturnPurchase;