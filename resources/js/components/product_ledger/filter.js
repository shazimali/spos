import React, {Component} from 'react'
import axios from 'axios'
import Select from 'react-select';
import SearchResult from './search_result';
class Filter extends Component{

    constructor(props){

        super(props);
        this.state = {

            products:[],
            searchData:'',
            searchSaleData:'',
            searchPurchaseData:'',
            selectedProduct:'',
            selectedType:'',
            type:'',
            fromDate:'',
            toDate:'',
            loaded:true,
            print:false
        }


        this.handleChange= this.handleChange.bind(this);
        this.handleSubmit= this.handleSubmit.bind(this);
        this.handlePrint= this.handlePrint.bind(this);

    }

    handleChange(e){

        this.setState({


            [e.target.id]:e.target.value

        })
    }

    handleSubmit(e){

        e.preventDefault()
        if(this.state.selectedProduct != "" ){

            this.setState({

                loaded:false,
                print:true,
                searchData:''
            })

            let url = location.origin;
            e.preventDefault()

            let query = url+'/product-ledger/search?product_type='+this.state.selectedType+'&product='+this.state.selectedProduct.value+'&from_date='+this.state.fromDate+'&to_date='+this.state.toDate

            axios.get(query)
            .then( (res) => {

                if(res.data.type == 1 || res.data.type == 2){


                    this.setState({
                        loaded:true,
                        searchData:res.data.results,
                        type: res.data.type
                    })
                }
                else{

                    this.setState({

                        loaded:true,
                        searchSaleData:res.data.sale,
                        searchPurchaseData:res.data.purchase,
                        type: res.data.type

                    })
                }



            })
            .catch( (res) => {

                this.setState({

                    loaded:true
                })

            })

        }
        else{

            alert('Please select product and produt type')
        }


    }

    handlePrint(e){

            let url = location.origin;

            e.preventDefault()

            let query = url+'/product-ledger/show?product='+this.state.selectedProduct.value+'&product_type='+this.state.selectedType+'&from_date='+this.state.fromDate+'&to_date='+this.state.toDate
            window.open(query,'_blank' ,  'fullscreen=yes')
            location.reload();

    }

    componentDidMount(){

        let url = location.origin
        let products
        let all_products
        let first_product = [{

            label:"All Products",
            value:"0"
        }]

            //get all products

        axios.get(url+'/all-products')
        .then( (res) => {

            products= res.data.map((pr)=>{
                return ({
                    label:pr.code +'-'+ pr.title ,
                    value:pr.id,
                })
            });

            all_products = first_product.concat(products);

            this.setState({
                ...this.state,
                    products:all_products
                })

        })
    }
    render(){

        return(

       <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="col-sm-10 box-title m-b-0"><b>Product Ledger Filter</b>
                    {
                        this.state.print ?
                    <button  onClick={this.handlePrint} class="btn pull-right btn-primary">Print</button>
                    : ''
                    }
                    </h3>
                    <br/>

                    <div class="row">
                        <form  onSubmit={this.handleSubmit}>
                        <div class="form-group col-lg-3">
                        <label>Product</label>
                        <Select value={this.state.selectedProduct} onChange={value => this.setState({ selectedProduct: value })} options={this.state.products} tabIndex="1" />
                    </div>

                    <div class="form-group col-lg-3">
                        <label>Product Type</label>
                        <select class="form-control" value={this.state.selectedType} onChange={this.handleChange} name="product_type" id="selectedType">
                            <option value="">Please Select</option>
                            <option value="sale">Sale</option>
                            <option value="purchase">Purchase</option>
                        </select>
                    </div>

                    <div class="form-group col-lg-3">
                            <label>From Date</label>
                            <input type="date" id="fromDate" onChange={this.handleChange} name="from_date" class="form-control" placeholder="mm/dd/yyyy"/>
                    </div>

                    <div class="form-group col-lg-3">
                            <label>To Date</label>
                            <input type="date" id="toDate" onChange={this.handleChange}  name="to_date" class="form-control" placeholder="mm/dd/yyyy"/>
                    </div>

                    <div class="form-group col-lg-2">
                            <label></label>
                            <input type="submit" class="btn btn-primary" value="search"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <SearchResult
    loaded={this.state.loaded}
    results={this.state.searchData}
    saleResults={this.state.searchSaleData}
    purchaseResults={this.state.searchPurchaseData}
    type={this.state.type}
     />
    </div>

        );
    }
}

export default Filter
